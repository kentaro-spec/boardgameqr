<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardgamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boardgames', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique()->comment('ボードゲーム名');
            $table->string('boardgame_image')->nullable()->comment('ボードゲーム画像');
            $table->unsignedInteger('post_count')->comment('ゲームが持つPost数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boardgames');
    }
}
