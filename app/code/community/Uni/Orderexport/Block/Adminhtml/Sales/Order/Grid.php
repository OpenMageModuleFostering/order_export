<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */

class Uni_Orderexport_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid {

    /** 
     * @return Uni_Orderexport_Block_Adminhtml_Sales_Order_Grid  
     */
    
    protected function _prepareMassaction() {
        parent::_prepareMassaction();
        $this->getMassactionBlock()->addItem('orderexport', array(
            'label' => Mage::helper('sales')->__('Export orders'),
            'url' => $this->getUrl('orderexport/adminhtml_export/orderExport'),
            'additional' => array(
                'visibility' => array(
                    'name' => 'profiles',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('orderexport')->__('Profiles'),
                    'values' => Uni_Orderexport_Block_Adminhtml_Sales_Order_Grid::getOptionArray2(),
                )
            )
        ));
    }

    
    /**
     * Create options for Order csv, xml 
     * 
     * @return array
     */
    static public function getOptionArray2() {
        $data_array = array();
        $data_array[Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_CSV] = 'Export Order (sample csv format)';
        $data_array[Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_XML] = 'Export Order (sample xml format)';
        return($data_array);
    }

}
