<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcommerceOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('ecommerce_order_product', function (Blueprint $table) {
            $table->id(); 
            
            $table->foreignId('order_id')->constrained('ecommerce_orders')->cascadeOnDelete();

            $table->foreignId('product_id')->constrained('ecommerce_products')->cascadeOnDelete();

            $table->integer('quantity')->default(1);
            
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
        Schema::dropIfExists('ecommerce_order_product');
    }
}
