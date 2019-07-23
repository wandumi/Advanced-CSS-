<?php
/**
 * Displays the main body of the theme
 *
 * @package Lambda
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2015 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.38.0
 */

get_header();
oxy_blog_header(__('Results for:', 'lambda-td'). ' ' .get_search_query());
get_template_part('partials/blog/list/' . oxy_get_option('blog_style'));
get_footer();