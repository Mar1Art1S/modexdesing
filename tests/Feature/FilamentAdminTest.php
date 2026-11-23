<?php

use App\Models\User;

test('unauthenticated users are redirected to admin login', function () {
    $response = $this->get('/admin');

    $response->assertRedirect('/admin/login');
});

test('admin login page loads successfully', function () {
    $response = $this->get('/admin/login');

    $response->assertSuccessful();
});

test('authenticated user can access admin dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/admin');

    $response->assertSuccessful();
});

test('authenticated user can access orders resource', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/admin/orders');

    $response->assertSuccessful();
});

test('authenticated user can access projects resource', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/admin/projects');

    $response->assertSuccessful();
});
