<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Species;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use Response; 
use App\Models\CategoriSpecie;

class CategoryController extends Controller
{
 
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         if ($request->ajax()) {
            $Category = Category::get();
           return $info= Datatables::of($Category)
            ->addIndexColumn()
            ->addColumn('logo', function($row){
                $data="<img style='width:20%' src='".$row->logo."'>";
                return $data;
            })
            ->addColumn('status', function($row){
                switch($row->status){
                    case 0:
                        $data='<button onclick="activar('.$row->id.')"  class="btn btn-success mr-1 mb-1">'.trans('category.active').'</button>';
                    break;
                    case 1:
                        $data='<button onclick="activar('.$row->id.')" class="btn btn-danger mr-1 mb-1">'.trans('category.inactive').'</button>';
                    break; 
                }
                return $data;
            }) 
            
            ->addColumn('especies', function($row){
                 return $row->getSpecies($row->id);
                })
            
                ->addColumn('type', function($row){
                   
                switch($row->type){
                    case 0: 
                        $data='<label   class="badge badge-success mr-1 mb-1">'.trans('general.product').'</label>';
                    break;
                    case 1:
                        $data='<label  class="badge badge-danger mr-1 mb-1">'.trans('general.service').'</label>';
                    break; 
                    case 2:
                        $data='<label  class="badge badge-warning mr-1 mb-1">'.trans('general.veterinary').'</label>';
                    break;
                    
                }
                return $data;
                   })
            ->addColumn('action', function($row){
                    $btn= '<a href="#"  class="btn btn-icon btn-warning mr-1 mb-1" id="editar_category" data-current="'.$row->id.'"  title="Editar"><i style="color:white !important" class="iconsmind-Edit"></i></a>';
                     return $btn;
            })
            ->rawColumns(['action','status','logo','type','especies'])
            ->make(true);
     }
        $datos=array('title'=>trans('menu.dashboard'),'subtitles'=>trans('category.subtitle') );

        $especies=new Species;
        return view('admin.category.index')->with(['datos'=>$datos])
                                          ->with(['especies'=>$especies->getAll()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $rules = [
                'name' => 'required', 
                'status' => 'required', 
                
            ];
            $customMessages = [
                'name.required' => trans('category.notification.nome'),
                'status.required' => trans('category.notification.status'),
                 
            ];
            $validator=Validator::make($request->all(), $rules, $customMessages);
      
    
            if ($validator->fails()) { 
                $mensaje=trans('category.notification.error');
                return response()->json(['status'=>true,'mensaje'=>$mensaje,'data'=>null]);
            }
            else{
           
                if($request->id==0){$Category=New Category();}
                else{$Category=Category::find($request->id);}
                $Category->name=$request->name;
                $Category->status=$request->status; 
                
                $Category->type=$request->type; 
                

                if($request->logo != null){
                    $carpeta="category";
                    $ln=\Str::random(25);
                    $name=$ln.".".$request->logo->getClientOriginalExtension();
                    $request->logo->storeAs($carpeta, $name,'public');
                    $Category->logo="".$carpeta."/".$name;
                }
                $Category->save();
                $CategoriSpecie=new CategoriSpecie;
                $CategoriSpecie->add($request->species_id,$Category->id);
                
                $mensaje=trans('category.notification.save');
                return response()->json(['status'=>false,'mensaje'=>$mensaje,'data'=>null]);

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    public function details($id,Request $request){
        if ($request->ajax()) {
            return response()->json(['especies'=>Category::getSpeciesDataArray($id)]);
        }
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $id=$request->id;
            $info=Category::find($id);
            $info->status= ($info->status==0) ? 1 : 0;
            $info->save();
            return response()->json(['mensaje'=>trans('general.modify')]);

        }

        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    public function info(Request $request)
    {
        if ($request->ajax()) {
            $id=$request->id;
            $info=Category::find($id);
       
            return response()->json(['data'=>$info,'especies'=>Category::getSpeciesArray($id)]);

        }

        return response()->json(['error' => 'Unauthenticated.'], 401);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $Category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $Category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $Category)
    {
        //
    }
}
