<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyBackgroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->string('case_no')->unique();
            $table->string('name_par_guar')->nullable();
            $table->string('job_vict_sur')->nullable();
            $table->smallInteger('age_vict_sur')->nullable();
            $table->text('rel_vict_sur')->nullable();
            $table->text('rttvs_if_oth_pls_spec')->nullable();
            $table->text('fam_back_region')->nullable();
            $table->text('fam_back_province')->nullable();
            $table->text('fam_back_city')->nullable();
            $table->text('fam_back_barangay')->nullable();
            $table->text('fam_back_house_no')->nullable();
            $table->text('fam_back_street')->nullable();
            $table->string('fam_back_cont_num')->nullable();
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
        Schema::dropIfExists('family_backgrounds');
    }
}
