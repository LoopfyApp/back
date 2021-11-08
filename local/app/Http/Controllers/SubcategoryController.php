<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use Response; 
use App\Models\SubcategoriSpecie;

class SubcategoryController extends Controller
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
            $Subcategory = Subcategory::get();
           return Datatables::of($Subcategory)
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
            
            ->addColumn('category', function($row){
                 return $row->category->name;
                })
                ->addColumn('species', function($row){

                    return $row->getSpecies($row->id);
                    //return "";//$row->category->species->name;
                   })
            ->addColumn('action', function($row){
                    $btn= '<a href="#"  class="btn btn-icon btn-warning mr-1 mb-1" id="editar_category" data-current="'.$row->id.'"  title="Editar"><i style="color:white !important" class="iconsmind-Edit"></i></a>';
                     return $btn;
            })
            ->rawColumns(['action','status','logo','category','species'])
            ->make(true);
     }
        $datos=array('title'=>trans('menu.dashboard'),'subtitles'=>trans('subcategory.subtitle') );

        $category=new Category;
        return view('admin.subcategory.index')->with(['datos'=>$datos])
                                          ->with(['category'=>$category->getAll()]);
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
                'name.required' => trans('subcategory.notification.nome'),
                'status.required' => trans('subcategory.notification.status'),
                 
            ];
            $validator=Validator::make($request->all(), $rules, $customMessages);
      
    
            if ($validator->fails()) { 
                $mensaje=trans('subcategory.notification.error');
                return response()->json(['status'=>true,'mensaje'=>$mensaje,'data'=>null]);
            }
            else{
                if($request->id==0){$Subcategory=New Subcategory();}
                else{$Subcategory=Subcategory::find($request->id);}
                $Subcategory->name=$request->name;
                $Subcategory->status=$request->status; 
                 
                $Subcategory->categories_id=$request->categories_id; 

                if($request->logo != null){
                    $carpeta="subcategory";
                    $ln=\Str::random(25);
                    $name=$ln.".".$request->logo->getClientOriginalExtension();
                    $request->logo->storeAs($carpeta, $name,'public');
                    $Subcategory->logo="".$carpeta."/".$name;
                }
                else{
                    $Subcategory->logo="null"; 
                }
                $Subcategory->save();

                
                $SubcategoriSpecie=new SubcategoriSpecie;
                $SubcategoriSpecie->add($request->species_id,$Subcategory->id);

                $mensaje=trans('subcategory.notification.save');
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

    

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $id=$request->id;
            $info=Subcategory::find($id);
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
            $info=Subcategory::find($id);
            return response()->json(['data'=>$info,'especies'=>Subcategory::getSpeciesArray($id)]);

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