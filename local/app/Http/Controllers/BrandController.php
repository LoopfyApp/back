<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

use Validator;
use DataTables;
use Response;

class BrandController extends Controller
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
            $Brand = Brand::get();
            return Datatables::of($Brand)
            ->addIndexColumn()
            ->addColumn('logo', function($row){
                $data="<img style='width:20%' src='".$row->logo."'>";
                
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
            ->rawColumns(['action','status','logo'])
            ->make(true);

        }
        $datos=array('title'=>trans('menu.dashboard'),'subtitles'=>trans('trademarks.subtitle') );
        return view('admin.trademarks.index')->with(['datos'=>$datos]);
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
                'name.required' => trans('trademarks.notification.nome'),
                'status.required' => trans('trademarks.notification.status'),
                 
            ];
            $validator=Validator::make($request->all(), $rules, $customMessages);
      
    
            if ($validator->fails()) { 
                $mensaje=trans('trademarks.notification.error');
                return response()->json(['status'=>true,'mensaje'=>$mensaje,'data'=>null]);
            }
            else{
                if($request->id==0){$Brand=New Brand();}
                else{$Brand=Brand::find($request->id);}
                $Brand->name=$request->name;
                $Brand->status=$request->status; 
                if($request->logo != null){
                    $carpeta="Brand";
                    $ln=\Str::random(25);
                    $name=$ln.".".$request->logo->getClientOriginalExtension();
                    $request->logo->storeAs($carpeta, $name,'public');
                    $Brand->logo="".$carpeta."/".$name;
                }
                else{
                    $Brand->logo="null";  
                }
                $Brand->save();
                $mensaje=trans('trademarks.notification.save');
                return response()->json(['status'=>false,'mensaje'=>$mensaje,'data'=>null]);

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Species  $species
     * @return \Illuminate\Http\Response
     */
    public function show(Species $species)
    {
        //
    }

    

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $id=$request->id;
            $info=Brand::find($id);
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
            $info=Brand::find($id);
            return response()->json(['data'=>$info]);

        }

        return response()->json(['error' => 'Unauthenticated.'], 401);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Species  $species
     * @return \Illuminate\Http\Response
     */
    public function edit(Species $species)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Species  $species
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Species $species)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Species  $species
     * @return \Illuminate\Http\Response
     */
    public function destroy(Species $species)
    {
        //
    }
}
