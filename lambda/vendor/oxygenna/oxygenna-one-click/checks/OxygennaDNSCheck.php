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

class OxygennaDNSCheck extends OxygennaSystemCheck
{
    private $args;

    public function __construct($args)
    {
        $this->args = $args;
        parent::__construct(__('DNS Lookup', 'lambda-admin-td'), 'warning');
    }

    public function check()
    {
        if (function_exists('gethostbyname')) {
            $ip = gethostbyname($this->args['domain']);

            $this->ok = $ip !== $this->args['domain'];
            $this->value = $ip;
            if ($this->ok) {
                $this->info = __('Your server can lookup ' . $this->args['domain'], 'lambda-admin-td');
            } else {
                $this->info = __('Your server can NOT lookup ' . $this->args['domain'], 'lambda-admin-td');
            }
        }
    }
}
