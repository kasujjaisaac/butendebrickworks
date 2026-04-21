<?php

use App\Models\User;

test('non admin users can not access the admin dashboard', function () {
    $user = User::factory()->create([
        'is_admin' => false,
    ]);

    $this->actingAs($user)
        ->get('/admin')
        ->assertForbidden();
});

test('admin root redirects to the dashboard route', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertRedirect(route('admin.dashboard', absolute: false));
});

test('admin users can access the admin dashboard', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get(route('admin.dashboard', absolute: false))
        ->assertOk()
        ->assertSeeText('Admin Dashboard')
        ->assertSeeText('Homepage Content');
});
