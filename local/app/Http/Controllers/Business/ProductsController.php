<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\SubcategoriSpecie;
use App\Models\Species;
use App\Models\Brand;
use App\Models\ProductDetail;
use App\Models\CartProduct;
use App\Models\CartProductDetails;
use Validator;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Response;
use DateTime;
use Str;
use File;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datos = Product::where('users_id',Auth()->user()->id)->get();
            return Datatables::of($datos)
            ->addIndexColumn()

            ->addColumn('categorys', function($row){
                $data=$row->categories->name;
                return $data;
            }) 

            ->addColumn('status', function($row){
                switch($row->status){
                    case 0:
                        $data='<button onclick="activar('.$row->id.')"  class="btn btn-success mr-1 mb-1">'.trans('species.active').'</button>';
                    break;
                    case 1:
                        $data='<button onclick="activar('.$row->id.')" class="btn btn-danger mr-1 mb-1">'.trans('species.inactive').'</button>';
                    break; 
                }
                return $data;
            }) 
            ->addColumn('action', function($row){

                    $btn= '<a href="#"  class="btn btn-icon btn-warning mr-1 mb-1" id="editar_species" data-current="'.$row->id.'"  title="Editar"><i style="color:white !important" class="iconsmind-Edit"></i></a>';
                    return $btn;
            })
            ->rawColumns(['action','status','categorys'])
            ->make(true);

        }
        $datos=array('title'=>trans('menu.productos'),'subtitles'=>trans('products.title') );
        return view('business.products.index')->with(['datos'=>$datos]);
    }

    public function add(Request $request)
    {
        $catgorias=Category::where('type',0)->get();
        $brand=Brand::get();
        $datos=array('title'=>trans('menu.productos'),'subtitles'=>trans('products.add') );
        return view('business.products.add')->with(['datos'=>$datos,'category'=>$catgorias,'brand'=>$brand]);
    }

    public function subcategoria($id){
        $catgorias=Subcategory::select('name','id')->where('categories_id',$id)->where('status',0)->get();
        return response()->json($catgorias);
    }

    public function species($id){
        $subcatgorias=SubcategoriSpecie::select('species_id')->where('categories_id',$id)->get();
        $species=Species::whereIn('id',$subcatgorias)->get();
        return response()->json($species);
    }

    public function storeEditData(Request $request){
        $idUsers= Auth()->user()->id;
        $Product=Product::find($request->id);

        $Product->users_id= $idUsers;
        $Product->category_id=$request->categories_id;
        $Product->marca_id=$request->brand;
        if($request->photo != null ){
            $Product->photo = $this->imagenUpload($request->photo, $idUsers);
        }

        $Product->codigo=$request->codigo;
        $Product->name=$request->name;
        $Product->description=$request->description;
        $Product->ficha="";
        $Product->price=$request->price;
        $Product->cantidad=$request->cantidad;

        $Product->offerts=($request->offerts_products=='on') ? 1 : 0;
        $Product->amount_offerts=$request->price_offerts;

        $Product->status=1;
        $Product->save();
        ProductDetail::where('meta_key','!=','photo')->where('prdoucto_id',$Product->id)->delete();

        $description=strip_tags($request->description);
        $description=substr($description,0,100);
        $this->cargarDetails($description,$Product->id,'descripcion_corta');
        $this->cargarDetails($request->categories_id,$Product->id,'category');
        $this->cargarDetails($request->subcategories_id,$Product->id,'subcategory');
       // $this->cargarDetails($request->presentacion,$Product->id,'presentacion');
        $this->cargarDetails($request->porte,$Product->id,'porte');
        $this->cargarDetails($request->codigo,$Product->id,'codigo');
        $this->cargarDetails($request->altura,$Product->id,'altura');
        $this->cargarDetails($request->largo,$Product->id,'largo');
        $this->cargarDetails($request->ancho,$Product->id,'ancho');
        $this->cargarDetails($request->peso,$Product->id,'peso');
        
        $species_id=$request->species_id;
        foreach($species_id as $data){
            $this->cargarDetails($data,$Product->id,'species');
        }
        //$this->uploadFiles($request,$Product->id);

        $carpeta = "store/products/" . $Product->id;
       
        if($request->hasfile('imagenes'))
        {
            $x=0;
           foreach($request->file('imagenes') as $file)
           {
            $x++;
               $name = $x."_".time().'.'.$file->extension();
              // $file->move($carpeta.'/', $name); 
               \Storage::disk('public')->put($carpeta.'/'.$name,  File::get($file)); 
               $this->cargarDetails($carpeta.'/'.$name,$Product->id,'photo');
           }
        }

        return redirect()->route('business.products.index')->with('message','Datos Registrado Correctamente');

    }

    public function storeData(Request $request){
 
       
        try{
        $idUsers= Auth()->user()->id;
        $Product=new Product;
        $Product->users_id= $idUsers;
        $Product->category_id=$request->categories_id;
        $Product->marca_id=$request->brand;
        if($request->photo != null ){
            $Product->photo = $this->imagenUpload($request->photo, $idUsers);
        }

        $Product->codigo=$request->codigo;
        $Product->name=$request->name;
        $Product->description=$request->description;
        $Product->ficha="";
        $Product->price=$request->price;
        $Product->status=1;

        $Product->offerts=($request->offerts_products=='on') ? 1 : 0;
        $Product->amount_offerts=$request->price_offerts;

        $Product->cantidad=$request->cantidad;
        $Product->save();

        $description=strip_tags($request->description);
        $description=substr($description,0,100);
        $this->cargarDetails($description,$Product->id,'descripcion_corta');
        
        $this->cargarDetails($request->categories_id,$Product->id,'category');
        $this->cargarDetails($request->subcategories_id,$Product->id,'subcategory');
       // $this->cargarDetails($request->presentacion,$Product->id,'presentacion');
        $this->cargarDetails($request->porte,$Product->id,'porte');


        $this->cargarDetails($request->codigo,$Product->id,'codigo');
        $this->cargarDetails($request->altura,$Product->id,'altura');
        $this->cargarDetails($request->largo,$Product->id,'largo');
        $this->cargarDetails($request->ancho,$Product->id,'ancho');
        $this->cargarDetails($request->peso,$Product->id,'peso');
        $this->cargarDetails($Product->photo,$Product->id,'photo');
        
        $species_id=$request->species_id;
        foreach($species_id as $data){
            $this->cargarDetails($data,$Product->id,'species');
        }
        //$this->uploadFiles($request,$Product->id);

        $carpeta = "store/products/" . $Product->id;
    
        if($request->hasfile('imagenes'))
        {
            $x=0;
           foreach($request->file('imagenes') as $file)
           {
            $x++;
               $name = $x."_".time().'.'.$file->extension();
              // $file->move($carpeta.'/', $name); 
               \Storage::disk('public')->put($carpeta.'/'.$name,  File::get($file)); 
               $this->cargarDetails($carpeta.'/'.$name,$Product->id,'photo');
           }
        }
        return redirect()->route('business.products.index')->with('message','Datos Registrado Correctamente');
       }
        catch (\Exception $e){
            return redirect()->route('business.products.index')->with('error','No se pudo registrar los datos del producto');

        }
    }

    public function uploadFiles($data,$idProductos){

        $carpeta = "store/products/" . $idProductos;
        if($data->hasfile('imagenes'))
        {
           foreach($data->file('imagenes') as $file)
           {
               $name = time().'.'.$file->extension();
               $file->move($carpeta.'/', $name);  
               $this->cargarDetails($carpeta.'/', $name,$Product->id,'photo');
           }
        }
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $id=$request->id;
            $info=Product::find($id);
            $info->status= ($info->status==0) ? 1 : 0;
            $info->save();
            return response()->json(['mensaje'=>trans('general.modify')]);
        }
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    public function cargarDetails($data,$idProductos,$type){
     
        if($data != null){
        $ProductDetail=new ProductDetail;
        $ProductDetail->meta_key=$type;
        $ProductDetail->meta_value=$data;
        $ProductDetail->prdoucto_id=$idProductos;
        $ProductDetail->save();}
    }

    public function imagenUpload($imagen, $idUsers)
    {

        if ($imagen != null) {
            
            $img = $this->getB64Image($imagen);
            $img_extension = $this->getB64Extension($imagen);
            $carpeta = "store/products/unica/" . $idUsers;
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



    public function edit(Request $request,$id)
    {
        $catgorias=Category::where('type',0)->get();
        $brand=Brand::get();
        $info=Product::where('id',$id)->first();
        $ProductDetail=ProductDetail::where('prdoucto_id',$id)->get();
        if($info != null){
            $info->details=$this->objecttoarray($ProductDetail);
        $datos=array('title'=>trans('menu.productos'),'subtitles'=>trans('products.edit') );
        return view('business.products.edit')->with(['info'=>$info,'datos'=>$datos,'category'=>$catgorias,'brand'=>$brand]);
        }
        else{
            return redirect()->route('business.products.index');
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


}
