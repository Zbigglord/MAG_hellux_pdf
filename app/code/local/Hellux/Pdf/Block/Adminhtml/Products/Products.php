<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_Pdf_Block_Adminhtml_Products_Products extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct(){
        $this->_blockGroup = 'hellux_pdf';
        $this->_controller = 'adminhtml_products_grid';
        $this->_headerText = Mage::helper('hellux_pdf')->__('Eksportuj produkty do katalogu pdf');

        parent::__construct();
    }

    protected function _prepareLayout()//Need to override this function to add remove button otherwise it just does not work
    {
        $this->_removeButton('add');

        return parent::_prepareLayout();
    }

}//end class

