<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */

class Uni_Orderexport_Block_Adminhtml_Export extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = "adminhtml_orderexport";   /*path to grid class folder in Block*/
        $this->_blockGroup = "orderexport";     /*it is module name*/
        $this->_headerText = Mage::helper('orderexport')->__('Manage Export History');
        parent::__construct();
        $this->_removeButton('add');
    }
}
