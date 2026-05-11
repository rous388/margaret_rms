<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intervenciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dispositivo_id')
                ->constrained('dispositivos')
                ->cascadeOnDelete();

            $table->foreignId('usuario_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('tipo_intervencion_id')
                ->constrained('tipos_intervencion')
                ->restrictOnDelete();

            $table->dateTime('fecha_inicio');
            $table->text('descripcion');

            $table->foreignId('estado_anterior_id')
                ->nullable()
                ->constrained('estados_dispositivo')
                ->nullOnDelete();

            $table->foreignId('estado_nuevo_id')
                ->nullable()
                ->constrained('estados_dispositivo')
                ->nullOnDelete();

            $table->enum('estado_intervencion', ['abierta', 'cerrada'])->default('abierta');
            $table->dateTime('fecha_cierre')->nullable();
            $table->dateTime('fecha_prevista_cierre')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intervenciones');
    }
};
