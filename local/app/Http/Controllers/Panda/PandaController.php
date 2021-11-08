<?php

namespace App\Http\Controllers\Panda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PandaController extends Controller
{
     
 
  public function pay( Request $request ){
 
    $token = $this->authenticate();
    $payment = new  Payment();
    $payment->user_id = $request->userd_id;
    $payment->user_id = $request->total_amount;
    $payment->seller_id = $request->customerSellerId;
    $payment->save();
    $paymentId = $this->generatePayment($token ,$request,$payment->id);
    $has_paid  = $this->capturePayment($token ,$paymentId,$request->amount);
    $payment->panda_id= $paymentId ;
    $payment->has_paid = $has_paid ;
    $payment->save();
       
   }

 public function authenticate(){
     $endpoint = "https://payments.pandapag.com.br/api/auth/login";
     $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $endpoint, ['query' => [
            'email' => 'loopfy@genios360.com', 
            'password' => 'f8YF4&%svYZa',
        ]]);
     if($response->getStatusCode()==200){
      $datos=json_decode($response->getBody()->getContents());
      return $datos->access_token;
     }
     else{
       return null;
     }
 
        
    }

    function capturePayment($token ,$paymentId,$amount){
      $headers = ['Authorization' => 'Bearer '.$token];
      $client = new \GuzzleHttp\Client();
      $endpoint="https://payments.pandapag.com.br";
      $endpoint = $endpoint.'/payments/'.$paymentId.'/autorize';
   
        $response = $client->request('POST',$endpoint );
                $data= [
                "service" => "sandbox",
                "amount" => $amount
            ];
      return $response;
    }

    function generatePayment($token,$request,$order_id){
      $endpoint = "https://payments.pandapag.com.br";
      $client = new \GuzzleHttp\Client();
      $headers = ['Authorization' => 'Bearer '.$token];
       
      $data = [
      "environment" => [ 
        "service"=> $request->service,
        "cardOnVault" =>  false,
        "callbackUrl"=>  "https://postman-echo.com/post",
       " useVault"=> false
      ],
      "payment" => [
        "transactionType"=> 1,
        "amount"=> $request->amount,
        "currencyCode"=> "brl",
        "productType"=> 1,
        "installments"=> 1,
        "captureType"=> 1
      ],
      "cardInfo" => [
        "cardNumber" => $request->cardNumber,
        "cardholderName" => $request->cardholderName,
        "securityCode" => $request->securityCode,
        "brand" => $request->brand,
        "expirationMonth" => $request->expirationMonth,
        "expirationYear" => $request->expirationYear
      ],
      "sellerInfo" => [
        "orderNumber" => $request->orderNumber,
        "softDescriptor" => $request->softDescriptor,
        "dynamicMcc" => 5051
      ],
      "customer" => [
        "customerSellerId" => $request->customerSellerId,
        "documentType" => 2,
        "documentNumberCDH" => $request->documentNumberCDH,
        "firstName" => $request->firstName,
        "lastName" => $request->lastName,
        "email" => $request->email,
        "phoneNumber" => $request->phoneNumber,
        "address" => $request->address,
        "complement" => $request->complement,
        "city" => $request->city,
        "state" => $request->state,
        "zipCode" =>$request->zipCode,
        "ipAddress" => "127.0.0.1"
        ],
       "order" =>[
          "order_id" =>$request->order_id,
          "order_date" =>$request->order_date,
          "total_order_amount" => $request->total_order_amount,
          "customer_name"  =>$request->customer_name,
          "customer_cpf" =>$request->customer_cpf,
          "customer_birthday" =>$request->customer_birthday,
          "customer_phoneNumber" =>$request->customer_phoneNumber,
          "customer_address" =>$request->customer_address,
          "customer_addressNumber" =>$request->customer_addressNumber,
          "customer_addressComplement" =>$request->customer_addressComplement,
          "customer_zipCode" =>$request->customer_zipCode,
          "customer_neighborhood" =>$request->customer_neighborhood,
          "customer_city" =>$request->customer_city,
          "customer_state" =>$request->customer_state
        ],
        "shopping_cart" => $request->shopping_cart,
        "split" =>[
          [
            "store_id" =>$request->store_id,
            "store_cnpj" =>$request->store_cnpj,
            "company_name" =>$request->company_name,
            "email" =>$request->email,
            "bank_number" =>$request->bank_number,
            "bank_branch" =>$request->bank_branch,
            "bank_account" =>$request->bank_account,
            "bank_account_type" =>$request->bank_account_type,
            "total_order_amount" => $request->tolal_amount,
            "order_id" =>$order_id
            ]
        
        ]

]; 

  

    $response = $this->client->request('POST', $endpoint.'/payments', [$headers]);
}



}
