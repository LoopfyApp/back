<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Species;
use App\Models\Breed;
use App\Models\CategoriSpecie;
use App\Models\Category;
use App\Models\UsersSpecie;

class AdminController extends Controller
{

    public function species(Request $request){
        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
           $species=Species::orderby('name','asc')->get();

            return response()->json([
                'error'=>false,
                'data' => $species
            ]);
        }

    }

    public function razas(Request $request){
        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
           $razas=Breed::where('species_id',$request->id_species)->orderby('name','asc')->get();

            return response()->json([
                'error'=>false,
                'data' => $razas
            ]);
        }

    }

    public function GetmascoteRaza(Request $request,$id){
        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
            $UsersSpecie=new UsersSpecie();
            
            return response()->json([
                'error'=>false,
                'data' => $UsersSpecie->getAllbreed($user->id,$id) 
            ], 200);
            
        }
    }


    public function Getmascote(Request $request){
        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
            $UsersSpecie=new UsersSpecie();
            
            return response()->json([
                'error'=>false,
                'data' => $UsersSpecie->getAll($user->id)
            ], 200);
            
        }
    }

    public function getSpecies(Request $request,$id){ 
        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
            $UsersSpecie=new UsersSpecie();

            return response()->json([
                'error'=>false,
                'data' => $UsersSpecie->getId($id)
            ], 200);

           
        }
        
    }
    public function mascote(Request $request){
        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
            $UsersSpecie=new UsersSpecie;
            return $UsersSpecie->add($request,$user->id);
        }
    }


    

    public function getServices(Request $request){
        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{

            $categoria=CategoriSpecie::select('categories_id')->where('species_id',$request->id)->get();
            $opciones=Category::whereIn('id',$categoria)->where('type','1')->where('status',0)->get();

            return response()->json([
                'error'=>false,
                'date' => $opciones
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
            
            $categoria=CategoriSpecie::select('categories_id')->where('species_id',$request->id)->get();
            $opciones=Category::whereIn('id',$categoria)->where('type','2')->where('status',0)->get();

            return response()->json([
                'error'=>false,
                'date' => $opciones
            ], 200);  
        }
    }

}
