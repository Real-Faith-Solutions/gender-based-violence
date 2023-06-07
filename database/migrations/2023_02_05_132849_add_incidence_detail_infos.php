<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIncidenceDetailInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidence_detail_infos', function (Blueprint $table) {
            $table->id();
            $table->string('case_no_modal')->nullable();
            $table->date('id_date_int_modal')->nullable();
            $table->string('id_name_intervi_modal')->nullable();
            $table->string('id_pos_desi_int_modal')->nullable();
            $table->tinyText('id_int_part_vio_modal')->nullable();
            $table->tinyText('id_ipv_phys_modal')->nullable();
            $table->tinyText('id_ipv_sexual_modal')->nullable();
            $table->tinyText('id_ipv_psycho_modal')->nullable();
            $table->tinyText('id_ipv_econo_modal')->nullable();
            $table->tinyText('id_rape_modal')->nullable();
            $table->tinyText('id_rape_incest_modal')->nullable();
            $table->tinyText('id_rape_sta_rape_modal')->nullable();
            $table->tinyText('id_rape_sex_int_modal')->nullable();
            $table->tinyText('id_rape_sex_assa_modal')->nullable();
            $table->tinyText('id_rape_mar_rape_modal')->nullable();
            $table->tinyText('id_traf_per_modal')->nullable();
            $table->tinyText('id_traf_per_sex_exp_modal')->nullable();
            $table->tinyText('id_traf_per_onl_exp_modal')->nullable();
            $table->tinyText('id_traf_per_others_modal')->nullable();
            $table->tinyText('id_traf_per_others_spec_modal')->nullable();
            $table->tinyText('id_traf_per_forc_lab_modal')->nullable();
            $table->tinyText('id_traf_per_srem_org_modal')->nullable();
            $table->tinyText('id_traf_per_prost_modal')->nullable();
            $table->tinyText('id_sex_hara_modal')->nullable();
            $table->tinyText('id_sex_hara_ver_modal')->nullable();
            $table->tinyText('id_sex_hara_others_modal')->nullable();
            $table->tinyText('id_sex_hara_others_spec_modal')->nullable();
            $table->tinyText('id_sex_hara_phys_modal')->nullable();
            $table->tinyText('id_sex_hara_use_obj_modal')->nullable();
            $table->tinyText('id_chi_abu_modal')->nullable();
            $table->tinyText('id_chi_abu_efpaccp_modal')->nullable();
            $table->tinyText('id_chi_abu_lasc_cond_modal')->nullable();
            $table->tinyText('id_chi_abu_others_modal')->nullable();
            $table->tinyText('id_chi_abu_others_spec_modal')->nullable();
            $table->tinyText('id_chi_abu_sex_int_modal')->nullable();
            $table->tinyText('id_chi_abu_phys_abu_modal')->nullable();
            $table->longText('id_descr_inci_modal')->nullable();
            $table->date('id_date_of_inci_modal')->nullable();
            $table->time('id_time_of_inci_modal')->nullable();
            $table->text('inci_det_house_no_modal')->nullable();
            $table->text('inci_det_street_modal')->nullable();
            $table->text('inci_det_region_modal')->nullable();
            $table->text('inci_det_province_modal')->nullable();
            $table->text('inci_det_city_modal')->nullable();
            $table->text('inci_det_barangay_modal')->nullable();
            $table->tinyText('id_pla_of_inci_modal')->nullable();
            $table->tinyText('id_pi_oth_pls_spec_modal')->nullable();
            $table->tinyText('id_was_inc_perp_onl_modal')->nullable();                       
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
        Schema::dropIfExists('incidence_detail_infos');
    }
}
