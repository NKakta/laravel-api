<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_lists', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->uuid('user_id');
            $table->string('name');
            $table->text('description');
            $table->integer('count')->default(0);
            $table->json('cover_urls')->nullable();
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
        Schema::dropIfExists('game_lists');
    }
}
