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

use App\Models\User;
use App\Models\Album;
use App\Models\Photo;

Route::get('/','HomeController@index');

Route::get('allalbums', function(){
    //return Album::get();
    $albums = Album::get();
    $albums->dump();
    $albums->pluck('album_name')->dd();

});

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

Route::group(
    [
        'middleware' => 'auth',
        'prefix' => 'dashboard'
    ],
    function(){
        Route::get('/', 'AlbumsController@index')
            ->name('albums');

        Route::get('/albums/create','AlbumsController@create')
            ->name('album.create');

        Route::get('/albums','AlbumsController@index')
            ->name('albums');

        //si vede con questa URL http://laravel.local/albums/12 (12 e' id album)
        Route::get('/albums/{album}', 'AlbumsController@show')
            ->where('id', '[0-9]+')
            ->middleware('can:view,album');

        Route::get('/albums/{id}/edit','AlbumsController@edit')
            ->where('id','[0-9]+')
            ->name('album.edit');

        Route::delete('/albums/{album}','AlbumsController@delete')
            ->name('album.delete')
            ->where('album', '[0-9]+');

        //Route::post('/albums/{id}','AlbumsController@store');
        Route::patch('/albums/{id}','AlbumsController@store')
        ->name('album.patch');

        Route::post('/albums','AlbumsController@save')
            ->name('album.save');

        Route::get('/albums/{album}/images','AlbumsController@getImages')
            ->name('album.getimages')
            ->where('album', '[0-9]+');

        Route::get('photos',function(){
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

        //con resource automaticamente si creano tutte le rotte corrispondenti
        //da Terminal --php artisan route:list
        //images
        Route::resource('photos', 'PhotosController');

        //con resource automaticamente si creano tutte le rotte corrispondenti
        //da Terminal --php artisan route:list
        Route::resource('categories','AlbumCategoryController');

    });


//Gallery routes
Route::group(
    [
       'prefix' => 'gallery'
    ],
    function(){
        Route::get('albums', 'GalleryController@index')
            ->name('gallery.albums');
        Route::get('/', 'GalleryController@index')
            ->name('gallery.albums');

        Route::get('album/{album}/images', 'GalleryController@showAlbumImages')
            ->name('gallery.album.images');
        Route::get('album/category/{category}', 'GalleryController@showAlbumsByCategory')
            ->name('gallery.album.category');
    }
);

//Route::get('/albums','AlbumsController@index')->name('albums')
//->middleware('auth');

Auth::routes();

//questa rotta e' stata inserita da Laravel con auth
//va alla pagina di welcome dopo la registrazione
//noi l'abbiamo commentata per farlo andare alla home gia' presente
//vedi rotta piu' in alto. che e' le'enco degli album
//Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', 'GalleryController@index');

//cosi' chiamando 'home' resta home sulla url ma la pagina e' la stessa di '/'
//perche' chiama lo stesso metodo index del controlle GalleryController
/*Route::get('/home', 'GalleryController@index');*/
//cosi' chiamando 'home' nella url lo toglie
/*Route::get('home', function(){
   return redirect('/');
});*/
//piu' semplice
Route::redirect('home','/');