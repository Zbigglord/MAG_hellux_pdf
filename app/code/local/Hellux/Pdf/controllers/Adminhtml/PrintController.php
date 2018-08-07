<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 09:28
 */
class Hellux_Pdf_Adminhtml_PrintController extends Mage_Adminhtml_Controller_Action {


 public function indexAction()
 {
  $this->_title($this->__('Pdf'))->_title($this->__('Exportuj produkty do katalogu pdf'));
  $this->loadLayout();
  $this->_setActiveMenu('hellux/pdf');
  $this->_addContent($this->getLayout()->createBlock('hellux_pdf/adminhtml_products_products'));
  $this->renderLayout();
 }

 public function exportAction(){

  $ids = $this->getRequest()->getParam('ids');
  if (!is_array($ids)) {

   $this->_getSession()->addError($this->__('Proszę zaznaczyć produkty do eksportu.'));

  } else {

    $this->getRequest()->setParam('export_array',$ids);//set array of prod to export ids and sent further
    $this->_redirect('*/*/edit');


  }//END if not array ids

 }//END EXPORT ACTION


 public function editAction()
 {

  $ids = $this->getRequest()->getParam('ids');
  if (!is_array($ids)) {

   $this->_getSession()->addError($this->__('Proszę zaznaczyć produkty do eksportu.'));

  } else {

   $session = Mage::getSingleton("core/session",  array("name"=>"frontend"));
   $session->setData('export_array', $ids);

  $this->_title($this->__('Pdf'))->_title($this->__('Eksportuj do PDF'));
  $this->loadLayout();
  $this->_setActiveMenu('hellux/pdf');
  $this->_addContent($this->getLayout()->createBlock('hellux_pdf/adminhtml_products_edit'));
  $this->renderLayout();
  }

 }


 public function saveAction()
 {
   $prod_array = array();//tablica wynikowa dla wszystkich posortowanych produktów
  $one_prod = array();//tablica pomocnicza dla jednrgo produktu

   $data = $this->getRequest()->getPost();

   $session = Mage::getSingleton("core/session",  array("name"=>"frontend"));
  $prods = $session->getData('export_array');
  $collection = Mage::getModel('catalog/product')->getCollection()->setStoreId($data['stores'][0])->addAttributeToSelect('*')->addIdFilter($prods)->load();

  foreach($collection as $one_product){
   $one_prod['filename'] = $data['file_name'];
   $one_prod['store_id'] = $data['stores'][0];
   $one_prod['name'] = $one_product['name'];
   $one_prod['sku'] = $one_product['sku'];
   $one_prod['image'] = $one_product->getImageUrl();
   $one_prod['price'] = $one_product['price'];
   $one_prod['width'] = $one_product['szer'];
   $one_prod['height'] = $one_product['wys'];
   $one_prod['oprawka'] = $one_product->getAttributeText('oprawka');
   $one_prod['klasae'] = $one_product->getAttributeText('klas_energ');
   $one_prod['stop_szczelnosci'] = $one_product->getAttributeText('stop_szczelnosci');
   //$one_prod['description'] = $one_product['description'];
   array_push($prod_array,$one_prod);
   $one_prod = array();
  }

  Hellux_Pdf_Model_Products::exportToFile($prod_array);

  $this->_title($this->__('Pdf'))->_title($this->__('Temporary to test'));
  $this->loadLayout();
  $this->_setActiveMenu('hellux/pdf');
  $this->_addContent($this->getLayout()->createBlock('hellux_pdf/adminhtml_products_products'));
  $this->renderLayout();
  //echo '<pre>';
  //print_r($prod_array);
  //echo '</pre>';
}

}