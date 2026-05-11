<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instalaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organizacion_id')
                ->constrained('organizaciones')
                ->cascadeOnDelete();

            $table->string('nombre');
            $table->string('pais')->nullable();
            $table->string('ciudad_zona')->nullable();
            $table->string('coordenadas')->nullable();
            $table->enum('estado', ['activa', 'inactiva', 'mantenimiento'])->default('activa');
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instalaciones');
    }
};
