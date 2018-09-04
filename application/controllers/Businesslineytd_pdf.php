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

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell($kolom1, $this->height, "", "TLR", 0, 'L');
    $pdf->Cell($kolom2+$kolom3+$kolom4+$kolom5+$kolom6, $this->height, "Carrier", "TLR", 0, 'C');
    $pdf->Cell($kolom7, $this->height, "", "TLR", 0, 'C');
    $pdf->Cell($kolom8, $this->height, "", "TLR", 0, 'C');
    $pdf->Cell($kolom9, $this->height, "", "TLR", 0, 'C');
    $pdf->Cell($kolom10, $this->height, "", "TLR", 0, 'C');
    $pdf->Ln();

    $pdf->Cell($kolom1, $this->height, "P&L Line Item", "LR", 0, 'L');
    $pdf->Cell($kolom2, $this->height, "Domestic", "TLR", 0, 'C');
    $pdf->Cell($kolom3, $this->height, "Domestic", "TLR", 0, 'C');
    $pdf->Cell($kolom4, $this->height, "International", "TLR", 0, 'C');
    $pdf->Cell($kolom5, $this->height, "International", "TLR", 0, 'C');
    $pdf->Cell($kolom6, $this->height, "Carrier", "TLR", 0, 'C');
    $pdf->Cell($kolom7, $this->height, "International", "LR", 0, 'C');
    $pdf->Cell($kolom8, $this->height, "Towers", "LR", 0, 'C');
    $pdf->Cell($kolom9, $this->height, "Infrastructure", "LR", 0, 'C');
    $pdf->Cell($kolom10, $this->height, "Simple Total", "LR", 0, 'C');
    $pdf->Ln();

    $pdf->Cell($kolom1, $this->height, "", "BLR", 0, 'L');
    $pdf->Cell($kolom2, $this->height, "Traffic", "BLR", 0, 'C');
    $pdf->Cell($kolom3, $this->height, "Network", "BLR", 0, 'C');
    $pdf->Cell($kolom4, $this->height, "Traffic", "BLR", 0, 'C');
    $pdf->Cell($kolom5, $this->height, "Network", "BLR", 0, 'C');
    $pdf->Cell($kolom6, $this->height, "Total", "BLR", 0, 'C');
    $pdf->Cell($kolom7, $this->height, "Adjacent", "BLR", 0, 'C');
    $pdf->Cell($kolom8, $this->height, "", "BLR", 0, 'C');
    $pdf->Cell($kolom9, $this->height, "", "BLR", 0, 'C');
    $pdf->Cell($kolom10, $this->height, "", "BLR", 0, 'C');
    $pdf->Ln();

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
            $pdf->RowMultiBorderWithHeight(array($item['plitemname'],
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
                                ,$this->height);
        }else{
            $pdf->Ln();
        }
        // $pdf->Ln();
   }

    $pdf->Output("","I");

  }

}



