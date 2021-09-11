<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherLessonsSprints extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_lessons_sprints', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('sprints_id');
            $table->integer('lessons_id');
            $table->primary(['sprints_id','lessons_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_lessons_sprints');
    }
}
