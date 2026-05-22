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
        Schema::create('usuario_permisos', function (Blueprint $table) {
            $table->id('id_permiso');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_modulo');

            $table->tinyInteger('puede_ver')->default(0);
            $table->tinyInteger('puede_crear')->default(0);
            $table->tinyInteger('puede_editar')->default(0);
            $table->tinyInteger('puede_eliminar')->default(0);
            $table->tinyInteger('puede_enviar')->default(0);

            $table->tinyInteger('estado')->default(1);
            $table->timestamp('fechacrea')->useCurrent();
            $table->timestamp('fechaedita')->nullable();
            $table->timestamp('fechaelimina')->nullable();

            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_modulo')->references('id_modulo')->on('modulos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_permisos');
    }
};
