<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReviseUserScopingAddressToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('user_region')->nullable()->change();
            $table->text('user_province')->nullable()->change();
            $table->text('user_municipality')->nullable()->change();
            $table->text('user_barangay')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('user_region')->nullable(false)->change();
            $table->text('user_province')->nullable(false)->change();
            $table->text('user_municipality')->nullable(false)->change();
            $table->text('user_barangay')->nullable(false)->change();

        });
    }
}
