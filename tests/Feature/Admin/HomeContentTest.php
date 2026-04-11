<?php

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('admin users can update homepage company content with uploads', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->put(route('admin.home.company.update'), [
        'name' => 'Butende Brick Works',
        'short_name' => 'BBW',
        'tagline' => 'Updated clay products for buildings that need to last.',
        'founded' => '1967',
        'years' => '58+',
        'mission' => 'Updated mission statement.',
        'vision' => 'Updated vision statement.',
        'history' => 'Updated history statement.',
        'story' => [
            'Updated story paragraph one.',
            'Updated story paragraph two.',
        ],
        'emails' => [
            'admin@butendebrickworks.co.ug',
        ],
        'phones' => [
            '+256 700 000 000',
        ],
        'primary_phone_href' => '+256 700 000 000',
        'whatsapp_href' => '+256 700 000 000',
        'address' => 'Matanga, Masaka, Uganda',
        'address_hint' => 'PRXP+V2, Butende',
        'hours' => 'Monday - Saturday, 8am - 5pm',
        'facebook' => 'https://www.facebook.com/butendebrickworks',
        'map_url' => 'https://maps.google.com/?q=PRXP%2BV2%2C%20Butende',
        'map_embed' => 'https://maps.google.com/maps?q=PRXP%2BV2%2C%20Butende&t=m&z=16&output=embed',
        'meta_description' => 'Updated homepage meta description.',
        'logo_upload' => UploadedFile::fake()->image('logo.jpg'),
        'hero_image_upload' => UploadedFile::fake()->image('hero.jpg'),
        'about_image_upload' => UploadedFile::fake()->image('about.jpg'),
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();

    $company = SiteSetting::query()->where('key', 'company')->firstOrFail()->value;

    expect($company['tagline'])->toBe('Updated clay products for buildings that need to last.');
    expect($company['logo_path'])->toStartWith('/storage/site-content/');
    expect($company['hero_image'])->toStartWith('/storage/site-content/');
    expect($company['about_image'])->toStartWith('/storage/site-content/');
});

test('updated homepage stats are shown on the public home page', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->put(route('admin.home.stats.update'), [
        'items' => [
            ['value' => '99+', 'label' => 'Years of trust'],
            ['value' => '8', 'label' => 'Clay collections'],
        ],
    ])->assertRedirect();

    $this->get('/')
        ->assertOk()
        ->assertSeeText('99+')
        ->assertSeeText('Years of trust')
        ->assertSeeText('Clay collections');
});
