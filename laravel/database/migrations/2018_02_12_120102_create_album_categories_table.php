<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name',64)->unique;
            $table->softDeletes();
            $table->timestamps();
        });

        //creazione tabella di relazione (pivot)
        Schema::create('album_category', function (Blueprint $table) {
            //id non obbligatorio
            $table->increments('id');
            $table->integer('album_id')->insigned();
            $table->integer('category_id')->insigned();

            //indice univoco, come se fosse la primay key
            $table->unique(['album_id','category_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_categories');
    }
}
