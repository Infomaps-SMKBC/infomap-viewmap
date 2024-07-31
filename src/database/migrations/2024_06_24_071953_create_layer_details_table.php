<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layer_details', function (Blueprint $table) {
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
            $table->string('point_type',30)->nullable();
            $table->string('category',30)->nullable();
            $table->string('street_name',300)->nullable();
            $table->string('layer_details',200)->nullable();
            $table->string('layer_name',30)->nullable();
            $table->string('remark')->nullable();
            $table->string('image',30)->nullable();
            $table->string('capicity_unit',20)->nullable();
            $table->string('survey_no',20)->nullable();
            $table->string('layer_type',30)->nullable();
            $table->string('feature_type',30)->nullable();
            $table->integer('layer_length')->nullable();
            $table->integer('layer_width')->nullable();
            $table->integer('layer_depth')->nullable();
            $table->integer('layer_year')->nullable();
            $table->string('funding_source',100)->nullable();
            $table->string('scheme',100)->nullable();
            $table->integer('estimate')->nullable();
            $table->date('start_date')->nullable();
            $table->string('completion_schedule',100)->nullable();
            $table->integer('project_status')->nullable()->commitment('0:Pending for Approval,1:Successfully approved,2:Rejected');
            $table->json('latlong')->nullable();
            $table->integer('created_by')->nullabe();
            $table->integer('updated_by')->nullabe();
            $table->integer('approved_by')->nullabe();
            $table->timestamp('approved_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('layer_details');
    }
}
