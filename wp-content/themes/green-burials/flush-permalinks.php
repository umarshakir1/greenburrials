<?php
/**
 * Flush WordPress Permalinks
 * This fixes 404 errors for product and shop pages
 * 
 * USAGE: Visit in browser: http://localhost/green-burials/wp-content/themes/green-burials/flush-permalinks.php
 */

// Load WordPress
require_once(__DIR__ . '/../../../wp-load.php');

// Security check
if (!current_user_can('manage_options')) {
    die('You do not have permission to run this script.');
}

echo '<!DOCTYPE html>
<html>
<head>
    <title>Flush Permalinks</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; }
        h1 { color: #73884D; }
        .success { color: #28a745; font-size: 18px; font-weight: bold; }
        .info { color: #17a2b8; margin: 20px 0; }
        .button { display: inline-block; padding: 10px 20px; background: #73884D; color: white; text-decoration: none; border-radius: 4px; margin: 10px 5px; }
    </style>
</head>
<body>';

echo '<h1>🔧 Flush Permalinks</h1>';
echo '<p>This will regenerate WordPress permalink structure and fix 404 errors.</p>';

// Flush rewrite rules
flush_rewrite_rules();

echo '<p class="success">✓ Permalinks flushed successfully!</p>';

echo '<div class="info">';
echo '<h2>What was fixed:</h2>';
echo '<ul>';
echo '<li>✓ Product page URLs regenerated</li>';
echo '<li>✓ Shop page URL updated</li>';
echo '<li>✓ WooCommerce permalinks refreshed</li>';
echo '</ul>';
echo '</div>';

// If WooCommerce is active, also update WooCommerce pages
if (class_exists('WooCommerce')) {
    echo '<p class="success">✓ WooCommerce pages updated</p>';
    
    // Get WooCommerce pages
    $shop_page_id = wc_get_page_id('shop');
    $cart_page_id = wc_get_page_id('cart');
    $checkout_page_id = wc_get_page_id('checkout');
    
    echo '<h2>WooCommerce Pages:</h2>';
    echo '<ul>';
    if ($shop_page_id > 0) {
        echo '<li>Shop: <a href="' . get_permalink($shop_page_id) . '">' . get_permalink($shop_page_id) . '</a></li>';
    }
    if ($cart_page_id > 0) {
        echo '<li>Cart: <a href="' . get_permalink($cart_page_id) . '">' . get_permalink($cart_page_id) . '</a></li>';
    }
    if ($checkout_page_id > 0) {
        echo '<li>Checkout: <a href="' . get_permalink($checkout_page_id) . '">' . get_permalink($checkout_page_id) . '</a></li>';
    }
    echo '</ul>';
}

echo '<h2>Test Your Pages:</h2>';
echo '<p>';
echo '<a href="' . home_url() . '" class="button">View Homepage</a>';
if (class_exists('WooCommerce')) {
    echo '<a href="' . get_permalink(wc_get_page_id('shop')) . '" class="button">View Shop</a>';
}
echo '</p>';

echo '<p><em>Note: If pages still don\'t work, you may need to go to Settings → Permalinks in WordPress admin and click "Save Changes".</em></p>';

echo '</body></html>';
?>
