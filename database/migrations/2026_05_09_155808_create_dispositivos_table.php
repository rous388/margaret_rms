<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispositivos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('instalacion_id')
                ->constrained('instalaciones')
                ->cascadeOnDelete();

            $table->foreignId('tipo_dispositivo_id')
                ->constrained('tipos_dispositivo')
                ->restrictOnDelete();

            $table->foreignId('estado_dispositivo_id')
                ->constrained('estados_dispositivo')
                ->restrictOnDelete();

            $table->string('nombre');
            $table->string('codigo_sac')->nullable();
            $table->string('codigo_sic')->nullable();
            $table->string('coordenadas')->nullable();
            $table->decimal('altura_antena', 8, 2)->nullable();
            $table->decimal('tiempo_vuelta', 8, 2)->nullable();
            $table->date('fecha_instalacion')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispositivos');
    }
};
