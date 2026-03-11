<?php
/**
 * Template Name: Compare
 */

get_header(); ?>

<div class="compare-page-wrapper container">
    <div class="account-breadcrumb">
        <a href="<?php echo home_url(); ?>"><i class="fa fa-home"></i></a> &gt; Compare
    </div>

    <h1 class="page-title">Product Comparison</h1>

    <div class="compare-content">
        <?php
        $compare = isset($_COOKIE['gb_compare']) ? json_decode(stripslashes($_COOKIE['gb_compare']), true) : array();
        
        if (!empty($compare)) : ?>
            <div class="compare-table-wrapper">
                <table class="compare-table">
                    <thead>
                        <tr>
                            <th>Features</th>
                            <?php foreach ($compare as $product_id) : 
                                $product = wc_get_product($product_id);
                                if (!$product) continue;
                                ?>
                                <td class="product-header" data-product-id="<?php echo $product_id; ?>">
                                    <button class="remove-from-compare btn-remove-top" data-product-id="<?php echo $product_id; ?>">&times;</button>
                                    <div class="product-image">
                                        <?php echo $product->get_image(); ?>
                                    </div>
                                    <div class="product-name">
                                        <a href="<?php echo get_permalink($product_id); ?>"><?php echo $product->get_name(); ?></a>
                                    </div>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Price</th>
                            <?php foreach ($compare as $product_id) : 
                                $product = wc_get_product($product_id);
                                ?>
                                <td><?php echo $product ? $product->get_price_html() : '-'; ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <th>Availability</th>
                            <?php foreach ($compare as $product_id) : 
                                $product = wc_get_product($product_id);
                                ?>
                                <td><?php echo ($product && $product->is_in_stock()) ? '<span class="in-stock">In Stock</span>' : '<span class="out-of-stock">Out of Stock</span>'; ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <?php foreach ($compare as $product_id) : 
                                $product = wc_get_product($product_id);
                                ?>
                                <td class="product-desc"><?php echo $product ? wp_trim_words($product->get_short_description(), 20) : '-'; ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <th>Action</th>
                            <?php foreach ($compare as $product_id) : 
                                $product = wc_get_product($product_id);
                                ?>
                                <td>
                                    <?php if ($product) : ?>
                                        <a href="?add-to-cart=<?php echo $product_id; ?>" class="button add_to_cart_button">Add to Cart</a>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="empty-compare">
                <p>No products selected for comparison.</p>
                <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="button">Go Shopping</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.compare-page-wrapper { padding: 40px 0; }
.compare-table-wrapper { overflow-x: auto; margin-top: 20px; }
.compare-table { width: 100%; border-collapse: collapse; min-width: 800px; }
.compare-table th { text-align: left; padding: 15px; border: 1px solid #eee; background: #f9f9f9; width: 200px; }
.compare-table td { text-align: center; padding: 15px; border: 1px solid #eee; vertical-align: top; }
.product-header { position: relative; }
.btn-remove-top { position: absolute; top: 5px; right: 5px; background: #e74c3c; color: #fff; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; line-height: 24px; text-align: center; padding: 0; }
.product-image img { max-width: 150px; height: auto; margin-bottom: 10px; border-radius: 4px; }
.product-name a { color: #333; font-weight: 600; text-decoration: none; display: block; margin-bottom: 10px; }
.product-desc { font-size: 13px; line-height: 1.5; color: #666; }
.empty-compare { text-align: center; padding: 60px 0; }
</style>

<!-- Removal handled globally in script.js -->

<?php get_footer(); ?>
