<?php
/**
 * Create Sample Blog Posts for Green Burials Theme
 * Run this file once to populate blog posts with images
 */

// WordPress Bootstrap
require_once('../../../wp-load.php');

// Check if running from correct location
if (!function_exists('wp_insert_post')) {
    die('Error: Could not load WordPress. Make sure this file is in the theme directory.');
}

// Sample blog post data matching the reference screenshot
$blog_posts = array(
    array(
        'title' => 'Praesent Lacinia Justo Eget Lacus Malesu Ada, In Luctus Est Fermentum.',
        'content' => 'Diam nisl lorem mollis sit Efficiturquia vit non efficitur sit auguela. Dolor non cefficitur efficitur sit lorem. Ar lorem. Ornare nisi Praesent mollis leo odifosit facilisis nibh lorem. Integer mollis lorem odio, er lorem odio, vel consectetur lorem. Duis vel consectetur lorem. Praeser lorem. Praesen Nullam velitquam vel Praesent Proin',
        'excerpt' => 'Diam nisl lorem mollis sit Efficiturquia vit non efficitur sit auguela. Dolor non cefficitur efficitur sit lorem...',
        'image' => 'Mask group (8)-min.png'
    ),
    array(
        'title' => 'Praesent Sodales Real Sed Cona Eguat Malesuada.',
        'content' => 'Elit non efficitur sit lorem. Ornare nibh lorem. Integer mollis lorem odio, vel condiinteger Praesent Proin Fusce tortor. Nullam interdum etiam nisi vel Praesen',
        'excerpt' => 'Elit non efficitur sit lorem. Ornare nibh lorem. Integer mollis lorem odio, vel condiinteger...',
        'image' => 'Mask group (9)-min.png'
    ),
    array(
        'title' => 'Making Ads In Justo Ret Elementum Its Eros At.',
        'content' => 'Diam Praesent Nulla Proin Fusce Fusce efficitur tortor vel vel Nullam quaatinterdum et nisi etiam quisvel Elit Duis',
        'excerpt' => 'Diam Praesent Nulla Proin Fusce Fusce efficitur tortor vel vel Nullam quaatinterdum et nisi...',
        'image' => 'Mask group (10)-min.png'
    ),
    array(
        'title' => 'Nullam Pulvinar Elit Sed Condim Rutrum Campo.',
        'content' => 'Suspendisse vel velit tempus, aliquet lectus nec, congue ligula condim. Nam Praesent Nulla Facilisis Praesent odio Odio Praesen Duis Viverr vulputate Vulputat ligula',
        'excerpt' => 'Suspendisse vel velit tempus, aliquet lectus nec, congue ligula condim...',
        'image' => 'Mask group (11)-min.png'
    ),
    array(
        'title' => 'Etend Non Magna Lacuina Ipsum Tincidunt Dapibus Sed Diam Sed.',
        'content' => 'Integer etiam Praesen Odio Praesen Duis Viverr vulputate Vulputat ligula Nullam nibh Facilisis Nullam Fusce odio Fusce Venenatis Praesen elit Duis aliquet',
        'excerpt' => 'Integer etiam Praesen Odio Praesen Duis Viverr vulputate Vulputat ligula...',
        'image' => 'Mask group (12)-min.png'
    ),
    array(
        'title' => 'Amare Pede Pellentear Elit Sed Condim Vutrum Campo.',
        'content' => 'Duis Viverr vulputate Vulputat ligula Nullam nibh Facilisis Nullam Fusce odio Fusce Venenatis Praesen elit Duis aliquet Praesent tortor vel Praesen Venenatis Praesen elit',
        'excerpt' => 'Duis Viverr vulputate Vulputat ligula Nullam nibh Facilisis...',
        'image' => 'Mask group (13)-min.png'
    ),
    array(
        'title' => 'Praesent Viverr Et Ees Real Sed Cona Eguat Maleusuada.',
        'content' => 'Suspendisse efficitur tortor vel Nullam quaatinterdum et nisi etiam quisvel Elit Duis Praesen Nullam Facilisis Prae elit Duis aliquet Praesent tortor vel Praesen Venenatis',
        'excerpt' => 'Suspendisse efficitur tortor vel Nullam quaatinterdum et nisi etiam quisvel...',
        'image' => 'Mask group (14)-min.png'
    ),
    array(
        'title' => 'Ouis Ac Juarty Vell Ella Veneuatis Rutrum Ac Wt.',
        'content' => 'Nullam quaatinterdum et nisi etiam quisvel Elit Duis Praesen Nullam Facilisis Prae elit Duis aliquet Praesent tortor vel Praesen Venenatis Praesen elit Duis aliquet',
        'excerpt' => 'Nullam quaatinterdum et nisi etiam quisvel Elit Duis Praesen...',
        'image' => 'Mask group (15)-min.png'
    )
);

echo "<h2>Creating Blog Posts for Green Burials Theme</h2>\n";

$theme_dir = get_template_directory();
$upload_dir = wp_upload_dir();

foreach ($blog_posts as $index => $post_data) {
    // Check if post already exists
    $existing_post = get_page_by_title($post_data['title'], OBJECT, 'post');
    
    if ($existing_post) {
        echo "<p>Post already exists: " . esc_html($post_data['title']) . "</p>\n";
        continue;
    }
    
    // Create post
    $post_id = wp_insert_post(array(
        'post_title'    => $post_data['title'],
        'post_content'  => $post_data['content'],
        'post_excerpt'  => $post_data['excerpt'],
        'post_status'   => 'publish',
        'post_type'     => 'post',
        'post_author'   => 1,
        'post_date'     => date('Y-m-d H:i:s', strtotime('-' . ($index * 2) . ' days'))
    ));
    
    if (is_wp_error($post_id)) {
        echo "<p style='color:red;'>Error creating post: " . esc_html($post_data['title']) . "</p>\n";
        continue;
    }
    
    // Handle featured image
    $image_path = $theme_dir . '/assets/blog-images/' . $post_data['image'];
    
    if (file_exists($image_path)) {
        // Include required files for media handling
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        // Copy file to uploads directory
        $filename = basename($image_path);
        $upload_file = wp_upload_bits($filename, null, file_get_contents($image_path));
        
        if (!$upload_file['error']) {
            $wp_filetype = wp_check_filetype($filename, null);
            
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title'     => sanitize_file_name($filename),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );
            
            $attach_id = wp_insert_attachment($attachment, $upload_file['file'], $post_id);
            
            if (!is_wp_error($attach_id)) {
                $attach_data = wp_generate_attachment_metadata($attach_id, $upload_file['file']);
                wp_update_attachment_metadata($attach_id, $attach_data);
                set_post_thumbnail($post_id, $attach_id);
                
                echo "<p style='color:green;'>✓ Created post with image: " . esc_html($post_data['title']) . "</p>\n";
            } else {
                echo "<p style='color:orange;'>⚠ Created post but couldn't attach image: " . esc_html($post_data['title']) . "</p>\n";
            }
        } else {
            echo "<p style='color:orange;'>⚠ Created post but couldn't upload image: " . esc_html($post_data['title']) . "</p>\n";
        }
    } else {
        echo "<p style='color:orange;'>⚠ Created post but image not found: " . esc_html($post_data['title']) . " (looked for: " . esc_html($image_path) . ")</p>\n";
    }
}

echo "<h3 style='color:green;'>✓ Blog post creation complete!</h3>\n";
echo "<p><a href='" . home_url('/blog') . "'>View Blog Page</a></p>\n";
echo "<p><strong>Note:</strong> If the blog page still shows 404, please flush permalinks by visiting: <a href='" . admin_url('options-permalink.php') . "'>Settings → Permalinks</a> and clicking 'Save Changes'.</p>\n";
?>
