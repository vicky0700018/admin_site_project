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
        Schema::table('lead_documents', function (Blueprint $table) {
            $table->index('lead_id');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->index(['role', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_documents', function (Blueprint $table) {
            $table->dropIndex(['lead_id']);
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role', 'deleted_at']);
        });
    }
};
