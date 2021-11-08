<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MelhorEnvioController extends Controller
{
    public function calcular(Request $request){

        $calculate=env("url_menv_sanbox")."/api/v2/me/shipment/calculate";

        $data=[];
        $data['from']['postal_code']="96020360";
        $data['to']['postal_code']="01018020";
        $data['products'][0]['id']="001";
        $data['products'][0]['width']=3;
        $data['products'][0]['height']=2;
        $data['products'][0]['length']=2;
        $data['products'][0]['weight']=0.3;
        $data['products'][0]['insurance_value']=10.3;
        $data['products'][0]['quantity']=1;
        $data['products'][1]['id']="002";
        $data['products'][1]['width']=5;
        $data['products'][1]['height']=5;
        $data['products'][1]['length']=4;
        $data['products'][1]['weight']=0.3;
        $data['products'][1]['insurance_value']=15.3;
        $data['products'][1]['quantity']=1;
 

           
             $client = new \GuzzleHttp\Client();
             $response = $client->post($calculate, [
                 'headers' => [
                     'Content-Type' => 'application/json',
                     'Accept' => 'application/json',
                     'Authorization' => 'Bearer ' . env('token_menv'),
                     'User-Agent' =>'Aplicação academiacurso@gmail.com'],
                 'body'    => json_encode($data)
             ]); 

             return json_decode($response->getBody(),true);
    }

}
