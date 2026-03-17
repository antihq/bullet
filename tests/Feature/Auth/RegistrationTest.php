<?php

use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyFeature(Features::registration());
});

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'email' => 'test@example.com',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('notes.index', absolute: false));

    $this->assertAuthenticated();
});

test('new users can register with optional password', function () {
    $response = $this->post(route('register.store'), [
        'email' => 'test@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('notes.index', absolute: false));

    $this->assertAuthenticated();

    expect(auth()->user()->password)->not->toBeNull();
});

test('password must be confirmed when provided', function () {
    $response = $this->post(route('register.store'), [
        'email' => 'test@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'different-password',
    ]);

    $response->assertSessionHasErrors(['password']);
});

test('password must meet requirements when provided', function () {
    $response = $this->post(route('register.store'), [
        'email' => 'test@example.com',
        'password' => '123',
        'password_confirmation' => '123',
    ]);

    $response->assertSessionHasErrors(['password']);
});
