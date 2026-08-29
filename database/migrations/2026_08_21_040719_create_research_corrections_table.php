<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('research_corrections', function (Blueprint $table) {

            $table->id();

            $table->foreignId('research_proposal_id')
                ->constrained('research_proposals')
                ->onDelete('cascade');

            $table->foreignId('supervisor_id')
                ->constrained('system_users')
                ->onDelete('cascade');

            $table->text('comment');

            $table->string('status')
                ->default('correction');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('research_corrections');
    }
};