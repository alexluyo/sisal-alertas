<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('device_tokens', function (Blueprint $table) {
            if (!Schema::hasColumn('device_tokens', 'id_anexo')) {
                $table->unsignedBigInteger('id_anexo')->nullable()->after('id_usuario');

                $table->foreign('id_anexo')
                    ->references('id_anexo')
                    ->on('anexos')
                    ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('device_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('device_tokens', 'id_anexo')) {
                $table->dropForeign(['id_anexo']);
                $table->dropColumn('id_anexo');
            }
        });
    }
};
