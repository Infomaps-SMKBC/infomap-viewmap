<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFloorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floor_details', function (Blueprint $table) {
            $table->id();
            $table->string('topo_id',20);
            $table->string('tax_number',50);
            $table->string('floor_type',50);
            $table->integer('gis_floor');
            $table->integer('mis_floor');
            $table->string('gis_usage',30);
            $table->string('mis_usage',30);
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
        Schema::dropIfExists('floor_details');
    }
}
