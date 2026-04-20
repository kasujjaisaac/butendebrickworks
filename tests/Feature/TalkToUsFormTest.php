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

it('silently discards honeypot talk to us submissions', function () {
    $response = $this->from('/contact')
        ->post(route('talk-to-us.store'), [
            'name' => 'Spam Bot',
            'email' => 'bot@example.com',
            'subject' => 'Spam',
            'message' => 'This should never be stored as a real enquiry.',
            'source_url' => 'http://localhost/contact',
            'website' => 'https://spam.invalid',
        ]);

    $response
        ->assertRedirect('/contact')
        ->assertSessionHas('talk_to_us_success');

    expect(ContactMessage::query()->count())->toBe(0);
});

it('rate limits repeated talk to us submissions', function () {
    $payload = [
        'name' => 'Rate Limited User',
        'email' => 'limited@example.com',
        'subject' => 'Bulk brick enquiry',
        'message' => 'We are planning a project and need product guidance for a real submission.',
        'source_url' => 'http://localhost/contact',
    ];

    foreach (range(1, 5) as $attempt) {
        $this->from('/contact')
            ->post(route('talk-to-us.store'), $payload)
            ->assertRedirect('/contact');
    }

    $this->from('/contact')
        ->post(route('talk-to-us.store'), $payload)
        ->assertStatus(429);

    expect(ContactMessage::query()->count())->toBe(5);
});
