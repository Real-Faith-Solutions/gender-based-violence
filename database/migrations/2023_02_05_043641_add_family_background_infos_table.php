<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFamilyBackgroundInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_background_infos', function (Blueprint $table) {
            $table->id();
            $table->string('case_no_modal')->nullable();
            $table->string('name_par_guar_modal')->nullable();
            $table->string('age_vict_sur_modal')->nullable();
            $table->string('job_vict_sur_modal')->nullable();
            $table->string('rel_vict_sur_modal')->nullable();
            $table->string('rttvs_if_oth_pls_spec_modal')->nullable();
            $table->string('fam_back_region_modal')->nullable();
            $table->string('fam_back_province_modal')->nullable();
            $table->string('fam_back_city_modal')->nullable();
            $table->string('fam_back_barangay_modal')->nullable();
            $table->string('fam_back_house_no_modal')->nullable();
            $table->string('fam_back_street_modal')->nullable();
            $table->string('fam_back_cont_num_modal')->nullable();
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
        Schema::dropIfExists('family_background_infos');
    }
}
