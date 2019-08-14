<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Orderexport_Block_Adminhtml_Orderexport extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        $url = Mage::helper('adminhtml')->getUrl('*/export/orderexport');
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'orderexport';
        $this->_controller = 'adminhtml_orderexport';
        $this->_removeButton('delete');
        $this->_removeButton('save');
        $this->_removeButton('back');
        $this->_removeButton('reset');
    }

    /**
     * 
     * @return string
     */
    public function getHeaderText() {
        return Mage::helper('orderexport')->__('Manual Order Export Manager');
    }

}
