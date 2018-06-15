<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_processsummary_controller
* @version 2018-05-25 11:32:24
*/
class Tblt_processsummary_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','n01');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        $i_search = getVarClean('i_search','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_processsummary');
            $table = new Tblt_processsummary($i_process_control_id);

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

            $req_param['where'] = array();
            // Filter Table

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
            logging('view data logprocesscontrol');
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }


    function crud() {

        $data = array();
        $oper = getVarClean('oper', 'str', '');
        switch ($oper) {
            case 'add' :
                //permission_check('can-add-data-master-wib');
                $data = $this->create();
            break;

            case 'edit' :
                //permission_check('can-edit-data-master-wib');
                $data = $this->update();
            break;

            case 'del' :
                //permission_check('can-delete-data-master-wib');
                $data = $this->destroy();
            break;

            default :
                //permission_check('can-view-data-master-wib');
                $data = $this->read();
            break;
        }

        return $data;
    }


    function readTable() {

        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_processsummary');
            $table = new Tblt_processsummary($i_process_control_id);

            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            if($count < 1) {
                exit;
            }

            $output = '';
            $subtotal = array('inamount' => 0,
                                 'outamount' => 0);

/*
           $items[2]['num'] = 3;
           $items[2]['summarycode'] = 'QTY';
           $items[2]['inamount'] = 1;
           $items[2]['objectcode'] = 'DWS';
           $items[2]['outamount'] = 1;

           $items[3]['num'] = 4;
           $items[3]['summarycode'] = '';
           $items[3]['inamount'] = 3;
           $items[3]['objectcode'] = 'SetWINS';
           $items[3]['outamount'] = 5; */


           $init_summarycode = $items[0]['summarycode'];
           foreach($items as $item) {

                if($init_summarycode != $item['summarycode']
                        and $item['summarycode'] != '') {

                            $output .= '<tr>';
                                $output .= '<td>&nbsp;</td>';
                                $output .= '<td><b>Total</b></td>';
                                $output .= '<td align="right"><b>'.numberFormat($subtotal['inamount']).'</b></td>';
                                $output .= '<td>&nbsp;</td>';
                                $output .= '<td align="right"><b>'.numberFormat($subtotal['outamount']).'</b></td>';
                            $output .= '</tr>';

                        $subtotal = array('inamount' => 0,
                                                'outamount' => 0);

                }


                $output .= '<tr>';
                    $output .= '<td>'.$item['num'].'</td>';
                    $output .= '<td>'.$item['summarycode'].'</td>';
                    $output .= '<td align="right">'.numberFormat($item['inamount']).'</td>';
                    $output .= '<td>'.$item['objectcode'].'</td>';
                    $output .= '<td align="right">'.numberFormat($item['outamount']).'</td>';
                $output .= '</tr>';

                $subtotal['inamount'] += $item['inamount'];
                $subtotal['outamount'] += $item['outamount'];
            }

            $output .= '<tr>';
                $output .= '<td>&nbsp;</td>';
                $output .= '<td><b>Total</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($subtotal['inamount']).'</b></td>';
                $output .= '<td>&nbsp;</td>';
                $output .= '<td align="right"><b>'.numberFormat($subtotal['outamount']).'</b></td>';
            $output .= '</tr>';

        }catch (Exception $e) {
            $data = array();
            $data['message'] = $e->getMessage();
            return $data;
        }

        echo $output;
        exit;

    }
}

/* End of file Tblp_logprocesscontrol_controller.php */