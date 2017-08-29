<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cam_id');
            $table->foreign('cam_id')->references('id')->on('campaigns')->onDelete('cascade')->onUpdate('cascade');
            $table->double('advertiserCost');
            $table->double('clicks');
            $table->double('conversions');
            $table->double('cost');
            $table->double('cpv');
            $table->double('cr');
            $table->double('ctr');
            $table->string('customVariable1');
            $table->double('cv');
            $table->double('epc');
            $table->double('epv');
            $table->double('errors');
            $table->double('hour');
            $table->double('ictr');
            $table->double('impressions');
            $table->double('profit');
            $table->double('revenue');
            $table->double('roi');
            $table->double('visits');
            $table->string('campaign_id');
            $table->string('zeropark_campaign_id');
            // 0 not live - 1 curently live
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('reports');
    }
}
