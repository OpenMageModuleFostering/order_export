<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */
class Uni_Orderexport_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * 
     * @return array of export profiles
     */
    public static function getExportProfile() {
        return array(
            '' => Mage::helper('orderexport')->__('--Select Profile--'),
            '9' => array(
                'value' => array(
                    array('value' => '1', 'label' => Mage::helper('orderexport')->__('Export Orders (sample csv format)')),
                    array('value' => '2', 'label' => Mage::helper('orderexport')->__('Export Orders (sample xml format)'))),
                'label' => Mage::helper('orderexport')->__('Order Export'),
            ),
            '10' => array(
                'value' => array(
                    array('value' => '3', 'label' => Mage::helper('orderexport')->__('Export Invoices (sample csv format)')),
                    array('value' => '4', 'label' => Mage::helper('orderexport')->__('Export Invoices (sample xml format)'))),
                'label' => Mage::helper('orderexport')->__('Invoice Export'),
            ),
            '11' => array(
                'value' => array(
                    array('value' => '5', 'label' => Mage::helper('orderexport')->__('Export Shipments (sample csv format)')),
                    array('value' => '6', 'label' => Mage::helper('orderexport')->__('Export Shipments (sample xml format)'))),
                'label' => Mage::helper('orderexport')->__('Shipment Export'),
            ),
            '12' => array(
                'value' => array(
                    array('value' => '7', 'label' => Mage::helper('orderexport')->__('Export Creditmemoes (sample csv format)')),
                    array('value' => '8', 'label' => Mage::helper('orderexport')->__('Export Creditmemoes (sample xml format)'))),
                'label' => Mage::helper('orderexport')->__('Creditmemo Export'),
            ),
            '13' => array(
                'value' => array(
                    array('value' => '10', 'label' => Mage::helper('orderexport')->__('Export Customers (sample csv format)')),
                    array('value' => '11', 'label' => Mage::helper('orderexport')->__('Export Customers (sample xml format)'))),
                'label' => Mage::helper('orderexport')->__('Customer Export'),
            ),
        );
    }

    /**
     * 
     * @return array of export profiles for grid
     */
    public static function getEntity() {
        return array(
            Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_CSV => Mage::helper('orderexport')->__('Order CSV'),
            Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_XML => Mage::helper('orderexport')->__('Order XML'),
            Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_CSV => Mage::helper('orderexport')->__('Invoice CSV'),
            Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_XML => Mage::helper('orderexport')->__('Invoice XML'),
            Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_CSV => Mage::helper('orderexport')->__('Shipment CSV'),
            Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_XML => Mage::helper('orderexport')->__('Shipment XML'),
            Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_CSV => Mage::helper('orderexport')->__('Creditmemoe CSV'),
            Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_XML => Mage::helper('orderexport')->__('Creditmemoe XML'),
            Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_CSV => Mage::helper('orderexport')->__('Customer CSV'),
            Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_XML => Mage::helper('orderexport')->__('Customer XML'),
        );
    }

    /** 
     * send email with exported file attachment 
     * @param string $file 
     * @param string $_option
     * @return boolean
     */
    public function sendMail($file, $_option) {
        $emailTemplate = Mage::getModel('core/email_template')->loadDefault('orderexport_email_email_template');
        $recipientEmail = '';
        $recipientName = '';
        $attachmentFilePath = '';
        if ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_XML) {
            $attachmentFilePath = Mage::getBaseDir('var') . DS . 'export' . DS . 'order' . DS . $file;
            $recipientEmail = Mage::getStoreConfig('orderexport/order_email/order_export_email');
            $recipientName = Mage::getStoreConfig('orderexport/order_email/order_export_name');
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_XML || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_PDF) {
            $attachmentFilePath = Mage::getBaseDir('var') . DS . 'export' . DS . 'invoice' . DS . $file;
            $recipientEmail = Mage::getStoreConfig('orderexport/invoice_email/invoice_export_email');
            $recipientName = Mage::getStoreConfig('orderexport/invoice_email/invoice_export_name');
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_XML) {
            $attachmentFilePath = Mage::getBaseDir('var') . DS . 'export' . DS . 'shipment' . DS . $file;
            $recipientEmail = Mage::getStoreConfig('orderexport/shipment_email/shipment_export_email');
            $recipientName = Mage::getStoreConfig('orderexport/shipment_email/shipment_export_name');
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_XML) {
            $attachmentFilePath = Mage::getBaseDir('var') . DS . 'export' . DS . 'creditmemo' . DS . $file;
            $recipientEmail = Mage::getStoreConfig('orderexport/creditmemo_email/creditmemo_export_email');
            $recipientName = Mage::getStoreConfig('orderexport/creditmemo_email/creditmemo_export_name');
        } elseif ($_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_CSV || $_option == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_XML) {
            $attachmentFilePath = Mage::getBaseDir('var') . DS . 'export' . DS . 'customer' . DS . $file;
            $recipientEmail = Mage::getStoreConfig('orderexport/customer_email/customer_export_email');
            $recipientName = Mage::getStoreConfig('orderexport/customer_email/customer_export_name');
        } else {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Oops...??? Something went wrong...!!!'));
            $this->_redirectReferer();
            return false;
        }
        if (file_exists($attachmentFilePath)) {
            $fileContents = file_get_contents($attachmentFilePath);
            $attachment = $emailTemplate->getMail()->createAttachment($fileContents);
            $attachment->filename = $file;
        }
        $emailTemplateVariables = array(
            'name' => Mage::getStoreConfig('trans_email/ident_general/name'),
            'email' => Mage::getStoreConfig('trans_email/ident_general/email')
        );
        try {
            $emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name'));
            $emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email'));
            $emailTemplate->send($recipientEmail, $recipientName, $emailTemplateVariables);
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * save export history
     * @param string $profile
     * @param string $file
     */
    public function saveHistory($profile, $file) {
        $dest = Mage::getBaseDir('var') . DS;
        $profile == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_CSV ? $dest.= 'export' . DS . 'order' : '';
        $profile == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_ORDER_XML ? $dest.= 'export' . DS . 'order' : '';
        $profile == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_CSV ? $dest.= 'export' . DS . 'invoice' : '';
        $profile == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_INVOICE_XML ? $dest.= 'export' . DS . 'invoice' : '';
        $profile == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_CSV ? $dest.= 'export' . DS . 'shipment' : '';
        $profile == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_SHIPMENT_XML ? $dest.= 'export' . DS . 'shipment' : '';
        $profile == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_CSV ? $dest.= 'export' . DS . 'creditmemo' : '';
        $profile == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CREDITMEMO_XML ? $dest.= 'export' . DS . 'creditmemo' : '';
        $profile == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_CSV ? $dest.= 'export' . DS . 'customer' : '';
        $profile == Uni_Orderexport_Model_Export_OrderExportCsv::EXPORT_CUSTOMER_XML ? $dest.= 'export' . DS . 'customer' : '';
        $data = array();
        $data['profile'] = $profile;
        $data['created_time'] = now();
        $data['filename'] = $file;
        $data['destination'] = $dest;
        try {
            $model = Mage::getModel('orderexport/orderexport');
            $model->setData($data);
            $model->save();
        } catch (Exception $exc) {
            Mage::getSingleton('core/session')->addError(Mage::helper('orderexport')->__('Exported report can not be saved due to internet failure'));
        }
    }

}
