<?php
require_once(__DIR__ . '/../../../wp-load.php');
if (!current_user_can('manage_options')) die('Unauthorized');

header('Content-Type: application/json');

$options = array(
    'permalink_structure' => get_option('permalink_structure'),
    'category_base' => get_option('category_base'),
    'tag_base' => get_option('tag_base'),
    'woocommerce_product_category_slug' => get_option('woocommerce_product_category_slug'),
    'woocommerce_product_tag_slug' => get_option('woocommerce_product_tag_slug'),
    'woocommerce_permalinks' => get_option('woocommerce_permalinks'),
);

echo json_encode($options, JSON_PRETTY_PRINT);
