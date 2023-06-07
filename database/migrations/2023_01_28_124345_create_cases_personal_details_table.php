<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesPersonalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_details', function (Blueprint $table) {
            $table->id();
            $table->string('client_made_a_report_before')->nullable();
            $table->date('date_of_intake')->nullable();
            $table->string('case_no')->unique();
            $table->string('type_of_client')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->tinyText('sex')->nullable();
            $table->string('extension_name')->nullable();
            $table->string('alias_name')->nullable();
            $table->smallInteger('age')->nullable();
            $table->tinyText('client_diverse_sogie')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('education')->nullable();
            $table->string('religion')->nullable();
            $table->text('religion_if_oth_pls_spec')->nullable();
            $table->string('nationality')->nullable();
            $table->text('nationality_if_oth_pls_spec')->nullable();
            $table->string('ethnicity')->nullable();
            $table->text('ethnicity_if_oth_pls_spec')->nullable();
            $table->string('employment_status')->nullable();
            $table->text('if_self_emp_pls_ind')->nullable();
            $table->text('house_hold_no')->nullable();
            $table->text('region')->nullable();
            $table->text('province')->nullable();
            $table->text('city')->nullable();
            $table->text('barangay')->nullable();
            $table->text('street')->nullable();
            $table->tinyText('is_idp')->nullable();
            $table->tinyText('is_pwd')->nullable();
            $table->text('if_pwd_pls_specify')->nullable();
            $table->mediumText('per_det_cont_info')->nullable();            
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
        Schema::dropIfExists('personal_details');
    }
}
