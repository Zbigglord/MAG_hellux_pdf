<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_Pdf_Block_Adminhtml_Products_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    protected function _prepareForm()
    {

        $form   = new Varien_Data_Form(array(
         'id'        => 'edit_form',
         'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
         'method'    => 'post',
         'enctype' => 'multipart/form-data'
        ));

        $fieldset   = $form->addFieldset('base_fieldset', array(
         'legend'    => Mage::helper('hellux_pdf')->__("Wybierz kategorię i nazwę pliku:"),
         'class'     => 'fieldset-wide',
        ));

        $fieldset->addField('store_id', 'multiselect', array(
            'name'      => 'stores[]',
            'label'     => Mage::helper('cms')->__('Store View'),
            'title'     => Mage::helper('cms')->__('Store View'),
            'required'  => true,
            'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
        ));

        $fieldset->addField('file_name', 'text', array(
     'name'      => 'file_name',
     'label'     => Mage::helper('hellux_pdf')->__('Nazwa pliku:'),
     'title'     => Mage::helper('hellux_pdf')->__('wpisz nazwę pliku bez rozszerzenia i bez ścieżki.'),
     'required'  => true,
     'value'     => ''
    ));

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();

    }

}
