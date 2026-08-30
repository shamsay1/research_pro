<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {

            $table->id();

            // Student anayehusika kwenye mazungumzo
            $table->foreignId('student_id')
                ->constrained('students')
                ->onDelete('cascade');

            // Admin anayehusika kwenye mazungumzo
            $table->foreignId('admin_id')
                ->constrained('system_users')
                ->onDelete('cascade');

            // Aliyetuma message
            $table->enum('sender_type', [
                'student',
                'admin'
            ]);

            // Ujumbe
            $table->text('message');

            // 0 = haijasomwa
            // 1 = imesomwa
            $table->boolean('is_read')->default(false);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};