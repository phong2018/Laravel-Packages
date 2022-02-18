<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesoOrdersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veso_orders_details', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('order_id')->constrained('veso_orders')->cascadeOnDelete();
            $table->string('status')->nullable();
            $table->string('details_key')->index()->nullable();
            $table->text('details')->nullable();
            $table->text('images')->nullable();
            $table->string('category')->nullable();
            $table->integer('agency_id')->index()->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('quantity_refund')->nullable(); 
            $table->decimal('price', $precision = 15, $scale = 2)->nullable();
            
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
        Schema::dropIfExists('veso_orders_details');
    }
}
