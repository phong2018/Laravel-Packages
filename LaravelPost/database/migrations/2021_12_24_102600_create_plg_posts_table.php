<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlgPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plg_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable()->index();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->integer('sort_order')->nullable();
            $table->string('tag')->nullable()->index();
            $table->foreignId('user_create_id')->constrained('users')->cascadeOnDelete();
            $table->date('publish_date')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('plg_posts');
    }
}
