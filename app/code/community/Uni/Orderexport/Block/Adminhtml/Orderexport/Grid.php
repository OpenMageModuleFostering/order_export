<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */
class Uni_Orderexport_Block_Adminhtml_Orderexport_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('exporthistory');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare  collecttion of exported details.
     * 
     * @return collection
     */
    protected function _prepareCollection() {
        $collection = Mage::getModel('orderexport/orderexport')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return grid of exported details.
     */
    protected function _prepareColumns() {
        $this->addColumn('id', array(
            'header' => Mage::helper('orderexport')->__('Export ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
        ));

        $this->addColumn('profile', array(
            'header' => Mage::helper('orderexport')->__('Profile'),
            'align' => 'left',
            'index' => 'profile',
            'type' => 'options',
            'options' => Mage::helper('orderexport')->getEntity()
        ));

        $this->addColumn('created_time', array(
            'header' => Mage::helper('orderexport')->__('Export Date-Time'),
            'width' => '150px',
            'type' => 'datetime',
            'index' => 'created_time',
        ));
        $this->addColumn('filename', array(
            'header' => Mage::helper('orderexport')->__('Exported File'),
            'index' => 'filename',
        ));
        $this->addColumn('destination', array(
            'header' => Mage::helper('orderexport')->__('Destination'),
            'index' => 'destination',
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('orderexport')->__('Action'),
            'width' => '100px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('orderexport')->__('Download File(s)'),
                    'url' => array('base' => '*/*/download'), //$this->getUrl('*/*/download'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
        ));
        parent::_prepareColumns();
    }

    /**
     * Prepare mass action controls
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction() {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('orderexport');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('orderexport')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('orderexport')->__('Exported file(s) from disk and FTP will be deleted.')
        ));
        return $this;
    }

}
