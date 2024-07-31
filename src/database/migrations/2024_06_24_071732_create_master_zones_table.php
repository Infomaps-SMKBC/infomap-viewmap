<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_zones', function (Blueprint $table) {
            $table->id();
            $table->integer('ulb_id');
            $table->string('name',60);
            $table->longtext('latlog')->nullable();
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
        Schema::dropIfExists('master_zones');
    }
}
