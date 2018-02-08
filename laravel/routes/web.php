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

Route::get('/home','AlbumsController@index')->name('albums');

Route::get('/albums','AlbumsController@index')->name('albums');
Route::get('/albums/{id}','AlbumsController@show')->where('id','[0-9]+');
Route::get('/albums/create','AlbumsController@create')->name('album.create');
Route::get('/albums/{id}/edit','AlbumsController@edit');
Route::delete('/albums/{album}','AlbumsController@delete')
->where('album', '[0-9]+');
Route::post('/albums','AlbumsController@save')->name('album.save');

//Route::post('/albums/{id}','AlbumsController@store');
Route::patch('/albums/{id}','AlbumsController@store');
Route::get('/albums/{album}/images','AlbumsController@getImages')
    ->name('album.getimages')
    ->where('album', '[0-9]+');


Route::get('/photos',function(){
    return Photo::all();
});

Route ::get('usernoalbums', function(){
    $usersnoalbum = DB::table('users as u')

        ->select('u.id','email','name')
        ->whereRaw('NOT EXISTS (SELECT user_id from albums where user_id=u.id)')

       // ->leftJoin('albums as a', 'u.id','a.user_id')
        //->whereNull('album_name')
        //->whereRaw('album_name is null')
        //->select('u.id','email','name','album_name')
        ->get();
    return $usersnoalbum;
});

//images
Route::resource('photos', 'PhotosController');
Auth::routes();

//questa rotta e' stata inserita da Laravel con auth
//va alla pagina di welcome dopo la registrazione
//noi l'abbiamo commentata per farlo andare alla home gia' presente
//vedi rotta piu' in alto. che e' le'enco degli album
//Route::get('/home', 'HomeController@index')->name('home');
