<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcommerceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecommerce_orders', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();  
            $table->string('status');
            $table->string('currency');
            $table->integer('total');
            $table->string('payment')->nullable();
            $table->string('ship')->nullable();
            $table->string('fullname')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('post_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedDecimal('discount')->default(0);
            $table->timestamps();
            $table->softDeletes(); 
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecommerce_orders');
    }
}
