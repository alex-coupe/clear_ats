<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('email');
            $table->string('last_name');
            $table->string('cv_path');
            $table->string('cover_path')->nullable();
            $table->integer('recruiter_id')->nullable();
            $table->boolean('introductory_contact_complete')->default(false);
            $table->string('current_salary')->nullable();
            $table->string('expected_salary')->nullable();
            $table->string('current_role')->nullable();
            $table->string('current_sector')->nullable();
            $table->string('interested_sectors')->nullable();
            $table->string('interested_roles')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('deleted')->default(false);
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
        Schema::dropIfExists('candidates');
    }
}
