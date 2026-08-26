<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('patient_name');
            // Right Eye (OD - Oculus Dexter)
            $table->string('sph_od')->nullable(); // Esfera Ojo Derecho
            $table->string('cyl_od')->nullable(); // Cilindro Ojo Derecho
            $table->string('axis_od')->nullable(); // Eje Ojo Derecho
            $table->string('add_od')->nullable(); // Adición Ojo Derecho
            // Left Eye (OS - Oculus Sinister)
            $table->string('sph_os')->nullable(); // Esfera Ojo Izquierdo
            $table->string('cyl_os')->nullable(); // Cilindro Ojo Izquierdo
            $table->string('axis_os')->nullable(); // Eje Ojo Izquierdo
            $table->string('add_os')->nullable(); // Adición Ojo Izquierdo
            // Pupillary Distance
            $table->string('pd')->nullable(); // Distancia pupilar (mm)
            $table->date('issue_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
