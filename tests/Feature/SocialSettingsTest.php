<?php

use App\Filament\Pages\ManageSocialSettings;
use App\Models\SiteSetting;
use App\Models\User;
use Livewire\Livewire;

test('guest cannot access filament social settings page', function () {
    $this->get('/admin/manage-social-settings')
        ->assertRedirect('/admin/login');
});

test('admin can view filament social settings page', function () {
    $admin = User::firstOrCreate(
        ['email' => 'admin@modexdesign.com'],
        [
            'name' => 'Modex Admin',
            'password' => bcrypt('password'),
        ]
    );

    $this->actingAs($admin)
        ->get('/admin/manage-social-settings')
        ->assertSuccessful()
        ->assertSee('Social Media Links & Contacts');
});

test('admin can update social and contact links via filament form', function () {
    $admin = User::firstOrCreate(
        ['email' => 'admin@modexdesign.com'],
        [
            'name' => 'Modex Admin',
            'password' => bcrypt('password'),
        ]
    );

    $this->actingAs($admin);

    Livewire::test(ManageSocialSettings::class)
        ->fillForm([
            'instagram_url' => 'https://instagram.com/custom_modex',
            'facebook_url' => 'https://facebook.com/custom_modex_page',
            'whatsapp_url' => 'https://wa.me/380991112233',
            'telegram_url' => 'https://t.me/custom_modex_channel',
            'contact_email' => 'hello@modexdesign.com',
            'contact_phone' => '+380 99 111 22 33',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $setting = SiteSetting::current()->fresh();

    expect($setting->instagram_url)->toBe('https://instagram.com/custom_modex')
        ->and($setting->facebook_url)->toBe('https://facebook.com/custom_modex_page')
        ->and($setting->whatsapp_url)->toBe('https://wa.me/380991112233')
        ->and($setting->telegram_url)->toBe('https://t.me/custom_modex_channel')
        ->and($setting->contact_email)->toBe('hello@modexdesign.com')
        ->and($setting->contact_phone)->toBe('+380 99 111 22 33');
});

test('public pages reflect updated social links and direct channels', function () {
    SiteSetting::current()->update([
        'instagram_url' => 'https://instagram.com/test_social_ig',
        'facebook_url' => 'https://facebook.com/test_social_fb',
        'whatsapp_url' => 'https://wa.me/380509998877',
        'telegram_url' => 'https://t.me/test_social_tg',
        'contact_email' => 'custom_orders@modexdesign.com',
    ]);

    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertSee('https://instagram.com/test_social_ig', false)
        ->assertSee('https://facebook.com/test_social_fb', false)
        ->assertSee('https://wa.me/380509998877', false)
        ->assertSee('https://t.me/test_social_tg', false)
        ->assertSee('mailto:custom_orders@modexdesign.com', false);
});
