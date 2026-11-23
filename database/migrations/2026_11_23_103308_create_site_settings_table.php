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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            // Google Integrations
            $table->string('google_analytics_id')->nullable();
            $table->string('google_tag_manager_id')->nullable();
            $table->string('google_site_verification')->nullable();

            // Meta tags (bilingual UA / EN)
            $table->string('meta_title_ua')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_description_ua')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->text('meta_keywords')->nullable();

            // OpenGraph / Social / Canonical
            $table->string('og_image')->nullable();
            $table->string('canonical_url')->nullable();
            $table->boolean('is_indexed')->default(true);

            // Custom Head & Body Scripts
            $table->text('custom_head_scripts')->nullable();
            $table->text('custom_body_scripts')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
