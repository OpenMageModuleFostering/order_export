<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Orderexport_Adminhtml_SalesexportController extends Mage_Adminhtml_Controller_Action {

    /**
     *  @return Shows manual export form.
     */
    public function manualExportAction() {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('orderexport/adminhtml_orderexport'));
        $this->renderLayout();
    }

    /**
     *  Checks selected profile to run.
     */
    public function allExportAction() {
        $data = $this->getRequest()->getPost();
        $_option = $data['profiles'];
        switch ($_option) {
            case 1:
                if ($this->orderValidate($data)) {
                    $this->orderExport($data, $_option);
                }break;
            case 2:
                if ($this->orderValidate($data)) {
                    $this->orderExport($data, $_option);
                }break;
            case 3:
                if ($this->invoiceValidate($data)) {
                    $this->invoiceExport($data, $_option);
                }break;
            case 4:
                if ($this->invoiceValidate($data)) {
                    $this->invoiceExport($data, $_option);
                }break;
            case 5:
                if ($this->shipmentValidate($data)) {
                    $this->shipmentExport($data, $_option);
                }break;
            case 6:
                if ($this->shipmentValidate($data)) {
                    $this->shipmentExport($data, $_option);
                }break;
            case 7:
                if ($this->creditmemoValidate($data)) {
                    $this->creditmemoExport($data, $_option);
                } break;
            case 8:
                if ($this->creditmemoValidate($data)) {
                    $this->creditmemoExport($data, $_option);
                }break;
            case 10:
                if ($this->customerValidate($data)) {
                    $this->customerExport($data, $_option);
                }break;
            case 11:
                if ($this->customerValidate($data)) {
                    $this->customerExport($data, $_option);
                }break;
            default:
                break;
        }
    }

    /**
     * 
     * Checks entered order ids are valid or not.

     * @param array $data manual export post data
     */
    public function orderValidate($data) {
        $collection1 = Mage::getModel('sales/order')->getCollection()
                ->addAttributeToFilter('increment_id', $data['starting_id'])
                ->getData();
        $collection2 = Mage::getModel('sales/order')->getCollection()
                ->addAttributeToFilter('increment_id', $data['ending_id'])
                ->getData();

        if (empty($collection1)) {

            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Starting ID is not valid. Please enter valid Order ID'));
            $this->_redirectReferer();
            return false;
        } elseif (empty($collection2)) {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Ending ID is not valid. Please enter valid Order ID'));
            $this->_redirectReferer();
            return false;
        } elseif (!empty($collection1) && !empty($collection2)) {
            if ($data['starting_id'] > $data['ending_id']) {
                Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Starting Order ID is greater than Ending Order ID'));
                $this->_redirectReferer();
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     *  Exports csv and xml format of orders.
     * @param array $data manual export post data
     * @param string $_option export type id
     */
    public function orderExport($data, $_option) {
        $ids = array();
        $collection = Mage::getModel('sales/order')->getCollection();
        $collection->addAttributeToSelect('entity_id')
                ->addAttributeToFilter('increment_id', array(
                    'from' => $data['starting_id'],
                    'to' => $data['ending_id']
        ));
        foreach ($collection->getData() as $key => $value) {
            $ids[] = $value['entity_id'];
        }
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_CSV) {
            $file = 'order_export_' . date("Ymd_His") . '.csv';
            $content = Mage::getModel('orderexport/export_OrderExportCsv')->exportOrderCsv($ids);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_XML) {
            $file = 'order_export_' . date("Ymd_His") . '.xml';
            $content = Mage::getModel('orderexport/export_OrderExportCsv')->exportOrderExcel($ids);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        }
    }

    /**
     *  Checks entered invoice ids are valid or not.
     *  @param array $data manual export post data
     */
    public function invoiceValidate($data) {
        $collection1 = Mage::getModel('sales/order_invoice')->getCollection()
                ->addAttributeToFilter('increment_id', $data['starting_id'])
                ->getData();
        $collection2 = Mage::getModel('sales/order_invoice')->getCollection()
                ->addAttributeToFilter('increment_id', $data['ending_id'])
                ->getData();

        if (empty($collection1)) {

            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Starting ID is not valid. Please enter valid Order ID'));
            $this->_redirectReferer();
            return false;
        } elseif (empty($collection2)) {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Ending ID is not valid. Please enter valid Order ID'));
            $this->_redirectReferer();
            return false;
        } elseif (!empty($collection1) && !empty($collection2)) {
            if ($data['starting_id'] > $data['ending_id']) {
                Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Starting Order ID is greater than Ending Order ID'));
                $this->_redirectReferer();
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     *  Exports csv and xml format of invoices.
     * @param array $data manual export post data
     * @param string $_option export type id
     */
    public function invoiceExport($data, $_option) {
        $ids = array();
        $collection = Mage::getModel('sales/order_invoice')->getCollection();
        $collection->addAttributeToSelect('entity_id')
                ->addAttributeToFilter('increment_id', array(
                    'from' => $data['starting_id'],
                    'to' => $data['ending_id']
        ));
        foreach ($collection->getData() as $key => $value) {
            $ids[] = $value['entity_id'];
        }
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_XML) {
            $file = 'invoice_export_' . date("Ymd_His") . '.xml';
            $content = Mage::getModel('orderexport/export_InvoiceExportCsv')->exportInvoiceExcel($ids);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_CSV) {
            $file = 'invoice_export_' . date("Ymd_His") . '.csv';
            $content = Mage::getModel('orderexport/export_InvoiceExportCsv')->exportInvoiceCsv($ids);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        }
    }

    /**
     *  Checks entered shipment ids are valid or not.
     * @param array $data manual export post data
     */
    public function shipmentValidate($data) {
        $collection1 = Mage::getModel('sales/order_shipment')->getCollection()
                ->addAttributeToFilter('increment_id', $data['starting_id'])
                ->getData();
        $collection2 = Mage::getModel('sales/order_shipment')->getCollection()
                ->addAttributeToFilter('increment_id', $data['ending_id'])
                ->getData();
        if (empty($collection1)) {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Starting ID is not valid. Please enter valid Order ID'));
            $this->_redirectReferer();
            return false;
        } elseif (empty($collection2)) {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Ending ID is not valid. Please enter valid Order ID'));
            $this->_redirectReferer();
            return false;
        } elseif (!empty($collection1) && !empty($collection2)) {
            if ($data['starting_id'] > $data['ending_id']) {
                Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Starting Order ID is greater than Ending Order ID'));
                $this->_redirectReferer();
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     *  Exports csv and xml format of shipments.
     * @param array $data manual export post data
     * @param string $_option export type id
     */
    public function shipmentExport($data, $_option) {
        $ids = array();
        $collection = Mage::getModel('sales/order_shipment')->getCollection();
        $collection->addAttributeToSelect('entity_id')
                ->addAttributeToFilter('increment_id', array(
                    'from' => $data['starting_id'],
                    'to' => $data['ending_id']
        ));
        foreach ($collection->getData() as $key => $value) {
            $ids[] = $value['entity_id'];
        }
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_XML) {
            $file = 'shipment_export_' . date("Ymd_His") . '.xml';
            $content = Mage::getModel('orderexport/export_ShipmentExportCsv')->exportShipmentExcel($ids);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_CSV) {
            $file = 'shipment_export_' . date("Ymd_His") . '.csv';
            $content = Mage::getModel('orderexport/export_ShipmentExportCsv')->exportShipmentCsv($ids);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        }
    }

    /**
     * Checks entered creditmemo ids are valid or not.
     * @param array $data manual export post data
     */
    public function creditmemoValidate($data) {
        $collection1 = Mage::getModel('sales/order_creditmemo')->getCollection()
                ->addAttributeToFilter('increment_id', $data['starting_id'])
                ->getData();
        $collection2 = Mage::getModel('sales/order_creditmemo')->getCollection()
                ->addAttributeToFilter('increment_id', $data['ending_id'])
                ->getData();

        if (empty($collection1)) {

            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Starting ID is not valid. Please enter valid Order ID'));
            $this->_redirectReferer();
            return false;
        } elseif (empty($collection2)) {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Ending ID is not valid. Please enter valid Order ID'));
            $this->_redirectReferer();
            return false;
        } elseif (!empty($collection1) && !empty($collection2)) {
            if ($data['starting_id'] > $data['ending_id']) {
                Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Starting Order ID is greater than Ending Order ID'));
                $this->_redirectReferer();
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Exports csv and xml format of creditmemos.
     * @param array $data manual export post data
     * @param string $_option export type id
     */
    public function creditmemoExport($data, $_option) {
        $ids = array();
        $collection = Mage::getModel('sales/order_creditmemo')->getCollection();
        $collection->addAttributeToSelect('entity_id')
                ->addAttributeToFilter('increment_id', array(
                    'from' => $data['starting_id'],
                    'to' => $data['ending_id']
        ));
        foreach ($collection->getData() as $key => $value) {
            $ids[] = $value['entity_id'];
        }
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_XML) {
            $file = 'creditmemo_export_' . date("Ymd_His") . '.xml';
            $content = Mage::getModel('orderexport/export_CreditmemoExportCsv')->exportCreditmemoExcel($ids);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_CSV) {
            $file = 'creditmemo_export_' . date("Ymd_His") . '.csv';
            $content = Mage::getModel('orderexport/export_CreditmemoExportCsv')->exportCreditmemoCsv($ids);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        }
    }

    /**
     * Checks entered customer ids are valid or not.
     * @param array $data manual export post data
     */
    public function customerValidate($data) {
        $collection1 = Mage::getModel('customer/customer')->getCollection();
        $collection1 = Mage::getModel('customer/customer')->getCollection()
                ->addAttributeToFilter('entity_id', $data['starting_id'])
                ->getData();
        $collection2 = Mage::getModel('customer/customer')->getCollection()
                ->addAttributeToFilter('entity_id', $data['ending_id'])
                ->getData();

        if (empty($collection1)) {

            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Starting ID is not valid. Please enter valid Order ID'));
            $this->_redirectReferer();
            return false;
        } elseif (empty($collection2)) {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Ending ID is not valid. Please enter valid Order ID'));
            $this->_redirectReferer();
            return false;
        } elseif (!empty($collection1) && !empty($collection2)) {
            if ($data['starting_id'] > $data['ending_id']) {
                Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Starting Order ID is greater than Ending Order ID'));
                $this->_redirectReferer();
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Exports csv and xml format of customers.
     * @param array $data manual export post data
     * @param string $_option export type id
     */
    public function customerExport($data, $_option) {
        $ids = array();
        $collection = Mage::getModel('customer/customer')->getCollection();

        $collection->addAttributeToSelect('entity_id')
                ->addAttributeToFilter('entity_id', array(
                    'from' => $data['starting_id'],
                    'to' => $data['ending_id']
        ));
        foreach ($collection->getData() as $key => $value) {
            $ids[] = $value['entity_id'];
        }
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_XML) {
            $file = 'customer_export_' . date("Ymd_His") . '.xml';
            $content = Mage::getModel('orderexport/export_CustomerExportCsv')->exportCustomerExcel($ids);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_CSV) {
            $file = 'customer_export_' . date("Ymd_His") . '.csv';
            $content = Mage::getModel('orderexport/export_CustomerExportCsv')->exportCustomerCsv($ids);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        }
    }

    /**
     * Upload exported file to primary ftp if enabled from backend.
     * @param string $fileName name of exported file.
     * @param string $_option export type id.
     */
    public function customFtpOne($fileName, $_option) {
        $host = Mage::getStoreConfig('ftpexport/primary_ftp/host');
        $ftp_path = Mage::getStoreConfig('ftpexport/primary_ftp/updir');
        $username = Mage::getStoreConfig('ftpexport/primary_ftp/username');
        $pass = Mage::getStoreConfig('ftpexport/primary_ftp/password');
        $port = Mage::getStoreConfig('ftpexport/primary_ftp/port');
        $timeout = Mage::getStoreConfig('ftpexport/primary_ftp/timeout');
        $localpath = '';
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_XML) {
            $localpath = Mage::getBaseDir('var') . DS . 'export' . DS . 'order' . DS . $fileName;
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_XML || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_PDF) {
            $localpath = Mage::getBaseDir('var') . DS . 'export' . DS . 'invoice' . DS . $fileName;
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_XML) {
            $localpath = Mage::getBaseDir('var') . DS . 'export' . DS . 'shipment' . DS . $fileName;
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_XML) {
            $localpath = Mage::getBaseDir('var') . DS . 'export' . DS . 'creditmemo' . DS . $fileName;
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_XML) {
            $localpath = Mage::getBaseDir('var') . DS . 'export' . DS . 'customer' . DS . $fileName;
        }
        try {
            if ($ftp_path && $username && $pass && $host) {
                $conn = ftp_connect($host, $port ? $port : '21', $timeout ? $timeout : '90');
                ftp_login($conn, $username, $pass);
                ftp_chdir($conn, $ftp_path);
                ftp_pasv($conn, true);
                chmod($ftp_path, 0777);
                ftp_chmod($conn, 0777, $fileName);
                $upload = ftp_put($conn, $fileName, $localpath, FTP_BINARY);
                if (!$upload) {
                    Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('File' . $fileName . ' failed to upload on primnary FTP.'));
                }
                ftp_close($conn);
            } else {
                Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Please check the credentials values of FTP is correctly set or not'));
                $this->_redirectReferer();
            }
        } catch (Exception $exc) {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Something went wrong. File has not been uploaded successfully'));
            $this->_redirectReferer();
        }
    }

    /**
     * Upload exported file to secondary ftp if enabled from backend.
     * @param string $fileName name of exported file.
     * @param string $_option export type id.
     */
    public function customFtpTwo($fileName, $_option) {
        $host = Mage::getStoreConfig('ftpexport/secondary_ftp/host');
        $ftp_path = Mage::getStoreConfig('ftpexport/secondary_ftp/updir');
        $username = Mage::getStoreConfig('ftpexport/secondary_ftp/username');
        $pass = Mage::getStoreConfig('ftpexport/secondary_ftp/password');
        $port = Mage::getStoreConfig('ftpexport/secondary_ftp/port');
        $timeout = Mage::getStoreConfig('ftpexport/secondary_ftp/timeout');
        $localpath = '';
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_XML) {
            $localpath = Mage::getBaseDir('var') . DS . 'export' . DS . 'order' . DS . $fileName;
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_XML || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_PDF) {
            $localpath = Mage::getBaseDir('var') . DS . 'export' . DS . 'invoice' . DS . $fileName;
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_XML) {
            $localpath = Mage::getBaseDir('var') . DS . 'export' . DS . 'shipment' . DS . $fileName;
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_XML) {
            $localpath = Mage::getBaseDir('var') . DS . 'export' . DS . 'creditmemo' . DS . $fileName;
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_XML) {
            $localpath = Mage::getBaseDir('var') . DS . 'export' . DS . 'customer' . DS . $fileName;
        }
        try {
            if ($ftp_path && $username && $pass && $host) {
                $conn = ftp_connect($host, $port ? $port : '21', $timeout ? $timeout : '90');
                ftp_login($conn, $username, $pass);
                ftp_chdir($conn, $ftp_path);
                ftp_pasv($conn, true);
                chmod($ftp_path, 0777);
                ftp_chmod($conn, 0777, $fileName);
                $upload = ftp_put($conn, $fileName, $localpath, FTP_BINARY);
                if (!$upload) {
                    Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('File' . $fileName . ' failed to upload on secondary ftp.'));
                    $this->_redirectReferer();
                }
                ftp_close($conn);
            } else {
                Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Please check the credentials values of FTP is correctly set or not'));
                $this->_redirectReferer();
            }
        } catch (Exception $exc) {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Something went wrong. File has not been uploaded successfully'));
            $this->_redirectReferer();
        }
    }

    /**
     * Declare headers and content file in response for file download
     *
     * @param string $fileName
     * @param string|array $content set to null to avoid starting output, $contentLength should be set explicitly in
     *                              that case
     * @param string $contentType
     * @param int $contentLength    explicit content length, if strlen($content) isn't applicable
     * @return Mage_Core_Controller_Varien_Action
     */
    protected function _prepareDownloadResponses(
    $fileName, $content, $_option, $contentType = 'application/octet-stream', $contentLength = null) {
        $session = Mage::getSingleton('admin/session');
        if ($session->isFirstPageAfterLogin()) {
            $this->_redirect($session->getUser()->getStartupPageUrl());
            return $this;
        }

        $isFile = false;
        $file = null;
        if (is_array($content)) {
            if (!isset($content['type']) || !isset($content['value'])) {
                return $this;
            }
            if ($content['type'] == 'filename') {
                $isFile = true;
                $file = $content['value'];
                $contentLength = filesize($file);
                if (Mage::getStoreConfig('ftpexport/primary_ftp/enable') == 1) {
                    $this->customFtpOne($fileName, $_option);
                }
                if (Mage::getStoreConfig('ftpexport/secondary_ftp/enable') == 1) {
                    $this->customFtpTwo($fileName, $_option);
                }
                Mage::helper('orderexport')->sendMail($fileName, $_option); /* send invoice mail */
            }
        }

        $this->getResponse()
                ->setHttpResponseCode(200)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
                ->setHeader('Content-type', $contentType, true)
                ->setHeader('Content-Length', is_null($contentLength) ? strlen($content) : $contentLength, true)
                ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"', true)
                ->setHeader('Last-Modified', date('r'), true);


        if (!is_null($content)) {
            if ($isFile) {
                $this->getResponse()->clearBody();
                $this->getResponse()->sendHeaders();

                $ioAdapter = new Varien_Io_File();
                $ioAdapter->open(array('path' => $ioAdapter->dirname($file)));
                $ioAdapter->streamOpen($file, 'r');
                while ($buffer = $ioAdapter->streamRead()) {
                    print $buffer;
                }
                $ioAdapter->streamClose();
                if (!empty($content['rm'])) {
                    $ioAdapter->rm($file);
                }
                exit(0);
            } else {
                $this->getResponse()->setBody($content);
            }
        }
        return $this;
    }

}
