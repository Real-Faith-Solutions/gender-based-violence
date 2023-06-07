<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerpetratorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perpetrator_details', function (Blueprint $table) {
            $table->id();
            $table->string('case_no')->unique();
            $table->string('perp_d_last_name')->nullable();
            $table->string('perp_d_first_name')->nullable();
            $table->string('perp_d_middle_name')->nullable();
            $table->string('perp_d_extension_name')->nullable();
            $table->string('perp_d_alias_name')->nullable();
            $table->tinyText('perp_d_sex_radio')->nullable();
            $table->date('perp_d_birthdate')->nullable();
            $table->integer('perp_d_age')->nullable();
            $table->tinyText('perp_d_rel_victim')->nullable();
            $table->text('perp_d_rel_vic_pls_spec')->nullable();
            $table->text('perp_d_occup')->nullable();
            $table->text('perp_d_educ_att')->nullable();
            $table->tinyText('perp_d_nationality')->nullable();
            $table->text('perp_d_nat_if_oth_pls_spec')->nullable();
            $table->tinyText('perp_d_religion')->nullable();
            $table->text('perp_d_rel_if_oth_pls_spec')->nullable();
            $table->text('perp_d_house_no')->nullable();
            $table->text('perp_d_street')->nullable();
            $table->text('perp_d_region')->nullable();
            $table->text('perp_d_province')->nullable();
            $table->text('perp_d_city')->nullable();
            $table->text('perp_d_barangay')->nullable();
            $table->text('perp_d_curr_loc')->nullable();
            $table->tinyText('perp_d_is_perp_minor')->nullable();
            $table->text('perp_d_if_yes_pls_ind')->nullable();
            $table->text('perp_d_addr_par_gua')->nullable();
            $table->string('perp_d_cont_par_gua')->nullable();
            $table->tinyText('perp_d_rel_guar_perp')->nullable();
            $table->text('perp_d_rel_rgp_pls_spec')->nullable();
            $table->longText('perp_d_oth_info_perp')->nullable();
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
        Schema::dropIfExists('perpetrator_details');
    }
}
