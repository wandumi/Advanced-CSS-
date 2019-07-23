<?php
/**
 * Show error messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>
<div class="alert alert-danger woocommerce-error">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-cross"></i>
    </button>
    <ul>
        <?php foreach ( $messages as $message ) : ?>
            <li><?php echo wp_kses_post( $message ); ?></li>
        <?php endforeach; ?>
    </ul>
</div>
