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
            $table->integer('semester_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->integer('lector_id')->unsigned();
            $table->string('position');
            // Questions
            $table->integer('course_parts')->unsigned()->nullable();
            $table->integer('course_description')->unsigned()->nullable();
            $table->integer('course_duplication')->unsigned()->nullable();
            $table->integer('lecturer_understandable')->unsigned()->nullable();
            $table->integer('lecturer_methods')->unsigned()->nullable();
            $table->integer('literature_usefullness')->unsigned()->nullable();
            $table->integer('estudies_materials')->unsigned()->nullable();
            $table->integer('course_tests')->unsigned()->nullable();
            $table->integer('lecturer_consultations')->unsigned()->nullable();
            $table->integer('course_results')->unsigned()->nullable();
            $table->integer('lecturer_again')->unsigned()->nullable();
            $table->integer('test_explanation')->unsigned()->nullable();
            $table->text('comments')->nullable();
            $table->integer('course_time')->unsigned()->nullable();

            $table->timestamps();

            $table->unique(['student_id', 'course_id', 'lector_id', 'semester_id']);
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
