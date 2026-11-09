<?php

test('home page returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

test('projects page returns a successful response', function () {
    $response = $this->get(route('projects'));

    $response->assertOk();
});

test('3d printing page returns a successful response', function () {
    $response = $this->get(route('printing'));

    $response->assertOk();
});

test('engineering page returns a successful response', function () {
    $response = $this->get(route('engineering'));

    $response->assertOk();
});

test('contacts page returns a successful response', function () {
    $response = $this->get(route('contacts'));

    $response->assertOk();
});
