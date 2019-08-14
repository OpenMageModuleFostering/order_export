<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */
?>

<?php

class Uni_Orderexport_Block_Adminhtml_Orderexport_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * 
     * @return form for manual export.
     */
    
    protected function _prepareForm() {

        $_value = '';
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/adminhtml_salesexport/allExport', array()),
            'method' => 'post',
        ));
        $fieldset = $form->addFieldset('manualexport', array('legend' => Mage::helper('orderexport')->__('Order Export')));

        $fieldset->addField('profiles', 'select', array(
            'name' => 'profiles',
            'label' => Mage::helper('orderexport')->__('Profiles'),
            'required' => true,
            'name' => 'profiles',
            'value' => '',
            'values' => Uni_Orderexport_Helper_Data::getExportProfile(),
        ));
        $fieldset->addField('starting_id', 'text', array(
            'name' => 'starting_id',
            'label' => Mage::helper('orderexport')->__('Starting ID'),
            'required' => true,
        ));
        $fieldset->addField('ending_id', 'text', array(
            'name' => 'ending_id',
            'label' => Mage::helper('orderexport')->__('Ending ID'),
            'required' => true,
        ));
        $fieldset->addField('submit', 'submit', array(
            'type' => 'submit',
            'class' => 'scalable',
            'value' => 'Export',
            'tabindex' => 1
        ));

        if (Mage::getSingleton('adminhtml/session')->getOrderexportData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getOrderexportData());
            Mage::getSingleton('adminhtml/session')->setOrderexportData(null);
        } elseif (Mage::registry('orderexport_data')) {
            $form->setValues(Mage::registry('orderexport_data')->getData());
        }
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
