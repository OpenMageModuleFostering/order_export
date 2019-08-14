<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */
class Uni_Orderexport_Model_Export_CustomerExportCsv {

    protected $_list = null;

    /**
     * 
     * @param Object $collection 
     */
    public function setList($collection) {
        $this->_list = $collection;
    }

    /**
     * 
     * @param array $customerIds selected customer ids
     * @return array
     */
    protected function _getCsvHeaders($customerIds) {
        $customer = current($customerIds);
        $headers = array_keys($customer->getData());
        return $headers;
    }

    /**
     * 
     * @param array $customerIds selected customer ids
     * @return array
     */
    protected function _getXmlHeaders($customerIds) {
        $headers = array();
        $customer = current($customerIds);
        $headers = array_keys($customer->getData());
        return $headers;
    }

    /**
     * 
     * @param array $customerIds selected customer ids
     * @return array
     */
    public function exportCustomerCsv($customerIds) {
        $collection = Mage::getModel('customer/customer')->getCollection()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('entity_id', array('in' => array($customerIds)));
        $this->setList($collection);
        if (!is_null($this->_list)) {
            $items = $this->_list->getItems();
            if (count($items) > 0) {

                $io = new Varien_Io_File();
                $path = Mage::getBaseDir('var') . DS . 'export' . DS . 'customer';
                $name = 'customer_export_' . date("Ymd_His");
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
     * @param array $customerIds selected customer ids
     * @return array
     */
    public function exportCustomerExcel($customerIds) {
        $collection = Mage::getModel('customer/customer')->getCollection()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('entity_id', array('in' => array($customerIds)));
        $this->setList($collection);
        if (!is_null($this->_list)) {
            $items = $this->_list->getItems();
            if (count($items) > 0) {
                $parser = new Varien_Convert_Parser_Xml_Excel();
                $io = new Varien_Io_File();
                $path = Mage::getBaseDir('var') . DS . 'export' . DS . 'customer';
                $name = 'customer_export_' . date("Ymd_His");
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
