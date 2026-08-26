<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('optometrist_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('patient_name');
            $table->string('email');
            $table->string('phone');
            $table->date('appointment_date');
            $table->string('time_slot'); // e.g. 10:00 AM, 04:30 PM
            $table->string('status')->default('pending'); // pending, confirmed, completed, cancelled
            $table->string('reason')->default('Examen de la vista completo');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
