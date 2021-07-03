<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMovieMovieListRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_movie_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_list_id');
            $table->unsignedBigInteger('movie_id');
            $table->timestamps();

            $table->foreign('movie_list_id')->references('id')->on('movie_lists');
            $table->foreign('movie_id')->references('id')->on('movies');
        });

        Schema::table('movie_lists', function (Blueprint $table) {
            if (env('DB_CONNECTION') !== 'sqlite') {
                $table->dropForeign('movie_lists_movie_id_foreign');
            }
            $table->dropColumn('movie_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_movie_list');

        Schema::table('movie_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('movie_id');
            $table->foreign('movie_id')->references('id')->on('movies');
        });
    }
}
