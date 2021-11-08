<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
use App\Models\Species;
use App\Models\Breed;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Auth;

class UsersSpecie extends Model
{
    use HasFactory;

    protected $appends = array('follower');

    public function getPhotoAttribute($value)
    {
        if ($value == 'null') {

            return asset("images/no-camaras.png");
        }
        return asset("local/storage/app/public/" . $value);
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


    public function getId($id)
    {
        return UsersSpecie::where('id', $id)->with(['users','species','breed'])->first();
    }

      public function getFollowerAttribute()
    {
         
        return FollowPostsPets::where('users_id',Auth::user()->id)->where('users_pets_follow_id',$this->id)->first();
    }

    public function add($data, $idUsers)
    {
        if($data->id == null){
            $mascote = new UsersSpecie();
        }
        else{
            $mascote = UsersSpecie::find($data->id);
        }
        $mascote->users_id = $idUsers;
        $mascote->species_id = $data->id_species;
        $mascote->breeds_id = $data->id_raza;
        $mascote->name = $data->name;
        $mascote->description = $data->description;
        
        $mascote->identification = $data->identification;
        $mascote->size = $data->size;
        $mascote->castrated = $data->castrated;
        if($data->vaccines != null){
            $mascote->vaccines = implode(",", $data->vaccines);
        }
        

        $mascote->genero = $data->genero;
        $mascote->birthday = $data->birthday;

 


 
        if ($data->photo != null && ( $data->photo != "../../assets/super/4.jpg" && $data->photo !='/assets/button/boton_foto.svg') ) {


            $img = $this->getB64Image($data->photo);
            $img_extension = 'png';//$this->getB64Extension($data->photo);

            $carpeta = "mascote/" . $idUsers;
            $ln = Str::random(25);
            $name = $ln . "." . $img_extension;
            Storage::disk('public')->put($carpeta . "/" . $name, $img);
            // $data->photo->storeAs($carpeta, $name,'public');
            $mascote->photo = "" . $carpeta . "/" . $name;
        } else {
            if($data->id==null){$mascote->photo = "null";}
        }


        $mascote->save();

        return response()->json([
            'error' => false,
            'message' => 'Dados salvos com sucesso'
        ], 200);
    }

    public function getAll($id)
    {
        return UsersSpecie::where('status', 0)->where('users_id', $id)->with(['species','breed'])->get();
    }

    public function getAllbreed($id,$species)
    {
        return UsersSpecie::where('status', 0)->where('species_id', $species)->where('users_id', $id)->get();
    }

    public function species()
    {
        return $this->belongsTo(Species::class, 'species_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function breed()
    {
        return $this->belongsTo(Breed::class, 'breeds_id');
    }
}
