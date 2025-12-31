<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_cms', function (Blueprint $table) {
            $table->id('id_menu_cms')->primary();  
            $table->string('name');
            $table->string('url');
            $table->boolean('is_active')->default(true);
            $table->boolean('deleted')->default(false);
            $table->enum('role',['Admin','Manager','Employe','Developer'])->nullable();
            $table->string('parrent_folder');
            $table->string('metode');
            $table->string('route_name');
            $table->string('class_name');
            $table->string('name_views');
            $table->foreignId('sub')->nullable()->constrained('sub_menu', 'id_sub_menu');
            $table->datetime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('menu_cms');
    }
};
