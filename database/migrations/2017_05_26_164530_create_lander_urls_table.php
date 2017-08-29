<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanderUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('lander_urls', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lander_id');
            $table->foreign('lander_id')->references('id')->on('landers')->onDelete('cascade')->onUpdate('cascade');
            $table->text('lander_url');
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
        Schema::dropIfExists('lander_urls');
    }
}
