<?php


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

use App\User;
use App\Models\Album;
use App\Models\Photo;

Route::get('/','HomeController@index');



//Route::get('/', function () {
    //return view('welcome'); //prints the page
    //return view('test'); //prints the page
    //return ['hello','world'];//prints the array in Jason
    //return 'hello world';//prints the string



Route::get('welcome/{name?}/{lastname?}/{age?}','WelcomeController@welcome')
->where([
        'name' => '[a-zA-Z]+',
        'lastname' => '[a-zA-Z]+',
        'age' => '[0-9]{1,3}'
    ]);



/*Route::get('/{name?}/{lastname?}/{age?}', function ($name='',$lastname='',$age=0) {
    return '<h1>hello world '.$name.' '.$lastname.' you are '.$age.' old</h1>';
})
    
    //->where('name','[a-zA-Z]+')
    //->where('name','[a-zA-Z]+');
    
    ->where([
        'name' => '[a-zA-Z]+',
        'lastname' => '[a-zA-Z]+',
        'age' => '[0-9]{1,3}'
    ]);*/


Route::get('/users',function(){
    return User::all();
});

Route::get('/albums','AlbumsController@index');
Route::delete('/albums/{id}','AlbumsController@delete');
Route::get('/albums/{id}','AlbumsController@show');
Route::get('/albums/{id}/edit','AlbumsController@edit');
Route::post('/albums/{id}','AlbumsController@store');



Route::get('/photos',function(){
    return Photo::all();
});