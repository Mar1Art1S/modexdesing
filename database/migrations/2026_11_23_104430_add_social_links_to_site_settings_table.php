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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('instagram_url')->nullable()->after('canonical_url');
            $table->string('facebook_url')->nullable()->after('instagram_url');
            $table->string('whatsapp_url')->nullable()->after('facebook_url');
            $table->string('telegram_url')->nullable()->after('whatsapp_url');
            $table->string('viber_url')->nullable()->after('telegram_url');
            $table->string('contact_email')->nullable()->after('viber_url');
            $table->string('contact_phone')->nullable()->after('contact_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'instagram_url',
                'facebook_url',
                'whatsapp_url',
                'telegram_url',
                'viber_url',
                'contact_email',
                'contact_phone',
            ]);
        });
    }
};
