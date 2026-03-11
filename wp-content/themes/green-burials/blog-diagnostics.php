<?php
/**
 * Blog Diagnostics - Check posts and permalink settings
 */

require_once('../../../wp-load.php');

echo "<h2>Blog Diagnostics</h2>\n";

// Check posts
echo "<h3>Blog Posts</h3>\n";
$posts = get_posts(array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'post_status' => 'publish'
));

echo "<p>Total published posts: <strong>" . count($posts) . "</strong></p>\n";

if (count($posts) > 0) {
    echo "<ul>\n";
    foreach ($posts as $post) {
        echo "<li>" . esc_html($post->post_title) . " (ID: " . $post->ID . ", Date: " . $post->post_date . ")</li>\n";
    }
    echo "</ul>\n";
} else {
    echo "<p style='color:red;'>No posts found!</p>\n";
}

// Check permalink structure
echo "<h3>Permalink Structure</h3>\n";
$permalink_structure = get_option('permalink_structure');
echo "<p>Current structure: <strong>" . ($permalink_structure ? esc_html($permalink_structure) : 'Plain (default)') . "</strong></p>\n";

// Check blog page URL
echo "<h3>Blog URL</h3>\n";
$blog_url = get_post_type_archive_link('post');
echo "<p>WordPress blog archive URL: <strong>" . esc_html($blog_url) . "</strong></p>\n";

// Check page on front settings
$show_on_front = get_option('show_on_front');
$page_on_front = get_option('page_on_front');
$page_for_posts = get_option('page_for_posts');

echo "<h3>Reading Settings</h3>\n";
echo "<p>Show on front: <strong>" . esc_html($show_on_front) . "</strong></p>\n";
echo "<p>Front page ID: <strong>" . esc_html($page_on_front) . "</strong></p>\n";
echo "<p>Posts page ID: <strong>" . esc_html($page_for_posts) . "</strong></p>\n";

// Try to flush and check
echo "<h3>Actions</h3>\n";
flush_rewrite_rules(true);
echo "<p style='color:green;'>✓ Permalinks flushed</p>\n";

// Provide links
echo "<h3>Test Links</h3>\n";
echo "<ul>\n";
echo "<li><a href='" . home_url('/') . "'>Home Page</a></li>\n";
echo "<li><a href='" . home_url('/blog/') . "'>Blog Page (/blog/)</a></li>\n";
if ($blog_url) {
    echo "<li><a href='" . $blog_url . "'>WordPress Archive URL</a></li>\n";
}
if (count($posts) > 0) {
    echo "<li><a href='" . get_permalink($posts[0]->ID) . "'>First Post</a></li>\n";
}
echo "</ul>\n";

echo "<h3>Template Files</h3>\n";
$theme_dir = get_template_directory();
echo "<p>Theme directory: " . esc_html($theme_dir) . "</p>\n";
echo "<ul>\n";
echo "<li>archive.php: " . (file_exists($theme_dir . '/archive.php') ? '✓ Exists' : '✗ Missing') . "</li>\n";
echo "<li>index.php: " . (file_exists($theme_dir . '/index.php') ? '✓ Exists' : '✗ Missing') . "</li>\n";
echo "<li>home.php: " . (file_exists($theme_dir . '/home.php') ? '✓ Exists' : '✗ Missing') . "</li>\n";
echo "</ul>\n";
?>
