<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directories', function (Blueprint $table) {
            $table->id();
            $table->string('dir_first_name');
            $table->string('dir_middle_name');
            $table->string('dir_last_name');
            $table->string('dir_post_desi');
            $table->string('dir_directory_type');
            $table->string('dir_contact_no_1');
            $table->string('dir_contact_no_2')->nullable();
            $table->string('dir_contact_no_3')->nullable();
            $table->string('dir_email');
            $table->string('dir_facebook')->nullable(); 
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
        Schema::dropIfExists('directories');
    }
}
