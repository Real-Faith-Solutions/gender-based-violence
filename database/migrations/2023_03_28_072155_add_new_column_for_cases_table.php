<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnForCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->text('region')->nullable();
            $table->text('province')->nullable();
            $table->text('city')->nullable();
            $table->text('barangay')->nullable();
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
