<?php

test('registration screen is not available to the public', function () {
    $response = $this->get('/register');

    $response->assertNotFound();
});

test('new users can not register through the public site', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertNotFound();
});
