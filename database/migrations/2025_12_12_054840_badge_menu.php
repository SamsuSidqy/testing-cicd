<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badge_menu', function (Blueprint $table) {
            $table->id('id_badge_menu')->primary();  
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->boolean('deleted')->default(false);
            $table->datetime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('badge_menu');
    }
};
