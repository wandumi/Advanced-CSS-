<?php
/**
 * Main mega menu class
 *
 * @package Lambda
 * @subpackage Admin
 *
 * @copyright (c) 2015 Oxygenna.com
 * @license **LICENSE**
 * @version 1.38.0
 * @author Oxygenna.com
 */

define('OXY_MEGA_MENU_DIR', OXY_THEME_DIR . 'vendor/oxygenna/oxygenna-mega-menu/');
define('OXY_MEGA_MENU_URI', OXY_THEME_URI . 'vendor/oxygenna/oxygenna-mega-menu/');

if (!class_exists('OxygennaMegaMenu')) {

    require_once(OXY_MEGA_MENU_DIR . 'inc/OxygennaMegaMenu.php');
    require_once(OXY_MEGA_MENU_DIR . 'walkers/FrontendBootstrapMegaMenuWalker.php');

    OxygennaMegaMenu::instance();
}
