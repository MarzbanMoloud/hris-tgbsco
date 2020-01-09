<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');
            $table->string('certificate_id')->nullable();
            $table->string('issuance_location')->nullable();
            $table->string('national_code')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('certificate_serial')->nullable();
            $table->integer('marital_status')->nullable();
            $table->integer('children_count')->nullable();
            $table->string('issuance_id')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->integer('military_status')->nullable();
            $table->string('personnel_code')->unique();
            $table->string('hire_date')->nullable();
            $table->integer('education_degree')->nullable();
            $table->string('major')->nullable();
            $table->string('education_location')->nullable();
            $table->integer('university_type')->nullable();
            $table->string('end_date')->nullable();

            /*----------- Relations -----------*/
            $table->unsignedBigInteger('job_id')->nullable();
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('set null');

            $table->unsignedBigInteger('organizational_unit_id')->nullable();
            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units')->onDelete('set null');

            $table->unsignedBigInteger('central_cost_id')->nullable();
            $table->foreign('central_cost_id')->references('id')->on('central_costs')->onDelete('set null');

            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

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
        Schema::dropIfExists('personnels');
    }
}
