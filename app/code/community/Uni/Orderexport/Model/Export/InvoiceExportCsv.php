<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Orderexport_Model_Export_InvoiceExportCsv {

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
     * @param array $invoices selected invoice ids
     * @return array
     */
    protected function _getCsvHeaders($invoices) {
        $invoice = current($invoices);
        $headers = array_keys($invoice->getData());
        return $headers;
    }

    /**
     * 
     * @param array $invoices selected invoice ids
     * @return array
     */
    protected function _getXmlHeaders($invoices) {
        $headers = array();
        $invoice = current($invoices);
        $headers = array_keys($invoice->getData());
        return $headers;
    }

    /**
     * 
     * @param array $invoices selected invoice ids
     * @return array
     */
    public function exportInvoiceCsv($invoices) {
        $collection = Mage::getModel('sales/order_invoice')->getCollection()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('entity_id', array('in' => array($invoices)));
        $this->setList($collection);
        if (!is_null($this->_list)) {
            $items = $this->_list->getItems();
            if (count($items) > 0) {

                $io = new Varien_Io_File();
                $path = Mage::getBaseDir('var') . DS . 'export' . DS . 'invoice';
                $name = 'invoice_export_' . date("Ymd_His");
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
     * @param array $invoices selected invoice ids
     * @return array
     */
    public function exportInvoiceExcel($invoices) {
        $collection = Mage::getModel('sales/order_invoice')->getCollection()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('entity_id', array('in' => array($invoices)));
        $this->setList($collection);
        if (!is_null($this->_list)) {
            $items = $this->_list->getItems();
            if (count($items) > 0) {
                $parser = new Varien_Convert_Parser_Xml_Excel();
                $io = new Varien_Io_File();
                $path = Mage::getBaseDir('var') . DS . 'export' . DS . 'invoice';
                $name = 'invoice_export_' . date("Ymd_His");
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
