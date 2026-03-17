<?php

use App\Models\User;

test('initials derives from email with dot separator', function () {
    $user = new User(['email' => 'john.doe@example.com']);

    expect($user->initials())->toBe('jd');
});

test('initials derives from email single part', function () {
    $user = new User(['email' => 'admin@example.com']);

    expect($user->initials())->toBe('a');
});

test('initials handles email with multiple dots', function () {
    $user = new User(['email' => 'john.middle.doe@example.com']);

    expect($user->initials())->toBe('jm');
});

test('initials handles null email', function () {
    $user = new User(['email' => null]);

    expect($user->initials())->toBe('');
});
