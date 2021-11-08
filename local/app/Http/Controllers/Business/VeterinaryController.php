<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\UserServices;
use App\Models\UserServicesHours;
use App\Models\UserServicesSpecies;

use Illuminate\Http\Request;
use Validator;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Response;
use DateTime;

class VeterinaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datos = UserServices::where('users_id',Auth()->user()->id)->where('type_option',1)->get();
            return Datatables::of($datos)
            ->addIndexColumn()

            ->addColumn('categorys', function($row){
                $data=$row->categories->name;
                return $data;
            })

            ->addColumn('days', function($row){
                $data=$row->hours($row->id);
                $datos="";
                foreach($data as $infodata){
                   $datos.='<label   class="badge badge-success mr-1 mb-1">'.trans('profile.label_day_'.$infodata->days).'</label>';
                }
                return $datos;
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
            ->rawColumns(['action','status','days','categorys'])
            ->make(true);

        }
        $datos=array('title'=>trans('menu.veterinary'),'subtitles'=>trans('services.title_consulta') );
        return view('business.veterinary.index')->with(['datos'=>$datos]);
    }

    
    public function add(Request $request)
    {
        $catgorias=Category::where('type',2)->get();
        $datos=array('title'=>trans('menu.veterinary'),'subtitles'=>trans('services.add_consulta') );
        return view('business.veterinary.add')->with(['datos'=>$datos,'category'=>$catgorias]);
    }

    
    public function edit($id)
    {
        $datosinfo = UserServices::where('id',$id)->first();
        $catgorias=Category::where('type',2)->get();
        $datos=array('title'=>trans('menu.veterinary'),'subtitles'=>trans('services.add') );
        return view('business.veterinary.edit')->with(['datos'=>$datos,'category'=>$catgorias,'datosinfo'=>$datosinfo]);
    }

    public function storeData(Request $request){

        if( str_replace(":","",$request->hour_inicio) > str_replace(":","",$request->hour_fin)  )
        {
            return redirect()->back()->with('error','Error al Guardar los datos');
        }
      

      if($request->id==0){
        $userservices=new UserServices;
      }
      else{
        $userservices=UserServices::find($request->id);
      }
      
        $userservices->users_id=Auth()->user()->id;
        $userservices->category_id=$request->categories_id;
        $userservices->name=$request->name;
        $userservices->description=$request->description;
        $userservices->price=$request->price;
        $userservices->status=0;
        $userservices->time=$request->time_hours;
        $userservices->time_open=$request->hour_inicio;
        $userservices->time_close=$request->hour_fin;
        $userservices->time_open_descanso=$request->hour_open_break;
        $userservices->time_close_descanso=$request->hour_close_break;
        $userservices->type_option=1;
        
 
        $userservices->save();

        $species_id=$request->species_id;
        UserServicesSpecies::where('user_services_id',$userservices->id)->delete();
        UserServicesHours::where('user_services_id',$userservices->id)->delete();
        foreach($species_id as $data){
            $especies=new UserServicesSpecies;
            $especies->user_services_id=$userservices->id;
            $especies->species_id=$data;
            $especies->category_id=$request->categories_id;
            $especies->users_id=Auth()->user()->id;
            $especies->save();
        }
        $this->timehours($request,$userservices->id);
     
        return redirect()->route('business.veterinary.index')->with('message','Datos Registrado Correctamente');
       

    }

    public function timehours($request,$idServicio){
       
        $total=$request->time_hours * 60;
        $f1 = new DateTime($request->hour_inicio);
        $f2 = new DateTime($request->hour_fin);
        $d = $f1->diff($f2);
        $diferencia= ($d->format('%H') *3600) / $total;
        $horaInicial=$request->hour_inicio;
        for($a=1;$a<=($diferencia-1);$a++){
           $nuevaHora=date("H:i",strtotime($horaInicial) + $total); 
           foreach($request->service_days as $info){
            $UserServicesHours=new UserServicesHours;
            $UserServicesHours->user_services_id=$idServicio;
            $UserServicesHours->days=$info;
            $UserServicesHours->bloque=$nuevaHora;
            $UserServicesHours->save();
            }
            $horaInicial=$nuevaHora;
        }
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $id=$request->id;
            $info=UserServices::find($id);
            $info->status= ($info->status==0) ? 1 : 0;
            $info->save();
            return response()->json(['mensaje'=>trans('general.modify')]);
        }
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

}
