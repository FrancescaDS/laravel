<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Album;
use App\Models\Photo;
use App\Models\AlbumCategory;

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
        AlbumCategory::truncate();

        $this->call(SeedUserTable::class);

        $this->call(SeedAlbumCategoriesTable::class);
        $this->call(SeedAlbumTable::class);
        $this->call(SeedPhotoTable::class);

    }
}
