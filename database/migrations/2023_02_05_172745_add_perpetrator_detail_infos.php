<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerpetratorDetailInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perpetrator_detail_infos', function (Blueprint $table) {
            $table->id();
            $table->string('case_no_modal')->nullable();
            $table->string('perp_d_last_name_modal')->nullable();
            $table->string('perp_d_first_name_modal')->nullable();
            $table->string('perp_d_middle_name_modal')->nullable();
            $table->string('perp_d_extension_name_modal')->nullable();
            $table->string('perp_d_alias_name_modal')->nullable();
            $table->tinyText('perp_d_sex_radio_modal')->nullable();
            $table->date('perp_d_birthdate_modal')->nullable();
            $table->integer('perp_d_age_modal')->nullable();
            $table->tinyText('perp_d_rel_victim_modal')->nullable();
            $table->text('perp_d_rel_vic_pls_spec_modal')->nullable();
            $table->text('perp_d_occup_modal')->nullable();
            $table->text('perp_d_educ_att_modal')->nullable();
            $table->tinyText('perp_d_nationality_modal')->nullable();
            $table->text('perp_d_nat_if_oth_pls_spec_modal')->nullable();
            $table->tinyText('perp_d_religion_modal')->nullable();
            $table->text('perp_d_rel_if_oth_pls_spec_modal')->nullable();
            $table->text('perp_d_house_no_modal')->nullable();
            $table->text('perp_d_street_modal')->nullable();
            $table->text('perp_d_region_modal')->nullable();
            $table->text('perp_d_province_modal')->nullable();
            $table->text('perp_d_city_modal')->nullable();
            $table->text('perp_d_barangay_modal')->nullable();
            $table->text('perp_d_curr_loc_modal')->nullable();
            $table->tinyText('perp_d_is_perp_minor_modal')->nullable();
            $table->text('perp_d_if_yes_pls_ind_modal')->nullable();
            $table->text('perp_d_addr_par_gua_modal')->nullable();
            $table->string('perp_d_cont_par_gua_modal')->nullable();
            $table->tinyText('perp_d_rel_guar_perp_modal')->nullable();
            $table->text('perp_d_rel_rgp_pls_spec_modal')->nullable();
            $table->longText('perp_d_oth_info_perp_modal')->nullable();
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
        Schema::dropIfExists('perpetrator_detail_infos');
    }
}
