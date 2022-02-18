<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesoWinPrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veso_win_prizes', function (Blueprint $table) {
            $table->id();              
            $table->foreignId('order_detail_id')->nullable()->constrained('veso_orders_details')->nullOnDelete();  
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('agency_id')->nullable()->constrained('users')->cascadeOnDelete();  
            $table->date('prize_date')->index()->nullable();
            $table->integer('noPeriod')->nullable();
            $table->integer('moneyNeedAddCustomer')->nullable();
            $table->string('ticket_type')->nullable();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('veso_win_prizes');
    }
}
