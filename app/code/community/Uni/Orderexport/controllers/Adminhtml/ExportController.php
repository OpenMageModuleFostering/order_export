<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Orderexport_Adminhtml_ExportController extends Mage_Adminhtml_Controller_Action {

    /**
     *  Exports csv and xml format of orders.
     */
    public function orderExportAction() {
        $orders = $this->getRequest()->getPost('order_ids', array());
        $_option = $this->getRequest()->getParam('profiles');
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_XML) {
            $file = 'order_export_' . date("Ymd_His") . '.xml';
            $content = Mage::getModel('orderexport/export_OrderExportCsv')->exportOrderExcel($orders);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_CSV) {
            $file = 'order_export_' . date("Ymd_His") . '.csv';
            $content = Mage::getModel('orderexport/export_OrderExportCsv')->exportOrderCsv($orders);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        }
    }

    /**
     *  Exports csv and xml format of shipment.
     */
    public function shipmentExportAction() {
        $shipments = $this->getRequest()->getPost('shipment_ids', array());
        $_option = $this->getRequest()->getParam('profiles');
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_XML) {
            $file = 'shipment_export_' . date("Ymd_His") . '.xml';
            $content = Mage::getModel('orderexport/export_ShipmentExportCsv')->exportShipmentExcel($shipments);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_CSV) {
            $file = 'shipment_export_' . date("Ymd_His") . '.csv';
            $content = Mage::getModel('orderexport/export_ShipmentExportCsv')->exportShipmentCsv($shipments);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        }
    }

    /**
     *  Exports csv and xml format of invoice.
     */
    public function invoiceExportAction() {
        $invoices = $this->getRequest()->getPost('invoice_ids', array());
        $_option = $this->getRequest()->getParam('profiles');
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_XML) {
            $file = 'invoice_export_' . date("Ymd_His") . '.xml';
            $content = Mage::getModel('orderexport/export_InvoiceExportCsv')->exportInvoiceExcel($invoices);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_CSV) {
            $file = 'invoice_export_' . date("Ymd_His") . '.csv';
            $content = Mage::getModel('orderexport/export_InvoiceExportCsv')->exportInvoiceCsv($invoices);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        }
    }

    /**
     *  Exports csv and xml format of creditmemo.
     */
    public function creditmemoExportAction() {
        $_option = $this->getRequest()->getParam('profiles');
        $creditmemos = $this->getRequest()->getPost('creditmemo_ids', array());
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_XML) {
            $file = 'creditmemo_export_' . date("Ymd_His") . '.xml';
            $content = Mage::getModel('orderexport/export_CreditmemoExportCsv')->exportCreditmemoExcel($creditmemos);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_CSV) {
            $file = 'creditmemo_export_' . date("Ymd_His") . '.csv';
            $content = Mage::getModel('orderexport/export_CreditmemoExportCsv')->exportCreditmemoCsv($creditmemos);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        }
    }

    /**
     *  Exports csv and xml format of customer.
     */
    public function customerExportAction() {
        $_option = $this->getRequest()->getParam('profiles');
        $customerIds = $this->getRequest()->getPost('customer', array());
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_XML) {
            $file = 'customer_export_' . date("Ymd_His") . '.xml';
            $content = Mage::getModel('orderexport/export_CustomerExportCsv')->exportCustomerExcel($customerIds);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_CSV) {
            $file = 'customer_export_' . date("Ymd_His") . '.csv';
            $content = Mage::getModel('orderexport/export_CustomerExportCsv')->exportCustomerCsv($customerIds);
            Mage::helper('orderexport')->saveHistory($_option, $file);
            $this->_prepareDownloadResponses($file, $content, $_option);
        }
    }

    /**
     *  Upload exported file to primary ftp if enabled from backend.
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
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Something went wrong. File has not been uploaded to FTP successfully'));
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
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Something went wrong. File has not been uploaded to FTP successfully'));
            $this->_redirectReferer();
        }
    }

    /**
     * Declare headers and content file in response for file download
     *
     * @param string $fileName
     * @param string|array $content set to null to avoid starting output, $contentLength should be set explicitly in
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
                if (Mage::getStoreConfig('ftpexport/primary_ftp/enable') == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_CSV) {
                    $this->customFtpOne($fileName, $_option);
                }
                if (Mage::getStoreConfig('ftpexport/secondary_ftp/enable') == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_CSV) {
                    $this->customFtpTwo($fileName, $_option);
                }
                Mage::helper('orderexport')->sendMail($fileName, $_option); /* send invoice mail */
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

    /**
     *  Shows history Grid of exported files. 
     */
    public function historyAction() {
        $this->_title($this->__('orderexport'))->_title($this->__('Export History'));
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     *  Download exported files from /var/export folder through grid .
     */
    public function downloadAction() {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('orderexport/orderexport')->load($id);
        if ($model->getId() || $id == 0) {
            try {
                if (file_exists($model['destination'] . DS . $model['filename'])) {
                    $filename = '';
                    if ($model) {
                        $filename = $model['filename'];
                    }
                    $filepath = $model['destination'] . DS . $filename;

                    if (!is_file($filepath) || !is_readable($filepath)) {
                        throw new Exception ();
                    }
                    $this->getResponse()
                            ->setHttpResponseCode(200)
                            ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
                            ->setHeader('Pragma', 'public', true)
                            ->setHeader('Content-type', 'application/force-download')
                            ->setHeader('Content-Length', filesize($filepath))
                            ->setHeader('Content-Disposition', 'attachment' . '; filename=' . basename($filepath));
                    $this->getResponse()->clearBody();
                    $this->getResponse()->sendHeaders();
                    readfile($filepath);
                    exit;
                } else {
                    Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('File ' . $model['filename'] . ' does not exist on the Disk'));
                    $this->_redirectReferer();
                }
            } catch (Exception $exc) {
                Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('File ' . $model['filename'] . ' does not exist on the Disk'));
                $this->_redirectReferer();
            }
        } else {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('File ' . $model['filename'] . ' does not exist on the Disk'));
            $this->_redirectReferer();
        }
    }

    /**
     *  Delete items from grid and from export folder also.
     */
    public function massDeleteAction() {

        $Ids = $this->getRequest()->getParam('orderexport');
        if (!is_array($Ids)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please Choose an Item to Delete'));
        } else {
            try {
                $filename = '';
                $errfile = '';
                $path = '';
                foreach ($Ids as $ids) {
                    $order = Mage::getModel('orderexport/orderexport')->load($ids);
                    $path = $order['destination'];
                    $filename = $order['filename'];
                    $order->delete();
                    if (file_exists($path . DS . $filename)) {
                        unlink($path . DS . $filename);
                        $this->deleteFtpOne($filename);
                        $this->deleteFtpTwo($filename);
                    } else {
                        Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('File ' . $filename . ' does not exist on the Disk'));
                        $this->_redirectReferer();
                    }
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__('Total of %d record(s) successfully deleted', count($Ids))
                );
            } catch (Exception $ex) {
                Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('File ' . $errfile . ' does not exist on the Disk'));
                $this->_redirectReferer();
            }
        }
        $this->_redirect('*/*/history');
    }

    /**
     *  Delete exported file(s) from Primary FTP.
     *  @param string $filename 
     */
    public function deleteFtpOne($filename) {
        $host = Mage::getStoreConfig('ftpexport/primary_ftp/host');
        $ftp_path = Mage::getStoreConfig('ftpexport/primary_ftp/updir');
        $username = Mage::getStoreConfig('ftpexport/primary_ftp/username');
        $pass = Mage::getStoreConfig('ftpexport/primary_ftp/password');
        $port = Mage::getStoreConfig('ftpexport/primary_ftp/port');
        $timeout = Mage::getStoreConfig('ftpexport/primary_ftp/timeout');
        try {
            $conn = ftp_connect($host, $port ? $port : '21', $timeout ? $timeout : '90');
            ftp_login($conn, $username, $pass);
            ftp_delete($conn, $ftp_path . DS . $filename);
            ftp_close($conn);
        } catch (Exception $ex) {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('File ' . $filename . ' does not exist on the ftp'));
            $this->_redirectReferer();
        }
    }

    /**
     *  Delete exported file(s) from Secondary FTP.
     * @param string $filename
     * 
     */
    public function deleteFtpTwo($filename) {
        $host = Mage::getStoreConfig('ftpexport/secondary_ftp/host');
        $ftp_path = Mage::getStoreConfig('ftpexport/secondary_ftp/updir');
        $username = Mage::getStoreConfig('ftpexport/secondary_ftp/username');
        $pass = Mage::getStoreConfig('ftpexport/secondary_ftp/password');
        $port = Mage::getStoreConfig('ftpexport/secondary_ftp/port');
        $timeout = Mage::getStoreConfig('ftpexport/secondary_ftp/timeout');
        try {
            $conn = ftp_connect($host, $port ? $port : '21', $timeout ? $timeout : '90');
            ftp_login($conn, $username, $pass);
            ftp_delete($conn, $ftp_path . DS . $filename);
            ftp_close($conn);
        } catch (Exception $ex) {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('File ' . $filename . ' does not exist on the ftp'));
            $this->_redirectReferer();
        }
    }

}
