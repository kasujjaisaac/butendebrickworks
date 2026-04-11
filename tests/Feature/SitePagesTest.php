<?php

it('renders the rebuilt public site pages', function (string $uri, string $text) {
    $this->get($uri)
        ->assertOk()
        ->assertSeeText($text);
})->with([
    ['/', 'Get pricing guidance quickly.'],
    ['/about', 'A factory story rooted in service, craft, and long-term regional value.'],
    ['/services', 'A production offer built around durability, variety, and usable construction guidance.'],
    ['/products', 'Clay products for projects that need structure, beauty, and long service life.'],
    ['/bricks', 'Structural fired clay units for walls, columns, arches, and long-life masonry work.'],
    ['/opportunities', 'Build with us beyond the production line.'],
    ['/jobs', 'We have no current job opening.'],
    ['/trainings-and-internship', 'We have no current training opening.'],
    ['/help-center', 'Questions we hear most often, rewritten around the real business.'],
    ['/contact', 'Reach the yard, the office, or the team behind the products.'],
]);

it('supports the product route alias', function () {
    $this->get('/products/floor-tiles')
        ->assertOk()
        ->assertSeeText('Floor Tiles');
});

it('shows the featured product families on the home page', function () {
    $this->get('/')
        ->assertOk()
        ->assertSeeText('Our Products')
        ->assertSeeText('Bricks')
        ->assertSeeText('Floor Tiles')
        ->assertSeeText('Decorative Bricks')
        ->assertSeeText('Ventilators')
        ->assertSeeText('Other Products');
});

it('shows partner cards on the home page', function () {
    $this->get('/')
        ->assertOk()
        ->assertSeeText('Our Clients')
        ->assertSeeText('Masaka Diocese')
        ->assertSeeText('Commercial Developers');
});

it('shows client reviews on the home page', function () {
    $this->get('/')
        ->assertOk()
        ->assertSeeText('Client Reviews')
        ->assertSeeText('Peter M.')
        ->assertSeeText('Residential builder');
});
