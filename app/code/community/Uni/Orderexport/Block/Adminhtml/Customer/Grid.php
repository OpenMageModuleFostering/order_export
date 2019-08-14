<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Orderexport_Block_Adminhtml_Customer_Grid extends Mage_Adminhtml_Block_Customer_Grid {

    /**
     * Prepare mass action controls
     *
     * @return Uni_Orderexport_Block_Adminhtml_Customer_Grid
     */
    protected function _prepareMassaction() {
        parent::_prepareMassaction();
        $this->getMassactionBlock()->addItem('customerexport', array(
            'label' => Mage::helper('customer')->__('Export Customers'),
            'url' => $this->getUrl('orderexport/adminhtml_export/customerExport'),
            'additional' => array(
                'visibility' => array(
                    'name' => 'profiles',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('orderexport')->__('Profiles'),
                    'values' => Uni_Orderexport_Block_Adminhtml_Customer_Grid::getOptionArray2(),
                )
            )
        ));
    }

    /**
     * Create options for Customers csv, xml 
     * 
     * @return array
     */
    static public function getOptionArray2() {
        $data_array = array();
        $data_array[Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_CSV] = 'Export Customers (sample csv format)';
        $data_array[Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_XML] = 'Export Customers (sample xml format)';
        return($data_array);
    }

}
