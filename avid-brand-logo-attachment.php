<?php
/*
Plugin Name: 03 AVID Brand Logo Attachment
Description: Displays selected brands of each product below product image based on brand attribute
Requires Plugins: woocommerce
Version: 1.1.0
Author: AVID-MIS
Author URI: www.avid.com.ph
*/
require_once(plugin_dir_path(__FILE__) . 'sidebar_dashboard.php');
function brand_logo_styling() {

    wp_enqueue_style('plugin_styling', get_template_directory_uri() . '/woocommerce.css');

    $logo_css = "
        .brand-logos {
            height: 15px !important;
            width: auto !important;
            margin-bottom: 0 !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        .brand-logos:hover {
            padding: 1px;
            border-color: white;
        }
    ";
    wp_add_inline_style('plugin_styling', $logo_css);
}
add_action('wp_enqueue_scripts', 'brand_logo_styling');

function asign_logo_to_product() {
    global $product;

    $enclose_start = '<a href="/brand/';
    $enclose_middle = '"><img src="';
    $enclose_end = '" class="brand-logos" alt="logo of the brand of the product"></a>';

    $product_brand = $product->get_attribute( 'Brand' );
    $brand_logo_info = get_option('brand_logo_info', array());

    $branded = false;

    foreach ($brand_logo_info as $brand) {
        if (stripos($product_brand, $brand['brand_name']) !== false) {
            echo $enclose_start . $brand['brand_name'] . $enclose_middle . $brand['brand_logo_url'] . $enclose_end;
            $branded = true;
            break; // No need to continue checking once a logo is assigned
        }
    }

    if (!$branded) {
        echo '<a><img src="https://avid.com.ph/wp-content/uploads/2023/11/no_logo.webp" class="brand-logos" alt="a blank placeholder image for product containers without a brand logo"></a>';
    }
}

add_action('woocommerce_shop_loop_item_title','asign_logo_to_product');
?>