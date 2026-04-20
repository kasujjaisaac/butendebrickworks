<?php

namespace App\Support;

class SiteContent
{
    public static function company(): array
    {
        return [
            'name' => 'Butende Brick Works',
            'short_name' => 'BBW',
            'logo_path' => 'images/butende-logo.jpg',
            'tagline' => 'Fired clay products for buildings that need to last.',
            'founded' => '1967',
            'years' => '57+',
            'mission' => 'To increase the quality and quantity of clay products through the improvement and adoption of modern production systems.',
            'vision' => 'To be the leading producer of noticeable and commendable fired clay products in the Greater Masaka Region.',
            'history' => 'Our company was established in 1967 under the ownership of Masaka Diocese.',
            'story' => [
                'Butende Brick Works began as a response to the region’s growing need for durable bricks for schools, churches, homes, and community buildings.',
                'Over the decades, the factory has grown into a dependable manufacturing partner that also supports pastoral and social programmes through the value created by its work.',
                'Today, the business pairs traditional fired-clay craftsmanship with a stronger focus on responsible production, community opportunity, and products that hold up beautifully over time.',
            ],
            'emails' => [
                'info@butendebrickworks.co.ug',
                'bricksbutende@gmail.com',
            ],
            'phones' => [
                '+256 782 783 078',
                '+256 704 505 661',
                '+256 752 698 301',
                '+256 775 505 661',
            ],
            'primary_phone_href' => '256775505661',
            'whatsapp_href' => '256775505661',
            'address' => 'Matanga, Masaka, Uganda',
            'address_hint' => 'PRXP+V2, Butende',
            'hours' => 'Monday - Saturday, 8am - 5pm',
            'facebook' => 'https://www.facebook.com/butendebrickworks',
            'socials' => [
                [
                    'name' => 'Facebook',
                    'href' => 'https://www.facebook.com/butendebrickworks',
                    'icon' => 'facebook',
                ],
                [
                    'name' => 'WhatsApp',
                    'href' => 'https://wa.me/256775505661',
                    'icon' => 'whatsapp',
                ],
                [
                    'name' => 'Email',
                    'href' => 'mailto:info@butendebrickworks.co.ug',
                    'icon' => 'mail',
                ],
            ],
            'map_url' => 'https://maps.google.com/?q=PRXP%2BV2%2C%20Butende',
            'map_embed' => 'https://maps.google.com/maps?q=PRXP%2BV2%2C%20Butende&t=m&z=16&output=embed',
            'hero_image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2024/11/DSC07157.png',
            'about_image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2024/07/WhatsApp-Image-2024-04-01-at-17.09.40-1024x500.jpeg',
            'meta_description' => 'Butende Brick Works manufactures durable fired clay bricks, tiles, ventilators, and other clay products for homes, schools, churches, and commercial projects across Uganda.',
            'core_values' => [
                [
                    'title' => 'Quality',
                    'description' => 'We produce fired clay products that meet the highest standards of durability and craftsmanship — every batch, every order.',
                ],
                [
                    'title' => 'Integrity',
                    'description' => 'We operate with honesty and transparency in everything we do, from production to pricing to the partnerships we build.',
                ],
                [
                    'title' => 'Community',
                    'description' => 'Our work creates lasting value for the Greater Masaka Region through employment, skills development, and support for social programmes.',
                ],
                [
                    'title' => 'Reliability',
                    'description' => 'Project teams and contractors depend on us for consistent supply and practical guidance. We take that responsibility seriously.',
                ],
                [
                    'title' => 'Sustainability',
                    'description' => 'We invest in responsible production practices — including tree-planting efforts — to protect the environment we work within.',
                ],
            ],
        ];
    }

    public static function stats(): array
    {
        return [
            [
                'value' => '57+',
                'label' => 'Years of service',
            ],
            [
                'value' => '5',
                'label' => 'Main product families',
            ],
            [
                'value' => '1967',
                'label' => 'Year established',
            ],
            [
                'value' => '6 days',
                'label' => 'Weekly operating schedule',
            ],
        ];
    }

    public static function capabilities(): array
    {
        return [
            [
                'title' => 'High-Quality Fired Clay Products',
                'description' => 'We manufacture premium clay bricks, floor tiles, ventilators, and complementary products using locally sourced clay and durable firing methods.',
            ],
            [
                'title' => 'Custom Profiles and Product Advice',
                'description' => 'Projects often need more than a standard unit. We support profile selection, quantity planning, and product combinations that suit the build.',
            ],
            [
                'title' => 'Reliable Supply for Institutions and Contractors',
                'description' => 'From churches and schools to homes and commercial compounds, we help teams source the product mix needed for phased construction work.',
            ],
            [
                'title' => 'Community-Focused Manufacturing',
                'description' => 'Our operations are grounded in long-term regional impact, from skills development and employment to responsible production and tree-planting efforts.',
            ],
        ];
    }

    public static function process(): array
    {
        return [
            [
                'title' => 'Tell us what you are building',
                'description' => 'Share the structure type, desired finish, and approximate quantities so we can point you to the right clay profile.',
            ],
            [
                'title' => 'Confirm the right product mix',
                'description' => 'We align standard and decorative units, ventilators, and floor pieces to the practical and aesthetic needs of the project.',
            ],
            [
                'title' => 'Schedule production and collection',
                'description' => 'Bulk orders and specialised pieces can be planned against your build sequence to reduce avoidable site delays.',
            ],
            [
                'title' => 'Build with confidence',
                'description' => 'The result is a supply plan rooted in durability, good workmanship, and a finish that still looks strong years later.',
            ],
        ];
    }

    public static function sectors(): array
    {
        return [
            'Schools and education facilities',
            'Churches and diocesan projects',
            'Homes and residential compounds',
            'Commercial buildings',
            'Boundary walls and courtyards',
            'Community infrastructure',
        ];
    }

    public static function products(): array
    {
        return [
            'bricks' => [
                'slug' => 'bricks',
                'path' => '/bricks',
                'name' => 'Bricks',
                'tagline' => 'Structural fired clay units for walls, columns, arches, and long-life masonry work.',
                'summary' => 'Our brick range is built for strength, clean detailing, and the warmth that only fired clay delivers. It covers standard walling units alongside profile bricks for corners, pillars, arches, and patterned finishes.',
                'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/BIG-HALF-BRICK-GROOVED.jpg',
                'benefits' => [
                    'Built for structural durability and dependable walling performance',
                    'Natural clay colour that ages with character instead of looking manufactured',
                    'Multiple shapes for tighter detailing around corners, pillars, and openings',
                ],
                'applications' => [
                    'Residential walls and perimeter fences',
                    'Schools, churches, and community buildings',
                    'Feature walls, arches, and entrance elements',
                ],
                'profiles' => [
                    [
                        'name' => 'Plain Brick',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/PLAIN-BRICK.jpg',
                        'description' => 'A classic choice for straightforward walling and timeless brick facades.',
                    ],
                    [
                        'name' => 'Half Brick',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/BIG-HALF-BRICK-GROOVED.jpg',
                        'description' => 'Useful for tight layouts, course adjustments, and neat pattern transitions.',
                    ],
                    [
                        'name' => 'Standard Brick Grooved',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/BIG-HALF-BRICK-GROOVED.jpg',
                        'description' => 'Adds texture and a stronger visual rhythm to exposed masonry work.',
                    ],
                    [
                        'name' => 'Arch Brick',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/ARCH-BRICK.jpg',
                        'description' => 'Special profiles that help resolve curves and arched openings cleanly.',
                    ],
                    [
                        'name' => 'Pillar Brick',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/PILLAR-BRICK.jpg',
                        'description' => 'Designed for clean column construction and decorative pillar work.',
                    ],
                    [
                        'name' => 'Corner Brick',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/CORNER-BRICK.jpg',
                        'description' => 'Resolves building corners with a clean, continuous clay finish.',
                    ],
                    [
                        'name' => 'T Brick',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/T-BRICK.jpg',
                        'description' => 'Useful at wall junctions and decorative T-shaped intersections.',
                    ],
                ],
            ],
            'floor-tiles' => [
                'slug' => 'floor-tiles',
                'path' => '/floor-tiles',
                'name' => 'Floor Tiles',
                'tagline' => 'Hard-wearing clay floor tiles for courtyards, verandas, walkways, and rustic interiors.',
                'summary' => 'Butende floor tiles bring warmth, durability, and a crafted finish to spaces that need both character and resilience. They work especially well where heavy foot traffic meets a natural architectural palette.',
                'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/3-4-1.jpg',
                'benefits' => [
                    'Durable finish suited to active family, institutional, and outdoor spaces',
                    'Warm clay texture that complements both traditional and modern buildings',
                    'A practical alternative for verandas, courtyards, and circulation areas',
                ],
                'applications' => [
                    'Verandas and covered terraces',
                    'Courtyards and garden walkways',
                    'Schools, guest facilities, and public gathering spaces',
                ],
                'profiles' => [
                    [
                        'name' => 'Standard Floor Tile',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/3-4-1.jpg',
                        'description' => 'A reliable all-purpose clay tile for indoor and outdoor surfaces.',
                    ],
                    [
                        'name' => 'Courtyard Tile',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/4-4-1.jpg',
                        'description' => 'A grounded clay finish for transitional spaces around the building edge.',
                    ],
                    [
                        'name' => 'Veranda Tile',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/2323-1.jpg',
                        'description' => 'Warm and durable — suited to covered outdoor circulation spaces.',
                    ],
                    [
                        'name' => 'Interior Floor Tile',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/DFDFD1-1.jpg',
                        'description' => 'Ideal when you want a natural floor that feels warm, tactile, and enduring.',
                    ],
                    [
                        'name' => 'Quarry Tile',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/Quary-Tile-1.jpg',
                        'description' => 'Sized and finished to handle movement, weather, and repeated use.',
                    ],
                ],
            ],
            'decorative-bricks' => [
                'slug' => 'decorative-bricks',
                'path' => '/decorative-bricks',
                'name' => 'Decorative Bricks',
                'tagline' => 'Clay pieces designed to add pattern, airflow, shadow, and architectural character.',
                'summary' => 'Decorative bricks from Butende Brick Works help projects stand out without sacrificing the earthy authenticity of fired clay. They are especially effective where architecture needs texture, rhythm, and a stronger identity.',
                'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/DOUBLE-POMPE.jpg',
                'benefits' => [
                    'Adds texture and identity to facades, screens, and feature walls',
                    'Pairs naturally with structural brick palettes from the same production line',
                    'Creates elegant ventilation and shadow effects in warm climates',
                ],
                'applications' => [
                    'Feature walls and entrance moments',
                    'Facade screens and patterned ventilation zones',
                    'Landscaped and hospitality-style spaces',
                ],
                'profiles' => [
                    [
                        'name' => 'Double Pompe',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/DOUBLE-POMPE.jpg',
                        'description' => 'Pattern-led units that create expressive masonry and screen effects.',
                    ],
                    [
                        'name' => 'Malta',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/MALTA.jpg',
                        'description' => 'A refined decorative profile suited to feature walls and facades.',
                    ],
                    [
                        'name' => 'Malta II',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/MALTA-2.jpg',
                        'description' => 'A variation of the Malta profile for richer patterned arrangements.',
                    ],
                    [
                        'name' => 'Single Pompe',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/SINGLE-POMPE-1.jpg',
                        'description' => 'Elegant single-unit screening for ventilation and visual texture.',
                    ],
                    [
                        'name' => 'Spina',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/SPINA.jpg',
                        'description' => 'A spine-like profile that adds rhythm and shadow to any exposed surface.',
                    ],
                ],
            ],
            'ventilators' => [
                'slug' => 'ventilators',
                'path' => '/ventilators',
                'name' => 'Ventilators',
                'tagline' => 'Clay ventilators that improve airflow while still feeling like part of the architecture.',
                'summary' => 'Our ventilators are designed to keep buildings breathing in a way that respects the language of clay construction. They help with comfort, airflow, and finished elevations that look considered rather than improvised.',
                'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/X-VENTILATORS.jpg',
                'benefits' => [
                    'Improves airflow in homes, institutions, and utility areas',
                    'Integrates visually with other fired clay products on the project',
                    'Supports comfort without depending entirely on mechanical ventilation',
                ],
                'applications' => [
                    'Gable ends and upper wall sections',
                    'Boundary walls and service buildings',
                    'Decorative ventilation in facades and corridors',
                ],
                'profiles' => [
                    [
                        'name' => 'Star Ventilator',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/star.jpg',
                        'description' => 'A star-patterned unit that combines strong airflow with decorative appeal.',
                    ],
                    [
                        'name' => 'O Ventilator',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/O-VENTILATORS-1.jpg',
                        'description' => 'Circular openings for smooth, even air distribution across wall sections.',
                    ],
                    [
                        'name' => 'Malta Ventilator',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/MALTA-2-1.jpg',
                        'description' => 'Best where airflow needs to be part of the building expression.',
                    ],
                    [
                        'name' => 'Quarter Circle Ventilator',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/Quater-Circle-Ventilator.jpg',
                        'description' => 'Curved units that work well at corners and arched wall sections.',
                    ],
                    [
                        'name' => 'X Ventilator',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/X-VENTILATORS.jpg',
                        'description' => 'A crisp geometric pattern that balances airflow and visual texture.',
                    ],
                ],
            ],
            'other-products' => [
                'slug' => 'other-products',
                'path' => '/other-products',
                'name' => 'Other Products',
                'tagline' => 'Complementary clay products for broader construction and finishing needs.',
                'summary' => 'In addition to our core lines, we produce other clay products that help complete a wider range of building applications. These pieces are useful when a project needs continuity across walling, roofing, or internal division elements.',
                'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/1-6-1.jpg',
                'benefits' => [
                    'Lets builders source matching clay products from one manufacturer',
                    'Supports projects that need both primary and supporting materials',
                    'Extends the same clay-led character across different construction zones',
                ],
                'applications' => [
                    'Roofing and weatherproofing components',
                    'Partitioning and lightweight separation work',
                    'Special-order or project-specific accessories',
                ],
                'profiles' => [
                    [
                        'name' => 'Roofing Tile I',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/1-6-1.jpg',
                        'description' => 'Clay roofing pieces for projects that want continuity from wall to roof.',
                    ],
                    [
                        'name' => 'Roofing Tile II',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/1-6-2.jpg',
                        'description' => 'A complementary roofing profile for varied roof layouts and ridges.',
                    ],
                    [
                        'name' => 'Roofing Tile III',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/1-7-1.jpg',
                        'description' => 'Durable fired clay for weatherproofing sloped and pitched roofs.',
                    ],
                    [
                        'name' => 'Roofing Tile IV',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/1-7.jpg',
                        'description' => 'A classic profile suited to traditional and institutional rooflines.',
                    ],
                    [
                        'name' => 'Max Pan',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/max-pan.jpg',
                        'description' => 'A pan-style roofing tile for broad coverage and clean ridge lines.',
                    ],
                    [
                        'name' => 'Clay Stove',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/stove.jpg',
                        'description' => 'Fired clay cooking stoves built for efficiency and everyday household use.',
                    ],
                    [
                        'name' => 'Partitioning Block',
                        'image' => 'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/1-5-1.jpg',
                        'description' => 'Useful where lightweight internal division is required.',
                    ],
                ],
            ],
        ];
    }

    public static function product(string $slug): ?array
    {
        return self::products()[$slug] ?? null;
    }

    public static function testimonials(): array
    {
        return [
            [
                'name' => 'Peter M.',
                'role' => 'Building contractor',
                'quote' => 'Clients keep returning to clay when they want durability and a finish that still feels honest years later.',
            ],
            [
                'name' => 'Institutional project team',
                'role' => 'Education facilities',
                'quote' => 'The product range is especially valuable when one project needs walling, decorative features, and airflow elements from the same source.',
            ],
            [
                'name' => 'Residential builder',
                'role' => 'Private home construction',
                'quote' => 'The material brings warmth and permanence to homes in a way that paint or imitation finishes cannot match.',
            ],
        ];
    }

    public static function partners(): array
    {
        return [
            [
                'name' => 'Masaka Diocese',
                'type' => 'Founding institution',
                'logo' => '/images/partners/2.jpg',
            ],
            [
                'name' => 'Contractors & Builders',
                'type' => 'Construction delivery',
                'logo' => '/images/partners/3.jpg',
            ],
            [
                'name' => 'Architects & Designers',
                'type' => 'Specification support',
                'logo' => '/images/partners/4.jpg',
            ],
            [
                'name' => 'Schools & Education Projects',
                'type' => 'Institutional builds',
                'logo' => '/images/partners/6.jpg',
            ],
            [
                'name' => 'Church & Parish Projects',
                'type' => 'Community infrastructure',
                'logo' => '/images/partners/7.jpg',
            ],
            [
                'name' => 'Commercial Developers',
                'type' => 'Mixed-use and business sites',
                'logo' => null,
            ],
        ];
    }

    public static function heroSlides(): array
    {
        return [
            [
                'headline' => 'Need premium bricks for your next home?',
                'body' => 'Request a quick quote for durable fired clay products built for long-life masonry work.',
                'primary' => [
                    'label' => 'Request Brick Quote',
                    'link' => '#request-quote',
                ],
                'secondary' => [
                    'label' => 'Explore Bricks',
                    'link' => '/bricks',
                ],
            ],
            [
                'headline' => 'Planning a school or church project?',
                'body' => 'Talk to us about product mix, phased supply, and fired clay options that hold up beautifully over time.',
                'primary' => [
                    'label' => 'Quote Institutional Build',
                    'link' => '#request-quote',
                ],
                'secondary' => [
                    'label' => 'See Capabilities',
                    'link' => '/services',
                ],
            ],
            [
                'headline' => 'Need tiles, ventilators, and decorative pieces?',
                'body' => 'Get guidance on combining clay products across walls, surfaces, and ventilation details from one source.',
                'primary' => [
                    'label' => 'Request Full Product Quote',
                    'link' => '#request-quote',
                ],
                'secondary' => [
                    'label' => 'Browse Products',
                    'link' => '/products',
                ],
            ],
        ];
    }

    public static function faqs(): array
    {
        return [
            [
                'question' => 'What products does Butende Brick Works make?',
                'answer'   => 'We manufacture fired clay bricks, decorative bricks, floor tiles, ventilators, and other supporting clay products such as roofing tiles and partitioning blocks.',
                'category' => 'Products',
            ],
            [
                'question' => 'Can you support bulk orders for institutions or contractors?',
                'answer'   => 'Yes. The business serves homes, churches, schools, and commercial projects, and larger orders can be discussed in line with project timelines and required quantities.',
                'category' => 'Ordering',
            ],
            [
                'question' => 'Do you make custom or specialised clay profiles?',
                'answer'   => 'Yes. The current product range already includes shaped units for corners, pillars, arches, and decorative applications, and we can guide clients toward the best fit for a project.',
                'category' => 'Products',
            ],
            [
                'question' => 'How do I request pricing or product guidance?',
                'answer'   => 'The fastest path is to call or email with your location, the type of project, the product you need, and an approximate quantity. That gives us enough context to guide the conversation.',
                'category' => 'Ordering',
            ],
            [
                'question' => 'Where is the factory located?',
                'answer'   => 'Butende Brick Works is located in Matanga, Masaka, Uganda, and the live site references the map point PRXP+V2, Butende.',
                'category' => 'Location',
            ],
            [
                'question' => 'Are jobs or training opportunities currently open?',
                'answer'   => 'There are no active job or training openings at the moment. Visit the Opportunities page and register your interest — we will reach out as soon as something relevant opens.',
                'category' => 'Careers',
            ],
        ];
    }

    public static function opportunities(): array
    {
        return [
            'intro' => 'Butende Brick Works creates opportunities in more than one way: through direct employment, hands-on training, contractor partnerships, and long-term supply relationships across the region.',
            'jobs' => [
                'status'  => 'No open positions',
                'open'    => false,
                'title'   => 'Employment',
                'message' => 'We have no current job openings. When positions are available they will appear here first. You are welcome to send a speculative expression of interest to our team.',
                'types'   => [
                    ['role' => 'Kiln & Production Operators', 'icon' => 'fire'],
                    ['role' => 'Quality Control & Grading', 'icon' => 'check'],
                    ['role' => 'Logistics & Site Delivery',  'icon' => 'truck'],
                    ['role' => 'Sales & Client Relations',   'icon' => 'chat'],
                ],
            ],
            'training' => [
                'status'  => 'No active intake',
                'open'    => false,
                'title'   => 'Training & Internship',
                'message' => 'Our hands-on programme places learners directly on the production floor — covering clay preparation, firing, quality grading, and warehouse operations. No active intake is currently running; check back for the next cohort.',
                'tracks'  => [
                    ['name' => 'Clay Preparation & Moulding',   'duration' => '4 weeks'],
                    ['name' => 'Kiln Operations & Firing',      'duration' => '6 weeks'],
                    ['name' => 'Quality Grading & Packing',     'duration' => '3 weeks'],
                    ['name' => 'Business & Supply Management',  'duration' => '4 weeks'],
                ],
            ],
            'partnerships' => [
                [
                    'title'  => 'Contractor Supply',
                    'body'   => 'Long-term supply agreements for developers and building contractors across the Greater Masaka Region.',
                    'icon'   => 'building',
                ],
                [
                    'title'  => 'Institutional Procurement',
                    'body'   => 'We work with schools, government bodies, and NGOs on bulk material sourcing at verified quality standards.',
                    'icon'   => 'institution',
                ],
                [
                    'title'  => 'Architectural Specification',
                    'body'   => 'Support architects and quantity surveyors with product samples, technical data sheets, and site visits.',
                    'icon'   => 'pen',
                ],
            ],
            'values' => [
                ['stat' => '20+', 'label' => 'Years in operation'],
                ['stat' => '50+', 'label' => 'Active staff & workers'],
                ['stat' => '100%', 'label' => 'Locally fired clay'],
                ['stat' => 'Masaka', 'label' => 'Based in the region'],
            ],
        ];
    }

    public static function projectsInUse(): array
    {
        return [
            [
                'image' => '/storage/site-content/projects/project-01.jpg',
                'caption' => 'Brick walling on a residential homestead',
                'tag' => 'Residential',
                'product' => 'Bricks',
                'span' => 'wide',
                'category' => 'Residential',
            ],
            [
                'image' => '/storage/site-content/projects/project-02.jpg',
                'caption' => 'Decorative brick feature at an entrance',
                'tag' => 'Feature wall',
                'product' => 'Decorative Bricks',
                'span' => 'normal',
                'category' => 'Feature & Facade',
            ],
            [
                'image' => '/storage/site-content/projects/project-03.jpg',
                'caption' => 'Institutional building with exposed clay walling',
                'tag' => 'Institutional',
                'product' => 'Bricks',
                'span' => 'normal',
                'category' => 'Institutional',
            ],
            [
                'image' => '/storage/site-content/projects/project-04.jpg',
                'caption' => 'Clay floor tiles laid in a covered outdoor space',
                'tag' => 'Outdoor flooring',
                'product' => 'Floor Tiles',
                'span' => 'normal',
                'category' => 'Residential',
            ],
            [
                'image' => '/storage/site-content/projects/project-05.jpg',
                'caption' => 'Ventilators integrated into a boundary wall',
                'tag' => 'Ventilation',
                'product' => 'Ventilators',
                'span' => 'normal',
                'category' => 'Feature & Facade',
            ],
            [
                'image' => '/storage/site-content/projects/project-06.jpg',
                'caption' => 'Completed structure built with Butende clay products',
                'tag' => 'Completed project',
                'product' => 'Bricks',
                'span' => 'wide',
                'category' => 'Commercial',
            ],
            [
                'image' => '/storage/site-content/projects/project-07.jpg',
                'caption' => 'Plain brick walling detail on an active build',
                'tag' => 'Walling detail',
                'product' => 'Bricks',
                'span' => 'normal',
                'category' => 'Residential',
            ],
            [
                'image' => '/storage/site-content/projects/project-08.jpg',
                'caption' => 'Grooved bricks giving rhythm to an external facade',
                'tag' => 'Facade',
                'product' => 'Decorative Bricks',
                'span' => 'normal',
                'category' => 'Feature & Facade',
            ],
            [
                'image' => '/storage/site-content/projects/project-09.jpg',
                'caption' => 'Church construction project in the Masaka region',
                'tag' => 'Church project',
                'product' => 'Bricks',
                'span' => 'normal',
                'category' => 'Institutional',
            ],
        ];
    }

    public static function blogPosts(): array
    {
        return [
            [
                'title'     => 'Choosing the Right Brick for Your Climate and Project Type',
                'excerpt'   => 'Not all fired-clay bricks perform the same way in every environment. We break down how exposure, load-bearing needs, and aesthetic goals should guide your material choice.',
                'category'  => 'Guide',
                'date'      => 'March 2026',
                'read_time' => '5 min read',
                'author'    => 'Butende Editorial',
                'color'     => '#b86033',
            ],
            [
                'title'     => 'The Enduring Aesthetic of Exposed Brick in Modern Ugandan Architecture',
                'excerpt'   => 'Architects across Kampala and greater Uganda are increasingly specifying exposed brick for its warmth, texture, and unmistakable sense of permanence. Here\'s what is driving the trend.',
                'category'  => 'Design',
                'date'      => 'February 2026',
                'read_time' => '4 min read',
                'author'    => 'Butende Editorial',
                'color'     => '#6e2f0e',
            ],
            [
                'title'     => 'How to Estimate Brick Quantities for Your Next Construction Project',
                'excerpt'   => 'Ordering too few bricks mid-project causes delays. Ordering too many wastes budget. We share the formula our team uses to help builders get it right the first time.',
                'category'  => 'Practical',
                'date'      => 'January 2026',
                'read_time' => '6 min read',
                'author'    => 'Butende Editorial',
                'color'     => '#4a1e08',
            ],
            [
                'title'     => 'Why Fired Clay Outperforms Concrete Block in Long-Term Building Performance',
                'excerpt'   => 'From thermal mass and moisture regulation to structural longevity, we examine why architects and engineers are returning to fired clay for projects built to last generations.',
                'category'  => 'Materials',
                'date'      => 'December 2025',
                'read_time' => '5 min read',
                'author'    => 'Butende Editorial',
                'color'     => '#8a3c12',
            ],
        ];
    }

    public static function navigation(): array
    {
        return [
            [
                'label' => 'Home',
                'path' => '/',
            ],
            [
                'label' => 'About',
                'path' => '/about',
            ],
            [
                'label' => 'Products',
                'path' => '/products',
                'children' => [
                    ['label' => 'All Products',      'path' => '/products',                   'icon' => 'grid',          'desc' => 'Browse the complete fired clay range.'],
                    ['label' => 'Bricks',            'path' => '/products/bricks',            'icon' => 'square',        'desc' => 'Structural units for walls, columns & arches.'],
                    ['label' => 'Floor Tiles',       'path' => '/products/floor-tiles',       'icon' => 'square',        'desc' => 'Hard-wearing tiles for verandas & courtyards.'],
                    ['label' => 'Ventilators',       'path' => '/products/ventilators',       'icon' => 'circle-dashed', 'desc' => 'Clay ventilators for natural airflow.'],
                    ['label' => 'Decorative Bricks', 'path' => '/products/decorative-bricks', 'icon' => 'sparkle',       'desc' => 'Pattern, shadow & architectural character.'],
                    ['label' => 'Other Products',    'path' => '/products/other',             'icon' => 'dots',          'desc' => 'Additional clay products & accessories.'],
                ],
            ],
            [
                'label' => 'Capabilities',
                'path' => '/services',
            ],
            [
                'label' => 'Opportunities',
                'path' => '/opportunities',
            ],
            [
                'label' => 'FAQ',
                'path' => '/help-center',
            ],
            [
                'label' => 'News',
                'path' => '/news',
            ],
            [
                'label' => 'Contact',
                'path' => '/contact',
            ],
        ];
    }
}
