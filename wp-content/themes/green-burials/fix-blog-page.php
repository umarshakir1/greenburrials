<?php
/**
 * Fix Blog Page Setup
 * This creates a dedicated "Blog" page and configures WordPress to use it
 */

require_once('../../../wp-load.php');

echo "<h2>Fixing Blog Page Setup</h2>\n";

// Create or get the Blog page
$blog_page = get_page_by_path('blog');

if (!$blog_page) {
    // Create a new Blog page
    $blog_page_id = wp_insert_post(array(
        'post_title'    => 'Blog',
        'post_name'     => 'blog',
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_author'   => 1
    ));
    
    if (is_wp_error($blog_page_id)) {
        echo "<p style='color:red;'>Error creating Blog page</p>\n";
    } else {
        echo "<p style='color:green;'>✓ Created Blog page (ID: $blog_page_id)</p>\n";
        
        // Set this page as the posts page
        update_option('page_for_posts', $blog_page_id);
        echo "<p style='color:green;'>✓ Set Blog page as the posts page</p>\n";
    }
} else {
    // Page already exists, just set it as posts page
    update_option('page_for_posts', $blog_page->ID);
    echo "<p style='color:green;'>✓ Blog page already exists (ID: {$blog_page->ID})</p>\n";
    echo "<p style='color:green;'>✓ Set as the posts page</p>\n";
}

// Flush permalinks
flush_rewrite_rules(true);
echo "<p style='color:green;'>✓ Permalinks flushed</p>\n";

echo "<h3 style='margin-top:2rem;'>Setup Complete!</h3>\n";
echo "<p><a href='" . home_url('/blog/') . "' style='display:inline-block; background:#73884D; color:#fff; padding:12px 24px; text-decoration:none; border-radius:25px; font-weight:600;'>View Blog Page</a></p>\n";
?>
