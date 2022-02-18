<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesoPrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veso_prizes', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('category')->index()->nullable();
            $table->string('province')->nullable();
            $table->date('prize_date')->nullable();
            $table->string('prize_time',10)->nullable(); 
            $table->string('prize_period',10)->index()->nullable();
            $table->string('prize_ticketType',100)->nullable();
            $table->text('prize_number')->nullable();
            $table->string('prize_value',500)->nullable(); 
            $table->string('prize_name',500)->nullable(); 
            $table->string('prize_quantity',500)->nullable(); 
            $table->tinyInteger('status')->nullable();  
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
        Schema::dropIfExists('veso_prizes');
    }
}
