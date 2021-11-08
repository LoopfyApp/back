<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\User;
use Carbon\Carbon;
use Auth;
use App\Jobs\SendEmailJob;
use App\Jobs\SendResetJob;
use App\Models\UsersDetails;
use OneSignal;

class AuthController extends Controller
{

    public function tokenPush(Request $request){
        if($request->idUser !== 0){
            $update=User::where('token_push',$request->token)->first(); 
            if($update){
            $update->token_push=null;
            $update->save();}
            $user = User::where('id',$request->idUser)->first(); 
            $user->plataforma=$request->plataforma;
            $user->token_push=$request->token;
            $user->save();
        }
    }
    public function reset(Request $request)
    {
        if($request->email ===null){
            return response()->json([
                'error' => true,
                'message' => 'Erro, o email inserido está incorreto.'
            ]);
        }
        else{
            $user = User::where('email',$request->email)->count();
            if($user==0){
                return response()->json([
                    'error' => true,
                    'message' => 'Erro, o email inserido está incorreto.'
                ]);
            }
            $code = $this->generarCodigo(6);
            $user = User::where('email',$request->email)->first();
            $user->password=bcrypt($code);
            $user->save();
            $this->enviarpush($user->token_push,$code,"Sua nova senha foi enviada para seu e-mail: ");
            $details['email'] = $user->email;
            $details['nombre'] = $user->name;
            $details['codigo'] = $code;
            $this->resetemail($details);

            return response()->json([
                'error' => false,
                'message' => 'Sua nova senha foi enviada para seu e-mail.'
            ]);
        }
    }

    public function resetPassword(Request $request){
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        } else {
            $code=$request->password;
            $user = User::where('id',$user->id)->first();
            $user->password=bcrypt($code);
            $user->save(); 


            $details['email'] = $user->email;
            $details['nombre'] = $user->name;
            $details['codigo'] = $code;
            $this->resetemail($details); 
            return response()->json([
                'error' => false,
                'message' => 'Sua nova senha foi enviada para seu e-mail.'
            ]);
        }
    }

    public function signUp(Request $request)
    {
        $foto = "null";
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);
     
        if ($request->photo == '/assets/button/boton_foto.svg') {
            $foto = "null";
        } else {
            $foto = $this->imagenbase64($request->photo);
        }
    
        $code = $this->generarCodigo(6);


        $update=User::where('token_push',$request->token)->first(); 
        if($update){
        $update->token_push=null;
        $update->save();}

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'photo' => $foto,
            'type' => $request->type,
            'codigo' => $code,
            'verification' => 1,
            'plataforma'=>$request->plataforma,
            'token_push'=>$request->token
        ]);
    
        $this->enviarpush($request->token,$code,"Seu código de validação é ");
        $userDetails = new UsersDetails();
        $userDetails->add($request, $user->id);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('ABCDEFGHIJKLMNOPQRSTUVWXYZ01ERDMORENO');

        $token = $tokenResult->token;

        $token->expires_at = Carbon::now()->addWeeks(4);
        $token->save();



        $details['email'] = $user->email;
        $details['nombre'] = $user->name;
        $details['codigo'] = $code;
        $details['dispositivo'] = "Android";
        $this->verification($details);

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
            'user' => $user
        ]);
    }


    public function imagenbase64($imagen)
    {
        $data = $imagen;
        $base64_str = substr($data, strpos($data, ",") + 1);
        $image = base64_decode($base64_str);
        $filename   = 'profile/profile_' . time() . '_' . rand(111, 699) . '.png';
        \Storage::disk('public')->put($filename, $image);

        return $filename;
    }

    public function verifyCode(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        } else {
            if ($user->codigo == $request->codigo) {

                $datos = User::find($user->id);
                $datos->codigo = 0;
                $datos->verification = 0;
                $datos->save();

                return response()->json([
                    'error' => false,
                    'message' => 'Usuário validado com sucesso',
                    'user' => $datos
                ]);
            } else {

                return response()->json([
                    'error' => true,
                    'message' => 'Erro, o código inserido está incorreto '
                ]);
            }
        }
    }

    public function CancelUser(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        } else {
            $datos = User::where('id', $user->id)->delete();

            return response()->json([
                'error' => false,
                'message' => 'Operação cancelada'
            ]);
        }
    }
    public function resendCode(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        } else {
            $code = $this->generarCodigo(6);
            $details['email'] = $user->email;
            $details['nombre'] = $user->name;
            $details['codigo'] = $code;
            $details['dispositivo'] = "Android";

            $datos = User::find($user->id);
            $datos->codigo = $code;
            $datos->save();

            $this->verification($details);

            return response()->json([
                'message' => 'Email enviado'
            ]);
        }
    }

    /**
     * Inicio de sesión y creación de token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('ABCDEFGHIJKLMNOPQRSTUVWXYZ01ERDMORENO');

        $token = $tokenResult->token;

        $token->expires_at = Carbon::now()->addWeeks(4);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
            'user' => $user
        ]);
    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function verification($details)
    {
        dispatch(new SendEmailJob($details));
    }

    public function resetemail($details)
    {
        dispatch(new SendResetJob($details));
    }

    public function generarCodigo($longitud)
    {
        $key = '';
        $pattern = '1234567890';
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++) $key .= $pattern[mt_rand(0, $max)];
        return $key;
    }


    public function consultaCNPJ(Request $request)
    {

        $CNPJ_WS = 'http://receitaws.com.br/v1/cnpj/';
        $URL = $CNPJ_WS . $request->cnpj;
        $data = json_decode(file_get_contents($URL));

        if ($data->status == "ERROR") {
            return response()->json([
                'error' => true,
                'message' => 'CNPJ inválido, tente novamente.',
         
            ]);
        } else {

            return response()->json([
                'error' => false,
                'message' => 'CNPJ  válido.',
                'data'=>$data
            ]);
        }
    }

    public function consultaCEP(Request $request)
    {
        $cep=$request->cep;
        $cep=str_replace("-","",$cep);
        $cep=str_replace(".","",$cep);
        $URL = 'https://viacep.com.br/ws/' . $cep . '/json/';
        $data = json_decode(file_get_contents($URL));

        if (isset($data->erro) == true) {
            return response()->json([
                'error' => true,
                'message' => 'CEP inválido, tente novamente.'
            ]);
        } else {
            $datos = [
                'zipcode'      => $request->cep,
                'street'       => $data->logradouro,
                'neighborhood' => $data->bairro,
                'city'         => $data->localidade,
                'state'        => $data->uf,
                'combinado' => $data->localidade . " / " . $data->uf . ", " . $data->bairro . ", " . $data->logradouro
            ];
            return response()->json([
                'error' => false,
                'data' => $datos
            ]);
        }
    }

    public function newcnpf(Request $request)
    {
        $url = "http://ws.hubdodesenvolvedor.com.br/v2/cnpj/?cnpj=".$request->cnpf."&token=111689005CiDWlghAzk201651112";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 450);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch); 
        $result = @json_decode($result);
        if (@$result->return == "OK") {
            return response()->json([
                'error' => false,
                'message' => 'CNPJ  válido.',
                'data'=>$result
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'CNPJ inválido, tente novamente.'
            ]);
        }
    }

    public function newcpf(Request $request){
 
        $fecha=Carbon::parse($request->data['data']);
        $url = "http://ws.hubdodesenvolvedor.com.br/v2/cpf/?cpf=".$request->data['cpf']."&data=".$fecha->format("d/m/Y")."&token=111689005CiDWlghAzk201651112";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 450);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch); 
        $result = @json_decode($result);
        if (@$result->return == "OK") {
            return response()->json([
                'error' => false,
                'message' => 'CPF  válido.',
                'data'=>$result
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'CPF inválido, tente novamente.'
            ]);
        }
    }

    public function enviarpush($token,$codigo,$title){
        $params = [];  
        $params['include_external_user_ids'] = [$token]; 
        $contents = [ 
           "en" => $title." ".$codigo, 
        ]; 
        $params['contents'] = $contents; 
        
        OneSignal::sendNotificationCustom($params);
    }

}
