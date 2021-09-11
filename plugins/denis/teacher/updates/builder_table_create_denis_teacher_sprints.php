<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherSprints extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_sprints', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('tag')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('name')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_sprints');
    }
}
