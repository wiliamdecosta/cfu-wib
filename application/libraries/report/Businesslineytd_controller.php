<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Businesslineytd_controller
* @version 2018-05-25 11:32:24
*/
class Businesslineytd_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','');
        $sord = getVarClean('sord','str','');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $periodid_fk = getVarClean('periodid_fk','str','');

        if(empty($periodid_fk)){
            $data['success'] = true;
            return $data;
        }

        try {

            $ci = & get_instance();
            $ci->load->model('report/businesslineytd');
            $table = new Businesslineytd($periodid_fk);

            $req_param = array(
                "sort_by" => $sidx,
                "sord" => $sord,
                "limit" => null,
                "field" => null,
                "where" => null,
                "where_in" => null,
                "where_not_in" => null,
                "search" => $_REQUEST['_search'],
                "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
                "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
                "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
            );

            // Filter Table
            $req_param['where'] = array();


            $table->setJQGridParam($req_param);
            $count = $table->countAll();

            if ($count > 0) $total_pages = ceil($count / $limit);
            else $total_pages = 1;

            if ($page > $total_pages) $page = $total_pages;
            $start = $limit * $page - ($limit); // do not put $limit*($page - 1)

            $req_param['limit'] = array(
                'start' => $start,
                'end' => $limit
            );

            $table->setJQGridParam($req_param);

            if ($page == 0) $data['page'] = 1;
            else $data['page'] = $page;

            $data['total'] = $total_pages;
            $data['records'] = $count;

            $data['rows'] = $table->getAll();
            $data['success'] = true;
            logging('view data tblm_category');
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }


    function readTable() {

        $periodid_fk = getVarClean('periodid_fk','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('report/businesslineytd');
            $table = new Businesslineytd($periodid_fk);

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
                        $output .= '<td nowrap style="'.$stylefont.' border: 0px;">&nbsp;&nbsp;</td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
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
            $ci->load->model('report/businesslineytd');
            $table = new Businesslineytd($periodid_fk);

            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            startExcel("BusinessLineYTD_".$periodid_fk.".xls");

            $output = '';
            $output .= '<div style="font-size: 18px; font-weight : bold;"> Business Line - Line Up</div>';
            $output .= '<div style="font-size: 14px; font-weight : bold;"> Model Year to date '.$period_code.'</div>';

        
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
                     $output .= '<tr style="'.$stylecolor.'">';
                        $output .= '<td nowrap style="'.$stylefont.' border: 0px;">&nbsp;&nbsp;</td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                        $output .= '<td align="right" style="'.$stylefont.' border: 0px;"></td>';
                    $output .= '</tr>';
                }

            }


            $output .= '</table>';
            echo $output;
            exit;

    }



}

/* End of file Businesslineytd_controller.php */