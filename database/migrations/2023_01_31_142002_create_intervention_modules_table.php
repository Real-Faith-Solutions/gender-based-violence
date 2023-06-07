<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervention_modules', function (Blueprint $table) {
            $table->id();
            $table->string('case_no')->unique();
            $table->string('im_type_of_service')->nullable();
            $table->text('im_typ_serv_if_oth_spec')->nullable();
            $table->string('im_speci_interv')->nullable();
            $table->text('im_spe_int_if_oth_spec')->nullable();
            $table->string('im_serv_prov')->nullable();
            $table->text('im_ser_pro_if_oth_spec')->nullable();
            $table->longText('im_speci_obje')->nullable();
            $table->date('im_target_date')->nullable();
            $table->string('im_status')->nullable();
            $table->date('im_if_status_com_pd')->nullable();
            $table->string('im_dsp_full_name')->nullable();
            $table->string('im_dsp_post_desi')->nullable();
            $table->string('im_dsp_email')->nullable();
            $table->string('im_dsp_contact_no_1')->nullable();
            $table->string('im_dsp_contact_no_2')->nullable();
            $table->string('im_dsp_contact_no_3')->nullable();
            $table->string('im_dasp_full_name')->nullable();
            $table->string('im_dasp_post_desi')->nullable();
            $table->string('im_dasp_email')->nullable();
            $table->string('im_dasp_contact_no_1')->nullable();
            $table->string('im_dasp_contact_no_2')->nullable();
            $table->string('im_dasp_contact_no_3')->nullable();
            $table->longText('im_summary')->nullable();
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
        Schema::dropIfExists('intervention_modules');
    }
}
