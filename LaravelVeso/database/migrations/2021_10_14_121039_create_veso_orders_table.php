<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesoOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veso_orders', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('userId')->nullable()->constrained('users')->nullOnDelete();  
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->decimal('total_prize', $precision = 15, $scale = 2)->nullable();
            $table->decimal('total', $precision = 15, $scale = 2)->nullable(); // for total money, customer have to pay
            $table->decimal('total_refund', $precision = 15, $scale = 2)->nullable(); // for total refund money
            $table->string('fullname')->nullable();
            $table->string('address')->nullable();
            $table->string('identity_card_number')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('post_code')->nullable(); 
            $table->string('bank_code')->nullable();
            $table->decimal('bank_transfer_fee', $precision = 15, $scale = 2)->nullable(); 
            $table->string('currency')->nullable(); 
            $table->string('phone_number')->index()->nullable();
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
        Schema::dropIfExists('veso_orders');
    }
}
