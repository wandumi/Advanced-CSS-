<?php
/**
 * One Click System Check
 *
 * @package One Click Installer
 * @subpackage Admin
 *
 * @copyright (c) 2015 Oxygenna.com
 * @license **LICENSE**
 * @version 1.38.0
 * @author Oxygenna.com
 */

require_once OXY_ONECLICK_DIR . 'inc/OxygennaSystemCheck.php';

class OxygennaFSockCheck extends OxygennaSystemCheck
{
    public function __construct($args)
    {
        parent::__construct(__('PHP cURL & fsock', 'lambda-admin-td'));
    }

    public function check()
    {
        if (function_exists('fsockopen') || function_exists('curl_init')) {
            if (function_exists('fsockopen') && function_exists('curl_init')) {
                $this->info = __('Your server has fsockopen and cURL enabled.', 'lambda-admin-td');
                $this->value = 'fsockopen & cURL';
            } elseif (function_exists('fsockopen')) {
                $this->info = __('Your server has fsockopen enabled, cURL is disabled.', 'lambda-admin-td');
                $this->value = 'fsockopen';
            } else {
                $this->info = __('Your server has cURL enabled, fsockopen is disabled.', 'lambda-admin-td');
                $this->value = 'cURL';
            }
            $this->ok = true;
        } else {
            $this->value = 'None';
            $this->info = __('Your server does not have fsockopen or cURL enabled - Demo content images will not be able to download. Contact your hosting provider.', 'lambda-admin-td'). '</mark>';
        }
    }
}
