<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizaciones', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->enum('tipo', ['ansp', 'cliente_final', 'fabricante', 'otro']);

            $table->foreignId('ansp_id')
                ->nullable()
                ->constrained('organizaciones')
                ->nullOnDelete();

            $table->string('pais')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->enum('estado', ['activa', 'inactiva'])->default('activa');
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizaciones');
    }
};
