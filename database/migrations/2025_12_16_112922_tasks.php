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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('id_tasks')->primary();
            $table->string('name');
            $table->foreignId('responsibility')->constrained('users', 'id_users');
            $table->enum('status',['Completed','Progress'])->default('Progress');
            $table->string('slug')->unique();
            $table->foreignId('project')->constrained('projects','id_projects');
            $table->datetime('deadline');
            $table->boolean('extend_deadline')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });


        Schema::create('forum',function(Blueprint $table){
            $table->id('id_forum');
            $table->string('message')->nullable();
            $table->foreignId('sender')->constrained('users','id_users');
            $table->enum('type',['Tugas','Pesan'])->default('Pesan');
            $table->timestamp('created_at')->useCurrent();
            $table->foreignId('tasks')->constrained('tasks','id_tasks');
        });

        Schema::create('files_tasks',function(Blueprint $table){
            $table->id('id_file_tasks')->primary();
            $table->foreignId('taks')->constrained('tasks','id_tasks');
            $table->string('name_file');
            $table->enum('type',['file','image']);
            $table->foreignId('forum')->constrained('forum','id_forum');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::drop('tasks');
        Schema::drop('files_tasks');
        Schema::drop('forum');
    }
};
