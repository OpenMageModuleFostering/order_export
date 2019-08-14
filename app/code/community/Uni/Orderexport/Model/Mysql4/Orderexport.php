<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */

class Uni_Orderexport_Model_Mysql4_Orderexport extends Mage_Core_Model_Mysql4_Abstract {
    
    public function _construct() {
        $this->_init('orderexport/orderexport','id');
    }
}
