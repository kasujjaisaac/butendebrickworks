<?php
/**
 * Script to download existing WordPress project images and save them locally
 * Run this from the Laravel project root: php download-project-images.php
 */

require 'vendor/autoload.php';

$baseDir = __DIR__;
$storagePath = $baseDir . '/storage/app/public/site-content/projects';

if (!is_dir($storagePath)) {
    mkdir($storagePath, 0755, true);
}

// List of images from WordPress to download
$images = [
    'https://butendebrickworks.co.ug/wp-content/uploads/2024/11/1-2-830x467.jpg',
    'https://butendebrickworks.co.ug/wp-content/uploads/2024/11/1-3-830x543.jpg',
    'https://butendebrickworks.co.ug/wp-content/uploads/2024/11/1-4-830x467.jpg',
    'https://butendebrickworks.co.ug/wp-content/uploads/2024/11/2-2-830x467.jpg',
    'https://butendebrickworks.co.ug/wp-content/uploads/2024/11/2-3-830x373.jpg',
    'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/DSC00628-830x467.jpg',
    'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/DSC00558-830x467.jpg',
    'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/DSC00569-830x467.jpg',
    'https://butendebrickworks.co.ug/wp-content/uploads/2025/02/DSC00623-830x467.jpg',
];

echo "Starting image download...\n";
echo "Target directory: $storagePath\n\n";

foreach ($images as $index => $url) {
    $filename = 'project-' . str_pad($index + 1, 2, '0', STR_PAD_LEFT) . '.jpg';
    $filepath = $storagePath . '/' . $filename;

    echo "[$index] Downloading: $url";

    try {
        $imageData = file_get_contents($url);
        
        if ($imageData === false) {
            echo " - FAILED (could not fetch)\n";
            continue;
        }

        file_put_contents($filepath, $imageData);
        echo " - OK ($filename)\n";
    } catch (Exception $e) {
        echo " - ERROR: " . $e->getMessage() . "\n";
    }
}

echo "\nDownload complete!\n";
echo "Images saved to: storage/app/public/site-content/projects/\n";
