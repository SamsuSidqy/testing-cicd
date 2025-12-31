<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_menu', function (Blueprint $table) {
            $table->id('id_sub_menu')->primary();  
            $table->string('name');
            $table->foreignId('badge')->references('id_badge_menu')->on('badge_menu');
            $table->boolean('is_active')->default(true);
            $table->boolean('deleted')->default(false);
            $table->string('icon');
            $table->datetime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('sub_menu');
    }
};
