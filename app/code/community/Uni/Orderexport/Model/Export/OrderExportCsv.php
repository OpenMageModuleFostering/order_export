<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */
class Uni_Orderexport_Model_Export_OrderExportCsv {

    const EXPORT_ORDER_CSV = 1;
    const EXPORT_ORDER_XML = 2;
    const EXPORT_INVOICE_CSV = 3;
    const EXPORT_INVOICE_XML = 4;
    const EXPORT_SHIPMENT_CSV = 5;
    const EXPORT_SHIPMENT_XML = 6;
    const EXPORT_CREDITMEMO_CSV = 7;
    const EXPORT_CREDITMEMO_XML = 8;
    const EXPORT_INVOICE_PDF = 9;
    const EXPORT_CUSTOMER_CSV=10;
    const EXPORT_CUSTOMER_XML=11;

    protected $_list = null;

    /**
     * 
     * @param object $collection 
     */
    public function setList($collection) {
        $this->_list = $collection;
    }

    /**
     * 
     * @param array $orders selected order ids
     * @return array
     */
    protected function _getCsvHeaders($orders) {
        $order = current($orders);
        $headers = array_keys($order->getData());
        return $headers;
    }

    /**
     * 
     * @param array $orders selected order ids
     * @return array
     */
    protected function _getXmlHeaders($orders) {
        $headers = array();
        $order = current($orders);
        $headers = array_keys($order->getData());
        return $headers;
    }

    /**
     * 
     * @param array $orders selected order ids
     * @return array
     */
    public function exportOrderCsv($orders) {
        $collection = Mage::getModel('sales/order')->getCollection()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('entity_id', array('in' => array($orders)));
        $this->setList($collection);
        if (!is_null($this->_list)) {
            $items = $this->_list->getItems();
            if (count($items) > 0) {

                $io = new Varien_Io_File();
                $path = Mage::getBaseDir('var') . DS . 'export' . DS . 'order';
                $name = 'order_export_' . date("Ymd_His");
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
     * @param array $orders selected order ids
     * @return array
     */
    public function exportOrderExcel($orders) {
        $collection = Mage::getModel('sales/order')->getCollection()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('entity_id', array('in' => array($orders)));
        $this->setList($collection);
        if (!is_null($this->_list)) {
            $items = $this->_list->getItems();
            if (count($items) > 0) {
                $parser = new Varien_Convert_Parser_Xml_Excel();
                $io = new Varien_Io_File();
                $path = Mage::getBaseDir('var') . DS . 'export' . DS . 'order';
                $name = 'order_export_' . date("Ymd_His");
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
