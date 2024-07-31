<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoadDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('road_details', function (Blueprint $table) {
            $table->id();
            $table->integer('state_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('tehsil_id')->nullable();
            $table->integer('block_id')->nullable();
            $table->integer('ulb_id')->nullable();
            $table->integer('village_panchyat_id')->nullable();
            $table->integer('village_id')->nullable();
            $table->integer('ward')->nullable();
            $table->string('street_name',300)->nullable();
            $table->string('road_type',300)->nullable();
            $table->longtext('latlog')->nullable();
            $table->double('distance_m',16,2)->nullable();
            $table->integer('created_by')->nullabe();
            $table->integer('updated_by')->nullabe();
            $table->string('ipaddress')->nullabe();
            $table->integer('status')->commitment('0:enable,1:disable');
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
        Schema::dropIfExists('road_details');
    }
}
