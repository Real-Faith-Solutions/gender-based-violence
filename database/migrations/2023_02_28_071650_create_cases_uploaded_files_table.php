<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesUploadedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases_uploaded_files', function (Blueprint $table) {
            $table->id();
            $table->string('case_no')->nullable();
            $table->string('file')->nullable();
            $table->string('file_extension')->nullable();
            $table->string('file_location')->nullable();
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
        Schema::dropIfExists('cases_uploaded_files');
    }
}
