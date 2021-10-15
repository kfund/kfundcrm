<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherFaq extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_faq', function($table)
        {
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->text('answer')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_faq', function($table)
        {
            $table->dropColumn('type');
            $table->dropColumn('title');
            $table->dropColumn('answer');
        });
    }
}
