<?php defined('BASEPATH') OR exit('No direct script access allowed');
require('fpdf/fpdf.php');
require('fpdf/invClassExtend.php');

class Businesslineytd_pdf extends CI_Controller{

  var $fontSize = 10;
    var $fontFam = 'Arial';
    var $yearId = 0;
    var $yearCode="";
    var $paperWSize = 297;
    var $paperHSize = 210;
    var $height = 5;
    var $currX;
    var $currY;
    var $widths;
    var $aligns;

    function __construct() {
        parent::__construct();
        //$this->formCetak();
        $pdf = new FPDF();
        $this->startY = $pdf->GetY();
        $this->startX = $this->paperWSize-42;
        $this->lengthCell = $this->startX+20;
    }

    function newLine($pdf){
        $pdf->Cell($this->lengthCell, $this->height, "", "", 0, 'L');
        $pdf->Ln();
    }


  function pageCetak() {
    $periodid_fk = getVarClean('periodid_fk','str','');
    $period_code = getVarClean('period_code','str','');


    $sql = "SELECT s01 plitemname,
                    s02 fonttype,
                    s03 dbgtype,
                    n01 domtrafficamt,
                    n02 domnetworkamt,
                    n03 intltrafficamt,
                    n04 intlnetworkamt,
                    n05 carrieramt,
                    n06 intladjacentamt,
                    n07 toweramt,
                    n08 infraamt,
                    n09 totalamt
            FROM table (f_ShowBusinessLineYTD(".$periodid_fk."))";

    $data = array();
    $output = $this->db->query($sql);
    $data = $output->result_array();


    $pdf = new FPDF();


    
    $pdf->AliasNbPages();
    $pdf->AddPage("L", "A4");
    $pdf->SetFont('Arial', 'B', 16);

    $pdf->Cell($this->lengthCell, $this->height, "Business Line - Line Up", "", 0, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln(8);
    $pdf->Cell($this->lengthCell, $this->height, "Model Year to date ".$period_code."", "", 0, 'L');
    $pdf->Ln(8);

    $kolom1 = ($this->lengthCell * 4) / 22;
    $kolom2 = ($this->lengthCell * 2) / 22;
    $kolom3 = ($this->lengthCell * 2) / 22;
    $kolom4 = ($this->lengthCell * 2) / 22;
    $kolom5 = ($this->lengthCell * 2) / 22;
    $kolom6 = ($this->lengthCell * 2) / 22;
    $kolom7 = ($this->lengthCell * 2) / 22;
    $kolom8 = ($this->lengthCell * 2) / 22;
    $kolom9 = ($this->lengthCell * 2) / 22;
    $kolom10 = ($this->lengthCell * 2) / 22;

    $pdf->SetFillColor(214,70,53);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->MultiCell($kolom1, 15, "", 1, "L", true); //P&L Line Item
    $pdf->Ln(-15);
    $pdf->Cell($kolom1, $this->height, "", 0, 0, 'L');
    $pdf->Cell($kolom2+$kolom3+$kolom4+$kolom5+$kolom6, $this->height, "", 1, 0, 'C', true); //Carrier
    $pdf->MultiCell($kolom7, 15, "", 1, "C", true); //International Adjacent
    $pdf->Ln(-15);
    $pdf->Cell($kolom1+$kolom2+$kolom3+$kolom4+$kolom5+$kolom6+$kolom7, $this->height, "", 0, 0, 'L');
    $pdf->MultiCell($kolom8, 15, "", 1, "C", true); //Towers
    $pdf->Ln(-15);
    $pdf->Cell($kolom1+$kolom2+$kolom3+$kolom4+$kolom5+$kolom6+$kolom7+$kolom8, $this->height, "", 0, 0, 'L');
    $pdf->MultiCell($kolom9, 15, "", 1, "C", true); //Infrastructure
    $pdf->Ln(-15);
    $pdf->Cell($kolom1+$kolom2+$kolom3+$kolom4+$kolom5+$kolom6+$kolom7+$kolom8+$kolom9, $this->height, "", 0, 0, 'L');
    $pdf->MultiCell($kolom10, 15, "", 1, "C", true); //Simple Total
    $pdf->Ln(-10);
    $pdf->Cell($kolom1, $this->height, "", 0, 0, 'L');
    $pdf->MultiCell($kolom2, 10, "", 1, "C", true); //Domestic Traffic
    $pdf->Ln(-10);
    $pdf->Cell($kolom1+$kolom2, $this->height, "", 0, 0, 'L');
    $pdf->MultiCell($kolom3, 10, "", 1, "C", true); //Domestic Network
    $pdf->Ln(-10);
    $pdf->Cell($kolom1+$kolom2+$kolom3, $this->height, "", 0, 0, 'L');
    $pdf->MultiCell($kolom4, 10, "", 1, "C", true); //International Traffic
    $pdf->Ln(-10);
    $pdf->Cell($kolom1+$kolom2+$kolom3+$kolom4, $this->height, "", 0, 0, 'L');
    $pdf->MultiCell($kolom5, 10, "", 1, "C", true); //International Network
    $pdf->Ln(-10);
    $pdf->Cell($kolom1+$kolom2+$kolom3+$kolom4+$kolom5, $this->height, "", 0, 0, 'L');
    $pdf->MultiCell($kolom6, 10, "", 1, "C", true); //Carrier Total
    $pdf->Ln(-15);
    
    
    $pdf->SetTextColor(255,255,255);

    $pdf->Cell($kolom1, $this->height, "", 0, 0, 'L');
    $pdf->Cell($kolom2+$kolom3+$kolom4+$kolom5+$kolom6, $this->height, "Carrier", 0, 0, 'C');
    $pdf->Cell($kolom7, $this->height, "", 0, 0, 'C');
    $pdf->Cell($kolom8, $this->height, "", 0, 0, 'C');
    $pdf->Cell($kolom9, $this->height, "", 0, 0, 'C');
    $pdf->Cell($kolom10, $this->height, "", 0, 0, 'C');
    $pdf->Ln();

    $pdf->Cell($kolom1, $this->height, "P&L Line Item", 0, 0, 'L');
    $pdf->Cell($kolom2, $this->height, "Domestic", 0, 0, 'C');
    $pdf->Cell($kolom3, $this->height, "Domestic", 0, 0, 'C');
    $pdf->Cell($kolom4, $this->height, "International", 0, 0, 'C');
    $pdf->Cell($kolom5, $this->height, "International", 0, 0, 'C');
    $pdf->Cell($kolom6, $this->height, "Carrier", 0, 0, 'C');
    $pdf->Cell($kolom7, $this->height, "International", 0, 0, 'C');
    $pdf->Cell($kolom8, $this->height, "Towers", 0, 0, 'C');
    $pdf->Cell($kolom9, $this->height, "Infrastructure", 0, 0, 'C');
    $pdf->Cell($kolom10, $this->height, "Simple Total", 0, 0, 'C');
    $pdf->Ln();

    $pdf->Cell($kolom1, $this->height, "", 0, 0, 'L');
    $pdf->Cell($kolom2, $this->height, "Traffic", 0, 0, 'C');
    $pdf->Cell($kolom3, $this->height, "Network", 0, 0, 'C');
    $pdf->Cell($kolom4, $this->height, "Traffic", 0, 0, 'C');
    $pdf->Cell($kolom5, $this->height, "Network", 0, 0, 'C');
    $pdf->Cell($kolom6, $this->height, "Total", 0, 0, 'C');
    $pdf->Cell($kolom7, $this->height, "Adjacent", 0, 0, 'C');
    $pdf->Cell($kolom8, $this->height, "", 0, 0, 'C');
    $pdf->Cell($kolom9, $this->height, "", 0, 0, 'C');
    $pdf->Cell($kolom10, $this->height, "", 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFillColor(250,250,210);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetWidths(array($kolom1, $kolom2, $kolom3, $kolom4, $kolom5, $kolom6, $kolom7, $kolom8, $kolom9, $kolom10));
    $pdf->SetAligns(array("L", "R", "R", "R", "R", "R", "R", "R", "R", "R"));

    foreach($data as $item) {

        if($item['fonttype'] == "BOLD"){
            $pdf->SetFont('Arial', 'B', 8);
        }else{
            $pdf->SetFont('Arial', '', 8);
        }

        if($item['plitemname'] != ""){
            if($item['dbgtype'] == "Y"){
                $color = true;
            }else{
                $color = false;
            }
            $pdf->RowMultiBorderWithHeightFill(array($item['plitemname'],
                                                 number_format($item['domtrafficamt']),
                                                 number_format($item['domnetworkamt']),
                                                 number_format($item['intltrafficamt']),
                                                 number_format($item['intlnetworkamt']),
                                                 number_format($item['carrieramt']),
                                                 number_format($item['intladjacentamt']),
                                                 number_format($item['toweramt']),
                                                 number_format($item['infraamt']),
                                                 number_format($item['totalamt'])),
                            array('TBLR',
                                  'TBLR',
                                  'TBLR',
                                  'TBLR',
                                  'TBLR',
                                  'TBLR',
                                  'TBLR',
                                  'TBLR',
                                  'TBLR',
                                  'TBLR',
                                  )
                                ,$this->height,
                                $color);
        }else{
            $pdf->Ln();
        }
        // $pdf->Ln();
   }

    $pdf->Output("","I");

  }

}



