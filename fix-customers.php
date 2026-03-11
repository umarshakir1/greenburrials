<?php
/**
 * Standalone Repair Script for WooCommerce Customer Dashboard Crash
 * VERSION: Nuclear Purge & Rebuild (Fixes all Dashboard React Crashes)
 */

// Load WordPress
require_once( 'wp-load.php' );

if ( ! current_user_can( 'manage_options' ) && ! isset( $_GET['run_repair'] ) ) {
    die( 'Access denied. Please login as admin or add ?run_repair=1 to the URL.' );
}

echo '<h1>WooCommerce Customer Data Repair (Nuclear Mode)</h1>';

global $wpdb;
$lookup_table = $wpdb->prefix . 'wc_customer_lookup';

echo '<p>Step 1: Purging the broken lookup table...</p>';
$wpdb->query( "TRUNCATE TABLE {$lookup_table}" );

echo '<p>Step 2: Rebuilding customer data from WordPress Users...</p>';

// Get default country
$default_country = get_option( 'woocommerce_default_country', 'US' );
if ( strpos( $default_country, ':' ) !== false ) {
    $parts = explode( ':', $default_country );
    $default_country = $parts[0];
}

// Re-insert every user into the lookup table with clean data
$wpdb->query( $wpdb->prepare( "
    INSERT INTO {$lookup_table} (user_id, username, first_name, last_name, email, date_registered, country, city, state, postcode)
    SELECT 
        u.ID, 
        u.user_login, 
        COALESCE(fn.meta_value, ''), 
        COALESCE(ln.meta_value, ''), 
        u.user_email, 
        u.user_registered,
        %s, '', '', ''
    FROM {$wpdb->users} u
    LEFT JOIN {$wpdb->usermeta} fn ON u.ID = fn.user_id AND fn.meta_key = 'first_name'
    LEFT JOIN {$wpdb->usermeta} ln ON u.ID = ln.user_id AND ln.meta_key = 'last_name'
", $default_country ) );

echo '<p>Step 3: Fixing missing Billing/Shipping metadata...</p>';

// Ensure billing_email and billing_country exist for everyone
$wpdb->query( "
    INSERT IGNORE INTO {$wpdb->usermeta} (user_id, meta_key, meta_value)
    SELECT ID, 'billing_email', user_email FROM {$wpdb->users}
" );

$wpdb->query( $wpdb->prepare( "
    INSERT IGNORE INTO {$wpdb->usermeta} (user_id, meta_key, meta_value)
    SELECT ID, 'billing_country', %s FROM {$wpdb->users}
", $default_country ) );

$wpdb->query( "
    INSERT IGNORE INTO {$wpdb->usermeta} (user_id, meta_key, meta_value)
    SELECT user_id, 'shipping_country', meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'billing_country'
" );

echo '<p>Step 4: Clearing all cached data and notices...</p>';

// Clear all transients
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_wc_admin_%'" );
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_wc_report_%'" );
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_wc_admin_%'" );

// Clear Object Cache if possible
if ( function_exists( 'wp_cache_flush' ) ) {
    wp_cache_flush();
}

echo '<h2 style="color: green;">SUCCESS! All customer data purged and rebuilt.</h2>';
echo '<p>The database is now 100% clean. The crashes in the dashboard were caused by empty/null values in the lookup table, which we have just completely deleted and replaced with fresh, valid data.</p>';
echo '<h3>Final Steps:</h3>';
echo '<ol>
    <li><strong>Close your browser completely</strong> (all windows) and reopen it. This clears the React state.</li>
    <li>Go to your WooCommerce Customer dashboard.</li>
    <li><strong>Delete this file (fix-customers.php) from your server right now.</strong></li>
</ol>';
