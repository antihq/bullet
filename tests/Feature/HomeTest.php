<?php

use App\Models\User;

test('guests are redirected to home from root', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('home'));
});

test('authenticated users are redirected to dashboard from root', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/');

    $response->assertRedirect(route('dashboard'));
});

test('guests can view the home page', function () {
    $response = $this->get(route('home'));

    $response->assertOk()->assertSee('Start your first note');
});
