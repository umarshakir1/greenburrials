<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="header-inner">
            <div class="site-branding">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/logo.png" alt="Green Burials" class="site-logo-img" width="50" height="50">
                    <span class="site-title">Green Burials</span>
                </a>
            </div>
            
            <nav class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'nav-menu',
                    'container' => false,
                    'fallback_cb' => 'green_burials_default_menu',
                ));
                ?>
            </nav>
            
            <div class="header-icons">
                <?php if (class_exists('WooCommerce') && function_exists('wc_get_cart_url')): ?>
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-icon" aria-label="Cart">
                    <svg class="header-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                    <?php if (function_exists('WC') && WC()->cart): ?>
                        <?php $cart_count = WC()->cart->get_cart_contents_count(); ?>
                        <?php if ($cart_count > 0): ?>
                            <span class="cart-count"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </a>
                <?php if (function_exists('wc_get_account_page_url')): ?>
                <a href="<?php echo esc_url(wc_get_account_page_url()); ?>" class="account-icon" aria-label="Account">
                    <svg class="header-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </a>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<?php
// Default menu fallback
function green_burials_default_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about')) . '">About</a></li>';
    echo '<li><a href="' . esc_url(home_url('/how-to')) . '">How To</a></li>';
    echo '<li><a href="' . esc_url(home_url('/as-seen-in')) . '">As Seen In</a></li>';
    echo '<li><a href="' . esc_url(home_url('/military')) . '">Military</a></li>';
    echo '<li><a href="' . esc_url(home_url('/blog')) . '">Blog</a></li>';
    if (class_exists('WooCommerce')) {
        echo '<li><a href="' . esc_url(wc_get_page_permalink('shop')) . '">Shop</a></li>';
    }
    echo '</ul>';
}
?>

<main id="main-content" class="site-main">
