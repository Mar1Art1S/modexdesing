<?php

use App\Filament\Pages\ManageSeoSettings;
use App\Models\SiteSetting;
use App\Models\User;
use Livewire\Livewire;

test('site settings singleton creates default record on access', function () {
    $settings = SiteSetting::current();

    expect($settings)->toBeInstanceOf(SiteSetting::class)
        ->and($settings->id)->toBe(1)
        ->and($settings->is_indexed)->toBeTrue()
        ->and($settings->meta_title_ua)->toContain('Modex');
});

test('guest cannot access filament seo settings page', function () {
    $this->get('/admin/manage-seo-settings')
        ->assertRedirect('/admin/login');
});

test('admin can view filament seo settings page', function () {
    $admin = User::firstOrCreate(
        ['email' => 'admin@modexdesign.com'],
        [
            'name' => 'Modex Admin',
            'password' => bcrypt('password'),
        ]
    );

    $this->actingAs($admin)
        ->get('/admin/manage-seo-settings')
        ->assertSuccessful()
        ->assertSee('SEO та Google');
});

test('admin can update seo and google analytics settings via filament form', function () {
    $admin = User::firstOrCreate(
        ['email' => 'admin@modexdesign.com'],
        [
            'name' => 'Modex Admin',
            'password' => bcrypt('password'),
        ]
    );

    $this->actingAs($admin);

    Livewire::test(ManageSeoSettings::class)
        ->fillForm([
            'google_analytics_id' => 'G-TEST123456',
            'google_tag_manager_id' => 'GTM-TEST999',
            'google_site_verification' => 'google-verify-code-xyz',
            'meta_title_ua' => 'Новий кастомний тайтл UA',
            'meta_title_en' => 'New custom title EN',
            'meta_description_ua' => 'Новий кастомний опис UA',
            'meta_description_en' => 'New custom description EN',
            'meta_keywords' => 'keyword1, keyword2',
            'og_image' => 'https://modexdesign.com/custom-og.jpg',
            'canonical_url' => 'https://modexdesign.com',
            'is_indexed' => true,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $setting = SiteSetting::current()->fresh();

    expect($setting->google_analytics_id)->toBe('G-TEST123456')
        ->and($setting->google_tag_manager_id)->toBe('GTM-TEST999')
        ->and($setting->google_site_verification)->toBe('google-verify-code-xyz')
        ->and($setting->meta_title_ua)->toBe('Новий кастомний тайтл UA');
});

test('homepage renders google analytics, search console verification, and meta tags from site settings', function () {
    SiteSetting::current()->update([
        'google_analytics_id' => 'G-ABC9876543',
        'google_tag_manager_id' => 'GTM-XYZ1234',
        'google_site_verification' => 'verification-token-unique',
        'meta_keywords' => 'rapid-prototyping, hardware-engineering',
    ]);

    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertSee('G-ABC9876543', false)
        ->assertSee('googletagmanager.com/gtag/js?id=G-ABC9876543', false)
        ->assertSee('GTM-XYZ1234', false)
        ->assertSee('verification-token-unique', false)
        ->assertSee('<meta name="google-site-verification" content="verification-token-unique"', false)
        ->assertSee('rapid-prototyping, hardware-engineering', false);
});
