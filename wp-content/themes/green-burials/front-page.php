<?php
/**
 * Template Name: Homepage
 * The homepage template for Green Burials theme
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1>GREEN BURIALS</h1>
                <p class="subtitle">Biodegradable Urns, Caskets, Coffins, Burial Shrouds. Private, Coffins Burial, A Seller Green and Natural.</p>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-primary">Shop Now</a>
            </div>
            <div class="hero-images">
                <!-- Overlapping images as per Figma -->
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Ellipse 1.png" alt="Biodegradable Urn" loading="eager" width="220" height="280" class="hero-img-1">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Ellipse 2.png" alt="Eco Casket" loading="eager" width="240" height="180" class="hero-img-2">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group(1).png" alt="Burial Basket" loading="eager" width="200" height="240" class="hero-img-3">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group.png" alt="Memorial Pot" loading="eager" width="180" height="180" class="hero-img-4">
            </div>
        </div>
    </div>
</section>

<!-- Info Boxes -->
<section class="info-boxes">
    <div class="container">
        <div class="info-box">
            <svg class="info-box-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
            </svg>
            <h3>Best Contact 24/7</h3>
            <p>Available anytime for support</p>
        </div>
        <div class="info-box">
            <svg class="info-box-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 18.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z"/>
            </svg>
            <h3>Free Ground Shipping</h3>
            <p>On all orders</p>
        </div>
        <div class="info-box">
            <svg class="info-box-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
            </svg>
            <h3>Flat Rate for Next Day</h3>
            <p>Express delivery available</p>
        </div>
    </div>
</section>

<!-- Green Burials Section -->
<section class="green-burials-section">
    <div class="container">
        <div class="green-burials-content">
            <div class="green-burials-images">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/image 52.png" alt="Eco-friendly casket with flowers" loading="lazy" width="500" height="300">
            </div>
            <div class="green-burials-text">
                <h2>Green Burials</h2>
                <p>Greenburials Biodegradable Urn, Casket And Coffin, Burial Shrouds And Keepsakes. All Our Products Are Certified By The Green Burial Council For Use In Natural Or Green Burial Grounds.</p>
                <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn-primary">Learn More For More</a>
            </div>
            <div class="green-burials-images">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/image 53.png" alt="Natural field burial" loading="lazy" width="500" height="300">
            </div>
        </div>
    </div>
</section>

<!-- Top Categories Section -->
<section class="product-section">
    <div class="container">
        <h2>Top Categories</h2>
        <div class="category-list">
            <a href="<?php echo esc_url(home_url('/product-category/water-cremation-urns')); ?>" class="category-item">Water Cremation Urns</a>
            <a href="<?php echo esc_url(home_url('/product-category/earth-burial-urns')); ?>" class="category-item">Earth Burial Urns</a>
            <a href="<?php echo esc_url(home_url('/product-category/caskets')); ?>" class="category-item">Top Categories Casket</a>
            <a href="<?php echo esc_url(home_url('/product-category/biodegradable-caskets')); ?>" class="category-item">Biodegradable Casket</a>
        </div>
        
        <div class="products-grid">
            <?php
            $featured_products = green_burials_get_featured_products(4);
            if ($featured_products->have_posts()) :
                while ($featured_products->have_posts()) : $featured_products->the_post();
                    global $product;
                    ?>
                    <div class="product-card">
                        <div class="product-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php 
                                $image_id = get_post_thumbnail_id();
                                $image_url = wp_get_attachment_image_url($image_id, 'product-thumb');
                                $image_url_2x = wp_get_attachment_image_url($image_id, 'product-thumb-2x');
                                ?>
                                <img src="<?php echo esc_url($image_url); ?>" 
                                     srcset="<?php echo esc_url($image_url); ?> 1x, <?php echo esc_url($image_url_2x); ?> 2x"
                                     alt="<?php the_title_attribute(); ?>" 
                                     loading="lazy" 
                                     width="300" 
                                     height="300">
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.svg" alt="<?php the_title(); ?>" loading="lazy" width="300" height="250">
                            <?php endif; ?>
                            <?php if ($product->is_on_sale()) : ?>
                                <span class="product-badge">Sale</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title"><?php the_title(); ?></h3>
                            <div class="product-price">
                                <?php echo $product->get_price_html(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn-shop">Shop Now</a>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
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
<section class="product-section">
    <div class="container">
        <h2>Best Sellers</h2>
        
        <div class="products-grid">
            <?php
            $best_sellers = green_burials_get_best_sellers(4);
            if ($best_sellers->have_posts()) :
                while ($best_sellers->have_posts()) : $best_sellers->the_post();
                    global $product;
                    ?>
                    <div class="product-card">
                        <div class="product-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('product-thumb'); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.svg" alt="<?php the_title(); ?>" loading="lazy" width="300" height="250">
                            <?php endif; ?>
                            <span class="product-badge">Best Seller</span>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title"><?php the_title(); ?></h3>
                            <div class="product-price">
                                <?php echo $product->get_price_html(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn-shop">Shop Now</a>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Dual Banners -->
<section class="dual-banners">
    <div class="container">
        <div class="banner-card">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask-group-5.png" alt="Bougainvillea Memorial Petals" loading="lazy" width="600" height="400">
            <div class="banner-overlay">
                <svg class="lotus-icon" width="60" height="60" viewBox="0 0 60 60" fill="white" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30 10C25 10 20 15 20 20C20 15 15 10 10 10C15 10 20 5 20 0C20 5 25 10 30 10Z"/>
                    <path d="M30 10C35 10 40 15 40 20C40 15 45 10 50 10C45 10 40 5 40 0C40 5 35 10 30 10Z"/>
                    <path d="M30 20C25 20 20 25 20 30C20 25 15 20 10 20C15 20 20 15 20 10C20 15 25 20 30 20Z"/>
                    <path d="M30 20C35 20 40 25 40 30C40 25 45 20 50 20C45 20 40 15 40 10C40 15 35 20 30 20Z"/>
                </svg>
                <h3>Bougainvillea Memorial Petals</h3>
                <p class="banner-price">$29</p>
                <a href="<?php echo esc_url(home_url('/product-category/memorial-petals')); ?>" class="btn-primary">Shop Now</a>
            </div>
        </div>
        <div class="banner-card">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask-group-3.png" alt="Water Burials With Petals" loading="lazy" width="600" height="400">
            <div class="banner-overlay">
                <svg class="lotus-icon" width="60" height="60" viewBox="0 0 60 60" fill="white" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30 10C25 10 20 15 20 20C20 15 15 10 10 10C15 10 20 5 20 0C20 5 25 10 30 10Z"/>
                    <path d="M30 10C35 10 40 15 40 20C40 15 45 10 50 10C45 10 40 5 40 0C40 5 35 10 30 10Z"/>
                    <path d="M30 20C25 20 20 25 20 30C20 25 15 20 10 20C15 20 20 15 20 10C20 15 25 20 30 20Z"/>
                    <path d="M30 20C35 20 40 25 40 30C40 25 45 20 50 20C45 20 40 15 40 10C40 15 35 20 30 20Z"/>
                </svg>
                <h3>Water Burials With Petals</h3>
                <p class="banner-price">$12</p>
                <a href="<?php echo esc_url(home_url('/product-category/water-burials')); ?>" class="btn-primary">Shop Now</a>
            </div>
        </div>
    </div>
</section>

<!-- Latest Products Section -->
<section class="product-section">
    <div class="container">
        <h2>Latest Products</h2>
        
        <div class="products-grid">
            <?php
            $latest_products = green_burials_get_latest_products(4);
            if ($latest_products->have_posts()) :
                while ($latest_products->have_posts()) : $latest_products->the_post();
                    global $product;
                    ?>
                    <div class="product-card">
                        <div class="product-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('product-thumb'); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.svg" alt="<?php the_title(); ?>" loading="lazy" width="300" height="250">
                            <?php endif; ?>
                            <span class="product-badge">New</span>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title"><?php the_title(); ?></h3>
                            <div class="product-price">
                                <?php echo $product->get_price_html(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn-shop">Shop Now</a>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="reviews-section">
    <div class="container">
        <h2>Reviews</h2>
        <div class="review-card">
            <p class="review-date">February 4, 2019</p>
            <div class="review-stars">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
            </div>
            <blockquote class="review-text">
                <span class="quote-open">"</span>
                I wanted to thank you for your excellent customer service. I ordered an urn for my mother's ashes and it arrived quickly and was exactly as described. The quality is outstanding and the price was very reasonable. I would highly recommend your company to anyone looking for a beautiful and affordable urn. Thank you again for making this difficult time a little easier.
                <span class="quote-close">"</span>
            </blockquote>
            <p class="review-author">William S. Nageli</p>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="blog-section">
    <div class="container">
        <h2>Our Latest Blogs</h2>
        <div class="blog-grid">
            <?php
            $blog_posts = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC',
            ));
            
            if ($blog_posts->have_posts()) :
                while ($blog_posts->have_posts()) : $blog_posts->the_post();
                    ?>
                    <div class="blog-card">
                        <div class="blog-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog-placeholder.svg" alt="<?php the_title(); ?>" loading="lazy" width="400" height="200">
                            <?php endif; ?>
                        </div>
                        <div class="blog-content">
                            <h3 class="blog-title"><?php the_title(); ?></h3>
                            <p class="blog-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn-learn-more">Learn More →</a>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <div class="newsletter-form">
                <h2>Sign Up For Newsletter</h2>
                <form action="#" method="post">
                    <input type="email" name="email" placeholder="New Email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
            <div class="newsletter-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.1841!2d-73.9875!3d40.7484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQ0JzU0LjIiTiA3M8KwNTknMTUuMCJX!5e0!3m2!1sen!2sus!4v1234567890" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
