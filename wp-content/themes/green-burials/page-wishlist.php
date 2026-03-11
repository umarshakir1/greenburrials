<?php
/**
 * Template Name: Wishlist
 */

/**
 * ── Cache Prevention ──────────────────────────────────────────────────────────
 * The wishlist is 100 % user-specific. We must tell every caching layer
 * to never store or serve a cached copy of this page.
 *
 * 1. LiteSpeed Cache plugin  →  mark as "no cache" (private, per-user)
 * 2. Standard PHP headers    →  fallback for any other proxy / CDN
 */
add_action('litespeed_init', function () {
    // Tell LSCWP: do NOT cache this page at all
    do_action('litespeed_control_set_nocache', 'Wishlist page is private per-user');
    // Belt-and-suspenders: also tag as private so ESI won't store it
    do_action('litespeed_tag_add_private', 'wishlist');
});

get_header();

// Fallback: standard HTTP no-cache headers for every other caching layer
if (function_exists('nocache_headers')) {
    nocache_headers();
}
// Extra headers for LiteSpeed / Nginx / CDN edge nodes
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Surrogate-Control: no-store');
?>

<div class="wishlist-page-wrapper">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="product-navigation">
            <?php green_burials_breadcrumb(); ?>
        </div>

        <h1 class="wishlist-page-title">MY WISHLIST</h1>

        <div class="wishlist-content">
            <?php
            $wishlist = function_exists('green_burials_get_current_wishlist_items')
                ? green_burials_get_current_wishlist_items()
                : array();

            if (!empty($wishlist) && is_array($wishlist)) : ?>
                <div class="wishlist-products-grid">
                    <?php foreach ($wishlist as $product_id) : 
                        $product = wc_get_product($product_id);
                        if (!$product) continue;
                        ?>
                        <div class="wishlist-product-card" data-product-id="<?php echo $product_id; ?>">
                            <button class="remove-from-wishlist" data-product-id="<?php echo $product_id; ?>" title="Remove from wishlist">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                            
                            <a href="<?php echo get_permalink($product_id); ?>" class="product-image-link">
                                <?php echo $product->get_image('woocommerce_thumbnail'); ?>
                            </a>
                            
                            <div class="product-details">
                                <h3 class="product-name">
                                    <a href="<?php echo get_permalink($product_id); ?>"><?php echo $product->get_name(); ?></a>
                                </h3>
                                
                                <div class="product-price">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                                
                                <div class="product-stock">
                                    <?php if ($product->is_in_stock()) : ?>
                                        <span class="in-stock">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            In Stock
                                        </span>
                                    <?php else : ?>
                                        <span class="out-of-stock">Out of Stock</span>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($product->is_in_stock()) : ?>
                                    <a href="<?php echo $product->add_to_cart_url(); ?>" class="add-to-cart-btn" data-product-id="<?php echo $product_id; ?>">
                                        Add to Cart
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="empty-wishlist">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <p>Your wishlist is currently empty.</p>
                    <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="btn-go-shopping">Go Shopping</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.wishlist-page-wrapper {
    padding: 60px 0;
    min-height: 60vh;
    background: #fdfdfb;
}

.wishlist-page-title {
    font-family: 'Times New Roman', Times, serif;
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin: 1.5rem 0 2.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-align: center;
}

.wishlist-products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2.5rem;
}

.wishlist-product-card {
    background: #fff;
    border: 1px solid #ECEBE6;
    border-radius: 12px;
    padding: 1.5rem;
    position: relative;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.wishlist-product-card:hover {
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    border-color: #73884D;
    transform: translateY(-5px);
}

.remove-from-wishlist {
    position: absolute;
    top: -12px;
    right: -12px;
    background: #fff;
    border: 1px solid #e74c3c;
    color: #e74c3c;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 20;
    box-shadow: 0 4px 10px rgba(231, 76, 60, 0.2);
}

.remove-from-wishlist:hover {
    background: #e74c3c;
    color: #fff;
}

.product-image-link {
    display: block;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    background: #f9f9f9;
}

.product-image-link img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.5s ease;
}

.product-details {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-name {
    font-family: 'Times New Roman', Times, serif;
    font-size: 1.15rem;
    font-weight: 600;
    margin: 0 0 0.75rem 0;
    line-height: 1.4;
}

.product-name a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s;
}

.product-name a:hover {
    color: #73884D;
}

.product-price {
    font-size: 1.4rem;
    color: #73884D;
    font-weight: 700;
    font-family: 'Times New Roman', Times, serif;
    margin-bottom: auto;
    padding: 0.5rem 0;
}

.product-stock {
    margin: 1rem 0;
}

.in-stock {
    color: #73884D;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.out-of-stock {
    color: #e74c3c;
    font-weight: 600;
    font-size: 0.9rem;
}

.add-to-cart-btn {
    background: #73884D;
    color: #fff;
    padding: 0.85rem 1.5rem;
    border-radius: 50px;
    text-align: center;
    text-decoration: none;
    font-weight: 600;
    font-family: 'Times New Roman', Times, serif;
    transition: all 0.3s;
    margin-top: 1rem;
    text-transform: uppercase;
    font-size: 0.9rem;
}

.add-to-cart-btn:hover {
    background: #5A6D3A;
    box-shadow: 0 5px 15px rgba(115, 136, 77, 0.3);
}

.empty-wishlist {
    text-align: center;
    padding: 100px 20px;
}

.empty-wishlist svg {
    margin: 0 auto 2rem;
    opacity: 0.5;
}

.empty-wishlist p {
    font-size: 1.25rem;
    color: #666;
    margin-bottom: 2.5rem;
}

.btn-go-shopping {
    background: #73884D;
    color: #fff;
    padding: 1rem 3rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-family: 'Times New Roman', Times, serif;
    display: inline-block;
    transition: all 0.3s;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-go-shopping:hover {
    background: #5A6D3A;
    box-shadow: 0 8px 20px rgba(115, 136, 77, 0.3);
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .wishlist-page-wrapper {
        padding: 30px 0;
    }
    .wishlist-page-title {
        font-size: 1.8rem;
    }
    
    .wishlist-products-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 2rem 1rem;
    }
    
    .wishlist-product-card {
        padding: 0.75rem;
    }

    .remove-from-wishlist {
        top: -8px;
        right: -8px;
        width: 28px;
        height: 28px;
    }
}

@media (max-width: 480px) {
    .wishlist-products-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
/* Loading Spinner */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.spinner-small {
    display: inline-block;
    width: 14px;
    height: 14px;
    border: 2px solid rgba(0,0,0,0.1);
    border-top-color: currentColor;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    vertical-align: middle;
}
</style>

<?php get_footer(); ?>