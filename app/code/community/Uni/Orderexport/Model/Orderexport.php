<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

class Uni_Orderexport_Model_Orderexport extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('orderexport/orderexport');
    }
}
