<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */
class Uni_Orderexport_Model_Export_ShipmentExportCsv {

    /**
     * 
     * @param object $collection 
     */
    public function setList($collection) {
        $this->_list = $collection;
    }

    /**
     * 
     * @param array $shipments selected shipment ids
     * @return array
     */
    protected function _getCsvHeaders($shipments) {
        $shipment = current($shipments);
        $headers = array_keys($shipment->getData());
        return $headers;
    }

    /**
     * 
     * @param array $shipments selected shipment ids
     * @return array
     */
    protected function _getXmlHeaders($shipments) {
        $headers = array();
        $shipment = current($shipments);
        $headers = array_keys($shipment->getData());
        return $headers;
    }

    /**
     * 
     * @param array $shipments selected shipment ids
     * @return array
     */
    public function exportShipmentCsv($shipments) {
        $collection = Mage::getModel('sales/order_shipment')->getCollection()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('entity_id', array('in' => array($shipments)));
        $this->setList($collection);
        if (!is_null($this->_list)) {
            $items = $this->_list->getItems();
            if (count($items) > 0) {

                $io = new Varien_Io_File();
                $path = Mage::getBaseDir('var') . DS . 'export' . DS . 'shipment';
                $name = 'shipment_export_' . date("Ymd_His");
                $file = $path . DS . $name . '.csv';
                $io->setAllowCreateFolders(true);
                $io->open(array('path' => $path));
                $io->streamOpen($file, 'w+');
                $io->streamLock(true);

                $io->streamWriteCsv($this->_getCsvHeaders($items));
                foreach ($items as $data) {
                    $io->streamWriteCsv($data->getData());
                }

                return array(
                    'type' => 'filename',
                    'value' => $file,
                    'rm' => false
                );
            }
        }
    }

    /**
     * 
     * @param array $shipments selected shipment ids
     * @return array
     */
    public function exportShipmentExcel($shipments) {
        $collection = Mage::getModel('sales/order_shipment')->getCollection()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('entity_id', array('in' => array($shipments)));
        $this->setList($collection);
        if (!is_null($this->_list)) {
            $items = $this->_list->getItems();
            if (count($items) > 0) {
                $parser = new Varien_Convert_Parser_Xml_Excel();
                $io = new Varien_Io_File();
                $path = Mage::getBaseDir('var') . DS . 'export' . DS . 'shipment';
                $name = 'shipment_export_' . date("Ymd_His");
                $file = $path . DS . $name . '.xml';
                $io->setAllowCreateFolders(true);
                $io->open(array('path' => $path));
                $io->streamOpen($file, 'w+');
                $io->streamLock(true);
                $headers = $this->_getXmlHeaders($items);
                $io->streamWrite($parser->getHeaderXml());
                $io->streamWrite($parser->getRowXml($headers));
                $val = $collection->getData();
                foreach ($val as $key => $value) {
                    $parseData = array();
                    foreach ($value as $v) {
                        $parseData[] = (string) $v;
                    }
                    $io->streamWrite($parser->getRowXml($parseData));
                    unset($parseData);
                }
                $io->streamWrite($parser->getFooterXml());
                $io->streamUnlock();
                $io->streamClose();
                return array(
                    'type' => 'filename',
                    'value' => $file,
                    'rm' => false
                );
            }
        }
    }

}
