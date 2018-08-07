<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:42
 */ 
class Hellux_Pdf_Model_Resource_Products_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('hellux_pdf/products');
    }

}