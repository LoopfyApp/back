<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Models\ServicesUserCalendar;
use App\Models\Models\ServicesUserCalendarDetails;
use App\Models\Species;
use App\Models\User;
use App\Models\UserServices;
use App\Models\UserServicesHours;
use App\Models\UserServicesSpecies;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    
    public function getindex(Request $request){

        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
            $UserServices=UserServicesSpecies::select('users_id')->where('category_id',$request->categorie)
            ->where('species_id',$request->id_especie)
            ->groupby('users_id')
            ->get();
      
            $userids=UserServices::select('users_id')->whereIn('users_id', $UserServices)->where('type_option',0)->get();
             
            $userinfo=User::whereIn('id', $userids)->get();

        $data=[];

        foreach($userinfo as $info){

            $array=array('id'=>$info->id,'razon'=>$info->userDetails->razon,'description'=>$info->userDetails->description,'photo'=>$info->userDetails->logo,'distance'=>10);
            array_push($data,$array);
        }

        
        $category=Category::where('id',$request->categorie)->first();
        $species=Species::where('id',$request->id_especie)->first();
        return response()->json([
            'error'=>false,
            'data' => $data,
            'category'=>$category,
            'species'=>$species
        ], 200);
        }

    }


    
    
    public function getindexVeterinary(Request $request){

        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
  
            $UserServices=UserServicesSpecies::select('users_id')->where('category_id',$request->categorie)
            ->where('species_id',$request->id_especie)
            ->groupby('users_id')
            ->get();
      
            $userids=UserServices::select('users_id')->whereIn('users_id', $UserServices)->where('type_option',1)->get();
             
            $userinfo=User::whereIn('id', $userids)->get();

        $data=[];

        foreach($userinfo as $info){

            $array=array('id'=>$info->id,'razon'=>$info->userDetails->razon,'description'=>$info->userDetails->description,'photo'=>$info->userDetails->logo,'distance'=>10);
            array_push($data,$array);
        }
        $category=Category::where('id',$request->categorie)->first();
        $species=Species::where('id',$request->id_especie)->first();
        return response()->json([
            'error'=>false,
            'data' => $data,
            'category'=>$category,
            'species'=>$species
        ], 200);
        }

    }

    public function getVeterinary(Request $request){

        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
        $UserServices=UserServicesSpecies::select('user_services_id')->where('category_id',$request->categorie)
        ->where('users_id',$request->store_id)
        ->where('species_id',$request->id_especie)
        ->groupby('user_services_id')
        ->get();

        $user=UserServices::whereIn('id', $UserServices)->where('type_option',1)->get();

        $data=[];

        foreach($user as $info){

            $array=array('id'=>$info->id,'name'=>$info->name,'description'=>$info->description,'price'=>$info->price);
            array_push($data,$array);
        }

        
        return response()->json([
            'error'=>false,
            'data' => $data
        ], 200);
        }

    }



      
    public function getservices(Request $request){

        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
        $UserServices=UserServicesSpecies::select('user_services_id')->where('category_id',$request->categorie)
        ->where('users_id',$request->store_id)
        ->where('species_id',$request->id_especie)
        ->groupby('user_services_id')
        ->get();

        $userinfo=UserServices::whereIn('id', $UserServices)->where('type_option',0)->get();

        $data=[];

        foreach($userinfo as $info){

            $array=array('id'=>$info->id,'name'=>$info->name,'description'=>$info->description,'price'=>$info->price);
            array_push($data,$array);
        }

        
        return response()->json([
            'error'=>false,
            'data' => $data
        ], 200);
        }

    }

      
    public function getCalendarservices(Request $request){
  
      
       $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
     
        $datos=UserServices::where('id', $request->service_id)->first();
        $date=Carbon::parse($request->date_service);
        $days=$date->isoFormat('d');
        $horas=UserServicesHours::where('user_services_id',$request->service_id)->where('days',$days)->get();
         
        $data=[];
        foreach($horas as $datosInfo){
           $hoursService=ServicesUserCalendarDetails::
           where('user_services_id',$request->service_id)->
           where('days_orders',$date->format('Y-m-d'))->
           where('timer_orders',$datosInfo->bloque)->count();
            if($hoursService==0){
            $array=array('id'=>$datosInfo->id,'fecha'=>$date->format('d-m-Y'),'hours'=>$datosInfo->bloque);
            array_push($data,$array);}
        }

       

            return response()->json([
                'error'=>false,
                'data' => $data
            ], 200);

        }
  
    }

    public function getAgendar(Request $request){

      
        $user = $request->user();
     
         if(!$user){
             return response()->json([
                 'error'=>true,
                 'message' => 'Unauthorized'
             ], 401);
         }
         else{
            $userid=$user->id;
            $id_service=$request->id_service;
            $date=Carbon::parse($request->date);
            $hour=$request->hour;
            $datos=UserServices::where('id', $id_service)->first();
            $store_id=$datos->users_id;
            $cart_number=$store_id."".date('his').date('Ymd');

            if($request->cart_number ==null){
            $services=new ServicesUserCalendar;
            $services->users_id=$userid;
            $services->user_store_id= $store_id;
            $services->cart_number=$cart_number;
            $services->status_pay=0;
            $services->number_transaction=0;
            $services->save();}
            else{
                $services=ServicesUserCalendar::where('status_pay',0)->where('cart_number',$request->cart_number)->first(); 

                if($services->user_store_id != $store_id){
                    return response()->json([
                        'error'=>true,
                        'message' => "Você não pode adicionar outro serviço se não for da mesma loja"
                    ], 401);
                }
            }
            
            $serviceCalendar=new  ServicesUserCalendarDetails;
            $serviceCalendar->users_id=$userid;	
            $serviceCalendar->users_species=$request->id_pet;
            $serviceCalendar->user_services_id=$id_service;
            $serviceCalendar->user_store_id=$store_id;
            $serviceCalendar->services_user_calendars=$services->id;	
            $serviceCalendar->timer_orders=$hour;
            $serviceCalendar->days_orders=$date->format("Y-m-d");
            $serviceCalendar->amount=$datos->price;	
            $serviceCalendar->save();
            
            //$services=ServicesUserCalendar::where('status_pay',0)->where('cart_number','401544920210526')->first(); 
            $items=$services->datailsInfo()->get();
            $store=$services->storeInfo;
            $infoData=[];
            $total=0;
            foreach($items as $datoInfo){
                $fecha=Carbon::parse($request->date)->format("d-m-Y");
                $userEspecie=$datoInfo->infoMascote;
                $servicio=$datoInfo->datailsServicio;
                $infoData['items'][]=array("id_service"=>$datoInfo->id, "date_service"=>$fecha,'hours'=>$datoInfo->timer_orders,'pets'=>$userEspecie->name,'pets_photo'=>$userEspecie->photo,'name_service'=>$servicio->name,'description_service'=>$servicio->description,'amount'=>$datoInfo->amount);
                $total= $total+$datoInfo->amount;
            }
            $infoData['cart']=array('id'=>$services->id,'cart_number'=>$services->cart_number,'total'=> $total);
            $infoData['store']=array('name'=>$store->userDetails->razon,'photo'=>$store->userDetails->photo);

            return response()->json([
                'error'=>false,
                'data' => $infoData
            ], 200);

         }

    }

    public function getCart($id_carts,Request $request){

        $user = $request->user();
     
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
        $services=ServicesUserCalendar::where('status_pay',0)->where('cart_number',$id_carts)->first(); 
        if($services){
        $items=$services->datailsInfo()->get();
        $store=$services->storeInfo;
        $infoData=[];
        $total=0;
        foreach($items as $datoInfo){
            $fecha=Carbon::parse($request->date)->format("d-m-Y");
            $userEspecie=$datoInfo->infoMascote;
            $servicio=$datoInfo->datailsServicio;
            $infoData['items'][]=array("id_service"=>$datoInfo->id, "date_service"=>$fecha,'hours'=>$datoInfo->timer_orders,'pets'=>$userEspecie->name,'pets_photo'=>$userEspecie->photo,'name_service'=>$servicio->name,'description_service'=>$servicio->description,'amount'=>$datoInfo->amount);
            $total= $total+$datoInfo->amount;
        }
        $infoData['cart']=array('id'=>$services->id,'cart_number'=>$services->cart_number,'total'=> $total);
        $infoData['store']=array('name'=>$store->userDetails->razon,'photo'=>$store->userDetails->photo);
        return response()->json([
            'error'=>false,
            'data' => $infoData

        ], 200);
    }
    else{
        return response()->json([
            'error'=>true,
            'message' => 'Não existem itens no carrinho'
        ], 401);
    }

    }
    }

    public function getDeleteCart(Request $request){
        $user = $request->user();
     
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
            $id_cart=$request->id_cart;
        $datos=ServicesUserCalendar::where('cart_number',$id_cart)->first();
        $datos->delete(); 
        ServicesUserCalendarDetails::where('services_user_calendars',$datos->id)->delete();
        return response()->json([
            'error'=>false,
            'message' => 'Informação apagada com sucesso'
        ], 200);
    }
    }

    public function getDeleteCartItems($id_cart,$items,Request $request){

        $user = $request->user();
     
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
        $services=ServicesUserCalendar::where('status_pay',0)->where('cart_number',$id_cart)->first(); 
        if($services){

        $delete=ServicesUserCalendarDetails::where('id',$items)->delete();

        $items=$services->datailsInfo()->get();
        $store=$services->storeInfo;
        $infoData=[];
        $total=0;
        foreach($items as $datoInfo){
            $fecha=Carbon::parse($request->date)->format("d-m-Y");
            $userEspecie=$datoInfo->infoMascote;
            $servicio=$datoInfo->datailsServicio;
            $infoData['items'][]=array("id_service"=>$datoInfo->id, "date_service"=>$fecha,'hours'=>$datoInfo->timer_orders,'pets'=>$userEspecie->name,'pets_photo'=>$userEspecie->photo,'name_service'=>$servicio->name,'description_service'=>$servicio->description,'amount'=>$datoInfo->amount);
            $total= $total+$datoInfo->amount;
        }
        $infoData['cart']=array('id'=>$services->id,'cart_number'=>$services->cart_number,'total'=> $total);
        $infoData['store']=array('name'=>$store->userDetails->razon,'photo'=>$store->userDetails->photo);
        return response()->json([
            'error'=>false,
            'data' => $infoData

        ], 200);
    }
    else{
        return response()->json([
            'error'=>true,
            'message' => 'Não existem itens no carrinho'
        ], 401);
    }

    }
    }

}
