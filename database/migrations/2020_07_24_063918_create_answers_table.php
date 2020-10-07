<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('post_id')->comment('ポストID');
            $table->string('text')->comment('回答');
            $table->unsignedInteger('bestanswer_flag')->comment('ベストアンサーフラッグ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
