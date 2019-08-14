<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
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
