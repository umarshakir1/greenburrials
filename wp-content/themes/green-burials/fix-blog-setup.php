<?php
/**
 * Fix Blog Page - Create Blog page and configure WordPress settings
 */

require_once('../../../wp-load.php');

echo "<h2>Blog Page Setup Fix</h2>\n";

// Check if Blog page exists
$blog_page = get_page_by_path('blog');

if (!$blog_page) {
    echo "<p style='color:orange;'>Blog page doesn't exist. Creating it now...</p>\n";
    
    // Create the Blog page
    $page_id = wp_insert_post(array(
        'post_title' => 'Blog',
        'post_name' => 'blog',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_content' => '<!-- Blog posts will be displayed here -->'
    ));
    
    if (!is_wp_error($page_id)) {
        echo "<p style='color:green;'>✓ Created Blog page with ID: $page_id</p>\n";
        
        // Set it as the posts page
        update_option('page_for_posts', $page_id);
        echo "<p style='color:green;'>✓ Set Blog page as Posts page in Reading Settings</p>\n";
    } else {
        echo "<p style='color:red;'>✗ Error creating Blog page: " . $page_id->get_error_message() . "</p>\n";
    }
} else {
    echo "<p style='color:green;'>✓ Blog page already exists (ID: " . $blog_page->ID . ")</p>\n";
    
    // Make sure it's set as posts page
    $posts_page_id = get_option('page_for_posts');
    if ($posts_page_id != $blog_page->ID) {
        update_option('page_for_posts', $blog_page->ID);
        echo "<p style='color:green;'>✓ Updated Posts page setting to Blog page</p>\n";
    } else {
        echo "<p style='color:green;'>✓ Blog page is already set as Posts page</p>\n";
    }
}

// Make sure front page is set to a static page
$show_on_front = get_option('show_on_front');
if ($show_on_front !== 'page') {
    update_option('show_on_front', 'page');
    echo "<p style='color:green;'>✓ Set homepage to display a static page</p>\n";
} else {
    echo "<p style='color:green;'>✓ Homepage is already set to static page</p>\n";
}

// Flush rewrites
flush_rewrite_rules(true);
echo "<p style='color:green;'>✓ Flushed permalink rules</p>\n";

// Show current settings
echo "<h3>Current Settings:</h3>\n";
echo "<ul>\n";
echo "<li>Show on front: " . get_option('show_on_front') . "</li>\n";
echo "<li>Front page ID: " . get_option('page_on_front') . "</li>\n";
echo "<li>Posts page ID: " . get_option('page_for_posts') . "</li>\n";
$posts_page = get_post(get_option('page_for_posts'));
if ($posts_page) {
    echo "<li>Posts page title: " . $posts_page->post_title . "</li>\n";
    echo "<li>Posts page slug: " . $posts_page->post_name . "</li>\n";
    echo "<li>Posts page URL: " . get_permalink($posts_page->ID) . "</li>\n";
}
echo "</ul>\n";

echo "<h3>Test Links:</h3>\n";
echo "<ul>\n";
echo "<li><a href='" . home_url('/') . "'>Home Page</a></li>\n";
echo "<li><a href='" . home_url('/blog/') . "'>Blog Page (/blog/)</a></li>\n";
if ($posts_page) {
    echo "<li><a href='" . get_permalink($posts_page->ID) . "'>Posts Page (via permalink)</a></li>\n";
}
echo "</ul>\n";

echo "<p style='background:#e7f3e7;padding:15px;border-left:4px solid #73884D;'><strong>Done!</strong> Try clicking the Blog Page link above.</p>\n";
?>
