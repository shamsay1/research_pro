<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supervisor_assignments', function (Blueprint $table) {

            $table->enum('supervisor_type', ['core', 'principal'])
                ->after('teacher_id');

        });
    }

    public function down(): void
    {
        Schema::table('supervisor_assignments', function (Blueprint $table) {
            $table->dropColumn('supervisor_type');
        });
    }
};