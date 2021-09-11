<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherSchools extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_schools', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('schools_school')->nullable();
            $table->string('slug')->nullable();
            $table->string('headmaster')->nullable();
            $table->string('head_phone')->nullable();
            $table->string('adress')->nullable();
            $table->string('coordinates')->nullable();
            $table->integer('start_year')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_schools');
    }
}
