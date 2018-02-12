<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\AlbumsCategory;

class SeedAlbumTable extends Seeder
{
    public function run()
    {
        //create ritorna una collection
        //ciclo poi la collection con il metodo each()
        //prendendo 3 categorie random prendendo con pluck solo l'id
        //ciclato in queste 3 per creare i record da mettere nella tabella
        // di relazione molti a molti tra albums e album-categories
        factory(Album::class,10)->create()
            ->each(function ($album){
                $cats = AlbumCategory::inRandomOrder()->take(3)->pluck('id');
                $cats->each(function ($cat_id) use($album){
                    AlbumsCategory::create([
                        'album_id' => $album->id,
                        'category_id' => $cat_id
                    ]);
                });
            });
    }
}
