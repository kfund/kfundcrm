<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherTeacherCities2 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_teacher_cities', function($table)
        {
            $table->renameColumn('teacher_profile_id', 'teacher_id');
            $table->primary(['teacher_id','cities_id']);
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_teacher_cities', function($table)
        {
            $table->dropPrimary(['teacher_id','cities_id']);
            $table->renameColumn('teacher_id', 'teacher_profile_id');
        });
    }
}
