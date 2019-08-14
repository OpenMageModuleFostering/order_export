<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */

class Uni_Orderexport_Model_Orderexport extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('orderexport/orderexport');
    }
}
