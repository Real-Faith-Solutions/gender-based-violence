<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewMoreColumnForCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->string('client_made_a_report_before')->nullable();
            $table->smallInteger('age')->nullable();
            $table->tinyText('sex')->nullable();
            $table->string('civil_status')->nullable();
            $table->tinyText('client_diverse_sogie')->nullable();
            $table->string('education')->nullable();
            $table->string('religion')->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('nationality')->nullable();
            $table->tinyText('is_idp')->nullable();
            $table->tinyText('is_pwd')->nullable();
            $table->smallInteger('age_vict_sur')->nullable();
            $table->text('nature_of_incidence')->nullable();
            $table->text('sub_option_of_nature_of_incidence')->nullable();
            $table->tinyText('id_pla_of_inci')->nullable();
            $table->tinyText('id_was_inc_perp_onl')->nullable();
            $table->integer('perp_d_age')->nullable();
            $table->tinyText('perp_d_sex_radio')->nullable();
            $table->tinyText('perp_d_rel_victim')->nullable();
            $table->text('perp_d_occup')->nullable();
            $table->tinyText('perp_d_nationality')->nullable();
            $table->tinyText('perp_d_is_perp_minor')->nullable();
            $table->string('im_type_of_service')->nullable();
            $table->tinyText('rm_was_cli_ref_by_org')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cases', function (Blueprint $table) {
            //
        });
    }
}
