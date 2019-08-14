<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
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
