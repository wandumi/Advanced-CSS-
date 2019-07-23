<?php
/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */
require_once OXY_TF_DIR . 'inc/OxygennaWidget.php';

/**
 * Adds Caelus_title widget.
 */
class OxyWidgetWPML extends OxygennaWidget
{
    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        $widget_options = array(
            'description' => __('WPML Language Selector', 'lambda-admin-td'),
            'classname'   => 'widget_wpml_language_selector'
        );
        parent::__construct('wpml-language-selector-options.php', false, $name = THEME_NAME . ' - ' . __('WPML Language Selector Widget', 'lambda-admin-td'), $widget_options);
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        extract($args);

        if (function_exists('icl_get_languages')) {
            $display_as = $this->get_option('display', $instance, 'name');
            $options = 'skip_missing=' . $this->get_option('skip_missing', $instance, '1');
            $options .= '&order=' . $this->get_option('orderby', $instance, 'asc');
            $options .= '&orderby=' . $this->get_option('order', $instance, 'id');
            $dropdown = $this->get_option('dropdown', $instance, 'off');
            $dropdown_alignment = $this->get_option('dropdown_align', $instance, 'dropdown-menu-left');
            $languages = icl_get_languages($options);

            $output = $before_widget;
            if ($dropdown == 'on') {
                $output .= '<div class="menu-container">';
                $output .= '<ul class="nav navbar-nav">';
                $output .= '<li class="menu-item dropdown">';
                $output .= '<a href="#" data-toggle="dropdown" class="dropdown-toggle">' . esc_html__('Languages', 'lambda-admin-td') . '</a>';
                $output .= '<ul role="menu" class="dropdown-menu ' . esc_html($dropdown_alignment) . '">';
                foreach ($languages as $lang) {
                    $class = $lang['active'] ? 'active' : '';
                    $link = $lang['active'] ? '#' : $lang['url'];

                    $output .= '<li class="menu-item ' . $class . ' ">';
                    $output .= '<a href="' . $link . '" class="navbar-text">';
                    switch($display_as) {
                        case 'name':
                        $output .= $lang['translated_name'];
                        break;
                        case 'name-native':
                        $output .= $lang['native_name'];
                        break;
                        case 'code':
                        $output .= $lang['language_code'];
                        break;
                        case 'flag':
                        $output .= '<img src="' . $lang['country_flag_url'] . '" alt="' . $lang['translated_name'] . '" />';
                        break;
                        case 'nameflag':
                        $output .= '<img src="' . $lang['country_flag_url'] . '" alt="' . $lang['translated_name'] . '" /> ' . $lang['translated_name'];
                        break;
                    }
                    $output .= '</a>';
                    $output .= '</li>';
                }
                $output .= '</li></ul></div>';
            } else {
                $output .= '<ul class="inline">';
                foreach ($languages as $lang) {
                    $class = $lang['active'] ? 'active' : '';
                    $link = $lang['active'] ? '#' : $lang['url'];
                    $output .= '<li class="' . $class . '">';
                    $output .= '<a href="' . $link . '" class="navbar-text">';
                    switch($display_as) {
                        case 'name':
                        $output .= $lang['translated_name'];
                        break;
                        case 'name-native':
                        $output .= $lang['native_name'];
                        break;
                        case 'code':
                        $output .= $lang['language_code'];
                        break;
                        case 'flag':
                        $output .= '<img src="' . $lang['country_flag_url'] . '" alt="' . $lang['translated_name'] . '" />';
                        break;
                        case 'nameflag':
                        $output .= '<img src="' . $lang['country_flag_url'] . '" alt="' . $lang['translated_name'] . '" /> ' . $lang['translated_name'];
                        break;
                    }
                    $output .= '</a>';
                    $output .= '</li>';
                }
                $output .= '</ul>';
            }
            $output .= $after_widget;
        } else {
            $output = 'You must install the WPML plugin';
        }

        echo $output;
    }
}
