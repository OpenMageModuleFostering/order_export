<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */
class Uni_Orderexport_Block_Adminhtml_Sales_Invoice_Grid extends Mage_Adminhtml_Block_Sales_Invoice_Grid {

    /** 
     * @return Uni_Orderexport_Block_Adminhtml_Sales_Invoice_Grid  
     */
    
    protected function _prepareMassaction() {
        parent::_prepareMassaction();
        $this->getMassactionBlock()->addItem('invoiceexport', array(
            'label' => Mage::helper('sales')->__('Export Invoices'),
            'url' => $this->getUrl('*/adminhtml_export/invoiceExport'),
            'additional' => array(
                'visibility' => array(
                    'name' => 'profiles',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('orderexport')->__('Profiles'),
                    'values' => Uni_Orderexport_Block_Adminhtml_Sales_Invoice_Grid::getOptionArray2(),
                )
            )
        ));
    }

    /**
     * Create options for Invoices csv, xml 
     * 
     * @return array
     */
    static public function getOptionArray2() {
        $data_array = array();
        $data_array[Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_CSV] = 'Export Invoices (sample csv format)';
        $data_array[Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_XML] = 'Export Invoices (sample xml format)';
        return($data_array);
    }

}
