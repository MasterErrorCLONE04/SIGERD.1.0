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
        Schema::table('tasks', function (Blueprint $table) {
            $table->json('initial_evidence_images')->nullable()->after('location');
            $table->json('final_evidence_images')->nullable()->after('initial_evidence_images');
            $table->text('final_description')->nullable()->after('final_evidence_images');
            $table->json('reference_images')->nullable()->after('final_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['initial_evidence_images', 'final_evidence_images', 'final_description', 'reference_images']);
        });
    }
};
