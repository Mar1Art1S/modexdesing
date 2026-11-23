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
            $table->id();
            $table->string('title_ua');
            $table->string('title_en');
            $table->string('category')->default('architecture');
            $table->text('description_ua')->nullable();
            $table->text('description_en')->nullable();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->integer('order_column')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
