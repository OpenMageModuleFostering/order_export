<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Orderexport_Block_Adminhtml_Sales_Shipment_Grid extends Mage_Adminhtml_Block_Sales_Shipment_Grid {

    /**
     * 
     * @return Uni_Orderexport_Block_Adminhtml_Sales_Shipment_Grid
     */
    protected function _prepareMassaction() {
        parent::_prepareMassaction();

        $this->getMassactionBlock()->addItem('shipmentexport', array(
            'label' => Mage::helper('sales')->__('Export Shipments'),
            'url' => $this->getUrl('*/adminhtml_export/shipmentExport'),
            'additional' => array(
                'visibility' => array(
                    'name' => 'profiles',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('orderexport')->__('Profiles'),
                    'values' => Uni_Orderexport_Block_Adminhtml_Sales_Shipment_Grid::getOptionArray2(),
                )
            )
        ));
    }

    /**
     * Create options for Shipment csv, xml 
     * 
     * @return array
     */
    static public function getOptionArray2() {
        $data_array = array();
        $data_array[Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_CSV] = 'Export Shipment (sample csv format)';
        $data_array[Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_XML] = 'Export Shipment (sample xml format)';
        return($data_array);
    }

}
