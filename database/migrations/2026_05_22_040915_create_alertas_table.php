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
        Schema::create('alertas', function (Blueprint $table) {

            $table->id('id_alerta');

            $table->unsignedBigInteger('id_tipo_alerta');

            $table->string('titulo', 150);

            $table->text('mensaje');

            $table->unsignedBigInteger('id_anexo')->nullable();

            $table->unsignedBigInteger('id_usuario');

            $table->tinyInteger('estado')->default(1);

            $table->timestamp('fecha_envio')->nullable();

            $table->timestamp('fechacrea')->useCurrent();

            $table->timestamp('fechaedita')->nullable();

            $table->timestamp('fechaelimina')->nullable();

            $table->foreign('id_anexo')
                ->references('id_anexo')
                ->on('anexos');

            $table->foreign('id_tipo_alerta')
                ->references('id_tipo_alerta')
                ->on('tipo_alertas');
                
            $table->foreign('id_usuario')
                ->references('id')
                ->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertas');
    }
};
