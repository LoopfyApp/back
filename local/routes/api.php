<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['cors']], function () {

Route::post('boleto/info', 'Pagarme\PagarmeController@boletopost'); 

Route::post('distance', 'Api\ProductsController@points'); 
Route::post('reset', 'Api\AuthController@reset');
Route::post('register', 'Api\AuthController@signUp');
Route::post('lojas/service/data', 'Api\ServiceController@getCalendarservices'); 

Route::post('melhor/envio', 'Shipping\MelhorEnvioController@calcular');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Api\AuthController@login');

    Route::post('cnpj', 'Api\AuthController@consultaCNPJ');
    Route::post('cep', 'Api\AuthController@consultaCEP');

    Route::post('newcnpj', 'Api\AuthController@newcnpf');
    Route::post('newcpf', 'Api\AuthController@newcpf');

    Route::post('tokenPush', 'Api\AuthController@tokenPush');
    

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('user', 'Api\AuthController@user');
        Route::post('user/passwordreset', 'Api\AuthController@resetPassword');

        
        Route::post('resend', 'Api\AuthController@resendCode');
        Route::post('verify', 'Api\AuthController@verifyCode');
        Route::post('species', 'Api\AdminController@species');
        Route::post('CancelUser', 'Api\AuthController@CancelUser');
        Route::post('razas', 'Api\AdminController@razas');
        Route::post('mascote', 'Api\AdminController@mascote');
        
        Route::get('user/get/mascotes', 'Api\AdminController@Getmascote');
        Route::get('user/get/mascotes/breed/{id}', 'Api\AdminController@GetmascoteRaza');

        
        Route::post('category/veterinary', 'Api\AdminController@getVeterinary');
        Route::post('category/services', 'Api\AdminController@getServices');
        Route::get('user/mascotes/{id}', 'Api\AdminController@getSpecies');

        
        Route::post('lojas/services', 'Api\ServiceController@getindex'); 
        Route::post('lojas/category/services', 'Api\ServiceController@getservices');
         
        Route::post('lojas/service/data', 'Api\ServiceController@getCalendarservices'); 
        Route::post('lojas/service/data/agendar', 'Api\ServiceController@getAgendar'); 

        Route::post('lojas/veterinary', 'Api\ServiceController@getindexVeterinary'); 
        Route::post('lojas/category/veterinary/services', 'Api\ServiceController@getVeterinary'); 



        Route::get('lojas/service/cart/{id_carts}', 'Api\ServiceController@getCart'); 
        Route::get('lojas/service/delete/cart/{id_cart}/{items}', 'Api\ServiceController@getDeleteCartItems');    
        Route::post('lojas/service/delete/cart', 'Api\ServiceController@getDeleteCart');         
  

        //POST
        Route::post('posts/store', 'Api\PostController@storePosts'); 
        Route::post('posts/comments/store', 'Api\PostController@storeCommentsPosts'); 
        Route::post('posts/reports/store', 'Api\PostController@storeReportPosts'); 
        Route::post('posts/follow/store', 'Api\PostController@storeFollowPosts'); 
        Route::post('posts/favorite/store', 'Api\PostController@storeFavoritePosts'); 
        Route::get('posts/all', 'Api\PostController@postall'); 
        Route::get('posts/{id}', 'Api\PostController@idPost'); 
        Route::post('posts/sugestions', 'Api\PostController@postallRandoms'); 
        Route::get('posts/pets/{id}', 'Api\PostController@postallId'); 
        Route::get('posts/comments/{id}', 'Api\PostController@postallComments'); 
        Route::post('posts/comments/delete', 'Api\PostController@deletePostComments'); 
        Route::post('posts/delete', 'Api\PostController@deletePosts');         
        Route::post('posts/follow/delete', 'Api\PostController@deleteFollowPosts'); 
        Route::post('posts/favorite/delete', 'Api\PostController@deleteFavoritePosts'); 

        //PRODUCTS
        Route::post('products/specie/{species_id}', 'Api\ProductsController@getIndexCategory'); 
        Route::post('products/search', 'Api\ProductsController@getIndexProductos'); 
        Route::post('products/{id}', 'Api\ProductsController@getIdProductos'); 
        Route::post('products/users/store', 'Api\ProductsController@getIndexProductosStore'); 
        Route::post('products/stores/offerts', 'Api\ProductsController@getIndexProductosOfferts'); 

        

        

        Route::post('products/carts/items', 'Api\ProductsController@detailsCart'); 
        Route::post('products/add/cart', 'Api\ProductsController@addcart'); 
        Route::post('products/delete/item/cart', 'Api\ProductsController@deleteitems'); 
        Route::post('products/delete/cart', 'Api\ProductsController@deleteCart'); 
        
        //STORES
        
        
        //PAGAMENTO

        Route::post('payament/juros', 'Pagarme\PagarmeController@parcelamiento'); 
        Route::post('payament/boletos', 'Pagarme\PagarmeController@boleto'); 



        Route::post('users/delete/pets', 'Api\PostController@deletePets');
        //deletePets
        
        
    });
});

});

/*id_pet:
      id_service:
      date: 'dd-MM-yyyy',,
      hour:'' 00:00
auth/lojas/service/data/agendar
post*/