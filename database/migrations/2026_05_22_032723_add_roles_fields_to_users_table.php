<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'rol')) {
                $table->enum('rol', ['ADMIN_FULL', 'SUBADMIN'])
                    ->default('SUBADMIN');
            }

            if (!Schema::hasColumn('users', 'id_distrito')) {
                $table->unsignedBigInteger('id_distrito')->nullable();
            }

            if (!Schema::hasColumn('users', 'id_anexo')) {
                $table->unsignedBigInteger('id_anexo')->nullable();
            }

            if (!Schema::hasColumn('users', 'id_sector')) {
                $table->unsignedBigInteger('id_sector')->nullable();
            }

            if (!Schema::hasColumn('users', 'estado')) {
                $table->tinyInteger('estado')->default(1);
            }

            if (!Schema::hasColumn('users', 'fechaedita')) {
                $table->timestamp('fechaedita')->nullable();
            }

            if (!Schema::hasColumn('users', 'fechaelimina')) {
                $table->timestamp('fechaelimina')->nullable();
            }

        });
    }

    public function down(): void
    {
        //
    }
};