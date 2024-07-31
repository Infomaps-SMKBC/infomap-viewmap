<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterULBSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_u_l_b_s', function (Blueprint $table) {
            $table->id();
            $table->integer('block_id')->nullable();
            $table->string('name',60);
            $table->integer('ulb_code')->nullable();
            $table->longtext('latlog')->nullable();
            $table->string('x',50)->nullable();
            $table->string('y',50)->nullable();
            $table->string('satellite_image')->nullable();
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
        Schema::dropIfExists('master_u_l_b_s');
    }
}
