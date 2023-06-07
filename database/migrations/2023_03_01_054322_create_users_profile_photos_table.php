<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersProfilePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_profile_photos', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
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
        Schema::dropIfExists('users_profile_photos');
    }
}
