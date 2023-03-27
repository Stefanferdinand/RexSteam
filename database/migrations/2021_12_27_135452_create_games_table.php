<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('genreId');
            $table->foreign('genreId')->references('id')->on('genres');
            $table->string('gameName');
            $table->longText('gameSummary');
            $table->longText('gameDescription');
            $table->string('gameDeveloper');
            $table->string('gamePublisher');
            $table->double('gamePrice');
            $table->string('gameCover');
            $table->string('gameTrailer');
            $table->boolean('adultOnly');
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
        Schema::dropIfExists('games');
    }
}
