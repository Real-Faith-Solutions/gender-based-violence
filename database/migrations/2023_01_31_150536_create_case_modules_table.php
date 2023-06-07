<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_modules', function (Blueprint $table) {
            $table->id();
            $table->string('case_no')->unique();
            $table->tinyText('cm_case_status')->nullable();
            $table->longText('cm_remarks')->nullable();
            $table->longText('cm_assessment')->nullable();
            $table->longText('cm_recommendation')->nullable();
            $table->text('cm_upload')->nullable();
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
        Schema::dropIfExists('case_modules');
    }
}
