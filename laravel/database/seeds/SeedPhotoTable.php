<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Album;
use App\Models\Photo;


class SeedPhotoTable extends Seeder
{
    public function run()
    {
        $albums = Album::get();
        foreach ($albums as $album) {
            factory(App\Models\Photo::class, 200)->create(
                ['album_id' => $album->id]
            );
        }

    }
}
