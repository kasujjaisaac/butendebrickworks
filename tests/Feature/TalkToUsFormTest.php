<?php

use App\Models\ContactMessage;

it('stores talk to us messages', function () {
    $response = $this->post(route('talk-to-us.store'), [
        'name' => 'Isaac Example',
        'email' => 'isaac@example.com',
        'phone' => '+256700000000',
        'subject' => 'Bulk brick enquiry',
        'message' => 'We are planning a school project and would like help choosing the right brick quantities and profiles.',
        'source_url' => 'http://localhost/contact',
    ]);

    $response
        ->assertRedirect()
        ->assertSessionHas('talk_to_us_success');

    expect(ContactMessage::query()->count())->toBe(1);

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'Isaac Example',
        'email' => 'isaac@example.com',
        'subject' => 'Bulk brick enquiry',
    ]);
});

it('validates talk to us identity fields', function () {
    $this->from('/contact')
        ->post(route('talk-to-us.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'subject' => '',
            'message' => 'short',
        ])
        ->assertRedirect('/contact')
        ->assertSessionHasErrors(['name', 'email']);
});

it('validates talk to us content fields', function () {
    $this->from('/contact')
        ->post(route('talk-to-us.store'), [
            'name' => 'Footer User',
            'email' => 'footer@example.com',
            'subject' => '',
            'message' => 'short',
        ])
        ->assertRedirect('/contact')
        ->assertSessionHasErrors(['subject', 'message']);
});

it('stores hero quote requests', function () {
    $response = $this->post(route('talk-to-us.store'), [
        'enquiry_type' => 'quote',
        'name' => 'Sarah Quote',
        'email' => 'sarah@example.com',
        'phone' => '+256701234567',
        'product_interest' => 'Bricks',
        'project_type' => 'Home build',
        'quantity' => '10,000 units',
        'details' => 'Need pricing for a new home build in Masaka.',
        'source_url' => 'http://localhost/',
    ]);

    $response
        ->assertRedirect()
        ->assertSessionHas('talk_to_us_success');

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'Sarah Quote',
        'email' => 'sarah@example.com',
        'subject' => 'Request for Quote',
    ]);
});
