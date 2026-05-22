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
        Schema::create('modulos', function (Blueprint $table) {
            $table->id('id_modulo');
            $table->string('nombre', 100);
            $table->string('clave', 100)->unique();
            $table->tinyInteger('estado')->default(1);
            $table->timestamp('fechacrea')->useCurrent();
            $table->timestamp('fechaedita')->nullable();
            $table->timestamp('fechaelimina')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos');
    }
};
