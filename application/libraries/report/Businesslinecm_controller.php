<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Businesslinecm_controller
* @version 2018-05-25 11:32:24
*/
class Businesslinecm_controller {

    function readTable() {

        $periodid_fk = getVarClean('periodid_fk','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('report/businesslinecm');
            $table = new Businesslinecm($periodid_fk);

            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            if($count < 1) {  echo ''; exit; }

            $output = '';


            foreach($items as $item) {
                $stylefont = "";
                $stylecolor = "";

                if($item['fonttype'] == "BOLD"){
                    $stylefont = "font-weight: bold; ";
                }else{
                    $stylefont = "font-weight: normal; ";
                }

                if($item['dbgtype'] == "Y"){
                    // $stylecolor = "background-color: #FBEC88; ";
                    $stylecolor = "background-color: #FAFAD2; ";
                }else{
                    $stylecolor = "background-color: #ffffff; ";
                }

                if($item['plitemname'] != ''){
                    $output .= '<tr style="'.$stylecolor.'">';
                        $output .= '<td nowrap style="'.$stylefont.'">'.$item['plitemname'].'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['domtrafficamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['domnetworkamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['intltrafficamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['intlnetworkamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['carrieramt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['intladjacentamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['toweramt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['infraamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['totalamt']).'</td>';
                    $output .= '</tr>';
                }else{
                    $output .= '<tr style="'.$stylecolor.'">';
                        $output .= '<td nowrap style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                    $output .= '</tr>';
                }


            }

        }catch (Exception $e) {
            $data = array();
            $data['message'] = $e->getMessage();
            return $data;
        }

        echo $output;
        exit;

        

    }

    function download_excel() {

            $periodid_fk = getVarClean('periodid_fk','str','');
            $period_code = getVarClean('period_code','str','');

            $ci = & get_instance();
            $ci->load->model('report/businesslinecm');
            $table = new Businesslinecm($periodid_fk);

            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            startExcel("BusinessLineCM_".$periodid_fk.".xls");

            $output = '';
            $output .= '<div style="font-size: 18px; font-weight : bold;"> Business Line - Line Up</div>';
            $output .= '<div style="font-size: 14px; font-weight : bold;"> Model Current Month '.$period_code.'</div>';

        
            $output .='<table  border="1">';

            $output.='<tr style="background-color: #D64635; color: #ffffff;">';
            $output.='  <th rowspan="2" style="vertical-align: middle;">P&L Line Item </th>
                        <th colspan="5" style="text-align: center;">Carrier</th>
                        <th rowspan="2" style="vertical-align: middle;">International Adjacent</th>
                        <th rowspan="2" style="vertical-align: middle;">Towers</th>
                        <th rowspan="2" style="vertical-align: middle;">Infrastructure</th>
                        <th rowspan="2"  style="vertical-align: middle;">Simple Total</th> ';
            $output.='</tr>';

            $output.='<tr style="background-color: #D64635; color: #ffffff;">';                         
            $output.='  <th style="text-align: center;">Domestic Traffic</th>
                        <th style="text-align: center;">Domestic Network</th>
                        <th style="text-align: center;">International Traffic</th>
                        <th style="text-align: center;">International Network</th> 
                        <th style="text-align: center;">Carrier Total</th> 
                        ';
            $output.='</tr>';

            if($count < 1)  {
                $output .= '</table>';
                echo $output;
                exit;
            }


            foreach($items as $item) {
                $stylefont = "";
                $stylecolor = "";

                if($item['fonttype'] == "BOLD"){
                    $stylefont = "font-weight: bold; ";
                }else{
                    $stylefont = "font-weight: normal; ";
                }

                if($item['dbgtype'] == "Y"){
                    // $stylecolor = "background-color: #FBEC88; ";
                    $stylecolor = "background-color: #FAFAD2; ";
                }else{
                    $stylecolor = "background-color: #ffffff; ";
                }

                if($item['plitemname'] != ''){
                    $output .= '<tr style="'.$stylecolor.'">';
                        $output .= '<td nowrap style="'.$stylefont.'">'.$item['plitemname'].'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['domtrafficamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['domnetworkamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['intltrafficamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['intlnetworkamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['carrieramt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['intladjacentamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['toweramt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['infraamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['totalamt']).'</td>';
                    $output .= '</tr>';
                }else{
                    $output .= '<tr style="'.$stylecolor.' border:0;">';
                        $output .= '<td nowrap style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                        $output .= '<td align="right" style="'.$stylefont.'"></td>';
                    $output .= '</tr>';
                }

            }


            $output .= '</table>';
            echo $output;
            exit;

    }



}

/* End of file Businesslinecm_controller.php */