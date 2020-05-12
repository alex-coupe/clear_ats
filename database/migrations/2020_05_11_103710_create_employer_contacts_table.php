<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployerContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('employer_id');
            $table->string('name');
            $table->string('telephone');
            $table->string('mobile')->nullable();
            $table->string('email');
            $table->string('job_title');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('employer_contacts');
    }
}
