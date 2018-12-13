<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title', 191)->default('');
            $table->string('slug', 191)->unique();
            $table->string('type', 10)->default('');
            $table->string('media', 191)->default('');
            $table->string('thumbnail', 191)->default('');
            $table->string('featured', 191)->default('');
            $table->boolean('safe')->default(true);
            $table->boolean('resized')->default(false);
            $table->boolean('reported')->default(false);
            $table->string('source', 191)->nullable();

            // Cache fields
            $table->integer('reports')->default(0)->unsigned();
            $table->integer('comments')->default(0)->unsigned();
            $table->integer('likes')->default(0)->unsigned();
            $table->integer('dislikes')->default(0)->unsigned();
            $table->integer('points')->default(0);

            $table->timestamps();
            $table->softDeletes();

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
        Schema::drop('posts');
    }

}
