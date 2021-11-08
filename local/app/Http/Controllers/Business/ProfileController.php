<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\UserHours;
use App\Models\UsersDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $datos = array('title' => trans('menu.dashboard'), 'subtitles' => trans('menu.profile'));
        return view('business.profile.index')->with(['datos' => $datos]);
    }

    public function saveIndex(Request $request)
    {
        $idUsers= Auth()->user()->id;
        if ($request->opciones == 1) {
            $opciones = UsersDetails::where('users_id', $idUsers)->first();
            $opciones->razon = $request->razon;
            $opciones->description = $request->description;
            $opciones->phone = $request->phone;
            $opciones->phone_comercial = $request->phone_comercial;
            if($request->photo != null ){
            $opciones->photo = $this->imagenUpload($request->photo, $idUsers);}
            if($request->logo != null ){
            $opciones->logo =  $this->imagenUpload($request->logo, $idUsers);}
            $opciones->save();
        }

        if ($request->opciones == 2) {
            $opciones = UsersDetails::where('users_id', $idUsers)->first(); 
            $opciones->cep = $request->cep;
            $opciones->address = $request->address;
            $opciones->complemento = $request->complemento;
            $opciones->save();
        }

        

        if ($request->opciones == 3) {
            $opciones = UserHours::where('users_id', $idUsers)->delete(); 
            
            for($a=1;$a<=7;$a++){
                $horas=new UserHours();
                $horas->days=$a;
                $horas->users_id=$idUsers;
                $horas->open=$request['open_'.$a];
                $horas->close=$request['close_'.$a];
                $horas->save();
            }
           
        }

        return redirect()->route('business.profile.index');
    }


    public function imagenUpload($imagen, $idUsers)
    {

        if ($imagen != null) {
            $img = $this->getB64Image($imagen);
            $img_extension = $this->getB64Extension($imagen);
            $carpeta = "store/" . $idUsers;
            $ln = Str::random(25);
            $name = $ln . "." . $img_extension;
            \Storage::disk('public')->put($carpeta . "/" . $name, $img);
            return $carpeta . "/" . $name;
        } else {
            return null;
        }
    }

    public function getB64Image($base64_image)
    {
        $image_service_str = substr($base64_image, strpos($base64_image, ",") + 1);
        $image = base64_decode($image_service_str);
        return $image;
    }

    public function getB64Extension($base64_image, $full = null)
    {
       // preg_match("/^data:image\/(.*);base64/i", $base64_image, $img_extension);
       // return ($full) ?  $img_extension[0] : $img_extension[1];

        $img = explode(',', $base64_image);
            $ini = substr($img[0], 11);
            $img_extension = explode(';', $ini);
            if ($full) {
                return "image/" . $img_extension[0];
            } else {
                return $img_extension[0];
            }
    }



    public function consultaCEP(Request $request){
        $URL = 'https://viacep.com.br/ws/'.$request->cep.'/json/';
        $data= json_decode( file_get_contents($URL) );
     
        if(isset($data->erro)==true){
            return response()->json([
                'error'=>true,
                'message' => 'CEP inválido, tente novamente.'
            ]);  
        }
        else{
            $datos= [
                'zipcode'      => $request->cep,
                'street'       => $data->logradouro,
                'neighborhood' => $data->bairro,
                'city'         => $data->localidade,
                'state'        => $data->uf,
                'combinado' => $data->localidade." / ".$data->uf.", ".$data->bairro.", ".$data->logradouro
            ];
            return response()->json([
                'error'=>false,
                'data' => $datos
            ]);  
           

        }
        
        }
}
