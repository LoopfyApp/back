<?php

use Illuminate\Support\Facades\Route; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('prueba', 'Panda\PandaController@authenticate')->name('sales.token.index'); 

Route::get('/', 'HomeController@home')->name('login');
Route::get('login', 'HomeController@home')->name('login');
Route::post('login', 'HomeController@login');

Route::get('logout', 'HomeController@logout')->name('logout');

Route::get('email-test', function(){

  

    $details['email'] = 'academiacurso@gmail.com';
    $details['nombre']="Duglas moreno";
    $details['dispositivo']="Android";
     

    Mail::send('emails.register', ['details' => $details], function ($message) 
        {
  
            $message->to('academiacurso@gmail.com'); 
            $message->subject("New Email From Your site");
        });

    dispatch(new App\Jobs\SendEmailJob($details));

  

    dd('done');

});
Route::prefix('admin')->group(function () {

    Route::get('home', 'PanelController@index')->name('admin.home');
    Route::resource('species', SpeciesController::class);
    Route::get('species/info/{id}', 'SpeciesController@info')->name('species.info');
    Route::get('species/status/{id}', 'SpeciesController@status')->name('species.status');
    Route::resource('category', CategoryController::class);
    Route::get('category/details/{id}', 'CategoryController@details')->name('category.details');
    Route::get('category/info/{id}', 'CategoryController@info')->name('category.info');
    Route::get('category/status/{id}', 'CategoryController@status')->name('category.status');
    Route::resource('subcategory', SubcategoryController::class);
    Route::get('subcategory/info/{id}', 'SubcategoryController@info')->name('subcategory.info');
    Route::get('subcategory/status/{id}', 'SubcategoryController@status')->name('subcategory.status');

    
    Route::resource('trademarks', BrandController::class);
    Route::get('trademarks/info/{id}', 'BrandController@info')->name('trademarks.info');
    Route::get('trademarks/status/{id}', 'BrandController@status')->name('trademarks.status');

    
    Route::resource('breed', BreedController::class);
    Route::get('breed/info/{id}', 'BreedController@info')->name('breed.info');
    Route::get('breed/status/{id}', 'BreedController@status')->name('breed.status');
});
 

Route::prefix('business')->group(function () {

    Route::get('profile', 'Business\ProfileController@index')->name('business.profile.index');
    Route::post('profile', 'Business\ProfileController@saveIndex')->name('business.profile.save');
    Route::get('profile/consulta', 'Business\ProfileController@consultaCEP')->name('business.profile.consulta');

    Route::get('bank/index', 'Business\PagarmeUserController@index')->name('business.profile.bank.index');
    Route::post('bank/index', 'Business\PagarmeUserController@createaccount')->name('business.profile.bank.store');

    Route::get('services', 'Business\ServicesController@index')->name('business.services.index');
    Route::get('services/add', 'Business\ServicesController@add')->name('business.services.add');
    Route::post('services/add', 'Business\ServicesController@storeData')->name('business.services.storedata');
    Route::get('services/edit/{id}', 'Business\ServicesController@edit')->name('business.services.edit');
    Route::get('services/status/{id}', 'Business\ServicesController@status')->name('business.services.status');



    
    Route::get('veterinary', 'Business\VeterinaryController@index')->name('business.veterinary.index');
    Route::get('veterinary/add', 'Business\VeterinaryController@add')->name('business.veterinary.add');
    Route::post('veterinary/add', 'Business\VeterinaryController@storeData')->name('business.veterinary.storedata');
    Route::get('veterinary/edit/{id}', 'Business\VeterinaryController@edit')->name('business.veterinary.edit');
    Route::get('veterinary/status/{id}', 'Business\VeterinaryController@status')->name('business.veterinary.status');

      
    Route::get('products', 'Business\ProductsController@index')->name('business.products.index');        
    Route::get('products/add', 'Business\ProductsController@add')->name('business.products.add');      
    Route::get('products/subcategorys/{id}', 'Business\ProductsController@subcategoria')->name('business.products.subcategorys');  
    Route::get('products/species/{id}', 'Business\ProductsController@species')->name('business.products.species');        
    Route::post('products/add', 'Business\ProductsController@storeData')->name('business.products.store'); 
    Route::get('products/status/{id}', 'Business\ProductsController@status')->name('business.products.status');     
    Route::get('products/edit/{id}', 'Business\ProductsController@edit')->name('business.products.edit');    
    Route::post('products/edit/{id}', 'Business\ProductsController@storeEditData')->name('business.products.editSave');   

    Route::get('agenda', 'Business\AgendaController@index')->name('business.agenda.index');      
    
    Route::get('sales', 'Business\SalesController@index')->name('business.sales.index'); 

    

});