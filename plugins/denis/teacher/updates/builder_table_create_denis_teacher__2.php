<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacher2 extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('job_title')->nullable();
            $table->string('adress')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('github')->nullable();
            $table->string('telegram')->nullable();
            $table->string('markup_skills')->nullable();
            $table->string('js_skills')->nullable();
            $table->string('teacher_skills')->nullable();
            $table->string('python')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_');
    }
}
