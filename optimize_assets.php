<?php
require_once('/var/www/html/green-burials/wp-load.php');
require_once('/var/www/html/green-burials/wp-content/themes/green-burials/functions.php');

$assets_dir = '/var/www/html/green-burials/wp-content/themes/green-burials/assets/figma_exported_images';
$files = [
    'Mask-group-3.png',
    'Mask-group-5.png',
    'Mask-group-1.png',
    '550451489ebc5697753c896d5deecd996d6bdfcb-scaled.jpg',
    'Rectangle 378.png',
    'image 53.png'
];

foreach ($files as $file) {
    $path = $assets_dir . '/' . $file;
    if (file_exists($path)) {
        echo "Optimizing $file...\n";
        $optimized = green_burials_compress_image($path, 80, 1200);
        if ($optimized !== $path) {
            echo "Successfully optimized $file to " . basename($optimized) . "\n";
        } else {
            echo "Failed to optimize $file or already optimized.\n";
        }
    }
}
?>
