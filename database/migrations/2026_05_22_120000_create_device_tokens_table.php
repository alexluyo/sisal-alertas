<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_tokens', function (Blueprint $table) {
            $table->id('id_device_token');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->unsignedBigInteger('id_anexo')->nullable();
            $table->text('token');
            $table->string('plataforma', 100)->nullable();
            $table->text('navegador')->nullable();
            $table->tinyInteger('estado')->default(1);
            $table->timestamp('fechacrea')->useCurrent();
            $table->timestamp('fechaedita')->nullable();
            $table->timestamp('fechaelimina')->nullable();

            $table->foreign('id_usuario')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('id_anexo')
                ->references('id_anexo')
                ->on('anexos')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_tokens');
    }
};
