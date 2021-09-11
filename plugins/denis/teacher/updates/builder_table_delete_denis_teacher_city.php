<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteDenisTeacherCity extends Migration
{
    public function up()
    {
        Schema::dropIfExists('denis_teacher_city');
    }
    
    public function down()
    {
        Schema::create('denis_teacher_city', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('cityname', 191)->nullable();
            $table->string('slug', 191)->nullable();
        });
    }
}
