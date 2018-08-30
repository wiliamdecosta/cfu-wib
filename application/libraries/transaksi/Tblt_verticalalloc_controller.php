<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_verticalalloc_controller
* @version 2018-05-25 11:32:24
*/
class Tblt_verticalalloc_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','s01');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $processcontrolid_pk = getVarClean('processcontrolid_pk','int',0);
        $i_search = getVarClean('i_search','str','');
        $ubiscode = getVarClean('ubiscode','str','');

        if(empty($ubiscode)) {
            $data['success'] = true;
            return $data;
        }

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_verticalalloc');
            $table = new Tblt_verticalalloc($processcontrolid_pk, $i_search);

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

            $table->setCriteria("upper(s01) = upper('".$ubiscode."')");

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
            logging('view data tblt_verticalalloc');
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



    function do_process() {

        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        $processcode = getVarClean('processcode','str','');
        $i_batch_control_id = getVarClean('i_batch_control_id','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_verticalalloc');
            $table = new Tblt_verticalalloc($i_process_control_id, '');

            $userdata = $ci->session->userdata;

           $sql = "BEGIN "
                    . " pack_VertAlloc.ProcessVertAlloc("
                    . " :i_process_control_id, "
                    . " :i_user_name"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_process_control_id', $i_process_control_id);
            oci_bind_by_name($stmt, ':i_user_name', $userdata['user_name']);

            ociexecute($stmt);

            $data['success'] = true;
            $data['message'] = 'Submit proses '.$processcode.' selesai ';

            $ci->load->model('parameter/tblp_processcontrol');
            $table = new Tblp_processcontrol($i_batch_control_id, '');
            $item = $table->get($i_process_control_id);

            $data['statuscode'] = $item['statuscode'];

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function cancel_process() {

        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        $i_batch_control_id = getVarClean('i_batch_control_id','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_verticalalloc');
            $table = new Tblt_verticalalloc($i_process_control_id, '');

            $userdata = $ci->session->userdata;

            cekCancel($i_process_control_id);
            
            $sql = "BEGIN "
                    . " pack_VertAlloc.CancelVertAlloc("
                    . " :i_process_control_id, "
                    . " :i_user_name"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_process_control_id', $i_process_control_id);
            oci_bind_by_name($stmt, ':i_user_name', $userdata['user_name']);

            ociexecute($stmt);

            $data['success'] = true;
            $data['message'] = 'Cancel proses selesai ';

            $ci->load->model('parameter/tblp_processcontrol');
            $table = new Tblp_processcontrol($i_batch_control_id, '');
            $item = $table->get($i_process_control_id);

            $data['statuscode'] = $item['statuscode'];

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function download_excel() {

            $processcontrolid_pk = getVarClean('processcontrolid_pk', 'int', 0);
            $periodid_fk = getVarClean('periodid_fk', 'int', 0);
            $ubiscode = getVarClean('ubiscode','str','');

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_verticalalloc');
            $table = new Tblt_verticalalloc($processcontrolid_pk, '');

            //$table->setCriteria("upper(s01) = upper('".$ubiscode."')");

            $items = $table->getAll(0, -1);
            $no = 1;

            startExcel("verticalalloc_".$periodid_fk.".xls");

            $output = '';
            $output .='<table  border="1">';

            $output.='<tr>';
                $output.='<th>NO</th>
                            <th>BU/Subsidiary</th>
                            <th>Activity</th>
                            <th>Overhead 1</th>
                            <th>Overhead 2</th>
                            <th>PL Item</th>
                            <th>PCA Amount</th>
                            <th>Pct OH 1</th>
                            <th>Vert Alloc from OH 1</th>
                            <th>Total after Vert Alloc OH 1</th>
                            <th>Pct OH 2</th>
                            <th>Vert Alloc from OH 2</th>
                            <th>Total after Vert Alloc OH 2</th>
                            ';
            $output.='</tr>';

             $subtotal = array('sumpcaamount' => 0,
                                 'sumamountohact1' => 0,
                                'sumvallocact1' => 0,
                                'amountohact2' => 0,
                                'sumvallocact2' => 0);


            $initubiscode = $items[0]['ubiscode'];

            foreach($items as $item) {
                $output .= '<tr>';
                $output .= '<td valign="top">'.$no++.'</td>';
                $output .= '<td valign="top">'.$item['ubiscode'].'</td>';
                $output .= '<td valign="top">'.$item['activityname'].'</td>';
                $output .= '<td valign="top">'.$item['overheadname1'].'</td>';
                $output .= '<td valign="top">'.$item['overheadname2'].'</td>';
                $output .= '<td valign="top">'.$item['plitemname'].'</td>';
                $output .= '<td valign="top" align="right">'.numberFormat($item['pcaamount'],2).'</td>';
                $output .= '<td valign="top" align="right">'.numberFormat($item['pctohact1'],2).' %</td>';
                $output .= '<td valign="top" align="right">'.numberFormat($item['amountohact1'],2).'</td>';
                $output .= '<td valign="top" align="right">'.numberFormat($item['vallocact1'],2).'</td>';
                $output .= '<td valign="top" align="right">'.numberFormat($item['pctohact2'],2).' %</td>';
                $output .= '<td valign="top" align="right">'.numberFormat($item['amountohact2'],2).'</td>';
                $output .= '<td valign="top" align="right">'.numberFormat($item['vallocact2'],2).'</td>';
                $output .= '</tr>';

                $subtotal['sumpcaamount'] += $item['pcaamount'];
                $subtotal['sumamountohact1'] += $item['amountohact1'];
                $subtotal['sumvallocact1'] += $item['vallocact1'];
                $subtotal['amountohact2'] += $item['amountohact2'];
                $subtotal['sumvallocact2'] += $item['vallocact2'];
            }

            // $output .= '<tr>';
            //     $output .= '<td colspan="6" align="center"><b>Total</b></td>';
            //     $output .= '<td valign="top" align="right">'.numberFormat($subtotal['sumpcaamount'],2).'</td>';
            //     $output .= '<td valign="top" align="right"></td>';
            //     $output .= '<td valign="top" align="right">'.numberFormat($subtotal['sumamountohact1'],2).'</td>';
            //     $output .= '<td valign="top" align="right">'.numberFormat($subtotal['sumvallocact1'],2).'</td>';
            //     $output .= '<td valign="top" align="right"></td>';
            //     $output .= '<td valign="top" align="right">'.numberFormat($subtotal['amountohact2'],2).'</td>';
            //     $output .= '<td valign="top" align="right">'.numberFormat($subtotal['sumvallocact2'],2).'</td>';
            // $output .= '</tr>';

            $output .= '</table>';
            echo $output;
            exit;

    }

    function sum_verticalalloc() {

            $processcontrolid_pk = getVarClean('processcontrolid_pk', 'int', 0);
            $ubiscode = getVarClean('ubiscode','str','');

            $data = array('rows' => array(), 'success' => false, 'message' => '');

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_verticalalloc');
            $table = new Tblt_verticalalloc($processcontrolid_pk, '');

            $sql = "SELECT   sum(n01) sum_pcaamount,
                             sum(n03) sum_amountohact1,
                             sum(n04) sum_vallocact1,
                             sum(n06) sum_amountohact2,
                             sum(n07) sum_vallocact2
                      FROM   table (f_ShowVertAlloc (?, '')) where s01 = ? ";

            $result = $table->db->query($sql, array($processcontrolid_pk, $ubiscode));
            $rows = $result->row_array();

            $data['success'] = true;
            $data['message'] = 'sukses';
            $data['rows'] = $rows;
          
            echo json_encode($data);
            exit;

    }

}

/* End of file Tblp_logprocesscontrol_controller.php */