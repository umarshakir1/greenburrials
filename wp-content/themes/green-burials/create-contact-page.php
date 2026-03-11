<?php
/**
 * Script to create the Contact Us page and assign the template.
 */

// Load WordPress
require_once(__DIR__ . '/../../../wp-load.php');

// Security check (optional, but good practice if run from browser)
if (php_sapi_name() !== 'cli' && !current_user_can('manage_options')) {
    die('Unauthorized access.');
}

$slug = 'contact';
$title = 'Contact Us';
$template = 'page-contact.php';

$existing_page = get_page_by_path($slug);

if ($existing_page) {
    echo "Page with slug '$slug' already exists. ID: " . $existing_page->ID . "\n";
    $page_id = $existing_page->ID;
} else {
    $page_id = wp_insert_post(array(
        'post_title' => $title,
        'post_name' => $slug,
        'post_content' => '', // Content is handled by the template
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_author' => 1,
    ));

    if ($page_id && !is_wp_error($page_id)) {
        echo "Successfully created page '$title' with slug '$slug'. ID: $page_id\n";
    } else {
        die("Failed to create page '$title'.\n");
    }
}

// Assign the template
update_post_meta($page_id, '_wp_page_template', $template);
echo "Assigned template '$template' to page ID $page_id.\n";

// Flush rewrite rules to ensure the new slug works
flush_rewrite_rules();
echo "Flushed rewrite rules.\n";
