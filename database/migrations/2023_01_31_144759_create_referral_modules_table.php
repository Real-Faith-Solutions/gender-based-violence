<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_modules', function (Blueprint $table) {
            $table->id();
            $table->string('case_no')->unique();
            $table->tinyText('rm_was_cli_ref_by_org')->nullable();
            $table->text('rm_name_ref_org')->nullable();
            $table->text('rm_ref_fro_ref_org')->nullable();
            $table->text('rm_addr_ref_org')->nullable();
            $table->text('rm_referred_by')->nullable();
            $table->text('rm_position_title')->nullable();
            $table->string('rm_contact_no')->nullable();
            $table->string('rm_email_add')->nullable();
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
        Schema::dropIfExists('referral_modules');
    }
}
