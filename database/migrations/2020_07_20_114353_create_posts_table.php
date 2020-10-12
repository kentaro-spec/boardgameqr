<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->comment('質問のタイトル');
            $table->string('text')->comment('質問内容');
            $table->string('interpretation')->nullable()->comment('個人の解釈');
            $table->string('imgpath')->nullable()->comment('解釈の画像');
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('boardgame_id')->comment('ボードゲームID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
