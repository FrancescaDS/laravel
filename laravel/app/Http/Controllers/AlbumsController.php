<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumRequest;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Photo;
use DB;
use Storage;

class AlbumsController extends Controller
{
    public function index(Request $request)
    {
        $queryBuilder = Album::orderBy('id','desc')->withCount('photos');
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

    public function show($id){
        $sql = 'SELECT * FROM albums WHERE id= :id';
        return DB::select($sql, ['id' => $id]);
    }

    public function edit($id){
        $album = Album::find($id);
        return view('albums.editalbum')->with('album',$album);
    }

    public function store($id, AlbumRequest $req){
        $album = Album::find($id);
        $album->album_name = request()->input('name');
        $album->description = request()->input('description');
        $album->user_id = 1;
        $this->processFile($id, $req, $album);
        $res = $album->save();
        $messaggio = $res ? 'Album '.$id.' aggiornato' : 'Album '.$id.' NON aggiornato';
        session()->flash('message', $messaggio);
        return redirect()->route('albums');
    }

    public function create(){
        $album = new Album();
        return view('albums.createalbum', ['album' => $album]);
    }

    public function save(AlbumUpdateRequest $request){
        $name = $request->input('name');
        $album = new Album();
        $album->album_name = $name;
        $album->description = $request->input('description');
        $album->user_id = 1;
        $res = $album->save();
        if($res){
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
        //con il metodo GET le ritorna tutte
        //$images = Photo::where('album_id', $album->id)->get();

        //ritorna la quantita di elementi per ogni pagina
        //qui e' in una costante nel file .env
        $images = Photo::where('album_id', $album->id)->paginate(env('ITEMS_PER_PAGE'));

        //return $images;
        return view('images.albumimages', compact('album', 'images'));
    }


}
