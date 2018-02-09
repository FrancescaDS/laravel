<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Photo;
use App\Models\Album;
use Storage;

class PhotosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
       // $this->authorizeResource(Photo::class);
    }

    protected $rules = [
        'album_id' => 'required|integer|exists:albums,id',
        'name' => 'required',
        'description' => 'nullable|min:3',
        'image_path' => 'required|image'
    ];

    protected $errorMessages = [
        'album_id.required' => 'Select an Album',
        'name.required' => 'Insert a name',
        'description.required' => 'Insert a description',
        'image_path.required' => 'Insert an image file',
        'image_path.image' => 'Format file non correct: insert an image file'

    ];

    public function index()
    {
        return Photo::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $id = $req->has('album_id')?$req->input('album_id'):null;
        $album = Album::firstOrNew(['id' => $id]);
        $photo = new Photo();
        $albums = $this->getAlbums();
        return view('images.editimage', compact('album','albums','photo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules, $this->errorMessages);

        $photo = new Photo();
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $photo->album_id = $request->input('album_id');

        $this->processFile($photo);
        $photo->save();
        return redirect(route('album.getimages',$photo->album_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        return $photo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        $albums = $this->getAlbums();
        $album = $photo->album;
        return view('images.editimage', compact('album','albums','photo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        unset($this->rules['image_path']);
        $this->validate($request, $this->rules, $this->errorMessages);
        $this->processFile($photo);
        $photo->album_id = $request->album_id;
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $res = $photo->save();
        $messaggio = $res ? 'Photo '.$photo->name.' aggiornata' : 'Photo '.$photo->name.' NON aggiornata';
        session()->flash('message', $messaggio);
        return redirect()->route('album.getimages', $photo->album_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $res = $photo->delete();
        if($res){
            $this->deleteFile($photo);
        }
        return ''.$res;
    }

    public function deleteFile(Photo $photo){
        $disk = config('filesystem.default');
        if($photo->image_path && Storage::disk($disk)->has($photo->image_path)){
            return Storage::disk($disk)->delete($photo->image_path);
        }
        return false;
    }

    public function processFile(Photo &$photo, Request $req = null)
    {
        if(!$req){
            $req = request();
        }
        if (!$req->hasFile('image_path')) {
            return false;
        }

        $file = $req->file('image_path');
        if (!$file->isValid()) {
            return false;
        }

        $fileName = $photo->id . '.' . $file->extension();
        $fileName = $file->storeAs(env('IMG_DIR').'/'.$photo->album_id, $fileName);
        $photo->image_path = $fileName;

        return true;
    }

    public function getAlbums(){
        return Album::orderBy('album_name')->get();
    }
}
