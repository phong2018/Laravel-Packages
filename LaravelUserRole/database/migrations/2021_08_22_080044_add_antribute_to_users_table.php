<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class addAntributeToUsersTable extends Migration
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
            $table->string('identity_card_number')->nullable();
            $table->string('identity_place')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('customer_bank_info')->nullable(); 
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();

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
            $table->dropColumn('identity_card_number'); 
            $table->dropColumn('identity_place'); 
            $table->dropColumn('phone_number'); 
            $table->dropColumn('address');
            $table->dropColumn('customer_bank_info');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('zip_code');
        });
    }
}
