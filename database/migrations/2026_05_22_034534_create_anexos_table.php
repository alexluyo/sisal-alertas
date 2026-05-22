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
        Schema::create('anexos', function (Blueprint $table) {
            $table->id('id_anexo');
            $table->string('nombre', 150);
            $table->string('descripcion', 255)->nullable();
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
        Schema::dropIfExists('anexos');
    }
};
