<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Orderexport_Block_Adminhtml_Sales_Creditmemo_Grid extends Mage_Adminhtml_Block_Sales_Creditmemo_Grid {

    /**
     * Prepare mass action controls
     *
     * @return Uni_Orderexport_Block_Adminhtml_Sales_Creditmemo_Grid
     */
    protected function _prepareMassaction() {
        parent::_prepareMassaction();

        $this->getMassactionBlock()->addItem('creditmemoexport', array(
            'label' => Mage::helper('sales')->__('Export Creditmemos'),
            'url' => $this->getUrl('*/adminhtml_export/creditmemoExport'),
            'additional' => array(
                'visibility' => array(
                    'name' => 'profiles',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('orderexport')->__('Profiles'),
                    'values' => Uni_Orderexport_Block_Adminhtml_Sales_Creditmemo_Grid::getOptionArray2(),
                )
            )
        ));
    }

    /**
     * Create options for Creditmemoes csv, xml 
     * 
     * @return array
     */
    static public function getOptionArray2() {
        $data_array = array();
        $data_array[Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_CSV] = 'Export Creditmemoes (sample csv format)';
        $data_array[Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_XML] = 'Export Creditmemoes (sample xml format)';
        return($data_array);
    }

}
