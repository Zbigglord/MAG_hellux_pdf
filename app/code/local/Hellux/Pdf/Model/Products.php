<?php
/**
 * Created by HELLUX.
 * Date: 2017-04-10
 * Time: 08:42
 */
include_once('fpdf.php');

class Hellux_Pdf_Model_Products extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('hellux_pdf/products');
    }
//FOUR TABLES PAGE VERSION:

    public static function exportToFile($prod_list = array()){

        $pdf = new FPDF('P','mm','A4');
        $pdf->SetAutoPageBreak(false);//to make sure, that footer won't be transfered to nex page
        $pdf->SetMargins(10,10,10);
        $pdf->AddFont('OpenSans-Light','','OpenSans-Light.php'); //first need to convert ttf to .php and .z - page to do that: http://fpdf.fruit-lab.de
        //do not forget change filename in (and i mean edit it) .php file after conversion
        $pdf->AddFont('OpenSans-Semibold','','OpenSans-Semibold.php');//first need to convert ttf to .php and .z - page to do that: http://fpdf.fruit-lab.de
        $store_id = $prod_list['store_id'];
        $product_count = count($prod_list);
        $pages = 0;
        $pom = 0; // used to count operations to make sure that last product page gonna have footer as well
        $year = date('Y');
        foreach($prod_list as $product){
            if($product['store_id'] == 1){//somehow cannot get proper translation from german store, as well as proper values (in german)

                $attribs = array (
                    'Katalognummer',
                    'breite',
                    'höhe',
                    'fassung',
                    'Energieklasse',
                    'schutzart',
                );
                $katalog_title = 'Hellux lampenkatalog '.$year;
                $page_site = 'www.lampencity.de';

            }else{
                $attribs = array (

                    'numer katalogowy',
                    'szerokoœæ',
                    'wysokoœæ',
                    'oprawka',
                    'klasa energetyczna',
                    'stopieñ szczelnoœci',
                );
                $katalog_title = 'Hellux - katalog lamp '.$year;
                $page_site = 'www.sklep.hellux.pl';

            }
            $filename = $product['filename'];//filename thatuser picked on backend
        }

        $page_header = 'HELLUX '.$year;
        $half_pageY = $pdf->GetPageHeight()/2;
        $half_pageX = $pdf->GetPageWidth()/2;

//first title page - to be done
        //  $pdf->AddPage();
        // $pdf->SetFont('OpenSans-Light','',28);
        //  $pdf->SetFillColor(217,4,43);
        // $pdf->SetTextColor(255,255,255);
        // $pdf->Ln($half_pageY);
        // $pdf->Cell($pdf->GetPageWidth()-10,30,$katalog_title,0,1,'R',1);

        $iterator = 0;//used to count to 4 to put only 4 product on one page

        foreach($prod_list as $product){

            switch ($iterator){
                case 0://first top left

                    $pdf->AddPage();
                    $pages++;
                    $pdf->SetXY(0,0);
                    $pdf->SetFillColor(255, 2, 4);
                    $pdf->SetTextColor(255,255,255);
                    $pdf->SetFont('OpenSans-Light','',8);
                    $pdf->Cell(23,5,$page_header,0,1,'L',1);
                    $pdf->SetXY(24,0);
                    $pdf->SetTextColor(0,0,0);
                    $pdf->Cell(40,5,$page_site,0,1,'L',0);
                    $pdf->SetXY(10,10);
                    $pdf->SetFont('OpenSans-Semibold','',18);
                    $product['name'] = iconv("UTF-8", "CP1250//TRANSLIT", $product['name']);//that is becouse coding from database is UTF but for fpdf we need win 1250
                    $pdf->Cell($half_pageX-10,10,$product['name'],0,1,'L',0);
                    $pdf->Image($product['image']);

                    $table_startY = $pdf->GetY()+5;
                    $row_width = ($half_pageX-5)/2;
                    $pdf->SetXY(10,$table_startY);
                    $pdf->SetTextColor(255,255,255);
                    $pdf->SetFont('OpenSans-Light','',8);
                    $i=0;

                    foreach($attribs as $key => $value){
                        $pdf->Cell($row_width,5,$value,0,1,'L',1);
                        $pdf->SetXY(10,$pdf->GetY()+0.50);
                        $i++;
                    }

                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFillColor(248,248,248);
                    $pdf->SetXY($row_width+0.50,$table_startY);
                    $pdf->Cell($row_width,5,$product['sku'],0,1,'C',1);
                    $pdf->SetXY($row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['width'],0,1,'C',1);
                    $pdf->SetXY($row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['height'],0,1,'C',1);
                    $pdf->SetXY($row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['oprawka'],0,1,'C',1);
                    $pdf->SetXY($row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['klasae'],0,1,'C',1);
                    $pdf->SetXY($row_width+0.50,$pdf->GetY()+0.50);
                   // $product['color'] = iconv("UTF-8", "CP1250//TRANSLIT", $product['color']);//that is becouse coding from database is UTF but for fpdf we need win 1250
                    $pdf->Cell($row_width,5,$product['stop_szczelnosci'],0,1,'C',1);

                    break;

                case 1://second top right

                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFont('OpenSans-Semibold','',18);
                    $pdf->SetXY($half_pageX+10,10);
                    $product['name'] = iconv("UTF-8", "CP1250//TRANSLIT", $product['name']);//that is becouse coding from database is UTF but for fpdf we need win 1250
                    $pdf->Cell($half_pageX-10,10,$product['name'],0,2,'L',0);
                    $pdf->Image($product['image']);

                    $table_startY = $pdf->GetY()+5;
                    $row_width = ($half_pageX-20)/2;
                    $pdf->SetXY($half_pageX+10,$table_startY);
                    $pdf->SetFillColor(255, 2, 4);
                    $pdf->SetTextColor(255,255,255);
                    $pdf->SetFont('OpenSans-Light','',8);
                    $i=0;

                    foreach($attribs as $key => $value){
                        $pdf->Cell($row_width,5,$value,0,1,'L',1);
                        $pdf->SetXY($half_pageX+10,$pdf->GetY()+0.50);
                        $i++;
                    }

                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFillColor(248,248,248);
                    $pdf->SetXY($half_pageX+10+$row_width+0.50,$table_startY);
                    $pdf->Cell($row_width,5,$product['sku'],0,1,'C',1);
                    $pdf->SetXY($half_pageX+10+$row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['width'],0,1,'C',1);
                    $pdf->SetXY($half_pageX+10+$row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['height'],0,1,'C',1);
                    $pdf->SetXY($half_pageX+10+$row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['oprawka'],0,1,'C',1);
                    $pdf->SetXY($half_pageX+10+$row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['klasae'],0,1,'C',1);
                    $pdf->SetXY($half_pageX+10+$row_width+0.50,$pdf->GetY()+0.50);
                   // $product['color'] = iconv("UTF-8", "CP1250//TRANSLIT", $product['color']);//that is becouse coding from database is UTF but for fpdf we need win 1250
                    $pdf->Cell($row_width,5,$product['stop_szczelnosci'],0,1,'C',1);

                    break;

                case 2://third middle left

                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFont('OpenSans-Semibold','',18);
                    $pdf->SetXY(10,$half_pageY-10);
                    $product['name'] = iconv("UTF-8", "CP1250//TRANSLIT", $product['name']);//that is becouse coding from database is UTF but for fpdf we need win 1250
                    $pdf->Cell($half_pageX-10,10,$product['name'],0,1,'L',0);
                    $pdf->Image($product['image']);

                    $table_startY = $pdf->GetY()+5;
                    $row_width = ($half_pageX-5)/2;
                    $pdf->SetXY(10,$table_startY);
                    $pdf->SetTextColor(255,255,255);
                    $pdf->SetFillColor(255, 2, 4);
                    $pdf->SetFont('OpenSans-Light','',8);
                    $i=0;

                    foreach($attribs as $key => $value){
                        $pdf->Cell($row_width,5,$value,0,1,'L',1);
                        $pdf->SetXY(10,$pdf->GetY()+0.50);
                        $i++;
                    }

                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFillColor(248,248,248);
                    $pdf->SetXY($row_width+0.50,$table_startY);
                    $pdf->Cell($row_width,5,$product['sku'],0,1,'C',1);
                    $pdf->SetXY($row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['width'],0,1,'C',1);
                    $pdf->SetXY($row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['height'],0,1,'C',1);
                    $pdf->SetXY($row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['oprawka'],0,1,'C',1);
                    $pdf->SetXY($row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['klasae'],0,1,'C',1);
                    $pdf->SetXY($row_width+0.50,$pdf->GetY()+0.50);
                    //$product['color'] = iconv("UTF-8", "CP1250//TRANSLIT", $product['color']);//that is becouse coding from database is UTF but for fpdf we need win 1250
                    $pdf->Cell($row_width,5,$product['stop_szczelnosci'],0,1,'C',1);

                    break;

                case 3://fourth middle right

                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFont('OpenSans-Semibold','',18);
                    $pdf->SetXY($half_pageX+10, $half_pageY-10);
                    $product['name'] = iconv("UTF-8", "CP1250//TRANSLIT", $product['name']);//that is becouse coding from database is UTF but for fpdf we need win 1250
                    $pdf->Cell($half_pageX-10,10,$product['name'],0,2,'L',0);
                    $pdf->Image($product['image']);

                    $table_startY = $pdf->GetY()+5;
                    $row_width = ($half_pageX-20)/2;
                    $pdf->SetXY($half_pageX+10,$table_startY);
                    $pdf->SetFillColor(255, 2, 4);
                    $pdf->SetTextColor(255,255,255);
                    $pdf->SetFont('OpenSans-Light','',8);
                    $i=0;

                    foreach($attribs as $key => $value){
                        $pdf->Cell($row_width,5,$value,0,1,'L',1);
                        $pdf->SetXY($half_pageX+10,$pdf->GetY()+0.50);
                        $i++;
                    }

                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFillColor(248,248,248);
                    $pdf->SetXY($half_pageX+10+$row_width+0.50,$table_startY);
                    $pdf->Cell($row_width,5,$product['sku'],0,1,'C',1);
                    $pdf->SetXY($half_pageX+10+$row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['width'],0,1,'C',1);
                    $pdf->SetXY($half_pageX+10+$row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['height'],0,1,'C',1);
                    $pdf->SetXY($half_pageX+10+$row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['oprawka'],0,1,'C',1);
                    $pdf->SetXY($half_pageX+10+$row_width+0.50,$pdf->GetY()+0.50);
                    $pdf->Cell($row_width,5,$product['klasae'],0,1,'C',1);
                    $pdf->SetXY($half_pageX+10+$row_width+0.50,$pdf->GetY()+0.50);
                    //$product['color'] = iconv("UTF-8", "CP1250//TRANSLIT", $product['color']);//that is because coding from database is UTF but for fpdf we need win 1250
                    $pdf->Cell($row_width,5,$product['stop_szczelnosci'],0,1,'C',1);

                    break;
            }

            $pom++;
            $iterator++;
            if($iterator > 3 || $pom >= $product_count){//if one page ends or products finished
                $iterator = 0;
                $pdf->SetFillColor(255, 2, 4);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('OpenSans-Light','',6);
                $pdf->SetXY(0,$pdf->GetPageHeight()-10);
                $pdf->Cell($pdf->GetPageWidth()-10,10,'Hellux '.$year,0,1,'C',0);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFillColor(248,248,248);
                $pdf->SetFont('OpenSans-Semibold','',14);
                $pdf->SetXY($pdf->GetPageWidth()-10,$pdf->GetPageHeight()-10);
                $pdf->Cell(10,10,$pages,0,1,'C',1);
            }

        }

        $basedir = Mage::getBaseDir();
        $pdf->Output( $basedir."/upload/pdf/".$filename.".pdf", "F" );
        $file_url = 'https://www.lampencity.de/upload/pdf/'.$filename.'.pdf';
        Mage::getSingleton('adminhtml/session')->addSuccess('Produkty wyeksportowane poprawnie do pliku: <a href="'.$file_url.'" target="_blank">'.$file_url.'</a>');

    }//END exportToFile()

}//END CLASS