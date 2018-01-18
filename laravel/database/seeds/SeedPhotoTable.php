<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Photo;

class SeedPhotoTable extends Seeder
{
    public function run()
    {
        factory(App\Models\Photo::class, 200)->create();
    }
}
