<?php

namespace App\Http\Controllers;

use App\Models\AlbumCategory;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Photo;
use App\User;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = Album::latest()->with('categories')->get();

        return view('gallery.albums')
            ->with('albums', $albums);
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

    public function showAlbumsByCategory(AlbumCategory $category)
    {
        return view('gallery.albums')
            ->with('albums', $category->albums);
    }

}
