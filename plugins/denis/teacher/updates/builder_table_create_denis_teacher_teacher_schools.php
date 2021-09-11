<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherTeacherSchools extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_teacher_schools', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('schools_id');
            $table->integer('teacher_id');
            $table->primary(['schools_id','teacher_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_teacher_schools');
    }
}
