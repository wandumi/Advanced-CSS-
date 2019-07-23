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

class OxygennaPHPCheck extends OxygennaSystemCheck
{
    private $args;

    public function __construct($args)
    {
        $this->args = $args;
        parent::__construct(__('PHP', 'lambda-admin-td') . ' - ' . $this->args['var']);
    }

    public function check()
    {
        $this->value = ini_get($this->args['var']);
        $this->ok = $this->condition($this->value, $this->args['compare'], $this->args['value']);
        // add extra info if not ok
        if (!$this->ok) {
             $this->info = sprintf(__('We recommend setting %s to at least %s. See: <a href="%s">Increasing memory allocated to PHP</a>', 'lambda-admin-td'),$this->args['var'], $this->args['value'], 'http://php.net/manual/en/configuration.changes.php') . '</span>';
        }
    }
}
