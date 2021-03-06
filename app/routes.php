<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    return Redirect::to('login');
    //return View::make('hello');
});

Route::post('login', function(){
    if(User::where('name',Input::get('name'))->count() == 0 )   
        return Redirect::to('login');
    else
    {
        $user = User::where('name',Input::get('name'))->take(1)->get();
        if($user[0]->password == Input::get('password'))
        {
            Auth::loginUsingId($user[0]->id);
            User::setCustomerSelect($user[0]->id, Input::get('nameCustomer'));
            return Redirect::to('showread');
        }
        else
            return Redirect::to('login');        
    }
});
Route::get('/login', 'HomeController@doLogin');
Route::post('/test_get_folio', 'HomeController@test_get_folio');
Route::post('/ordenesmhd', 'OrdenEsMController@storeHandheld');
Route::resource('ordenesd', 'OrdenEsDController');
Route::post('/variables/get_var_read', 'HomeController@get_var_read');
Route::post('/variables/set_no_read', 'HomeController@set_no_read');
Route::get('/test', 'HomeController@test');
Route::resource('ordenesm', 'OrdenEsMController');
Route::resource('logs', 'EventsLogController');
Route::get('/reset_read','HomeController@reset_read');
Route::group(array('before' => 'auth'), function()
{    
    Route::post('/test_get_product', 'HomeController@test_get_product');    
    Route::get('/logout','HomeController@logout');
    Route::post('/add_product', 'HomeController@add_product');

    Route::get('/upc/data_pending', 'OrdenEsDController@row_data_pending');
    Route::get('/upc/data/{id?}', 'OrdenEsDController@row_data');    
    Route::post('/read/start_read', 'OrdenEsDController@start_read');
    Route::post('/read/show_read', 'OrdenEsDController@show_read');
    Route::post('/read/checkfolio', 'OrdenEsDController@checkfolio');

    Route::get('/ordenesm',  'OrdenEsMController@getIndex');
    Route::get('/getIndexData',  'OrdenEsMController@getIndexData');

    Route::get('/showread', 'OrdenEsMController@showread');        

    Route::get('/dates/lastfolio', 'OrdenEsMController@dateslastfolio');
    Route::post('/writeJsonFolio', 'OrdenEsMController@writeJsonFolio');
    Route::post('/writeJsonTags', 'OrdenEsMController@writeJsonTags');

    Route::get('/sync', 'SyncController@index');
    Route::post('/sync', 'SyncController@postInventory');
    Route::post('/sync/desktop', 'SyncController@postDesktop');
    Route::post('/sync/postRead', 'SyncController@postRead');

    Route::get('/events_logs/rows_data', 'EventsLogController@rows_data');

    Route::resource('customer', 'CustomerController');

    Route::resource('product', 'ProductController');

});
