<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php wp_head(); ?>
    <style id="atg-manual-overrides">
        @font-face {
            font-family: 'Times New Roman Custom';
            src: url('<?php echo get_template_directory_uri(); ?>/assets/times.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Times New Roman Custom';
            src: url('<?php echo get_template_directory_uri(); ?>/assets/Times New Roman - Bold.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
            font-display: swap;
        }

        /* Generic Header/Footer/Body Title Overrides */
        h1, h2, h3, h4, h5, h6,
        h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
        .category-product-title,
        .latest-product-title,
        .bestseller-title,
        .product-title,
        .best-sellers-title,
        .gb-title,
        .section-title,
        .page-title,
        .info-box-title,
        .banner-title-white,
        .newsletter-title-modern,
        .blog-title-modern,
        .entry-title,
        .entry-title a,
        .post-title,
        .post-title a,
        .shop-title,
        .price,
        .price .amount,
        .woocommerce-Price-amount,
        .amount,
        .button,
        .btn-hero,
        .btn-category-shop,
        .btn-bestseller-shop,
        .btn-latest-shop,
        .btn-learn-more,
        .wp-element-button,
        .main-nav-full a,
        .nav-menu-full a,
        .all-categories-trigger,
        .header-action-label,
        .header-action-link,
        .mobile-action-label,
        .mobile-action-sub,
        .action-text span {
            font-family: 'Times New Roman Custom', 'Times New Roman', Times, serif !important;
            font-weight: bold !important;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        /* Specifically target Home Page sections to ensure they win */
        .hero-section-figma h1,
        .info-boxes .info-box-title,
        .green-burials-section .gb-title,
        .top-categories-section .section-title,
        .top-categories-section .category-product-title,
        .best-sellers-section .best-sellers-title,
        .best-sellers-section .category-product-title,
        .latest-products-section .section-title,
        .latest-products-section .category-product-title,
        .latest-blog-section .section-title-dark,
        .latest-blog-section .blog-title-modern,
        .newsletter-section-modern .newsletter-title-modern {
            font-family: 'Times New Roman Custom', 'Times New Roman', Times, serif !important;
            font-weight: bold !important;
        }
    </style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Desktop Header Only -->
<div class="desktop-header-only">
    <!-- Top Info Bar -->
    <div class="top-info-bar">
        <div class="container">
            <div class="top-info-inner">
                <div class="shipping-notice">
                    Please Contact Us For International Shipping
                </div>
                <div class="header-top-row-flex">
                    <div class="header-contact-info">
                        <a href="mailto:Admin@greenburials.com" class="header-contact-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg> Admin@greenburials.com
                        </a>
                        <a href="tel:1.866.946.0030" class="header-contact-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg> 1.866.946.0030
                        </a>
                    </div>
                    <div class="social-icons-header">
                        <a href="#" aria-label="Facebook"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
                        <a href="#" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" width="16" height="16" class="icon-instagram">
                            <rect x="2" y="2" width="20" height="20" rx="5"
                                  stroke="currentColor" stroke-width="2" fill="none"/>
                            <circle cx="12" cy="12" r="4"
                                    stroke="currentColor" stroke-width="2" fill="none"/>
                            <circle cx="17.5" cy="6.5" r="1.2"
                                    fill="currentColor"/>
                        </svg>
                        </a>
                        <a href="#" aria-label="Twitter"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
  <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"></path>
</svg></a>
                        <a href="#" aria-label="YouTube"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.33 29 29 0 0 0-.46-5.33zM9.75 15.02V8.83l6.25 3.09z"></path></svg></a>
                        <a href="#" aria-label="Pinterest"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/></svg></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header (Full) -->
    <div class="main-header-full">
        <div class="container">
            <div class="main-header-inner">
                <div class="site-branding-full">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link-full">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/logo.png" alt="Green Burials" class="site-logo-full">
                    </a>
                </div>
                
                <div class="header-search">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="search" name="s" placeholder="Search" class="search-input">
                        <input type="hidden" name="post_type" value="product" />
                        <button type="submit" class="search-button">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </button>
                    </form>
                </div>
                
                <div class="header-actions">
                    <div class="header-account-dropdown">
                        <?php if (is_user_logged_in()) : ?>
                            <a href="<?php echo class_exists('WooCommerce') ? esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) : '#'; ?>" class="header-account">
                                <div class="icon-circle">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </div>
                                <div class="action-text">
                                    <span class="header-action-label">My Account</span>
                                    <span class="header-action-link">Dashboard</span>
                                </div>
                            </a>
                            <div class="account-dropdown-menu">
                                <a href="<?php echo class_exists('WooCommerce') ? esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) : '#'; ?>" class="dropdown-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    My Account
                                </a>
                                <a href="<?php echo home_url('/wishlist'); ?>" class="dropdown-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                    Wishlist
                                </a>
                                <a href="<?php echo wp_logout_url(home_url()); ?>" class="dropdown-item logout-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    Logout
                                </a>
                            </div>
                        <?php else : ?>
                            <a href="<?php echo class_exists('WooCommerce') ? esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) : '#'; ?>" class="header-account">
                                <div class="icon-circle">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </div>
                                <div class="action-text">
                                    <span class="header-action-label">My Account</span>
                                    <span class="header-action-link">Login</span>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php echo green_burials_render_header_cart(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar (Full) -->
    <div class="nav-bar-wrapper">
        <div class="nav-bar-full">
            <div class="container">
                <div class="nav-bar-inner">
                    <div class="all-categories-container" id="allCategoriesTrigger">
                        <div class="all-categories-trigger">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h4v4H4zm6 0h4v4h-4zm6 0h4v4h-4zM4 10h4v4H4zm6 0h4v4h-4zm6 0h4v4h-4zM4 16h4v4H4zm6 0h4v4h-4zm6 0h4v4h-4z"/></svg> All Categories
                        </div>
                        <div class="all-categories-dropdown mega-menu-container" id="allCategoriesDropdown">
                            <div class="mega-menu-inner">
                                <!-- Sidebar -->
                                <div class="mega-menu-sidebar">
                                    <ul class="mega-menu-categories">
                                        <?php
                                        $navbar_categories = get_terms( array(
                                            'taxonomy'     => 'product_cat',
                                            'orderby'      => 'meta_value_num',
                                            'meta_key'     => 'order',
                                            'order'        => 'ASC',
                                            'hierarchical' => true,
                                            'hide_empty'   => false,
                                            'parent'       => 0,
                                            'exclude'      => get_option( 'default_category', 1 ), // Exclude Uncategorized
                                        ) );
                                        // Fallback: sort by name if meta ordering not supported
                                        if ( is_wp_error( $navbar_categories ) || empty( $navbar_categories ) ) {
                                            $navbar_categories = get_terms( array(
                                                'taxonomy'   => 'product_cat',
                                                'orderby'    => 'name',
                                                'order'      => 'ASC',
                                                'hide_empty' => false,
                                                'parent'     => 0,
                                                'exclude'    => get_option( 'default_category', 1 ),
                                            ) );
                                        }

                                        if ( ! is_wp_error( $navbar_categories ) && ! empty( $navbar_categories ) ) {
                                            foreach ( $navbar_categories as $index => $nav_cat ) {
                                                $active_class = ($index === 0) ? 'active' : '';
                                                echo '<li class="mega-cat-item ' . $active_class . '" data-category-id="' . $nav_cat->term_id . '">';
                                                echo '<a href="' . esc_url( get_term_link( $nav_cat ) ) . '">' . esc_html( $nav_cat->name ) . '</a>';
                                                echo '<span class="mega-arrow"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg></span>';
                                                echo '</li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>

                                <!-- Content Area -->
                                <div class="mega-menu-content-wrapper">
                                    <?php
                                    if ( ! is_wp_error( $navbar_categories ) && ! empty( $navbar_categories ) ) {
                                        foreach ( $navbar_categories as $index => $nav_cat ) {
                                            $display_style = ($index === 0) ? 'display: flex;' : 'display: none;';
                                            ?>
                                            <div class="mega-menu-content" id="mega-content-<?php echo $nav_cat->term_id; ?>" style="<?php echo $display_style; ?>">
                                                <div class="mega-category-header">
                                                    <h3 class="mega-category-title"><?php echo esc_html( $nav_cat->name ); ?></h3>
                                                </div>
                                                <div class="mega-menu-main-content">
                                                    <div class="mega-content-left">
                                                        <ul class="mega-subcategories">
                                                            <?php
                                                            $sub_categories = get_terms( array(
                                                                'taxonomy'   => 'product_cat',
                                                                'parent'     => $nav_cat->term_id,
                                                                'orderby'    => 'meta_value_num',
                                                                'meta_key'   => 'order',
                                                                'order'      => 'ASC',
                                                                'hide_empty' => false,
                                                            ) );
                                                            if ( ! is_wp_error( $sub_categories ) && ! empty( $sub_categories ) ) {
                                                                foreach ( $sub_categories as $sub_cat ) {
                                                                    echo '<li><a href="' . esc_url( get_term_link( $sub_cat ) ) . '">' . esc_html( $sub_cat->name ) . '</a></li>';
                                                                }
                                                            } else {
                                                                echo '<li><a href="' . esc_url( get_term_link( $nav_cat ) ) . '">View All ' . esc_html( $nav_cat->name ) . '</a></li>';
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                    <div class="mega-content-right">
                                                        <div class="mega-featured-products">
                                                            <?php
                                                            $featured_products = new WP_Query( array(
                                                                'post_type'      => 'product',
                                                                'posts_per_page' => 2,
                                                                'tax_query'      => array(
                                                                    array(
                                                                        'taxonomy' => 'product_cat',
                                                                        'field'    => 'term_id',
                                                                        'terms'    => $nav_cat->term_id,
                                                                    ),
                                                                ),
                                                            ) );

                                                            if ( $featured_products->have_posts() ) :
                                                                while ( $featured_products->have_posts() ) : $featured_products->the_post();
                                                                    global $product;
                                                                    ?>
                                                                    <div class="mega-product-card">
                                                                        <a href="<?php the_permalink(); ?>">
                                                                            <div class="mega-product-image">
                                                                                <?php
                                                                                if ( has_post_thumbnail() ) {
                                                                                    the_post_thumbnail( 'woocommerce_thumbnail' );
                                                                                } else {
                                                                                    echo '<img src="' . wc_placeholder_img_src() . '" alt="Placeholder">';
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                            <h4 class="mega-product-title"><?php the_title(); ?></h4>
                                                                        </a>
                                                                    </div>
                                                                    <?php
                                                                endwhile;
                                                                wp_reset_postdata();
                                                            endif;
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <nav class="main-nav-full">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'main-nav-full',
                            'menu_class'     => 'nav-menu-full',
                            'container'      => false,
                            'fallback_cb'    => 'green_burials_full_menu',
                        ));
                        ?>
                    </nav>
                    
                    <div class="nav-right-group">
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-contact">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Header Custom -->
<div class="mobile-header-custom">
    <!-- Top Green Bar - Simple Notice Only -->
    <div class="mobile-top-bar">
        <div class="container">
            <div class="mobile-notice">Please Contact Us For International Shipping</div>
        </div>
    </div>

    <!-- Mobile Main Header - New Layout -->
    <div class="mobile-main-header">
        <div class="container">
            <div class="mobile-header-new-layout">
                <!-- Left Group: Hamburger + Search -->
                <div class="mobile-left-side">
                    <button class="mobile-hamburger-btn" id="mobileHamburgerBtn" aria-label="Open Menu">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <button class="mobile-search-icon-btn" id="mobileSearchBtn" aria-label="Search">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </div>

                <!-- Center: Logo -->
                <div class="mobile-logo-centered">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/logo.png" alt="Green Burials">
                    </a>
                </div>

                <!-- Right: Account + Cart Icons -->
                <div class="mobile-right-icons">
                    <a href="<?php echo is_user_logged_in() ? (class_exists('WooCommerce') ? esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) : '#') : (class_exists('WooCommerce') ? esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) : '#'); ?>" class="mobile-icon-btn" aria-label="Account">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </a>
                    <a href="<?php echo function_exists('wc_get_cart_url') ? esc_url(wc_get_cart_url()) : '#'; ?>" class="mobile-icon-btn mobile-cart-btn" aria-label="Cart">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <?php if (function_exists('WC') && WC()->cart) : ?>
                            <span class="mobile-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Search Overlay (slides from top) -->
<div class="mobile-search-overlay" id="mobileSearchOverlay">
    <div class="mobile-search-overlay-content">
        <button class="mobile-search-close" id="mobileSearchClose" aria-label="Close Search">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="mobile-search-overlay-form">
            <input type="search" name="s" placeholder="Search" class="mobile-search-overlay-input" autofocus>
            <input type="hidden" name="post_type" value="product" />
            <button type="submit" class="mobile-search-overlay-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </form>
    </div>
</div>

<!-- Mobile Side Navigation (slides from left) -->
<div class="mobile-side-nav" id="mobileSideNav">
    <div class="mobile-side-nav-header">
        <h3>Menu</h3>
        <button class="mobile-side-nav-close" id="mobileSideNavClose" aria-label="Close Menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    <div class="mobile-side-nav-content">
        <!-- Categories Section -->
        <div class="mobile-side-nav-section">
            <button class="mobile-side-nav-trigger" id="mobileCategoriesTrigger">
                <span>Shop Categories</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="mobile-side-nav-panel" id="mobileCategoriesPanel">
                <div class="mobile-accordion">
                    <?php
                    $mobile_categories = get_terms( array(
                        'taxonomy'   => 'product_cat',
                        'orderby'    => 'term_order',
                        'order'      => 'ASC',
                        'parent'     => 0,
                        'hide_empty' => false,
                        'exclude'    => get_option( 'default_category', 1 ),
                    ) );
                    // Fallback: sort by name if term_order not supported
                    if ( is_wp_error( $mobile_categories ) || empty( $mobile_categories ) ) {
                        $mobile_categories = get_terms( array(
                            'taxonomy'   => 'product_cat',
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                            'parent'     => 0,
                            'hide_empty' => false,
                            'exclude'    => get_option( 'default_category', 1 ),
                        ) );
                    }
                    
                    if ( ! is_wp_error( $mobile_categories ) && ! empty( $mobile_categories ) ) {
                        foreach ( $mobile_categories as $cat ) {
                            ?>
                            <div class="mobile-accordion-item">
                                <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="mobile-category-link">
                                    <span class="cat-name"><?php echo esc_html($cat->name); ?></span>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </a>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="mobile-side-nav-links">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'main-nav-full',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'fallback_cb'    => 'green_burials_mobile_menu',
            ));
            ?>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="highlight-link">Contact Us</a>
        </nav>
    </div>
</div>



<?php
// Fallback menu for full navigation
function green_burials_full_menu() {
    echo '<ul class="nav-menu-full">';
    echo '<li><a href="' . esc_url(home_url('/about')) . '">About Green Burials</a></li>';
    echo '<li><a href="' . esc_url(home_url('/how-to')) . '">How To Size An Urn</a></li>';
    echo '<li><a href="' . esc_url(home_url('/military')) . '">Military Discounts Available</a></li>';
    echo '<li><a href="' . esc_url(home_url('/blog')) . '">Blog</a></li>';
    echo '</ul>';
}
?>

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

// Mobile menu fallback
function green_burials_mobile_menu() {
    echo '<ul class="mobile-nav-list">';
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
