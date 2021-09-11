<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacher7 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_', function($table)
        {
            $table->date('teaching_since')->nullable()->unsigned(false)->default(null)->change();
            $table->dropColumn('type');
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_', function($table)
        {
            $table->string('teaching_since', 191)->nullable()->unsigned(false)->default(null)->change();
            $table->string('type', 191)->nullable();
        });
    }
}
