<?php

//Register sidebar for website
if (function_exists("register_sidebar")) {
  register_sidebar();
}

function enqueue_wc_cart_fragments()
{
  wp_enqueue_script('wc-cart-fragments');
}
add_action('wp_enqueue_scripts', 'enqueue_wc_cart_fragments');

//function display name category in loop product elementor
function display_product_categories_in_loop() {
    global $product;

    $categories = get_the_terms($product->get_id(), 'product_cat');
	if (!empty($categories) && !is_wp_error($categories)) {
        $first_category = $categories[0];

        echo '<div class="name-category-in-loop"><span>' . esc_html($first_category->name) . '</span></div>';
  
    }
    
}
add_action('woocommerce_before_shop_loop_item', 'display_product_categories_in_loop', 15);
