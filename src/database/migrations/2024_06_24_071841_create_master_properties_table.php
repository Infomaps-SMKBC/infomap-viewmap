<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_properties', function (Blueprint $table) {
            $table->id();
            $table->integer('state_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('tehsil_id')->nullable();
            $table->integer('block_id')->nullable();
            $table->integer('ulb_id')->nullable();
            $table->integer('village_panchyat_id')->nullable();
            $table->integer('village_id')->nullable();
            $table->integer('hamlet_id')->nullable();
            $table->integer('slum_id')->nullable();
            $table->integer('ward')->nullable();
            $table->integer('phc_id')->nullable();
            $table->integer('sector_id')->nullable();
            $table->string('topo_id',20)->nullable();
            $table->integer('street_id')->nullable();
            $table->integer('zone_id')->nullable();
            $table->string('property_name',50)->nullable();
            $table->string('property_shape',50)->nullable();
            $table->string('nooffloor',2)->nullable();
            $table->string('usage',50)->nullable();
            $table->string('construction',50)->nullable();
            $table->string('area_name',150)->nullable();
            $table->longtext('latlog')->nullable();
            $table->string('image',100)->nullable();
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
        Schema::dropIfExists('master_properties');
    }
}
