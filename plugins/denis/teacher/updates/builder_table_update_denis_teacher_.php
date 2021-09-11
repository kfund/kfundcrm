<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacher extends Migration
{
    public function up()
    {
        Schema::rename('denis_teacher_teachers', 'denis_teacher_');
    }
    
    public function down()
    {
        Schema::rename('denis_teacher_', 'denis_teacher_teachers');
    }
}
