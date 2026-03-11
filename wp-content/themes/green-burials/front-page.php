<?php
/**
 * Template Name: Homepage
 * The homepage template for Green Burials theme
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero-section-figma lazy-load">
    <div class="hero-overlay">
        <div class="container">
            <div class="hero-content-figma">
                <div class="hero-text-left">
                    <h1>GREEN BURIALS</h1>
                    <p class="hero-subtitle">Biodegradable Urns, Caskets, Coffins And Burial Shrouds</p>
                    <p class="hero-description">GreenBurials.com Is The Hub Of All Natural And Biodegradable Urns, Caskets, Coffins And Burial Shrouds. As A Seller Of Green And Natural Burial Cremation Urns That Adhere To The Green Burial Council Standards And Best Practice Methods.</p>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-hero">Shop Now</a>
                </div>
                <div class="hero-products-right">
                    <!-- Single Product Image -->
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/img-1-1.webp" alt="Biodegradable Urn" class="hero-product-single">
                </div>
            </div>
        </div>
    </div>
</section>                                                                                                                  

<!-- Info Boxes -->
<section class="info-boxes lazy-load">
    <div class="container">
        <div class="info-boxes-grid">
            <div class="info-box-card">
                <div class="info-box-icon-circle green">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group.png" alt="Contact Us">
                </div>
                <h3 class="info-box-title">CONTACT US 24/7</h3>
                <p class="info-box-text">= Toll Free: 1.815.814.0590</p>
                <p class="info-box-subtext">Best Price Guarantee ~ 30 Day Money Back Guarantee.</p>
            </div>
            
            <div class="info-box-card">
                <div class="info-box-icon-circle gold">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group(1).png" alt="Free Shipping">
                </div>
                <h3 class="info-box-title">FREE GROUND SHIPPING</h3>
                <p class="info-box-text">Within The Contiguous U.S. = Shipments Usually</p>
                <p class="info-box-subtext">Processed Within 48 Hours Of Purchase.</p>
            </div>
            
            <div class="info-box-card">
                <div class="info-box-icon-circle green">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group(2).png" alt="Flat Rate">
                </div>
                <h3 class="info-box-title">FLAT-RATE FOR 2ND DAY ($35)</h3>
                <p class="info-box-text">Standard Overnight Delivering ($80)</p>
                <p class="info-box-subtext">(Caskets, Shipping Not Supported Rates</p>
                <p class="info-box-subtext">Additional)</p>
                <p class="info-box-subtext">Please Call For All International Shipments</p>
            </div>
        </div>
    </div>
</section>

<!-- Green Burials Section -->
<section class="green-burials-section lazy-load">
    <div class="container">
        <div class="green-burials-grid">
            <!-- Left Image -->
            <div class="gb-image-left">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask-group-1.webp" alt="Eco-friendly wicker casket with flowers">
            </div>
            
            <!-- Center Text Content -->
            <div class="gb-text-center">
                <div class="section-decoration">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group (2).png" alt="Decoration">
                </div>
                <h2 class="gb-title">Green Burials</h2>
                <p class="gb-subtitle">Biodegradable Urn, Casket, Coffins And Burial Shroud</p>
                
                <p class="gb-description">GreenBurials.com Is The Hub Of All Natural And Biodegradable Urns, Caskets, Coffins And Burial Shrouds. As A Seller Of Green And Natural Burial Cremation Urns That Adhere To The Green Burial Council Standards And Best Practice Methods. We Offer The Best, Most Sustainable Solutions To Those Seeking Eco-Friendly Funeral Options, Including Scattering Solutions, Biodegradable Urns, Eco-Friendly Caskets, And Dignified Cremation Containers. We Also Have Collection Of Other Biodegradable Cremation or Memorial Products Include Jewelry, Eco-Friendly Stationary, And Pet-Specific Urns.</p>
                
                <p class="gb-description">All Cremation Urns Come With The Added Distinction Of Being Airport Security X-Ray Approved To Pass Through In Carry-On Luggage.</p>
                
        
                
                <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn-learn-more">Learn More</a>
            </div>
            
            <!-- Right Image -->
            <div class="gb-image-right">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask-group-3.webp" alt="Natural burial flowers in garden">
            </div>
        </div>
    </div>
</section>

<!-- Top Categories Section -->
<section class="top-categories-section lazy-load">
    <div class="container">
        <!-- Decorative image above title -->
        <div class="section-decoration">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group (2).png" alt="Decoration">
        </div>
        
        <h2 class="section-title">Top Categories</h2>
        
        <!-- Category Filter Tabs -->
        <div class="category-filters" id="categoryFilters">
            <button class="mobile-filter-toggle" id="mobileFilterToggle" aria-label="Toggle Categories">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="color: #6B7A4D;"><path d="M4 4h4v4H4zm6 0h4v4h-4zm6 0h4v4h-4zM4 10h4v4H4zm6 0h4v4h-4zm6 0h4v4h-4zM4 16h4v4H4zm6 0h4v4h-4zm6 0h4v4h-4z"/></svg>
            </button>
            <?php
            // Dynamically generate filter buttons based on available categories
            $filter_categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'parent'     => 0,
                'orderby'    => 'term_order',
                'order'      => 'ASC',
                'exclude'    => get_option( 'default_category', 1 ),
            ));
            // Fallback: sort by name if term_order returns empty
            if ( is_wp_error( $filter_categories ) || empty( $filter_categories ) ) {
                $filter_categories = get_terms(array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                    'parent'     => 0,
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                    'exclude'    => get_option( 'default_category', 1 ),
                ));
            }
            
            if (!is_wp_error($filter_categories) && !empty($filter_categories)) {
                $is_first = true;
                foreach ($filter_categories as $filter_cat) {
                    if ($filter_cat->count > 0) {
                        $active_class = $is_first ? ' active' : '';
                        $display_name = $filter_cat->name;
                        
                        // Truncate long names for mobile display
                        if (strlen($display_name) > 25) {
                            $display_name_short = substr($display_name, 0, 22) . '..';
                        } else {
                            $display_name_short = $display_name;
                        }
                        
                        echo '<button class="filter-btn' . $active_class . '" data-category="' . esc_attr($filter_cat->slug) . '">';
                        echo esc_html($display_name);
                        echo '</button>';
                        
                        $is_first = false;
                    }
                }
            }
            ?>
        </div>
        
        <!-- Products Grid -->
        <div class="top-categories-grid" id="categoryProductsGrid">
            <?php
            // Dynamically get all product categories for filtering
            // This ensures compatibility between localhost and live environments
            $all_categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'parent'     => 0, // Only top-level categories
                'orderby'    => 'term_order',
                'order'      => 'ASC',
                'exclude'    => get_option( 'default_category', 1 ),
            ));
            // Fallback: sort by name if term_order returns empty
            if ( is_wp_error( $all_categories ) || empty( $all_categories ) ) {
                $all_categories = get_terms(array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                    'parent'     => 0,
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                    'exclude'    => get_option( 'default_category', 1 ),
                ));
            }
            
            // Fallback to hardcoded mappings if needed (for specific ordering/naming)
            $preferred_categories = array(
                'biodegradable-caskets',
                'water-cremation-urns',
                'earth-burial-urns',
                'biodegradable-pet-urns',
                'seed-paper-mementos',
                'eco-stationery',
                'keepsakes',
                'shrouds-and-carriers',
                'scattering-tubes-urns',
                'water-burials',
                'memorial-petals',
                'memorial-products',
                'burial-shrouds',
                'caskets',
                'biodegradable'
            );
            
            // Build category mappings dynamically
            $category_mappings = array();
            
            if (!is_wp_error($all_categories) && !empty($all_categories)) {
                foreach ($all_categories as $category) {
                    if ($category->count > 0) { // Only include categories with products
                        $category_mappings[$category->slug] = array($category->name, $category->slug);
                    }
                }
            }
            
            // If no categories found, use a safe fallback
            if (empty($category_mappings)) {
                $category_mappings = array(
                    'uncategorized' => array('All Products', 'uncategorized')
                );
            }
            
            $first_category = true;
            
            // Loop through each category and get products
            foreach ($category_mappings as $cat_key => $cat_data) :
                
                list($cat_name, $cat_slug) = $cat_data;
                
                // Try to get products from this category
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 4,
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => $cat_slug,
                        ),
                    ),
                );
                
                $category_products = new WP_Query($args);
                
                // If category has no products, try with the key as slug
                if (!$category_products->have_posts()) {
                    $args['tax_query'][0]['terms'] = $cat_key;
                    $category_products = new WP_Query($args);
                }
                
                // If still no products found for this category, skip it entirely
                if (!$category_products->have_posts()) {
                    wp_reset_postdata();
                    $first_category = false;
                    continue;
                }
                
                // Display products
                if ($category_products->have_posts()) :
                    while ($category_products->have_posts()) : $category_products->the_post();
                        global $product;
                        $is_visible = $first_category ? '' : 'display:none;';
                        ?>
                        <div class="category-product-card" data-category="<?php echo esc_attr($cat_key); ?>" style="<?php echo $is_visible; ?>">
                            <a href="<?php the_permalink(); ?>" class="card-link-overlay" aria-label="View <?php the_title_attribute(); ?>"></a>
                            <div class="category-product-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php 
                                    $image_id = get_post_thumbnail_id();
                                    $image_url = wp_get_attachment_image_url($image_id, 'product-thumb');
                                    ?>
                                    <img src="<?php echo esc_url($image_url); ?>" 
                                         alt="<?php the_title_attribute(); ?>" 
                                         loading="lazy">
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.svg" alt="<?php the_title(); ?>" loading="lazy">
                                <?php endif; ?>
                            </div>
                            <div class="category-product-info">
                                <h3 class="category-product-title"><?php the_title(); ?></h3>
                                <div class="category-product-price-rating">
                                    <div class="category-product-price">
                                        <?php echo $product->get_price_html(); ?>
                                    </div>
                                    <div class="category-product-rating">
                                        <?php 
                                        $rating_count = $product->get_rating_count();
                                        $average = $product->get_average_rating();
                                        echo wc_get_rating_html($average, $rating_count);
                                        ?>
                                    </div>
                                </div>
                                <div class="category-product-actions">
                                    <a href="<?php the_permalink(); ?>" class="btn-category-shop">Shop Now</a>
                                    <?php
                                    $gb_has_epo = gb_product_has_required_epo_options( $product->get_id() );
                                    if ( $gb_has_epo ) : ?>
                                        <a href="<?php the_permalink(); ?>"
                                           class="btn-category-add-to-cart add_to_cart_button product_type_<?php echo esc_attr( $product->get_type() ); ?> gb-epo-redirect"
                                           data-product_id="<?php echo $product->get_id(); ?>"
                                           data-product-permalink="<?php the_permalink(); ?>"
                                           data-has-required-options="1"
                                           aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
                                           rel="nofollow"
                                        ><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
                                           class="btn-category-add-to-cart add_to_cart_button product_type_<?php echo esc_attr( $product->get_type() ); ?> ajax_add_to_cart"
                                           data-product_id="<?php echo $product->get_id(); ?>"
                                           data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
                                           data-quantity="1"
                                           data-has-required-options="0"
                                           aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
                                           rel="nofollow"
                                        ><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                
                $first_category = false;
            endforeach;
            ?>
        </div>
    </div>
</section>

<!-- Banner Section -->
<section class="banner-section">
    <div class="container">
        <h2>We Have The Pleasure Of Servicing Numerous Families And Commercial Enterprise, Repeat Customers.</h2>
    </div>
</section>

<!-- Best Sellers Section -->
<section class="best-sellers-section lazy-load">
    <div class="container">
        <div class="best-sellers-header">
            <div class="section-title-wrapper">
                <div class="section-decoration">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask-group-4.png" alt="Decoration">
                </div>
                <h2 class="best-sellers-title">Best Sellers</h2>
            </div>
            <div class="carousel-nav-buttons">
                <button class="carousel-nav-btn carousel-prev" id="bestSellersPrev">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 18L9 12L15 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="carousel-nav-btn carousel-next" id="bestSellersNext">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="carousel-wrapper">
            <div class="best-sellers-carousel" id="bestSellersCarousel">
                <?php
                $best_sellers = green_burials_get_best_sellers(8); // Get 8 products for carousel
                if ($best_sellers->have_posts()) :
                    while ($best_sellers->have_posts()) : $best_sellers->the_post();
                        global $product;
                        ?>
                        <div class="category-product-card bestseller-card">
                            <a href="<?php the_permalink(); ?>" class="card-link-overlay" aria-label="View <?php the_title_attribute(); ?>"></a>
                            <div class="category-product-image">
                                <?php if ($product->is_on_sale()) : ?>
                                    <span class="sale-badge">Sale</span>
                                <?php endif; ?>
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php 
                                    $image_id = get_post_thumbnail_id();
                                    $image_url = wp_get_attachment_image_url($image_id, 'product-thumb');
                                    ?>
                                    <img src="<?php echo esc_url($image_url); ?>" 
                                         alt="<?php the_title_attribute(); ?>" 
                                         loading="lazy">
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.svg" alt="<?php the_title(); ?>" loading="lazy">
                                <?php endif; ?>
                            </div>
                            <div class="category-product-info">
                                <h3 class="category-product-title"><?php the_title(); ?></h3>
                                <div class="category-product-price-rating">
                                    <div class="category-product-price">
                                        <?php echo $product->get_price_html(); ?>
                                    </div>
                                    <div class="category-product-rating">
                                        <?php
                                        $rating_count = $product->get_rating_count();
                                        $average = $product->get_average_rating();
                                        echo wc_get_rating_html($average, $rating_count);
                                        ?>
                                    </div>
                                </div>
                                <div class="category-product-actions">
                                    <a href="<?php the_permalink(); ?>" class="btn-bestseller-shop">Shop Now</a>
                                    <?php
                                    $gb_has_epo = gb_product_has_required_epo_options( $product->get_id() );
                                    if ( $gb_has_epo ) : ?>
                                        <a href="<?php the_permalink(); ?>"
                                           class="btn-category-add-to-cart add_to_cart_button product_type_<?php echo esc_attr( $product->get_type() ); ?> gb-epo-redirect"
                                           data-product_id="<?php echo $product->get_id(); ?>"
                                           data-product-permalink="<?php the_permalink(); ?>"
                                           data-has-required-options="1"
                                           aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
                                           rel="nofollow"
                                        ><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
                                           class="btn-category-add-to-cart add_to_cart_button product_type_<?php echo esc_attr( $product->get_type() ); ?> ajax_add_to_cart"
                                           data-product_id="<?php echo $product->get_id(); ?>"
                                           data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
                                           data-quantity="1"
                                           data-has-required-options="0"
                                           aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
                                           rel="nofollow"
                                        ><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Dual Banners -->
<section class="dual-banners-section">
    <div class="container">
        <div class="dual-banners-grid">
            <!-- Banner 1: Bougainvillea Memorial Petals -->
            <div class="banner-card-modern">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/f6eaf8bc50c689cdf7e331afc7e784a3ede44a8b.png" alt="Bougainvillea Memorial Petals" loading="lazy">
                <div class="banner-content-overlay">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group (1).png" alt="Lotus Icon" class="lotus-icon-img">
                    <h3 class="banner-title-white">Bougainvillea<br>Memorial Petals</h3>
                </div>
            </div>
            
            <!-- Banner 2: Water Burials With Petals -->
            <div class="banner-card-modern">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/img-1-2.webp" alt="Water Burials With Petals" loading="lazy">
                <div class="banner-content-overlay">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group (1).png" alt="Lotus Icon" class="lotus-icon-img">
                    <h3 class="banner-title-white">Water Burials<br>With Petals</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Products Section -->
<section class="latest-products-section lazy-load">
    <div class="container">
        <div class="section-decoration">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group (2).png" alt="Decoration">
        </div>
        <h2 class="section-title">Latest Products</h2>
        
        <div class="latest-carousel-wrapper">
            <div class="latest-products-track" id="latestProductsTrack">
                <?php
                $latest_products = green_burials_get_latest_products(8);
                if ($latest_products->have_posts()) :
                    while ($latest_products->have_posts()) : $latest_products->the_post();
                        global $product;
                        ?>
                        <div class="category-product-card latest-product-card">
                            <a href="<?php the_permalink(); ?>" class="card-link-overlay" aria-label="View <?php the_title_attribute(); ?>"></a>
                            <div class="category-product-image">
                                <?php if ($product->is_on_sale()) : ?>
                                    <span class="sale-badge">Sale</span>
                                <?php endif; ?>
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('woocommerce_thumbnail'); ?>
                                <?php else : ?>
                                    <img src="<?php echo wc_placeholder_img_src(); ?>" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="category-product-info">
                                <h3 class="category-product-title"><?php the_title(); ?></h3>
                                <div class="category-product-price-rating">
                                    <div class="category-product-price"><?php echo $product->get_price_html(); ?></div>
                                    <div class="category-product-rating">
                                        <?php 
                                        $rating_count = $product->get_rating_count();
                                        $average = $product->get_average_rating();
                                        echo wc_get_rating_html($average, $rating_count);
                                        ?>
                                    </div>
                                </div>
                                <div class="category-product-actions">
                                    <a href="<?php the_permalink(); ?>" class="btn-latest-shop">Shop Now</a>
                                    <?php
                                    $gb_has_epo = gb_product_has_required_epo_options( $product->get_id() );
                                    if ( $gb_has_epo ) : ?>
                                        <a href="<?php the_permalink(); ?>"
                                           class="btn-category-add-to-cart add_to_cart_button product_type_<?php echo esc_attr( $product->get_type() ); ?> gb-epo-redirect"
                                           data-product_id="<?php echo $product->get_id(); ?>"
                                           data-product-permalink="<?php the_permalink(); ?>"
                                           data-has-required-options="1"
                                           aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
                                           rel="nofollow"
                                        ><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
                                           class="btn-category-add-to-cart add_to_cart_button product_type_<?php echo esc_attr( $product->get_type() ); ?> ajax_add_to_cart"
                                           data-product_id="<?php echo $product->get_id(); ?>"
                                           data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
                                           data-quantity="1"
                                           data-has-required-options="0"
                                           aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
                                           rel="nofollow"
                                        ><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
        
        <div class="latest-nav-buttons">
            <button class="latest-nav-btn latest-prev" id="latestPrev">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="#555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button class="latest-nav-btn latest-next" id="latestNext">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18L15 12L9 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<!-- Reviews Section -->
<section class="reviews-section-slider lazy-load">
    <div class="container">
        <div class="reviews-header">
            <div class="section-decoration-white">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group (2).png" alt="Decoration" style="filter: brightness(0) invert(1);">
            </div>
            <h2 class="section-title-white">Reviews</h2>
        </div>

        <div class="reviews-slider-container">


            <div class="reviews-track-wrapper">
                <div class="reviews-track" id="reviewsTrack">
                    <!-- Review 1 -->
                    <div class="review-slide">
                        <div class="review-card-modern">
                            <div class="review-header-row">
                                <div class="review-quote-icon">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path>
                                    </svg>
                                </div>
                                <div class="review-date-modern">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    February 1, 2019
                                </div>
                            </div>
                            <div class="review-content-modern">
                                <p>If You Have A Family Member Or Friend That Has Expressed Interest In An Environmentally Friendly Funeral, And Requires A Fully Certified, Bio-Degradable Casket, I Urge You To Contact Darius At GreenBurials.Com. After A Close Family Member Recently Passed Away, We Were Told By The Funeral Home That It Would Take 4 Or More Days To Obtain A Bio-Degradable Bamboo Casket. Later That Evening, I Searched The Internet To See If There Were Other Options For A Quicker Delivery. I Truly Believe That God Directed Me To GreenBurials.Com And To Darius. Believe Me When I Tell You That Darius Is An Angel From Heaven. He Is Caring, Compassionate, And Most Of All, He Delivers Phenominal Customer Service. I First Talked To Darius The Evening My Family Member Passed Away. The Very Next Evening, He Had A Beautiful Casket Waiting At Our City's Airport.</p>
                                <p>Darius Proactively Stayed In Contact With Us Throughout The Process. He Explained The Options Available For The Casket, Took The Order Over The Phone, Communicated The Freight Location At The Local Airport, Called The Next Morning To Ensure That We Received The Casket And That Everything Was OK. I Cannot Emphasize Enough How Appreciative Our Family Is Of GreenBurials.Com And Darius' Compassionate And Efficient Attention.</p>
                            </div>
                            <div class="review-footer-modern">
                                <div class="review-stars-modern">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                </div>
                                <span class="review-author-modern">William A. Napoli</span>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>


        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="latest-blog-section lazy-load">
    <div class="container">
        <div class="blog-header">
            <div class="section-decoration-gold">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask-group-4.png" alt="Decoration">
            </div>
            <h2 class="section-title-dark">Our Latest Blogs</h2>
        </div>

        <div class="latest-blog-grid">
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC'
            );
            $blog_query = new WP_Query($args);

            if ($blog_query->have_posts()) :
                while ($blog_query->have_posts()) : $blog_query->the_post();
            ?>
                <div class="blog-card-modern">
                    <div class="blog-image-modern">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php else : ?>
                            <img src="<?php echo wc_placeholder_img_src(); ?>" alt="Placeholder">
                        <?php endif; ?>
                        <div class="blog-category-badge">Green Burials</div>
                    </div>
                    <div class="blog-content-modern">
                        <h3 class="blog-title-modern"><?php the_title(); ?></h3>
                        <div class="blog-date-modern">
                            <i class="fa fa-calendar"></i> <?php echo get_the_date('F j, Y'); ?>
                        </div>
                        <div class="blog-excerpt-modern">
                            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn-blog-learn-more">Learn More</a>
                    </div>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No blog posts found.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section-modern lazy-load" data-bg="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/newsletter-bg.webp">
    <div class="newsletter-overlay"></div>
    <div class="container relative-z">
        <div class="newsletter-grid-modern">
            <div class="newsletter-content-left">
                <div class="section-decoration-white-left">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group (2).png" alt="Decoration" style="filter: brightness(0) invert(1);">
                </div>
                <h2 class="newsletter-title-modern">Signup For Newsletter</h2>
                <form class="newsletter-form-modern">
                    <input type="email" placeholder="Your Email Address..." required>
                    <button type="submit" class="btn-subscribe-modern">Subscribe</button>
                </form>
            </div>
            <div class="newsletter-map-modern">
                <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2983.336497746534!2d-87.8546366845674!3d41.60537497924466!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880e163690666667%3A0x6666666666666666!2s14448%20Golf%20Rd%2C%20Orland%20Park%2C%20IL%2060462%2C%20USA!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
