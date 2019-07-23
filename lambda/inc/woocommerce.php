<?php
/**
 * All Woocommerce stuff
 *
 * @package Lambda
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2015 Oxygenna.com
 * @license **LICENSE**
 * @version 1.38.0
 */

add_theme_support('woocommerce');

if (oxy_is_woocommerce_active()) {
     // Dequeue WooCommerce stylesheet(s)
    if (version_compare(WOOCOMMERCE_VERSION, '2.1') >= 0) {
        // WooCommerce 2.1 or above is active
        add_filter('woocommerce_enqueue_styles', '__return_false');
    } else {
        // WooCommerce is less than 2.1
        define('WOOCOMMERCE_USE_CSS', false);
    }

    function oxy_shop_product_widget()
    {
        dynamic_sidebar('product-page');
    }
    /**
     * All hooks for the shop page and category list page go here
     *
     * @return void
     **/
    function oxy_shop_and_category_hooks()
    {
        if (is_shop() || is_product_category() || is_product_tag()) {
            function oxy_remove_title()
            {
                return false;
            }
            add_filter('woocommerce_show_page_title', 'oxy_remove_title');

            function oxy_shop_layout_start()
            {
                switch (oxy_get_option('shop_layout')) {
                    case 'sidebar-left':?>
                        <div class="row"><div class="col-md-3"> <?php get_sidebar(); ?></div><div class="col-md-9"><?php
                        break;
                    case 'sidebar-right': ?>
                        <div class="row"><div class="col-md-9"><?php
                        break;
                }
            }
            // remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
            add_action('woocommerce_before_main_content', 'oxy_shop_layout_start', 18);
            add_action('woocommerce_before_main_content', 'wc_print_notices', 18);
            add_action( 'woocommerce_before_main_content', 'oxy_shop_product_widget', 17 );

            function oxy_shop_layout_end()
            {
                switch (oxy_get_option('shop_layout')) {
                    case 'sidebar-left': ?>
                        </div></div><?php
                        break;
                    case 'sidebar-right': ?>
                        </div><div class="col-md-3"><?php get_sidebar(); ?></div></div><?php
                        break;
                }
            }
            add_action('woocommerce_after_main_content', 'oxy_shop_layout_end', 9);


            function oxy_before_breadcrumbs()
            {
                echo '<div class="row"><div class="col-md-6">';
            }
             // remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
            add_action('woocommerce_before_main_content', 'oxy_before_breadcrumbs', 19);

            function oxy_after_breadcrumbs()
            {
                echo '</div><div class="col-md-6 text-right">';
            }
            add_action('woocommerce_before_main_content', 'oxy_after_breadcrumbs', 20);

            function oxy_after_orderby()
            {
                echo '</div></div>';
            }
            add_action('woocommerce_before_shop_loop', 'oxy_after_orderby', 30);

        }
    }

    function oxy_single_product_hooks()
    {
        if (is_product()) {
            // we need to reposition the messages before the breadcrumbs
            remove_action('woocommerce_before_single_product', 'wc_print_notices', 12);
            add_action('woocommerce_before_main_content', 'wc_print_notices', 15);
            add_action('woocommerce_before_main_content', 'oxy_shop_product_widget', 11);
        }
    }

    // Avatar on review tab of single product gets called by a hook since v4.6
    function oxy_woocommerce_review_display_gravatar($comment)
    {
        echo get_avatar($comment, apply_filters('woocommerce_review_gravatar_size', '48'), '', get_comment_author());
    }
    add_action('woocommerce_review_before', 'oxy_woocommerce_review_display_gravatar', 10);

    function oxy_load_woo_scripts()
    {
        if (wp_style_is('wcqi-css', 'registered')) {
            wp_deregister_style('wcqi-css');
        }
    }

    add_action('wp', 'oxy_shop_and_category_hooks');
    add_action('wp', 'oxy_single_product_hooks');
    add_action('wp_enqueue_scripts', 'oxy_load_woo_scripts');

    // GLOBAL HOOKS - EFFECT ALL PAGES
    // Removing action that shows in the footer a site-wide note
    remove_action( 'wp_footer', 'woocommerce_demo_store', 10);

    // Removing action that shows the woocommerce navigation on top of account page(as of v4.6)
    remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation');

    // Removing action that shows the review avatar on single product page(as of v4.6)
    remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10);

    // first unhook the global WooCommerce wrappers. They were adding another <div id=content> around.
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    // remove rating from below the product title
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

    // remove add to cart from below products in a list
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

    // move add to cart into product-info div
    add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 11);

    // cross sales products ordering in cart page
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
    add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 11 );

    // add categories below title
    function oxy_add_categories_below_title()
    {
        global $product;
        echo $product->get_categories(', ', '<span class="product-categories">', '</span>');
    }
    add_action('woocommerce_after_shop_loop_item_title', 'oxy_add_categories_below_title', 6);

    function oxy_before_main_content_10()
    {
        $template_margin = oxy_get_option('template_margin');
        echo '<section class="section section-commerce">';
        echo '<div class="container element-top-' . $template_margin . ' element-bottom-' . $template_margin . '">';
    }
    add_action('woocommerce_before_main_content', 'oxy_before_main_content_10', 10);

    function oxy_after_main_content_10()
    {
        echo '</div></section>';
    }
    add_action('woocommerce_after_main_content', 'woocommerce_site_note', 10);
    add_action('woocommerce_after_main_content', 'oxy_after_main_content_10', 11);

    function custom_override_breadcrumb_fields($fields)
    {
        $fields['wrap_before']='<ol class="breadcrumb">';
        $fields['wrap_after']='</ol>';
        $fields['before']='<li>';
        $fields['after']='</li>';
        $fields['delimiter']=' ';
        return $fields;
    }
    add_filter('woocommerce_breadcrumb_defaults', 'custom_override_breadcrumb_fields');

    // removing default woocommerce image display. Also affects shortcodes.
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

    function oxy_woocommerce_template_loop_product_thumbnail()
    {
        global $product;
        $image_ids = $product->get_gallery_attachment_ids();
        $back_image = array_shift($image_ids);
        echo '<div class="product-image">';
        echo '<div class="product-image-front">' . woocommerce_get_product_thumbnail() . '</div>';
        if (null != $back_image) {
            $back_image_html = wp_get_attachment_image($back_image, 'shop_catalog', false, array('alt' => 'Product Image'));
            echo '<div class="product-image-back">' . $back_image_html . '</div>';
        }
        echo '<div class="product-image-overlay">';
        echo '<h4>';
        echo __('View Details', 'lambda-td');
        echo '</h4>';
        echo woocommerce_template_loop_rating();
        echo '</div>';
        echo '</div>';
    }
    add_action('woocommerce_before_shop_loop_item_title', 'oxy_woocommerce_template_loop_product_thumbnail', 10);

    function oxy_woo_shop_header()
    {
        global $post;
        if (is_shop()) {
            oxy_page_header(woocommerce_get_page_id('shop'), array('heading_type' => 'page'));
        } elseif (is_product_category()) {
            $category = get_queried_object();
            if (isset($category->term_id)) {
                oxy_create_taxonomy_header($category);
            }
        } elseif (is_product_tag()) {
            $tag = get_queried_object();
            if (isset($tag->term_id)) {
                oxy_create_taxonomy_header($tag);
            }
        } elseif (is_page(get_option('woocommerce_myaccount_page_id'))) {
            oxy_page_header(get_option('woocommerce_myaccount_page_id'), array('heading_type' => 'page'));
        } else {
            oxy_page_header($post->ID, array('heading_type' => 'page'));
        }
    }

    function oxy_create_taxonomy_header($queried_object)
    {
        $meta_title = get_option(THEME_SHORT . '-tax-mtb-content'. $queried_object->term_id, '');
        $title = empty($meta_title) ? $queried_object->name : $meta_title;
        // has this page been overriden?
        if (get_option(THEME_SHORT . '-tax-mtb-override_header'. $queried_object->term_id, 'default') === 'default') {
            oxy_default_page_header($title, array('heading_type' => 'page'));
        } else {
            if (get_option(THEME_SHORT . '-tax-mtb-show_header'. $queried_object->term_id, 'show') === 'show') {
                $heading_options = include OXY_THEME_DIR . '/inc/options/shortcodes/shared/heading-option-list.php';
                $heading_section_options = include OXY_THEME_DIR . '/inc/options/shortcodes/shared/heading-section-option-list.php';

                $heading = oxy_call_shortcode_with_tax_meta('oxy_section_heading', $heading_options, $title, $queried_object->term_id, array('heading_type' => 'page'));
                echo oxy_call_shortcode_with_tax_meta('oxy_shortcode_section', $heading_section_options, $heading, $queried_object->term_id);
            }
        }
    }

    // Change number or products per row to based on options
    add_filter('loop_shop_columns', 'oxy_woocom_loop_columns');
    if (!function_exists('oxy_woocom_loop_columns')) {
        function oxy_woocom_loop_columns()
        {
            if (is_shop() || is_product()) {
                return oxy_get_option('woocommerce_shop_page_columns', 3);
            } elseif (is_product_category()) {
                $category = get_queried_object();
                if (isset($category->term_id)) {
                    return get_option(THEME_SHORT . '-tax-mtb-product_columns'. $category->term_id, 3);
                }
            } elseif (is_product_tag()) {
                $tag = get_queried_object();
                if (isset($tag->term_id)) {
                    return get_option(THEME_SHORT . '-tax-mtb-product_columns'. $tag->term_id, 3);
                }
            } else {
                return 3;
            }
        }
    }

    // Change number or products shown in cross sells
    add_filter('woocommerce_cross_sells_columns', 'oxy_woocommerce_cross_sells_columns');
    if (!function_exists('oxy_woocommerce_cross_sells_columns')) {
        function oxy_woocommerce_cross_sells_columns($columns)
        {
            return 4;
        }
    }

    function oxy_woocommerce_subcategory_count_html($html, $category)
    {
        return ' <small class="count">' . $category->count . __(' Products', 'lambda-td') . '</small>';
    }
    add_filter('woocommerce_subcategory_count_html', 'oxy_woocommerce_subcategory_count_html', 10, 2);


    /**
     * adds a form-control class to all checkout fields
     *
     * @return void
     * @author
     **/
    function oxy_add_form_control_checkout_fields($fields)
    {
        foreach ($fields as $formkey => $form) {
            foreach ($fields[$formkey] as $id => $field) {
                $fields[$formkey][$id]['input_class'][] = 'form-control';
            }
        }
        return $fields;
    }
    add_filter('woocommerce_checkout_fields', 'oxy_add_form_control_checkout_fields');
}

remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description');

if (! function_exists('get_product_search_form')) {

    /**
     * Output Product search forms.
     *
     * @access public
     * @subpackage  Forms
     * @param bool $echo (default: true)
     * @return string
     * @todo This function needs to be broken up in smaller pieces
     */
    function get_product_search_form($echo = true)
    {
        do_action('get_product_search_form');

        $search_form_template = locate_template('product-searchform.php');
        if ('' != $search_form_template) {
            require $search_form_template;
            return;
        }

        $form = '<form role="search" method="get" id="searchform" action="' . esc_url(home_url('/')) . '">
        <div class="input-group">
            <input type="text" value name="s" class="form-control" placeholder="'. esc_attr__('Search', 'woocommerce') .'">
                <span class="input-group-btn">
                <button class="btn btn-primary" type="submit" id="searchsubmit" value="' . get_search_query() . '">
                    <i class="fa fa-search"></i>
                </button>
            <input type="hidden" name="post_type" value="product">
            </span>
        </div></form>';

        if ($echo) {
            echo apply_filters('get_product_search_form', $form);
        } else {
            return apply_filters('get_product_search_form', $form);
        }
    }

    if ( ! function_exists( 'woocommerce_output_related_products' ) ) {

        /**
         * Output the related products.
         *
         * @subpackage  Product
         */
        function woocommerce_output_related_products() {

            $related_products = oxy_get_option('woocommerce_shop_page_columns');
            $args = array(
                'posts_per_page' => $related_products,
                'columns' => 2,
                'orderby' => 'rand'
            );

            woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
        }
    }
}

if ( ! function_exists( 'woocommerce_site_note' ) ) {

    /**
     * Adds a demo store banner to the site if enabled
     *
     */
    function woocommerce_site_note() {

        if ( ! is_store_notice_showing() ) {
            return;
        }

        $notice = get_option( 'woocommerce_demo_store_notice' );

        if ( empty( $notice ) ) {
            $notice = __( 'This is a demo store for testing purposes &mdash; no orders shall be fulfilled.', 'woocommerce' );
        }
        echo '<div class="alert alert-info">' . wp_kses_post( $notice ) . '</div>';

    }
}
