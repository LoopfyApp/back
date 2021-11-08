<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\SubcategoriSpecie;
use App\Models\Species;
use App\Models\Brand;
use App\Models\ProductDetail;
use App\Models\CategoriSpecie;
use App\Models\User;
use App\Models\CartProductDetails;
use App\Models\CartProduct;

class ProductsController extends Controller
{
    public function getIndexCategory(Request $request,$species_id){
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 401);
        } else {
        
            $catgoerias=CategoriSpecie::select('categories_id')->where('species_id',$request->species_id)->get();
            $dataCategory=Category::whereIn('id',$catgoerias)->where('type',0)->where('status',0)->get();

            return response()->json([
                'error' => false,
                'data' => $dataCategory
            ], 200);
        }

    }

    public function getIdProductos(Request $request,$id){
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 401);
        } else {
            $producto=Product::where('id',$id)->first(); 
            $ProductDetail=ProductDetail::where('prdoucto_id',$id)->get();
            $array=$this->objecttoarray($ProductDetail);
            if($producto->price){
                $producto->price=isset($producto->price) ? (float)$producto->price : 0;
            }
            if($producto->category_id > 0){
                $producto->nameCategoria=Category::where('id',$producto->category_id)->first()->name;
            }
            if($producto->marca_id > 0){

                $producto->nameMarca=Brand::where('id',$producto->marca_id)->first()->name;
            }

            $info=User::where('id', $producto->users_id)->first();
            $storeUser=array('id'=>$info->id,'razon'=>@$info->userDetails->razon,'description'=>@$info->userDetails->description,'photo'=>@$info->userDetails->logo);
            if($array['subcategory']){
                $array['subcategory_name']= Subcategory::where('id',$array['subcategory'])->first()->name;
                $producto->idsubcatgoria=(int)$array['subcategory'];
            } 
            if($array['species']){
                $a=0;
                foreach($array['species'] as $speciesData){
                    $array['species'][$a]=Species::where('id',$speciesData)->first()->name;
                    $a++;
                }

            } 
            if($array['photo']){
                $a=0;
                foreach($array['photo'] as $foto){
                    $array['photo'][$a]= asset("local/storage/app/public/".$foto);
                    $a++;
                }
            }
            $producto->store=$storeUser;
            $producto->details=$array; 

            return response()->json([
                'error' => false,
                'data' => $producto
            ], 200);
        }


    }


    public function getIndexProductosOfferts(Request $request){
     
        $user = $request->user();
      
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 401);
        } else { 
   
        $producto=Product::where('offerts',1)->where('status',0)->get();
        $productosArray=[];
        $marcas=[];
        $subcategoriasP=[];
        $categoriasP=[];
        $especieP=[];
        foreach($producto as $items){
            $ProductDetail=ProductDetail::where('prdoucto_id',$items->id)->get();
            $array=$this->objecttoarray($ProductDetail);
             $items->price=(float)$items->price;

             $info=User::where('id', $items->users_id)->first();
             $storeUser=array('id'=>$info->id,'razon'=>@$info->userDetails->razon,'description'=>@$info->userDetails->description,'photo'=>@$info->userDetails->logo);
          
             
            if($array['subcategory']){
                $array['subcategory_name']= Subcategory::where('id',$array['subcategory'])->first()->name;
                $items->idsubcatgoria=(int)$array['subcategory'];
                array_push($subcategoriasP,(int)$array['subcategory']);
            }


            if($items->category_id > 0){
                $items->nameCategoria=Category::where('id',$items->category_id)->first()->name;
            }
            if($items->marca_id > 0){

                $items->nameMarca=Brand::where('id',$items->marca_id)->first()->name;
            }


            if($array['species']){
                $a=0;
                foreach($array['species'] as $speciesData){
                    
                    array_push($especieP,(int)$speciesData);
                    $array['species_name'][$a]=Species::where('id',$speciesData)->first()->name;
                    $a++;
                }

            } 

            if($array['photo']){
                $a=0;
                foreach($array['photo'] as $foto){
                    $array['photo'][$a]= asset("local/storage/app/public/".$foto);
                    $a++;
                }
            }

            $items->store=$storeUser;
            $items->details=$array;
            array_push($categoriasP,$items->category_id	);
            array_push($marcas,$items->marca_id);
            array_push($productosArray,$items);
        }
         
      
        $subactegoryEspecies=SubcategoriSpecie::whereIn('categories_id',$subcategoriasP)->whereIn('species_id',$especieP)->with('subcategories')->get();
        $category=Category::whereIn('id',$categoriasP)->get();
        $species=Species::whereIn('id',$especieP)->get();
        $marcas=Brand::whereIn('id',$marcas)->get();

        $datos=array('products'=>$productosArray, 
        "subcategory"=>$subactegoryEspecies,
        'category'=>$category,
        'marcas'=>$marcas,
        'species'=>$species);
        return response()->json([
            'error' => false,
            'data' => $datos
        ], 200);
    }

    }

    public function getIndexProductos(Request $request){
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 401);
        } else {
        $idCategoria=$request->categorie;
        $species_id=$request->id_especie;

        $ProductDetail=ProductDetail::select('prdoucto_id')->where('meta_key','species')->where('meta_value',$species_id)->get();

        $producto=Product::whereIn('id',$ProductDetail)->where('status',0)->where('category_id',$idCategoria)->get();
 
        $productosArray=[];
        $marcas=[];
        foreach($producto as $items){
            $ProductDetail=ProductDetail::where('prdoucto_id',$items->id)->get();
            $array=$this->objecttoarray($ProductDetail);
            \Log::info($items);
            $info=User::where('id', $items->users_id)->first();
            $storeUser=array('id'=>$info->id,'razon'=>@$info->userDetails->razon,'description'=>@$info->userDetails->description,'photo'=>@$info->userDetails->logo);
            $items->price=(float)$items->price;
            if($array['subcategory']){
                $array['subcategory_name']= Subcategory::where('id',$array['subcategory'])->first()->name;
                $items->idsubcatgoria=(int)$array['subcategory'];
            }

            if($items->category_id > 0){
                $items->nameCategoria=Category::where('id',$items->category_id)->first()->name;
            }
            if($items->marca_id > 0){

                $items->nameMarca=Brand::where('id',$items->marca_id)->first()->name;
            }

       
            if($array['photo']){
                $a=0;
                foreach($array['photo'] as $foto){
                    $array['photo'][$a]= asset("local/storage/app/public/".$foto);
                    $a++;
                }
            }
            $items->store=$storeUser;
            $items->details=$array;

            array_push($marcas,$items->marca_id);
            array_push($productosArray,$items);
        }
        $subactegory=Subcategory::select('id')->where('categories_id',$idCategoria)->get();
        $subactegoryEspecies=SubcategoriSpecie::whereIn('categories_id',$subactegory)->where('species_id',$species_id)->with('subcategories')->get();

        $category=Category::where('id',$idCategoria)->first();
        $species=Species::where('id',$species_id)->first();
        $marcas=Brand::whereIn('id',$marcas)->get();

        $datos=array('products'=>$productosArray, "subcategory"=>$subactegoryEspecies,
        'category'=>$category,
        'marcas'=>$marcas,
        'species'=>$species);
        return response()->json([
            'error' => false,
            'data' => $datos
        ], 200);
    }

    }



    public function getIndexProductosStore(Request $request){
        $user = $request->user();
      
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 401);
        } else { 
        $store=$request->store;
        $producto=Product::where('users_id',$store)->where('status',0)->get();
        $productosArray=[];
        $marcas=[];
        $subcategoriasP=[];
        $categoriasP=[];
        $especieP=[];
        foreach($producto as $items){
            $ProductDetail=ProductDetail::where('prdoucto_id',$items->id)->get();
            $array=$this->objecttoarray($ProductDetail);
             $items->price=(float)$items->price;

             $info=User::where('id', $items->users_id)->first();
             $storeUser=array('id'=>$info->id,'razon'=>@$info->userDetails->razon,'description'=>@$info->userDetails->description,'photo'=>@$info->userDetails->logo);
          
             
            if($array['subcategory']){
                $array['subcategory_name']= Subcategory::where('id',$array['subcategory'])->first()->name;
                $items->idsubcatgoria=(int)$array['subcategory'];
                array_push($subcategoriasP,(int)$array['subcategory']);
            }


            if($items->category_id > 0){
                $items->nameCategoria=Category::where('id',$items->category_id)->first()->name;
            }
            if($items->marca_id > 0){

                $items->nameMarca=Brand::where('id',$items->marca_id)->first()->name;
            }


            if($array['species']){
                $a=0;
                foreach($array['species'] as $speciesData){
                    
                    array_push($especieP,(int)$speciesData);
                    $array['species_name'][$a]=Species::where('id',$speciesData)->first()->name;
                    $a++;
                }

            } 

            if($array['photo']){
                $a=0;
                foreach($array['photo'] as $foto){
                    $array['photo'][$a]= asset("local/storage/app/public/".$foto);
                    $a++;
                }
            }

            $items->store=$storeUser;
            $items->details=$array;
            array_push($categoriasP,$items->category_id	);
            array_push($marcas,$items->marca_id);
            array_push($productosArray,$items);
        }
        $info=User::where('id', $store)->first();
        $storeUser=array('id'=>$info->id,'razon'=>@$info->userDetails->razon,'description'=>@$info->userDetails->description,'photo'=>@$info->userDetails->logo,'address'=>@$info->userDetails->address,'photo_background'=>@$info->userDetails->photo);
     
      
        $subactegoryEspecies=SubcategoriSpecie::whereIn('categories_id',$subcategoriasP)->whereIn('species_id',$especieP)->with('subcategories')->get();
        $category=Category::whereIn('id',$categoriasP)->get();
        $species=Species::whereIn('id',$especieP)->get();
        $marcas=Brand::whereIn('id',$marcas)->get();

        $datos=array('products'=>$productosArray, "subcategory"=>$subactegoryEspecies,
        'category'=>$category,
        'marcas'=>$marcas,
        'store'=>$storeUser,
        'species'=>$species);
        return response()->json([
            'error' => false,
            'data' => $datos
        ], 200);
    }

    }




    public function objecttoarray($data)
    {
        $infarray=[];
        $a=0; $b=0;
        foreach($data as $info){
            if($info->meta_key=='photo'){
                $infarray[$info->meta_key][$a]=$info->meta_value;
                $a++;
            }
            elseif( $info->meta_key=='species'){
                $infarray[$info->meta_key][$b]=$info->meta_value;
                $b++;
            }
            else{
                $infarray[$info->meta_key]=$info->meta_value;
            }
            
        }
        return $infarray;
    }

    public function detailsCart(Request $request){
        $user = $request->user();
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
      
            $cart=CartProduct::where('cart_number',$request->cart_number)->count();
            if($cart==0){
                return response()->json([
                    'error'=>true,
                    'message' => "Você não tem producto"
                ], 401);
            }
            $cart=CartProduct::where('cart_number',$request->cart_number)->first();
            $datos=$this->dataCartsinfo($cart->id,$cart->cart_number);

            return response()->json([
                'error' => false,
                'data' => $datos
            ], 200);
        }
    }

    public function addcart(Request $request){
        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
            $userid=$user->id;
            $store_id=$request->store_id;
            $product_id=$request->id_product;
            $producto=Product::where('id',$product_id)->first();
            if($request->cantidad > $producto->cantidad){
                return response()->json([
                    'error'=>true,
                    'message' => "Produto com estoque indisponivel no momento"
                ], 401); 
            }
            if($request->cart_number ==null){ 
                $cart=new CartProduct;
                $cart_number=$store_id."".date('his').date('Ymd');
                $cart->users_id=$userid;
                $cart->users_store= $store_id;
                $cart->cart_number=$cart_number;
                $cart->status_pay=0;
                $cart->number_transaction=0;
                $cart->save(); }
            else{
                $cart=CartProduct::where('cart_number',$request->cart_number)->first();
                if($cart->users_store != $store_id){
                    return response()->json([
                        'error'=>true,
                        'message' => "Você não pode adicionar outro producto se não for da mesma loja"
                    ], 401);
                }
            }
            $details=new CartProductDetails;
            $details->users_id=$userid;
            $details->user_store_id=$store_id;
            $details->cart_id=$cart->id;
            $details->id_products=$product_id;
            $details->amount=$request->amount;
            $details->cantidad=$request->cantidad;
            $details->save();

            $datos=$this->dataCarts($cart->id,$store_id,$cart->cart_number);

            return response()->json([
                'error' => false,
                'data' => $datos
            ], 200);
        }
    }


    public function dataCartsinfo($idCarts,$carts){

        $details=CartProductDetails::where('cart_id',$idCarts)->get();
        $dataProduct=[];
        foreach($details as $items){
            $producto=Product::where('id',$items->id_products)->first();
            $items->products=$producto;
            $items->total_amount=$items->amount*$items->cantidad;
            array_push($dataProduct,$items);
            $store=$items->user_store_id;
        }
        $info=User::where('id', $store)->first();
        $storeUser=array('id'=>$info->id,'razon'=>@$info->userDetails->razon,'description'=>@$info->userDetails->description,'photo'=>@$info->userDetails->logo,'address'=>@$info->userDetails->address,'photo_background'=>@$info->userDetails->photo);
     
       return $datos=array('products'=>$dataProduct, "store"=>$storeUser,"cart_number"=>$carts);


    }

    public function dataCarts($idCarts,$store,$carts){
        $info=User::where('id', $store)->first();
        $storeUser=array('id'=>$info->id,'razon'=>@$info->userDetails->razon,'description'=>@$info->userDetails->description,'photo'=>@$info->userDetails->logo,'address'=>@$info->userDetails->address,'photo_background'=>@$info->userDetails->photo);
        $details=CartProductDetails::where('cart_id',$idCarts)->get();
        $dataProduct=[];
        foreach($details as $items){
            $producto=Product::where('id',$items->id_products)->first();
            $items->products=$producto;
            $items->total_amount=$items->amount*$items->cantidad;
            array_push($dataProduct,$items);
        }
       return $datos=array('products'=>$dataProduct, "store"=>$storeUser,"cart_number"=>$carts);


    }

    public function deleteCart(Request $request){
        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{

            $cart=CartProduct::where('cart_number',$request->cart_number)->first();
            $details=CartProductDetails::where('id',$cart->id)->delete();
            CartProduct::where('cart_number',$request->cart_number)->delete();
            return response()->json([
                'error'=>false,
                'message' => 'Informação apagada com sucesso'
            ], 200);
        }
    
    }

    public function deleteitems(Request $request){
        $user = $request->user();
    
        if(!$user){
            return response()->json([
                'error'=>true,
                'message' => 'Unauthorized'
            ], 401);
        }
        else{
            $details=CartProductDetails::where('id',$request->id_details_cart)->delete();
            $cart=CartProduct::where('cart_number',$request->cart_number)->first();

            $datos=$this->dataCarts($cart->id,$cart->users_store,$cart->cart_number);

            return response()->json([
                'error' => false,
                'data' => $datos
            ], 200);


        }

        

    }

    public function points(Request $request){
   
        $cart=CartProduct::where('cart_number',$request->store)->first();
        $info=User::where('id', $cart->users_store)->first();
       

        if(@$info->userDetails->cep == null){
            return response()->json([
                'error'=>true,
                'message' => 'Essa loja esta fora de alcance no momento'
            ], 401); 
        } 
        else{
            $cep=str_replace("-","",@$info->userDetails->cep);
            $cep=intval(substr($cep,0,5));

            if(($cep > 9999)){

                return response()->json([
                    'error'=>true,
                    'message' => 'Essa loja esta fora de alcance no momento',
                    'data'=>$cep 
                ], 401); 
            }
        }
        $cepstore=intval($request->cep);
        $cepstore=intval(substr($request->cep,0,5));
   
      
        if(($cepstore > 9999)){

            return response()->json([
                'error'=>true,
                'message' => 'O CEP não está na faixa de remessa, coloque um CEP (Capital SP), (Grande SP)'
            ], 401); 
        }

       
            $sumapeso=0;
            $details=CartProductDetails::where('cart_id',$cart->id)->get();
            foreach($details as $items){
                $producto=ProductDetail::where('meta_key','peso')->where('prdoucto_id',$items->id_products)->first();
                if($producto!= null){
                    $sumapeso= $sumapeso+($producto->meta_value * $items->cantidad) ;
                }
            }
            if($sumapeso > 10){
                $total=$sumapeso-10;
                $costo= $total + 14;

            }
            else{
                $costo=14;
            }

        return response()->json([
            'error'=>false,
            'data' => $costo
        ], 200); 
       
    }

}
