<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesoProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veso_products', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->foreignId('prize_id')->nullable()->constrained('veso_prizes')->nullOnDelete();  
            $table->string('category')->index();
            $table->string('type')->index();
            $table->string('number')->nullable();
            $table->string('period')->nullable();
            $table->date('prize_date')->nullable();
            $table->text('province')->nullable();
            $table->integer('price')->nullable(); 
            $table->string('image')->nullable();
            $table->integer('quantity')->nullable();// quantity remain
            $table->integer('quantity_sold')->nullable();//quantity sold online
            $table->integer('quantity_reward')->nullable(); //quanity for reward (in quantity sold)
            $table->integer('quantity_paid')->nullable(); //quantity admin paid for agency
            $table->integer('quantity_sold_direct')->nullable();//quantity sold direct
            $table->integer('quantity_unsold')->nullable();//quantity unsold - cannot sold
            $table->tinyInteger('status')->nullable(); 
            $table->foreignId('user_create_id')->constrained('users')->cascadeOnDelete();
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
        Schema::dropIfExists('veso_products');
    }
}
