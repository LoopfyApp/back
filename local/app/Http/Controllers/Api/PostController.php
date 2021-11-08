<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommentsPostsPets;
use App\Models\FavoritePostsPets;
use App\Models\FollowPostsPets;
use App\Models\PostsPets;
use App\Models\UsersSpecie;
use App\Models\ReportPostsPets;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PostController extends Controller
{

    public function storePosts(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 401);
        } else {
            $post = new PostsPets;
            $post->users_id = $user->id;
            $post->users_pets_id = $request->pets_id;
            $post->description = utf8_encode($request->description);
            $post->photo = $this->imagenbase64($request->photo, $user->id);
            $post->save();

            return response()->json([
                'error' => false,
                'message' => 'Postagem criada com sucesso'
            ], 200);
        }
    }

    public function storeCommentsPosts(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 401);
        } else {
            $coments = new CommentsPostsPets;
            $coments->users_id = $user->id;
            $coments->users_pets_id = $request->pets_id;
            $coments->posts_pets_id = $request->posts_id;
            $coments->comments = utf8_encode($request->comments);
            $coments->save();

            return response()->json([
                'error' => false,
                'message' => 'Comentário criada com sucesso'
            ], 200);
        }
    }



    public function storeFavoritePosts(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 401);
        } else {
            $coments = new FavoritePostsPets;
            $coments->users_id = $user->id;
            $coments->users_pets_id = $request->pets_id;
            $coments->posts_pets_id = $request->posts_id;
            $coments->save();

            return response()->json([
                'error' => false,
                'message' => 'Curtido com sucesso'
            ], 200);
        }
    }


    public function storeFollowPosts(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 401);
        } else {
            $coments = new FollowPostsPets;
            $coments->users_id = $user->id;
            $coments->users_pets_id = $user->id;
            $coments->users_pets_follow_id = $request->users_pets_follow_id;
            $coments->save();

            return response()->json([
                'error' => false,
                'data'=>$coments,
                'message' => 'Seguindo seu pets, com sucesso'
            ], 200);
        }
    }



    public function storeReportPosts(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 401);
        } else {
            $coments = new ReportPostsPets;
            $coments->users_id = $user->id;
            $coments->users_pets_id = $request->pets_id;
            $coments->posts_pets_id = $request->posts_id;
            $coments->motive = $request->motive;
            $coments->save();

            return response()->json([
                'error' => false,
                'message' => 'Comentário criada com sucesso'
            ], 200);
        }
    }



    public function imagenbase64($imagen, $id)
    {
        $data = $imagen;
        $base64_str = substr($data, strpos($data, ",") + 1);
        $image = base64_decode($base64_str);
        $filename   = 'post/' . $id . 'post_' . time() . '_' . rand(111, 699) . '.png';
        \Storage::disk('public')->put($filename, $image);
        return $filename;
    }

public function idPost($id,Request $request){
    
    if ($request->user()) {
        $post = PostsPets::where('id',$id)->where('status',0)->with('users', 'pets') 
        ->with('comenets','comenets.pets')
        ->where('status', 0)
        ->orderby('created_at', 'desc')->get();

        return response()->json([
            'error' => false,
            'data' => $post
        ], 200);
    }

    return response()->json([
        'error' => false,
        'mensaje' => "Error"
    ], 401);
}

    public function postall(Request $request)
    {
 
        if ($request->user()) {
            $post = PostsPets::
            where('status', 0)
            ->with('users', 'pets') 
            ->with('comenets','comenets.pets')
            ->orderby('created_at', 'desc')->get();

            return response()->json([
                'error' => false,
                'data' => $post
            ], 200);
        }

        return response()->json([
            'error' => false,
            'mensaje' => "Error"
        ], 401);
    }


    
    public function postallRandoms(Request $request)
    {

        if ($request->user()) {
            $post = 
            PostsPets::
            where('status', 0)
            ->inRandomOrder()
            ->with('users', 'pets') 
            ->with('comenets','comenets.pets')
            ->limit(5)->get();

            return response()->json([
                'error' => false,
                'data' => $post
            ], 200);
        }

        return response()->json([
            'error' => true,
            'mensaje' => "Error"
        ], 401);
    }
   

    public function postallId(Request $request, $id)
    {

        if ($request->user()) {
            $user_id = $request->user()->id;
            $post = PostsPets::
            where('users_pets_id', $id)
            ->where('status', 0)
            ->orderby('created_at', 'desc')
            ->with('users', 'pets')
            ->withCount('favoritepets')
            ->get();
            return response()->json([
                'error' => false,
                'data' => $post
            ], 200);
        }

        return response()->json([
            'error' => false,
            'mensaje' => "Error"
        ], 401);
    }



    public function postallComments(Request $request, $id)
    {
        if ($request->user()) {
            $user_id = $request->user()->id;
            $post = CommentsPostsPets::where('posts_pets_id', $id)->with('pets')->orderby('created_at', 'desc')->get();
            return response()->json([
                'error' => false,
                'data' => $post
            ], 200);
        }

        return response()->json([
            'error' => false,
            'mensaje' => "Error"
        ], 401);
    }



    public function deletePostComments(Request $request)
    {
        if ($request->user()) {

            $post = CommentsPostsPets::where('id', $request->id_comment)->delete();
            return response()->json([
                'error' => false,
                'message' => 'Comentário removido com sucesso'
            ], 200);
        }

        return response()->json([
            'error' => false,
            'mensaje' => "Error"
        ], 401);
    }



    public function deletePosts(Request $request)
    {
        if ($request->user()) {

            $post = PostsPets::where('id', $request->id_post)->delete();
            return response()->json([
                'error' => false,
                'message' => 'Postagem excluída com sucesso'
            ], 200);
        }

        return response()->json([
            'error' => false,
            'mensaje' => "Error"
        ], 401);
    }


    public function deleteFollowPosts(Request $request)
    {
        if ($request->user()) {

            $post = FollowPostsPets::where('id', $request->id)->delete();
            return response()->json([
                'error' => false,
                'message' => 'Pets excluída com sucesso'
            ], 200);
        }

        return response()->json([
            'error' => false,
            'mensaje' => "Error"
        ], 401);
    }


    public function deleteFavoritePosts(Request $request)
    {
        if ($request->user()) {

            $post = FavoritePostsPets::where('id', $request->id)->delete();
            return response()->json([
                'error' => false,
                'message' => 'Postagem excluída com sucesso'
            ], 200);
        }

        return response()->json([
            'error' => false,
            'mensaje' => "Error"
        ], 401);
    }




public function deletePets(Request $request){
    
    if ($request->user()) {
        PostsPets::where('users_pets_id',$request->idPets)->update(['status'=>1]);
        UsersSpecie::where('id',$request->idPets)->update(['status'=>1]);

        return response()->json([
            'error' => false,
            'mensaje' => "Pets Apagado"
        ], 200);
    }
}
    
}
