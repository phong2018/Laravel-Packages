<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgencyInfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //  
            $table->text('point_info')->nullable();
            $table->text('agency_info')->nullable();
            $table->text('agency_name')->nullable();
            
            $table->text('bank_info')->nullable();
            $table->text('refund_tickets')->nullable();
            $table->text('temp_data')->nullable();

            $table->integer('presenter_id')->index()->nullable();
            $table->integer('lock_point')->index()->default(0);
            
            $table->integer('accumulate_point')->default(0);
 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //    
            $table->dropColumn('point_info'); 
            $table->dropColumn('agency_info'); 
            $table->dropColumn('agency_name'); 
            
            $table->dropColumn('bank_info'); 
            $table->dropColumn('refund_tickets'); 
            $table->dropColumn('temp_data'); 

            $table->dropColumn('presenter_id');   
            $table->dropColumn('lock_point');
            $table->dropColumn('accumulate_point');
            
        });
    }
}
