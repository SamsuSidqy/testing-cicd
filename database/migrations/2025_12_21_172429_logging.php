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
        Schema::create('logging', function (Blueprint $table) {
            $table->id('id_logging')->primary();
            $table->foreignId('users')->nullable()->constrained('users','id_users');
            $table->enum('type',['Error','Info','Warning'])->default('Error');
            $table->text('data')->nullable();
            $table->string('ip4');
            $table->string('method');
            $table->string('device');
            $table->string('platform');
            $table->string('browser');
            $table->string('agent');
            $table->string('browser_version');
            $table->string('url');
            $table->string('title')->nullable();
            $table->text('deskripsi');
            $table->integer('status_code');
            $table->datetime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('logging');
    }
};
