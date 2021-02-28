<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameListListItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_list_list_item', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('game_list_id')->unsigned();
            $table->foreign('game_list_id')
                ->references('id')
                ->on('game_lists')->onDelete('cascade');
            $table->bigInteger('list_item_id')->unsigned();
            $table->foreign('list_item_id')
                ->references('id')
                ->on('list_items')->onDelete('cascade');
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
        Schema::dropIfExists('game_list_list_item');
    }
}
