<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_permission_users', function (Blueprint $table) {
            $table->id('id_role_permission_users')->primary();
            $table->foreignId('id_users')->nullable()->constrained('users', 'id_users');
            $table->foreignId('id_menu')->nullable()->constrained('menu_cms', 'id_menu_cms');
            $table->boolean('create')->default(true);
            $table->boolean('delete')->default(true);
            $table->boolean('updated')->default(true);
            $table->boolean('show')->default(true);
            $table->unique(['id_users', 'id_menu']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('role_permission_users');

    }
};
