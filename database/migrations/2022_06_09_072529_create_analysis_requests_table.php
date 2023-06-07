<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analysis_requests', function (Blueprint $table) {
            $table->id();
            $table->string('acount_name');
            $table->string('unit_no_floor_bldg_name');
            $table->string('street_name_or_subdivision');
            $table->string('barangay_name');
            $table->string('municipality_or_city');
            $table->string('zip_code');
            $table->string('province');
            $table->string('contact_person');
            $table->string('phone');
            $table->string('mobile');
            $table->string('email');
            $table->string('collected_by');
            $table->string('date_collected');
            $table->string('time_collected');
            $table->string('last_microbial_testing');
            $table->string('last_change_of_filter');
            $table->string('last_change_of_uv');
            $table->string('collection_point');
            $table->string('address_of_collection_point');
            $table->string('uv_light');
            $table->string('chlorinator');
            $table->string('faucet_condition_after_disinfection');
            $table->string('source_of_water_sample');
            $table->string('water_purpose');
            $table->string('test_request');
            $table->string('customer_representative_name');
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
        Schema::dropIfExists('analysis_requests');
    }
}
