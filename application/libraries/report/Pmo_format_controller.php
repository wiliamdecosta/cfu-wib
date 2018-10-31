<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class pmo_format_controller
* @version 2018-05-25 11:32:24
*/
class Pmo_format_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','');
        $sord = getVarClean('sord','str','');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $bl_id = getVarClean('bl_id','str','');
        $i_budget_ver = getVarClean('i_budget_ver','str','');
        $period = getVarClean('period','str','');

        if(empty($bl_id) && empty($i_budget_ver) && empty($period)){
            $data['success'] = true;
            return $data;
        }

        try {

            $ci = & get_instance();
            $ci->load->model('report/pmo_format');
            $table = new Pmo_format($bl_id, $i_budget_ver, $period);

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

    function readHeader() {
        $bl_id = getVarClean('bl_id','str','');
        $i_budget_ver = getVarClean('i_budget_ver','str','');
        $period = getVarClean('period','str','');
        try{
            $ci = & get_instance();
            $ci->load->model('report/pmo_format');
            $table = new Pmo_format($bl_id, $i_budget_ver, $period);

            $bulan = $table->getMtD($period);
            $tahun = $table->getYtD($period);
            $currmonth = $table->getMonth($period);

        $data['currmonth'] = $currmonth['currmonth'];
        $data['bulan'] = $bulan['bulan'];
        $data['tahun'] = $tahun['tahun'];

        echo json_encode($data);
        exit;

        }catch (Exception $e) {
            $data = array();
            $data['message'] = $e->getMessage();
            echo json_encode($data);
            exit;
        }

        
    }

    function readTable() {

        $bl_id = getVarClean('bl_id','str','');
        $i_budget_ver = getVarClean('i_budget_ver','str','');
        $period = getVarClean('period','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('report/pmo_format');
            $table = new Pmo_format($bl_id, $i_budget_ver, $period);

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

                if($item['bgtype'] == "Y"){
                    // $stylecolor = "background-color: #FBEC88; ";
                    $stylecolor = "background-color: #FAFAD2; ";
                }else{
                    $stylecolor = "background-color: #ffffff; ";
                }

                if($item['pl_name'] != ''){
                    $output .= '<tr style="'.$stylecolor.'">';
                        $output .= '<td nowrap style="'.$stylefont.'">'.$item['pl_name'].'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.$item['unit'].'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['currenr_month_amt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['currenr_month_target']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['currenr_month_real']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['currenr_month_ach']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['currenr_month_mom']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['last_year_amt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['last_year_target']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['last_year_real']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['last_year_ach']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['last_year_mom']).'</td>';
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

            $bl_id = getVarClean('bl_id','str','');
            $i_budget_ver = getVarClean('i_budget_ver','str','');
            $period = getVarClean('period','str','');

            $ci = & get_instance();
            $ci->load->model('report/pmo_format');
            $table = new Pmo_format($bl_id, $i_budget_ver, $period);

            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            $bulan = $table->getMtD($period);
            $tahun = $table->getYtD($period);
            $currmonth = $table->getMonth($period);

            startExcel("pmo_format_".$period.".xls");

            $output = '';
            $output .= '<div style="font-size: 18px; font-weight : bold;"> PMO Format</div>';

        
            $output .='<table  border="1">';

           // $output.='<tr style="background-color: #D64635; color: #ffffff;">';
            $output.='  <tr style=" color: #ffffff;">
                                <th style="vertical-align: middle; background-color: #305496;" rowspan="3">Financial </th>
                                <th style="vertical-align: middle; text-align: center; background-color: #305496;" rowspan="3">UNIT</th>
                                <th style="vertical-align: middle; text-align: center; background-color: #00B0F0; " rowspan="3">'.$currmonth['currmonth'].'</th>
                                <th style="vertical-align: middle; text-align: center; background-color: #00B0F0;" colspan="3">'.$bulan['bulan'].'</th>
                                <th style="vertical-align: middle; text-align: center; background-color: #00B0F0;" rowspan="3">MoM</th>
                                <th style="vertical-align: middle; text-align: center; background-color: #4472C4;" rowspan="3">'.$tahun['tahun'].'</th>
                                <th style="vertical-align: middle; text-align: center; background-color: #4472C4;" colspan="3">'.$bulan['bulan'].'</th>
                                <th style="vertical-align: middle; text-align: center; background-color: #4472C4;" rowspan="3">YoY</th>
                            </tr>
                            <tr style="color: #ffffff;">
                                <th style="vertical-align: middle; text-align: center; background-color: #00B0F0;" colspan="3">MtD</th>
                                <th style="vertical-align: middle; text-align: center; background-color: #4472C4;" colspan="3">YtD</th>
                            </tr>
                            <tr style="color: #ffffff;">
                                <th style="vertical-align: middle; text-align: center; background-color: #00B0F0;">TARGET</th>
                                <th style="vertical-align: middle; text-align: center; background-color: #00B0F0;">REAL</th>
                                <th style="vertical-align: middle; text-align: center; background-color: #00B0F0;">ACH.</th>
                                <th style="vertical-align: middle; text-align: center; background-color: #4472C4;">TARGET</th>
                                <th style="vertical-align: middle; text-align: center; background-color: #4472C4;">REAL</th>
                                <th style="vertical-align: middle; text-align: center; background-color: #4472C4;">ACH</th>
                            </tr>
                         ';
            //$output.='</tr>';

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

                if($item['bgtype'] == "Y"){
                    // $stylecolor = "background-color: #FBEC88; ";
                    $stylecolor = "background-color: #FAFAD2; ";
                }else{
                    $stylecolor = "background-color: #ffffff; ";
                }

                if($item['pl_name'] != ''){
                    $output .= '<tr style="'.$stylecolor.'">';
                       $output .= '<td nowrap style="'.$stylefont.'">'.$item['pl_name'].'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.$item['unit'].'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['currenr_month_amt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['currenr_month_target']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['currenr_month_real']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['currenr_month_ach']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['currenr_month_mom']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['last_year_amt']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['last_year_target']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['last_year_real']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['last_year_ach']).'</td>';
                        $output .= '<td align="right" style="'.$stylefont.'">'.number_format($item['last_year_mom']).'</td>';
                    $output .= '</tr>';
                }else{
                     $output .= '</table>';
                     $output .= '<table>';
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
                    $output .= '</tr>';
                    $output .= '</table>';
                    $output .= '<table border="1">';
                }

            }


            $output .= '</table>';
            echo $output;
            exit;

    }



}

/* End of file pmo_format_controller.php */