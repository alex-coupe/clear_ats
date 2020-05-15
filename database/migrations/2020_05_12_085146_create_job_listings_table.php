<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('employer_ref');
            $table->string('recruiter_ref')->nullable();
            $table->string('job_title');
            $table->string('remuneration');
            $table->string('work_pattern');
            $table->string('job_description');
            $table->integer('employer_location_id');
            $table->dateTime('expiry_date');
            $table->dateTime('live_date')->nullable();
            $table->string('job_description_url')->nullable();
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
        Schema::dropIfExists('job_listing');
    }
}
