<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use Illuminate\Http\Request;
use App\Models\Species; 
use Validator;
use DataTables;
use Response; 

class BreedController extends Controller
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
            $Breed = Breed::get();
           return $info= Datatables::of($Breed)
            ->addIndexColumn()
            ->addColumn('logo', function($row){
                $data="<img style='width:20%' src='".$row->logo."'>";
                return $data;
            })
            ->addColumn('status', function($row){
                switch($row->status){
                    case 0:
                        $data='<button onclick="activar('.$row->id.')"  class="btn btn-success mr-1 mb-1">'.trans('breed.active').'</button>';
                    break;
                    case 1:
                        $data='<button onclick="activar('.$row->id.')" class="btn btn-danger mr-1 mb-1">'.trans('breed.inactive').'</button>';
                    break; 
                }
                return $data;
            }) 
            
            ->addColumn('especies', function($row){
                 return $row->species->name;
                }) 
            ->addColumn('action', function($row){
                    $btn= '<a href="#"  class="btn btn-icon btn-warning mr-1 mb-1" id="editar_category" data-current="'.$row->id.'"  title="Editar"><i style="color:white !important" class="iconsmind-Edit"></i></a>';
                     return $btn;
            })
            ->rawColumns(['action','status','logo','especies'])
            ->make(true);
     }
        $datos=array('title'=>trans('menu.dashboard'),'subtitles'=>trans('breed.subtitle') );

        $especies=new Species;
        return view('admin.breed.index')->with(['datos'=>$datos])
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
                'name.required' => trans('breed.notification.nome'),
                'status.required' => trans('breed.notification.status'),
                 
            ];
            $validator=Validator::make($request->all(), $rules, $customMessages);
      
    
            if ($validator->fails()) { 
                $mensaje=trans('breed.notification.error');
                return response()->json(['status'=>true,'mensaje'=>$mensaje,'data'=>null]);
            }
            else{
                if($request->id==0){$Breed=New Breed();}
                else{$Breed=Breed::find($request->id);}
                $Breed->name=$request->name;
                $Breed->status=$request->status; 
                 
                $Breed->species_id=$request->species_id; 

                if($request->logo != null){
                    $carpeta="breed";
                    $ln=\Str::random(25);
                    $name=$ln.".".$request->logo->getClientOriginalExtension();
                    $request->logo->storeAs($carpeta, $name,'public');
                    $Breed->logo="".$carpeta."/".$name;
                }
                else{
                    $Breed->logo="null";
                }
                $Breed->save();
                $mensaje=trans('breed.notification.save');
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
    public function show(Breed $category)
    {
        //
    }

    

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $id=$request->id;
            $info=Breed::find($id);
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
            $info=Breed::find($id);
            return response()->json(['data'=>$info]);

        }

        return response()->json(['error' => 'Unauthenticated.'], 401);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function edit(Breed $Category)
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
    public function update(Request $request, Breed $Category)
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
