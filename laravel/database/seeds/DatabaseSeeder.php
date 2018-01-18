<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Album;
use App\Models\Photo;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        //DB::table('users')->truncate();
        Album::truncate();
        Photo::truncate();

        $this->call(SeedUserTable::class);
        $this->call(SeedAlbumTable::class);
        $this->call(SeedPhotoTable::class);

    }
}
