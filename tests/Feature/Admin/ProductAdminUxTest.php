<?php

use App\Models\User;

it('shows live calculator guidance on the admin product form', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.products.create'))
        ->assertOk()
        ->assertSeeText('Live Calculator Preview')
        ->assertSeeText('Units for 10 m²')
        ->assertSeeText('Calculator tip:');
});
