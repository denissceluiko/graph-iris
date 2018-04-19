<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->integer('faculty_id')->unsigned();
            $table->integer('program_id')->unsigned();
            $table->integer('times_taken')->unsigned();
            $table->dateTime('started_at');
            $table->integer('duration')->unsigned();
            $table->string('semester');
            $table->integer('course_id')->unsigned();
            $table->integer('lector_id')->unsigned();
            $table->string('position');
            // Questions
            $table->integer('course_parts')->unsigned();
            $table->integer('course_description')->unsigned();
            $table->integer('course_duplication')->unsigned();
            $table->integer('lecturer_understandable')->unsigned();
            $table->integer('lecturer_methods')->unsigned();
            $table->integer('literature_usefullness')->unsigned();
            $table->integer('estudies_materials')->unsigned();
            $table->integer('course_tests')->unsigned();
            $table->integer('lecturer_consultations')->unsigned();
            $table->integer('course_results')->unsigned();
            $table->integer('lecturer_again')->unsigned();
            $table->integer('test_explanation')->unsigned();
            $table->text('comments');
            $table->integer('course_time')->unsigned();

            $table->timestamps();

            $table->unique(['student_id', 'program_id', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissions');
    }
}
