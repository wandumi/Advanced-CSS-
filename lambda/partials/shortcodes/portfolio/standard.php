<?php
/**
 * Portfolio shortcode
 *
 * @package Lambda
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2015 Oxygenna.com
 * @license **LICENSE**
 * @version 1.38.0
 */
?>
<div class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-padding="<?php echo esc_attr($item_padding); ?>" data-col-xs="<?php echo esc_attr($xs_col); ?>" data-col-sm="<?php echo esc_attr($sm_col); ?>" data-col-md="<?php echo esc_attr($md_col); ?>" data-col-lg="<?php echo esc_attr($lg_col); ?>" data-layout="<?php echo esc_attr($layout_mode); ?>">
    <?php
        // set staggered timings if needed
        if( $item_scroll_animation_timing === 'staggered' ) {
            $item_delay = $item_scroll_animation_delay;
            $item_scroll_animation_delay = 0;
        }
        global $post;

        foreach( $posts as $index => $post ) {
            setup_postdata( $post );
            // item classes
            $item_link_target = get_post_meta( $post->ID, THEME_SHORT . '_target', true );
            $post->classes = array();
            // item classes filter
            $filter_tags = get_the_terms( $post->ID, 'oxy_portfolio_categories' );
            if( $filter_tags && ! is_wp_error( $filter_tags ) ) :
                foreach( $filter_tags as $tag ):
                    $post->classes[] = 'filter-' . $tag->slug;
                endforeach;
            endif;
            // set masonry width if we are making a masonry portfolio
            if( $code === 'portfolio_masonry' ) {
                $wide_class = get_post_meta( $post->ID, THEME_SHORT.'_masonry_width', true );
                $post->classes[] = 'masonry-' . $wide_class;
            }?>
            <?php
            $magnific_link = '';
            $magnific_popup_caption = '';
            $magnific_type = 'image';
            $title = get_the_title( $post->ID );
            $format = get_post_meta( $post->ID, THEME_SHORT. '_post_type', true );
            switch( $format ) {
                case 'video':
                    $magnific_type = 'video';
                    $video = get_post_meta( $post->ID, THEME_SHORT. '_post_video_link', true );
                    $magnific_link = $video;
                break;
                case 'gallery':
                    $magnific_type = 'gallery';
                    $gallery_content = get_post_meta( $post->ID, THEME_SHORT. '_post_gallery', true );
                    $magnific_link = oxy_get_content_gallery( $gallery_content );

                    if ($magnific_caption === 'off') {
                        $magnific_popup_caption = 'hide';
                    }
                break;
                default:
                case 'standard':
                break;
            }

            if ( $magnific_caption === 'image_caption') {
                $magnific_popup_caption = oxy_get_image_caption(get_post_thumbnail_id( $post->ID ));
            } else if ( $magnific_caption === 'post_title_caption' ) {
                $magnific_popup_caption = get_the_title( $post->ID );
            }
            $title = $magnific_popup_caption;

            if ($magnific_caption === 'off') {
                $title = '';
            }
            ?>

            <div class="masonry-item portfolio-item <?php echo implode( ' ', $post->classes ); ?>" data-menu-order="<?php echo $post->menu_order; ?>" data-date="<?php echo get_the_date( 'c' ); ?>" data-title="<?php the_title(); ?>" data-comments="<?php echo $post->comment_count; ?>">
                <?php echo oxy_complex_image( array(
                    'image'                    => get_post_thumbnail_id( $post->ID ),
                    'size'                     => $item_size,
                    'title'                    => $title,
                    'alt'                      => get_the_title( $post->ID ),
                    'link'                     => oxy_get_slide_link( $post ),
                    'link_target'              => $item_link_target,
                    'item_link_type'           => $item_link_type,
                    'magnific_link'            => $magnific_link,
                    'magnific_popup_caption'   => $magnific_popup_caption,
                    'magnific_type'            => $magnific_type,
                    'captions_below'           => $item_captions_below,
                    'captions_below_link_type' => $captions_below_link_type,
                    'caption_title'            => get_the_title( $post->ID ),
                    'caption_text'             => get_the_excerpt(),
                    'caption_align'            => $item_caption_align,
                    'hover_filter'             => $item_hover_filter,
                    'hover_filter_invert'      => $hover_filter_invert,
                    'overlay'                  => $item_overlay,
                    'button_text_zoom'         => oxy_get_option( 'portfolio_button_text_zoom' ),
                    'button_text_details'      => oxy_get_option( 'portfolio_button_text_details' ),
                    'overlay_caption_vertical' => $item_caption_vertical,
                    'overlay_animation'        => $item_overlay_animation,
                    'overlay_grid'             => $item_overlay_grid,
                    'overlay_icon'             => $item_overlay_icon,
                    // global options
                    'margin_top'             => 0,
                    'margin_bottom'          => 0,
                    'scroll_animation'       => $item_scroll_animation,
                    'portfolio_item'         => true,
                    'scroll_animation_delay' => $item_scroll_animation_delay,
                )); ?>
            </div>
            <?php
            if( $item_scroll_animation_timing === 'staggered' ) {
                $item_scroll_animation_delay += $item_delay;
            }
        }
    ?>
</div>
<?php
if( $pagination !== 'none' ) {
    oxy_portfolio_pagination( $pagination );
}
?>