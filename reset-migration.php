<?php
/**
 * Standalone Reset Script for WooCommerce Migration
 * VERSION: High-Performance Batched Deletion
 */

// Load WordPress
require_once( 'wp-load.php' );

// Increase limits
@set_time_limit( 300 );
@ini_set( 'memory_limit', '512M' );

if ( ! current_user_can( 'manage_options' ) && ! isset( $_GET['run_reset'] ) ) {
    die( 'Access denied. Please login as admin or add ?run_reset=1 to the URL.' );
}

$batch_size = 1000;

echo '<h1>WooCommerce Migration Reset (Batched)</h1>';

global $wpdb;

// 1. Get a batch of customer IDs
$prefix = $wpdb->prefix;
$cap_key = $prefix . 'capabilities';
$customer_ids = $wpdb->get_col( $wpdb->prepare( 
    "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = %s AND meta_value LIKE '%%customer%%' LIMIT %d",
    $cap_key,
    $batch_size
) );

if ( empty( $customer_ids ) ) {
    // Check if we still have any records in the lookup table
    $lookup_table = $wpdb->prefix . 'wc_customer_lookup';
    $wpdb->query( "TRUNCATE TABLE {$lookup_table}" );
    
    // Reset migration flags
    delete_option( 'cb_migration_status' );
    delete_option( 'cb_migration_progress' );
    
    echo '<h2 style="color: green;">Reset Complete!</h2>';
    echo '<p>All customers deleted and migration state reset.</p>';
    echo '<p><strong>DELETE THIS FILE (reset-migration.php) NOW!</strong></p>';
    die();
}

echo '<p>Deleting ' . count( $customer_ids ) . ' customers...</p>';
$id_list = implode( ',', array_map( 'intval', $customer_ids ) );

// Perform Deletion (Direct SQL for speed)
$wpdb->query( "DELETE FROM {$wpdb->users} WHERE ID IN ($id_list)" );
$wpdb->query( "DELETE FROM {$wpdb->usermeta} WHERE user_id IN ($id_list)" );

// Simple redirect for next batch
$next_url = add_query_arg( array( 'run_reset' => 1, 'v' => time() ), $_SERVER['REQUEST_URI'] );
echo '<p>Batch finished. Redirecting to clean more...</p>';
echo '<script>window.location.href = "' . $next_url . '";</script>';
echo '<p><a href="' . $next_url . '">Click here if it doesn\'t redirect automatically</a></p>';
