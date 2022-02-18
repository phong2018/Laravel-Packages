<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlgPostRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plg_post_related', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('plg_posts')->cascadeOnDelete();
            $table->foreignId('relate_id')->constrained('plg_posts')->cascadeOnDelete();
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
        Schema::dropIfExists('plg_post_related');
    }
}
