<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Photo;
use App\User;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = Album::latest()->get();
        foreach ($albums as $album){
            return $album->categories;
        }



        return view('gallery.albums')
            ->with('albums', Album::latest()
            ->get()
            );
    }

    public function showAlbumImages(Album $album)
    {
        return view(
            'gallery.images',
            [
                'images' => Photo::whereAlbumId($album->id)
                        ->latest()
                        ->get(),
                'album' => $album
            ]
        );
    }
}
