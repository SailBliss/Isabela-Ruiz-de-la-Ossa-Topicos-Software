<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('email')->unique();
            $table->string('password_hash');
            $table->string('telefono', 30);
            $table->date('fecha_registro');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuentas');
    }
};
