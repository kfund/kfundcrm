<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherTeachers extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_teachers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('name')->nullable();
            $table->text('city')->nullable();
            $table->text('date_of_birth')->nullable();
            $table->text('job_title')->nullable();
            $table->text('email')->nullable();
            $table->text('mobile')->nullable();
            $table->text('adress')->nullable();
            $table->text('documents')->nullable();
            $table->text('telegram')->nullable();
            $table->text('github')->nullable();
            $table->text('markup_skill')->nullable();
            $table->text('js_skill')->nullable();
            $table->text('teacher_skill')->nullable();
            $table->text('python_skill')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_teachers');
    }
}
