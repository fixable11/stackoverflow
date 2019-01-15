<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique();;
            $table->string('nickname')->unique();
            $table->text('description');
            $table->string('avatar_path')->nullable();
            $table->date('birthday');
            $table->string('gender');
            $table->string('number')->unique();;
            $table->string('address')->nullable();
            $table->json('social_links')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_metas');
    }
}
