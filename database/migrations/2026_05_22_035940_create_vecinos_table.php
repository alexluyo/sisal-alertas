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
        Schema::create('vecinos', function (Blueprint $table) {
            $table->id('id_vecino');
            $table->string('dni', 15)->nullable();
            $table->string('nombres', 150);
            $table->string('celular', 20)->nullable();
            $table->string('direccion', 200)->nullable();

            $table->unsignedBigInteger('id_anexo');
            $table->text('token_notificacion')->nullable();
            $table->tinyInteger('notificaciones')->default(0);

            $table->tinyInteger('estado')->default(1);
            $table->timestamp('fechacrea')->useCurrent();
            $table->timestamp('fechaedita')->nullable();
            $table->timestamp('fechaelimina')->nullable();

            $table->foreign('id_anexo')
                ->references('id_anexo')
                ->on('anexos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vecinos');
    }
};
