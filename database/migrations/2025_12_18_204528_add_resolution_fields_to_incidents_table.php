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
            $table->timestamp('resolved_at')->nullable()->after('status');
            $table->json('final_evidence_images')->nullable()->after('resolved_at');
            $table->text('resolution_description')->nullable()->after('final_evidence_images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn(['resolved_at', 'final_evidence_images', 'resolution_description']);
        });
    }
};
