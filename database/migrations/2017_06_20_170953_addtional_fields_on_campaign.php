<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddtionalFieldsOnCampaign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // 0 : not ban, 1: banned
            $table->integer('blacklist_cost')->default(1);
            $table->integer('greylist_cost')->default(1);
             $table->integer('whitelist_cost')->default(3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
           
            $table->dropColumn('blacklist_cost');
           $table->dropColumn('greylist_cost');
           $table->dropColumn('whitelist_cost');
        });
    }
}
