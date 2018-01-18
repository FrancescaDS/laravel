<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Album;

class SeedAlbumTable extends Seeder
{
    public function run()
    {
        factory(App\Models\Album::class, 10)->create();
    }
}
