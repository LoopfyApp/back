<?php

namespace App\Http\Controllers\Pagarme;

use App\Http\Controllers\Controller;
use App\Models\UserBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PagarMe\PagarMe;
use PagarMe\Client;
use Carbon\Carbon;

use App\Models\Models\ServicesUserCalendar;
use App\Models\Models\ServicesUserCalendarDetails;
use App\Models\Transaction;
class PagarmeController extends Controller
{
    public $pagarme;

    public function __construct(){
        $this->pagarme = new Client(config('app.pagar_test'));  
    }

   public function index()
   {
    
    $bankAccounts = $this->pagarme->bankAccounts()->getList();
      var_dump($bankAccounts);
    }

    public function createaccount(Request $request){
 
      /*  $bankAccount = $this->pagarme->bankAccounts()->create([
            'bank_code' => $request->bank,
            'agencia' => $request->bank_conde,
            'agencia_dv' => $request->number_bank,
            'conta' =>  $request->account_bank,
            'conta_dv' =>  $request->number_account_bank,
            'document_number' =>   $request->number_document,
            'legal_name' =>   $request->legal_name,
            'type' =>   $request->type_bank,
            'document_type'=>$request->type_number
          ]);

          if($bankAccount){ 
      
           $recipient = $this->pagarme->recipients()->create([
            'anticipatable_volume_percentage' => '85', 
            'automatic_anticipation_enabled' => 'true', 
            'bank_account_id' => $bankAccount->id, 
            'transfer_day' => '15', 
            'transfer_enabled' => 'true', 
            'transfer_interval' => 'monthly'
          ]); */

           
            $data=new UserBank; 
            $data->bank_code= $request->bank;
            $data->agencia= $request->bank_conde;
            $data->agencia_dv= $request->number_bank;
            $data->conta=  $request->account_bank;
            $data->conta_dv = $request->number_account_bank;
            $data->document_number=   $request->number_document;
            $data->legal_name =   $request->legal_name;
            $data->type =   $request->type_bank;
            $data->document_type=$request->type_number;
            $data->code_account=Auth::user()->id;
            $data->recipient_id=Auth::user()->id;
            $data->users_id=Auth::user()->id;
            $data->status=0;
            $data->save();

            return redirect()->route('business.profile.bank.index')->with('message','Datos Registrado Correctamente');
          // }
         //  return redirect()->back()->with('error','Verificar dados como CPF / CNPJ e detalhes da conta');    

    }

    public function parcelamiento(Request $request){
      $calculateInstallments = $this->pagarme->transactions()->calculateInstallments([
        'amount' => number_format($request->amount,2,"",""),
        'free_installments' => 1,
        'max_installments' => 6,
        'interest_rate' =>  13
      ]);  
      $juros=[]; 
      foreach ($calculateInstallments->installments as $key => $datos){
  
        $monto=substr($datos->amount,0,-2).".".substr($datos->amount,-2);
        $installment=$datos->installment;
        $monto_total=substr($datos->installment_amount,0,-2).".".substr($datos->installment_amount,-2);
        $texto=$installment." x ".$monto_total." = ".$monto;
        $data=array("texto"=>$texto,"amount"=>$monto,"installment"=>$installment,"installment_amount"=>$monto_total);
        array_push($juros,$data);
        \Log::info($key);
      }
      return response()->json([
        'error' => false,
        'data' => $juros
        ], 200);
    }

    public function boleto(Request $request){
      
      $user = $request->user();
    
      if(!$user){
          return response()->json([
              'error'=>true,
              'message' => 'Unauthorized'
          ], 401);
      }

      $tipo=$request->tipo;
      $id_carts=$request->id_carts;
      $telefono=$request->phone;
      if($tipo==1){
        $services=ServicesUserCalendar::where('status_pay',0)->where('cart_number',$id_carts)->first(); 
    
        $items=$services->datailsInfo()->get();
        $store=$services->storeInfo;
        $infoData=[];
        $total=0;
        $x=1;
        foreach($items as $datoInfo){
            $fecha=Carbon::parse($request->date)->format("d-m-Y");
            $userEspecie=$datoInfo->infoMascote;
            $servicio=$datoInfo->datailsServicio;
            $infoDatas=array("id"=>"#".$x,"title"=>$servicio->name." (".$servicio->description.")","quantity"=>1,"unit_price"=>$datoInfo->amount,"tangible"=>False);
            $total= $total+$datoInfo->amount;
            array_push($infoData,$infoDatas);
            $x++;
        }
        $total=number_format($total,2,"","");
      }
      else{
        $cart=CartProduct::where('cart_number',$request->id_carts)->first();
      }

     // return (object)$infoData;


      $result=$this->validatecpf($request);
      if (@$result->return == "OK") {
        
        $numeroCpf=$result->result->numero_de_cpf;
        $nombreCpf=$result->result->nome_da_pf;
  
      }
      else{
        return response()->json([
          'error' => true,
          'message' => 'CPF inválido, tente novamente.'
      ]);
      }
      try {
      $transactiones = $this->pagarme->transactions()->create([
        'amount' => $total,
        'payment_method' => 'boleto',
        'postback_url'=>url('api/boleto/info'),
        
        'customer' => [
            'external_id' => "#".$user->id,
            'name' => $nombreCpf,
            'type' => 'individual',
            'country' => 'br',
            'documents' => [
              [
                'type' => 'cpf',
                'number' => $numeroCpf
              ]
            ],
            'phone_numbers' => [ "+55".$telefono ],
            'email' => $user->email,
        ],
        'items' => $infoData,
    ]);
 
    $dt=(array)json_encode($transactiones);
    $newTransaction=new Transaction();
    $newTransaction->users_id=$user->id;
    $newTransaction->user_store_id=$store->id;
    $newTransaction->cart_number=$id_carts;
    $newTransaction->type=$tipo;
    $newTransaction->id_transaction=$transactiones->id;
    $newTransaction->url_boleto=isset($transactiones->boleto_url) ? $transactiones->boleto_url :  'ninguno' ;
    $newTransaction->payment_method=$transactiones->payment_method;
    $newTransaction->transcations=$dt;
    $newTransaction->save();

    
    return response()->json([
      'error'=>false,
      'data' => $transactiones
      ], 200);
    }
      catch (Exception $e) {
        
        return response()->json([
          'error' => true,
          'message' => $e->getMessage()
      ]);
    }
  

    }

    public function validatecpf($request){
      $fecha=Carbon::parse($request->data);
      $url = "http://ws.hubdodesenvolvedor.com.br/v2/cpf/?cpf=".$request->cpf."&data=".$fecha->format("d/m/Y")."&token=111689005CiDWlghAzk201651112";
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
      return $result;

    }

    public function boletopost(Request $request){
      \Log::info($request->all());

    }
}
