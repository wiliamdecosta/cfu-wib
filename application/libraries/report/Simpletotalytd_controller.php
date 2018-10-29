<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Simpletotalytd_controller
* @version 2018-05-25 11:32:24
*/
class Simpletotalytd_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','');
        $sord = getVarClean('sord','str','');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $year_id = getVarClean('year_id','str','');

        if(empty($year_id)){
            $data['success'] = true;
            return $data;
        }

        try {

            $ci = & get_instance();
            $ci->load->model('report/simpletotalytd');
            $table = new Simpletotalytd($year_id);

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

        $year_id = getVarClean('year_id','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('report/simpletotalytd');
            $table = new Simpletotalytd($year_id);

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
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['janamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['febamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['maramt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['apramt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['mayamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['junamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['julamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['augamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['sepamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['octamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['novamt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['decamt']).'</td>';
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

            $year_id = getVarClean('year_id','str','');

            $ci = & get_instance();
            $ci->load->model('report/simpletotalytd');
            $table = new Simpletotalytd($year_id);

            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            startExcel("simpletotalytd_".$year_id.".xls");

            $output = '';
            $output .= '<div style="font-size: 18px; font-weight : bold;"> P&L CFU Simple Total</div>';
            $output .= '<div style="font-size: 14px; font-weight : bold;"> Model Year to date '.$year_id.'</div>';

        
            $output .='<table  border="1">';

            $output.='<tr style="background-color: #D64635; color: #ffffff;">';
            $output.='  <th style="vertical-align: middle;">P&L Line Item </th>
                        <th style="vertical-align: middle;">JANUARI </th>
                        <th style="vertical-align: middle;">FEBRUARI </th>
                        <th style="vertical-align: middle;">MARET </th>
                        <th style="vertical-align: middle;">APRIL </th>
                        <th style="vertical-align: middle;">MEI </th>
                        <th style="vertical-align: middle;">JUNI </th>
                        <th style="vertical-align: middle;">JULI </th>
                        <th style="vertical-align: middle;">AGUSTUS </th>
                        <th style="vertical-align: middle;">SEPTEMBER </th>
                        <th style="vertical-align: middle;">OKTOBER </th>
                        <th style="vertical-align: middle;">NOVEMBER </th>
                        <th style="vertical-align: middle;">DESEMBER </th>
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
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['janamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['febamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['maramt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['apramt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['mayamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['junamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['julamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['augamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['sepamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['octamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['novamt']).'</td>';
                        $output .= '<td nowrap align="right" style="'.$stylefont.'">'.number_format($item['decamt']).'</td>';
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

/* End of file Simpletotalytd_controller.php */