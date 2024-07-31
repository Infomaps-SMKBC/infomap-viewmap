<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_details', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id')->nullable();
            $table->string('topo_id',20)->nullable();
            $table->string('tax_number',50)->nullable();
            $table->string('gis_owner',100)->nullable();
            $table->string('mis_owner',100)->nullable();
            $table->string('owner_mobile',10)->nullable();
            $table->string('owner_email',30)->nullable();
            $table->string('aadhar_card',12)->nullable();
            $table->string('gst_no',15)->nullable();
            $table->string('portion_name',70)->nullable();
            $table->integer('no_of_portion')->nullable();
            $table->double('water_tax_amount',16,2)->nullable();
            $table->integer('water_connection_no')->nullable();
            $table->double('ugd_tax_amount',16,2)->nullable();
            $table->integer('ugd_conn_no')->nullable();
            $table->string('water_tax_no',30)->nullable();
            $table->string('ugd_tax_no',30)->nullable();
            $table->double('tax_amount',16,2)->nullable();
            $table->string('plan_approval_no',10)->nullable();
            $table->integer('lr_no')->nullable();
            $table->string('eb_no',50)->nullable();
            $table->string('upload_document',100)->nullable();
            $table->integer('project_status')->nullable()->commitment('0:Pending for Approval,1:Successfully approved,2:Rejected');
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('property_details');
    }
}
