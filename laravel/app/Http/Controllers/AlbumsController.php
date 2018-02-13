<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\AlbumRequest;
use App\Http\Requests\AlbumUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\AlbumsCategory;
use App\Models\Photo;
use App\User;
use DB;
use Storage;

class AlbumsController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth')->only(['create']);
        //$this->middleware('auth')->except(['index']);

    }

    public function index(Request $request)
    {
        $queryBuilder = Album::orderBy('id','desc')->withCount('photos')->with('categories');
        $queryBuilder->where('user_id', Auth::user()->id);
        if($request->has('id')){
            $queryBuilder->where('id',$request->get('id'));
        }
        if($request->has('album_name')){
            $queryBuilder->where('album_name', 'LIKE', '%'.$request->get('album_name').'%');
        }
        $albums = $queryBuilder->paginate(env('ITEMS_PER_PAGE'));
        return view('albums.albums', ['albums' => $albums]);
}

    public function delete(Album $album){
        //$album = Album::findOrFail($id);
        //$res = $album->delete();

        //$res = $album = Album::find($id)->delete();

        $this->authorize('delete', $album);

        $thumbNail = $album->album_thumb;
        $disk = config('filesystem.default');
        $res = $album->delete();
        if($res){
            if($thumbNail && Storage::disk($disk)->has($thumbNail)){
                Storage::disk($disk)->delete($thumbNail);
            }
        }
        return ''.$res;
    }

    /*public function show($id){
        $sql = 'SELECT * FROM albums WHERE id= :id';
        return DB::select($sql, ['id' => $id]);
    }*/

    public function edit($id){
        $album = Album::find($id);

        //altro modo per autorizzare
       // Auth::user()->can('update',$album);

        $this->authorize('update', $album);


        /*if(\Gate::denies('manage-album', $album)){
            abort(401, 'Unauthorized');
        }*/

        /* if($album->user->id !== Auth::user()->id){
            abort(401, 'Unauthorized');
        }*/

        $selectedCategories = $album->categories->pluck('id')->toArray();
        $categories = AlbumCategory::get();
        return view('albums.editalbum')
            ->with(
                [
                    'album'=>$album,
                    'categories'=>$categories,
                    'selectedCategories'=>$selectedCategories
                ]);
    }

    public function store($id, AlbumUpdateRequest $req){
        $album = Album::find($id);

        /*if(\Gate::denies('manage-album', $album)){
            abort(401, 'Unauthorized');
        }*/

        $album->album_name = request()->input('name');
        $album->description = request()->input('description');
        $album->user_id =  request()->user()->id;
        $this->processFile($id, $req, $album);
        $res = $album->save();
        //il metodo sync sincronizza le relazioni molti a molti
        //album-categorie
        $album->categories()->sync($req->categories);
        $messaggio = $res ? 'Album '.$id.' aggiornato' : 'Album '.$id.' NON aggiornato';
        session()->flash('message', $messaggio);
        return redirect()->route('albums');
    }

    public function create(){
        $album = new Album();

        $categories = AlbumCategory::get();
        $selectedCategories=[];
        return view('albums.createalbum',
            [
                'album' => $album,
                'categories' => $categories,
                'selectedCategories' => $selectedCategories
            ]);
    }

    public function save(AlbumRequest $request){

        $album = new Album();
        $name = $request->input('name');
        $album->album_name = $name;
        $album->album_thumb = '';
        $album->description = $request->input('description');
        $album->user_id = $request->user()->id;
        $res = $album->save();

        if($res){
            if($request->has('categories')){
                //il metodo attach inserisce le relazioni molti a molti
                //album-categorie
                $album->categories()->attach($request->categories);
            }
            if($this->processFile($album->id, $request, $album)){
                $album->save();
            }
        }

        $messaggio = $res ? 'Album "'.$name.'" creato' : 'Album "'.$name.'" NON creato';

        session()->flash('message', $messaggio);
        return redirect()->route('albums');
    }


    public function processFile($id, Request $req, &$album)
    {
        if (!$req->hasFile('album_thumb')) {
            return false;
        }

        $file = $req->file('album_thumb');
        if (!$file->isValid()) {
            return false;
        }

        //$fileName = $file->store(env('ALBUM_THUMB_DIR'), 'public');
        //$fileName = $file->store(env('ALBUM_THUMB_DIR'));
        $fileName = $id . '.' . $file->extension();
        $fileName = $file->storeAs(env('ALBUM_THUMB_DIR'), $fileName);
        $album->album_thumb = $fileName;
        return true;
    }

    public function getImages(Album $album){

        if(\Gate::denies('manage-album', $album)){
            abort(401, 'Unauthorized');
        }

        //con il metodo GET le ritorna tutte
        //$images = Photo::where('album_id', $album->id)->get();

        //ritorna la quantita di elementi per ogni pagina
        //qui e' in una costante nel file .env
        $images = Photo::where('album_id', $album->id)->paginate(env('ITEMS_PER_PAGE'));

        //return $images;
        return view('images.albumimages', compact('album', 'images'));
    }

    public function  show( Album $album){
        echo 'show';
        dd($album);
    }

}
