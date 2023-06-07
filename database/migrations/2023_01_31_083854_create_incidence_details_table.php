<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidence_details', function (Blueprint $table) {
            $table->id();
            $table->string('case_no')->unique();
            $table->date('id_date_int')->nullable();
            $table->string('id_name_intervi')->nullable();
            $table->string('id_pos_desi_int')->nullable();
            $table->tinyText('id_int_part_vio')->nullable();
            $table->tinyText('id_ipv_phys')->nullable();
            $table->tinyText('id_ipv_sexual')->nullable();
            $table->tinyText('id_ipv_psycho')->nullable();
            $table->tinyText('id_ipv_econo')->nullable();
            $table->tinyText('id_rape')->nullable();
            $table->tinyText('id_rape_incest')->nullable();
            $table->tinyText('id_rape_sta_rape')->nullable();
            $table->tinyText('id_rape_sex_int')->nullable();
            $table->tinyText('id_rape_sex_assa')->nullable();
            $table->tinyText('id_rape_mar_rape')->nullable();
            $table->tinyText('id_traf_per')->nullable();
            $table->tinyText('id_traf_per_sex_exp')->nullable();
            $table->tinyText('id_traf_per_onl_exp')->nullable();
            $table->tinyText('id_traf_per_others')->nullable();
            $table->tinyText('id_traf_per_others_spec')->nullable();
            $table->tinyText('id_traf_per_forc_lab')->nullable();
            $table->tinyText('id_traf_per_srem_org')->nullable();
            $table->tinyText('id_traf_per_prost')->nullable();
            $table->tinyText('id_sex_hara')->nullable();
            $table->tinyText('id_sex_hara_ver')->nullable();
            $table->tinyText('id_sex_hara_others')->nullable();
            $table->tinyText('id_sex_hara_others_spec')->nullable();
            $table->tinyText('id_sex_hara_phys')->nullable();
            $table->tinyText('id_sex_hara_use_obj')->nullable();
            $table->tinyText('id_chi_abu')->nullable();
            $table->tinyText('id_chi_abu_efpaccp')->nullable();
            $table->tinyText('id_chi_abu_lasc_cond')->nullable();
            $table->tinyText('id_chi_abu_others')->nullable();
            $table->tinyText('id_chi_abu_others_spec')->nullable();
            $table->tinyText('id_chi_abu_sex_int')->nullable();
            $table->tinyText('id_chi_abu_phys_abu')->nullable();
            $table->longText('id_descr_inci')->nullable();
            $table->date('id_date_of_inci')->nullable();
            $table->time('id_time_of_inci')->nullable();
            $table->text('inci_det_house_no')->nullable();
            $table->text('inci_det_street')->nullable();
            $table->text('inci_det_region')->nullable();
            $table->text('inci_det_province')->nullable();
            $table->text('inci_det_city')->nullable();
            $table->text('inci_det_barangay')->nullable();
            $table->tinyText('id_pla_of_inci')->nullable();
            $table->tinyText('id_pi_oth_pls_spec')->nullable();
            $table->tinyText('id_was_inc_perp_onl')->nullable();                       
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
        Schema::dropIfExists('incidence_details');
    }
}
