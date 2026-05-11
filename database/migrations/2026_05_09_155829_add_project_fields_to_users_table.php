<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellidos')->nullable()->after('name');

            $table->foreignId('organizacion_id')
                ->nullable()
                ->after('password')
                ->constrained('organizaciones')
                ->nullOnDelete();

            $table->enum('rol', ['admin_ansp', 'tecnico', 'cliente_visor'])
                ->default('cliente_visor')
                ->after('organizacion_id');

            $table->enum('estado', ['activo', 'inactivo'])
                ->default('activo')
                ->after('rol');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organizacion_id']);
            $table->dropColumn([
                'apellidos',
                'organizacion_id',
                'rol',
                'estado',
            ]);
        });
    }
};
