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
        Schema::table('users', function (Blueprint $table) {

            $table->enum('rol', [
                'ADMIN_FULL',
                'SUBADMIN'
            ])->default('SUBADMIN');

            $table->unsignedBigInteger('id_distrito')->nullable();
            $table->unsignedBigInteger('id_anexo')->nullable();
            $table->unsignedBigInteger('id_sector')->nullable();

            $table->tinyInteger('estado')->default(1);

            $table->timestamp('fechacrea')->nullable();
            $table->timestamp('fechaedita')->nullable();
            $table->timestamp('fechaelimina')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
