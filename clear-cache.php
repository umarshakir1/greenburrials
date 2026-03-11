<?php
/**
 * WordPress Cache Clearer
 * Run this file directly in browser: http://localhost/green-burials/clear-cache.php
 */

// Load WordPress
require_once('wp-load.php');

// Clear all transients
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_site_transient_%'");

// Clear object cache
wp_cache_flush();

// Clear rewrite rules
flush_rewrite_rules();

echo "<h1>WordPress Cache Cleared!</h1>";
echo "<p>All transients, object cache, and rewrite rules have been flushed.</p>";
echo "<p><strong>Now refresh your blog page.</strong></p>";
echo "<p><a href='/green-burials/blog'>Go to Blog Page</a></p>";
?>
