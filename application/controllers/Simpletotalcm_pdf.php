<?php defined('BASEPATH') OR exit('No direct script access allowed');
require('mpdf60/mpdf.php');

class Simpletotalcm_pdf extends CI_Controller{

    function __construct() {
        parent::__construct();
        
    }


    function pageCetak() {
        $year_id = getVarClean('year_id','str','');


        $sql = "SELECT n01 counterno,
                        s01 plitemname,
                        s02 fonttype,
                        s03 dbgtype,
                        n02 janamt,
                        n03 febamt,
                        n04 maramt,
                        n05 apramt,
                        n06 mayamt,
                        n07 junamt,
                        n08 julamt,
                        n09 augamt,
                        n10 sepamt,
                        n11 octamt,
                        n12 novamt,
                        n13 decamt
                FROM table (f_SimpleTotalCM(".$year_id."))";

        $data = array();
        $output = $this->db->query($sql);
        $data = $output->result_array();

        $mpdf = new mPDF('c','A4-L','',''); 
        $mpdf->SetDisplayMode('fullpage');

        $html = '';
        $html .= '<html>';
        $html .= '<body style="font-family:arial; font-size: 8pt;">';
        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<td style="font-size: 16pt;"><strong>P&L CFU Simple Total</strong></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="font-size: 12pt;"><strong>Model Current Month '.$year_id.'</strong></td>';
        $html .= '</tr>';
        $html .= '</table>';

        $html .= '<table border="1" cellspacing="0" cellpadding="3" width="100%">';
        $html .= '<tr style="background-color: #D64635;">';
        $html .= '<th align="left" width="15%"><font color="rgb(255, 255, 255)">P&L Line Item</font></th>';
        $html .= '<th width="7%"><font color="rgb(255, 255, 255)">JANUARI</font></th>';
        $html .= '<th width="7.5%"><font color="rgb(255, 255, 255)">FEBRUARI</font></th>';
        $html .= '<th width="7%"><font color="rgb(255, 255, 255)">MARET</font></th>';
        $html .= '<th width="7%"><font color="rgb(255, 255, 255)">APRIL</font></th>';
        $html .= '<th width="7%"><font color="rgb(255, 255, 255)">MEI</font></th>';
        $html .= '<th width="7%"><font color="rgb(255, 255, 255)">JUNI</font></th>';
        $html .= '<th width="7%"><font color="rgb(255, 255, 255)">JULI</font></th>';
        $html .= '<th width="7%"><font color="rgb(255, 255, 255)">AGUSTUS</font></th>';
        $html .= '<th width="7.5%"><font color="rgb(255, 255, 255)">SEPTEMBER</font></th>';
        $html .= '<th width="7%"><font color="rgb(255, 255, 255)">OKTOBER</font></th>';
        $html .= '<th width="7%"><font color="rgb(255, 255, 255)">NOVEMBER</font></th>';
        $html .= '<th width="7%"><font color="rgb(255, 255, 255)">DESEMBER</font></th>';
        $html .= '</tr>';

        foreach($data as $item) {
            $stylefont = "";
            $stylecolor = "";
            
            if($item['fonttype'] == "BOLD"){
                $stylefont = "font-weight: bold; ";
            }else{
                $stylefont = "font-weight: normal; ";
            }

            if($item['dbgtype'] == "Y"){
                $stylecolor = "background-color: #FAFAD2; ";
            }else{
                $stylecolor = "background-color: #ffffff; ";
            }


            if($item['plitemname'] != ''){
                $html .= '<tr style="'.$stylecolor.'">';
                    $html .= '<td nowrap style="'.$stylefont.'">'.$item['plitemname'].'</td>';
                    $html .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['janamt']).'</td>';
                    $html .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['febamt']).'</td>';
                    $html .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['maramt']).'</td>';
                    $html .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['apramt']).'</td>';
                    $html .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['mayamt']).'</td>';
                    $html .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['junamt']).'</td>';
                    $html .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['julamt']).'</td>';
                    $html .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['augamt']).'</td>';
                    $html .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['sepamt']).'</td>';
                    $html .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['octamt']).'</td>';
                    $html .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['novamt']).'</td>';
                    $html .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['decamt']).'</td>';
                $html .= '</tr>';
            }else{
                $html .= '<tr style="'.$stylecolor.' border: 0px;">';
                    $html .= '<td nowrap style="'.$stylefont.' border: 0px;">&nbsp;&nbsp;</td>';
                    $html .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                    $html .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                    $html .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                    $html .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                    $html .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                    $html .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                    $html .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                    $html .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                    $html .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                    $html .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                    $html .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                    $html .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                $html .= '</tr>';
            }
        }

        $html .= '</table>';

        $html .= '</body>';
        $html .= '</html>';

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    

    }

}



