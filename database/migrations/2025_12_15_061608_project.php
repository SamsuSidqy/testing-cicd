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
        Schema::create('projects', function (Blueprint $table) {
            $table->id('id_projects')->primary();
            $table->foreignId('pm')->constrained('users', 'id_users');
            $table->datetime('start');
            $table->datetime('ended');
            $table->string('deskripsi');
            $table->string('slug')->unique();
            $table->string('title');
            $table->boolean('deleted')->default(false);
            $table->double('latitude');
            $table->double('lontitude');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('member_project', function (Blueprint $table) {
            $table->id('id_member_project')->primary();
            $table->foreignId('id_projects')->constrained('projects','id_projects');
            $table->foreignId('id_users')->constrained('users','id_users');        
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('projects');
        Schema::drop('member_project');
    }
};
