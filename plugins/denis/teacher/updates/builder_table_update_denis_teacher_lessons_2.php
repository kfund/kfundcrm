<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherLessons2 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_lessons', function($table)
        {
            $table->text('field3')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_lessons', function($table)
        {
            $table->dropColumn('field3');
        });
    }
}
