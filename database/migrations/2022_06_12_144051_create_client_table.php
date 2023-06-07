<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->id();
            $table->string('account_name');
            $table->string('business_tin');
            $table->string('name_of_owner');
            $table->string('type_of_ownership');
            $table->string('name_of_authorized_person');
            $table->string('unit_no_floor_bldg_name');
            $table->string('street_name_or_subdivision');
            $table->string('barangay_name');
            $table->string('municipality_or_city');
            $table->string('zip_code');
            $table->string('province');
            $table->string('phone');
            $table->string('mobile');
            $table->string('email');
            $table->string('preferred_model_of_contract');
            $table->string('fsr_assigned');
            $table->string('market_segment');
            $table->string('no_of_microbiology_samples');
            $table->string('sample_collection_frequency_micro');
            $table->string('no_of_physico_chemical_samples');
            $table->string('sample_collection_frequency_pchem');
            $table->string('assigned_week');
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
        Schema::dropIfExists('client');
    }
}
