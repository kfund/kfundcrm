<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteDenisTeacher2 extends Migration
{
    public function up()
    {
        Schema::dropIfExists('denis_teacher_');
    }
    
    public function down()
    {
        Schema::create('denis_teacher_', function($table)
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
            $table->text('telegram')->nullable();
            $table->text('github')->nullable();
            $table->text('markup_skill')->nullable();
            $table->text('js_skill')->nullable();
            $table->text('teacher_skill')->nullable();
            $table->text('python_skill')->nullable();
            $table->string('slug', 191)->nullable();
            $table->text('tags')->nullable();
            $table->binary('document1')->nullable();
            $table->binary('document2')->nullable();
        });
    }
}
