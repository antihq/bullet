<?php

use App\Models\User;

test('withoutPassword factory state creates user with null password', function () {
    $user = User::factory()->withoutPassword()->create();

    expect($user->password)->toBeNull();
});

test('default factory state creates user with hashed password', function () {
    $user = User::factory()->create();

    expect($user->password)->not->toBeNull()
        ->and($user->password)->not->toBe('password');
});
