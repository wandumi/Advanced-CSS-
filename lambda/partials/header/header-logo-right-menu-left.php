<?php
/**
 * Creates a boostrap header
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
<div id="masthead" class="menu navbar navbar-static-top header-logo-right-menu-left oxy-mega-menu <?php echo esc_attr(implode(' ', $classes)); ?>" role="banner">
    <div class="<?php echo esc_attr(implode(' ', $container_classes)); ?>">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".main-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php include(locate_template('partials/header/logo.php')); ?>
        </div>
        <div class="nav-container">
            <nav class="collapse navbar-collapse logo-navbar  main-navbar navbar-left" role="navigation">
                <?php include(locate_template('partials/header/nav.php')); ?>
            </nav>
        </div>
    </div>
</div>