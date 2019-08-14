<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */
class Uni_Orderexport_Model_Export_CreditmemoExportCsv {

    protected $_list = null;

    /**
     * 
     * @param array $creditmemos selected creditmemo ids
     * @return array
     */
    public function exportCreditmemoCsv($creditmemos) {
        $collection = Mage::getModel('sales/order_creditmemo')->getCollection()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('entity_id', array('in' => array($creditmemos)));
        $this->setList($collection);
        if (!is_null($this->_list)) {
            $items = $this->_list->getItems();
            if (count($items) > 0) {

                $io = new Varien_Io_File();
                $path = Mage::getBaseDir('var') . DS . 'export' . DS . 'creditmemo';
                $name = 'creditmemo_export_' . date("Ymd_His");
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
                    'rm' => false /* can delete file after use */
                );
            }
        }
    }

    /**
     * 
     * @param Object $collection 
     */
    public function setList($collection) {
        $this->_list = $collection;
    }

    /**
     * 
     * @param array $creditmemos selected creditmemo ids
     * @return array
     */
    protected function _getCsvHeaders($creditmemos) {
        $creditmemo = current($creditmemos);
        $headers = array_keys($creditmemo->getData());
        return $headers;
    }

    /**
     * 
     * @param array $creditmemos selected creditmemo ids
     * @return array
     */
    protected function _getXmlHeaders($creditmemos) {
        $headers = array();
        $creditmemo = current($creditmemos);
        $headers = array_keys($creditmemo->getData());
        return $headers;
    }

    /**
     * 
     * @param array $creditmemos selected creditmemo ids
     * @return array
     */
    public function exportCreditmemoExcel($creditmemos) {
        $collection = Mage::getModel('sales/order_creditmemo')->getCollection()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('entity_id', array('in' => array($creditmemos)));
        $this->setList($collection);
        if (!is_null($this->_list)) {
            $items = $this->_list->getItems();
            if (count($items) > 0) {

                $parser = new Varien_Convert_Parser_Xml_Excel();
                $io = new Varien_Io_File();
                $path = Mage::getBaseDir('var') . DS . 'export' . DS . 'creditmemo';
                $name = 'creditmemo_export_' . date("Ymd_His");
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
