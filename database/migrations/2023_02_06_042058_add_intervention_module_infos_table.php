<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInterventionModuleInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervention_module_infos', function (Blueprint $table) {
            $table->id();
            $table->string('case_no_modal')->nullable();
            $table->string('im_type_of_service_modal')->nullable();
            $table->text('im_typ_serv_if_oth_spec_modal')->nullable();
            $table->string('im_speci_interv_modal')->nullable();
            $table->text('im_spe_int_if_oth_spec_modal')->nullable();
            $table->string('im_serv_prov_modal')->nullable();
            $table->text('im_ser_pro_if_oth_spec_modal')->nullable();
            $table->longText('im_speci_obje_modal')->nullable();
            $table->date('im_target_date_modal')->nullable();
            $table->string('im_status_modal')->nullable();
            $table->date('im_if_status_com_pd_modal')->nullable();
            $table->string('im_dsp_full_name_modal')->nullable();
            $table->string('im_dsp_post_desi_modal')->nullable();
            $table->string('im_dsp_email_modal')->nullable();
            $table->string('im_dsp_contact_no_1_modal')->nullable();
            $table->string('im_dsp_contact_no_2_modal')->nullable();
            $table->string('im_dsp_contact_no_3_modal')->nullable();
            $table->string('im_dasp_full_name_modal')->nullable();
            $table->string('im_dasp_post_desi_modal')->nullable();
            $table->string('im_dasp_email_modal')->nullable();
            $table->string('im_dasp_contact_no_1_modal')->nullable();
            $table->string('im_dasp_contact_no_2_modal')->nullable();
            $table->string('im_dasp_contact_no_3_modal')->nullable();
            $table->longText('im_summary_modal')->nullable();
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
        Schema::dropIfExists('intervention_module_infos');
    }
}
