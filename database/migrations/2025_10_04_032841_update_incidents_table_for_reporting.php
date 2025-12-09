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
        Schema::table('incidents', function (Blueprint $table) {
            $table->string('location')->nullable()->after('description');
            $table->timestamp('report_date')->nullable()->after('location');
            
            // Renombrar y cambiar tipo de columna 'image' a 'initial_evidence_images' (JSON)
            // Para manejar la posible pérdida de datos, una solución ideal implicaría:
            // 1. Añadir nueva columna (initial_evidence_images_new)
            // 2. Migrar datos de 'image' a 'initial_evidence_images_new' (string a array JSON)
            // 3. Eliminar 'image'
            // 4. Renombrar 'initial_evidence_images_new' a 'initial_evidence_images'
            // Sin embargo, para una implementación inicial y simplificada, y asumiendo que los datos existentes no son críticos o se manejarán externamente,
            // eliminaremos la columna 'image' y añadiremos la nueva columna 'initial_evidence_images' como JSON.
            
            if (Schema::hasColumn('incidents', 'image')) {
                $table->dropColumn('image');
            }
            $table->json('initial_evidence_images')->nullable()->after('report_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn(['location', 'report_date', 'initial_evidence_images']);
            
            // Revertir la columna 'image' a su estado original si fue eliminada
            $table->string('image')->nullable()->after('reported_by');
        });
    }
};
