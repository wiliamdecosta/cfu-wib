<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_costdriverentry_controller
* @version 2018-05-24 16:18:32
*/
class Tblt_costdriverentry_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','n03');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');
        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        $i_search = getVarClean('i_search','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_costdriverentry');
            $table = new Tblt_costdriverentry($i_process_control_id, $i_search);

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
            logging('view data tblt_costdriverentry');
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


    function create() {


        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $errors = array();

        if (isset($items[0])){

        }else {

            try{


                $ci = & get_instance();
                $ci->load->model('transaksi/tblt_costdriverentry');
                $table = new Tblt_costdriverentry($items['pprocesscontrolid_fk'], '');

                $table->db->trans_begin(); //Begin Trans

                    $record = array();
                    $record['periodid_fk'] = $items['periodid_fk'];
                    $record['code'] = $items['code'];
                    $record['ubiscode'] = $items['ubiscode'];
                    $record['unitid_fk'] = $items['unitid_fk'];
                    $record['listingno'] = $items['listingno'];
                    $record['domtrafficvalue'] = $items['domtrafficvalue'];
                    $record['domnetworkvalue'] = $items['domnetworkvalue'];
                    $record['intltrafficvalue'] = $items['intltrafficvalue'];
                    $record['intlnetworkvalue'] = $items['intlnetworkvalue'];
                    $record['intladjacentvalue'] = $items['intladjacentvalue'];
                    $record['towervalue'] = $items['towervalue'];
                    $record['infravalue'] = $items['infravalue'];
                    $record['pprocesscontrolid_fk'] = $items['pprocesscontrolid_fk'];

                    $table->db->set( $record );
                    $table->db->insert( $table->table );

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data added successfully';
                logging('create data tblt_costdriverentry');

            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function update() {


        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        if (isset($items[0])){

        }else {

            try{

                $ci = & get_instance();
                $ci->load->model('transaksi/tblt_costdriverentry');
                $table = new Tblt_costdriverentry($items['pprocesscontrolid_fk'], '');

                $table->db->trans_begin(); //Begin Trans

                    $keys = array();
                    $keys['periodid_fk'] = $items['periodid_fk'];
                    $keys['code'] = $items['code'];
                    $keys['ubiscode'] = $items['ubiscode'];


                    $record = array();
                    $record['listingno'] = $items['listingno'];
                    $record['domtrafficvalue'] = $items['domtrafficvalue'];
                    $record['domnetworkvalue'] = $items['domnetworkvalue'];
                    $record['intltrafficvalue'] = $items['intltrafficvalue'];
                    $record['intlnetworkvalue'] = $items['intlnetworkvalue'];
                    $record['intladjacentvalue'] = $items['intladjacentvalue'];
                    $record['towervalue'] = $items['towervalue'];
                    $record['infravalue'] = $items['infravalue'];

                    $table->db->set($record);
                    $table->db->where("periodid_fk",$keys['periodid_fk']);
                    $table->db->where("code",$keys['code']);
                    $table->db->where("ubiscode",$keys['ubiscode']);
                    $table->db->update($table->table);

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data update successfully';
                logging('update data tblt_costdriverentry');

            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function destroy() {

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        try{

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_costdriverentry');
            $table = new Tblt_costdriverentry($items['pprocesscontrolid_fk'], '');

            $table->db->trans_begin(); //Begin Trans

            $total = 0;
            if (is_array($items)){
                $keys = array();
                $keys['periodid_fk'] = $items['periodid_fk'];
                $keys['code'] = $items['code'];
                $keys['ubiscode'] = $items['ubiscode'];

                $table->db->where('periodid_fk', $keys['periodid_fk']);
                $table->db->where('code', $keys['code']);
                $table->db->where('ubiscode', $keys['ubiscode']);
                $table->db->delete($table->table);

                $data['total'] = $total = 1;
                $data['success'] = true;
                $data['message'] = $total.' Data deleted successfully';
                logging('delete data tblt_costdriverentry');
            }

            $table->db->trans_commit(); //Commit Trans

        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
            $data['rows'] = array();
            $data['total'] = 0;
        }
        return $data;
    }

    function copy_default() {

        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        $processcode = getVarClean('processcode','str','');
        $i_batch_control_id = getVarClean('i_batch_control_id','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_costdriverentry');

            $table = new Tblt_costdriverentry($i_process_control_id, '');

            $userdata = $ci->session->userdata;

           $sql = "BEGIN "
                    . " pack_CostDriver.CopyCostDriverEntry("
                    . " :i_process_control_id, "
                    . " :i_user_name,"
                    . " :o_result_msg, "
                    . " :o_result_code "
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_process_control_id', $i_process_control_id);
            oci_bind_by_name($stmt, ':i_user_name', $userdata['user_name']);

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_result_msg', $o_result_msg, 2000000);
            oci_bind_by_name($stmt, ':o_result_code', $o_result_code, 2000000);


            ociexecute($stmt);

             if($o_result_code == 0) {
                $data['success'] = true;
            }

            $data['o_result_code'] = $o_result_code;
            $data['message'] = $o_result_msg;

            $ci->load->model('parameter/tblp_processcontrol');
            $table = new Tblp_processcontrol($i_batch_control_id, '');
            $item = $table->get($i_process_control_id);

            $data['statuscode'] = $item['statuscode'];

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }


    function copy_periode_lalu() {

        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        $processcode = getVarClean('processcode','str','');
        $i_batch_control_id = getVarClean('i_batch_control_id','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_costdriverentry');

            $table = new Tblt_costdriverentry($i_process_control_id, '');

            $userdata = $ci->session->userdata;

           $sql = "BEGIN "
                    . " pack_CostDriver.CopyPrevPeriod("
                    . " :i_process_control_id, "
                    . " :i_user_name,"
                    . " :o_result_msg, "
                    . " :o_result_code "
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_process_control_id', $i_process_control_id);
            oci_bind_by_name($stmt, ':i_user_name', $userdata['user_name']);

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_result_msg', $o_result_msg, 2000000);
            oci_bind_by_name($stmt, ':o_result_code', $o_result_code, 2000000);


            ociexecute($stmt);

             if($o_result_code == 0) {
                $data['success'] = true;
            }

            $data['o_result_code'] = $o_result_code;
            $data['message'] = $o_result_msg;

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
            $ci->load->model('transaksi/tblt_costdriverentry');
            $table = new Tblt_costdriverentry($i_process_control_id, '');

            $userdata = $ci->session->userdata;

            cekCancel($i_process_control_id);

            $sql = "BEGIN "
                    . " pack_CostDriver.CancelCDEntry("
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


            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_costdriverentry');
            $table = new Tblt_costdriverentry($processcontrolid_pk, '');

            $count = $table->countAll();
            $items = $table->getAll(0, -1, 'n03', 'asc');
            $no = 1;

            startExcel("costdriverentry_".$periodid_fk.".xls");

            $output = '';
            $output .='<table  border="1">';

            $output.='<tr>';
                $output.='<th>NO</th>
                            <th>UBIS/SUBSIDIARY</th>
                            <th>COST DRIVER</th>
                            <th>UNIT</th>
                            <th>DOM TRAFFIC</th>
                            <th>DOM NETWORK</th>
                            <th>INTL TRAFFIC</th>
                            <th>INTL NETWORK</th>
                            <th>INTL ADJACENT</th>
                            <th>TOWER</th>
                            <th>INFRASTRUCTURE</th>
                            ';
            $output.='</tr>';

            $subtotal = array('domtrafficvalue' => 0,
                                    'domnetworkvalue' => 0,
                                    'intltrafficvalue' => 0,
                                    'intlnetworkvalue' => 0,
                                    'intladjacentvalue' => 0,
                                    'towervalue' => 0,
                                    'infravalue' => 0
                                );

            if($count < 1)  {
                $output .= '</table>';
                echo $output;
                exit;
            }

            $initubiscode = $items[0]['ubiscode'];

            foreach($items as $item) {

                if($initubiscode != $item['ubiscode']) {
                    $output .= '<tr>';
                        $output .= '<td colspan="4" align="center"><b>Total</b></td>';
                        $output .= '<td align="right"><b>'.numberFormat($subtotal['domtrafficvalue'],2).'</b></td>';
                        $output .= '<td align="right"><b>'.numberFormat($subtotal['domnetworkvalue'],2).'</b></td>';
                        $output .= '<td align="right"><b>'.numberFormat($subtotal['intltrafficvalue'],2).'</b></td>';
                        $output .= '<td align="right"><b>'.numberFormat($subtotal['intlnetworkvalue'],2).'</b></td>';
                        $output .= '<td align="right"><b>'.numberFormat($subtotal['intladjacentvalue'],2).'</b></td>';
                        $output .= '<td align="right"><b>'.numberFormat($subtotal['towervalue'],2).'</b></td>';
                        $output .= '<td align="right"><b>'.numberFormat($subtotal['infravalue'],2).'</b></td>';
                    $output .= '</tr>';

                    $subtotal = array('domtrafficvalue' => 0,
                                    'domnetworkvalue' => 0,
                                    'intltrafficvalue' => 0,
                                    'intlnetworkvalue' => 0,
                                    'intladjacentvalue' => 0,
                                    'towervalue' => 0,
                                    'infravalue' => 0
                                );

                    $initubiscode = $item['ubiscode'];
                }

                $output .= '<tr>';
                $output .= '<td valign="top">'.$no++.'</td>';
                $output .= '<td valign="top">'.$item['ubiscode'].'</td>';
                $output .= '<td valign="top">'.$item['costdriver'].'</td>';
                $output .= '<td valign="top">'.$item['unitcode'].'</td>';

                $output .= '<td valign="top" align="right"><b>'.numberFormat($item['domtrafficvalue'],2).'</b></td>';
                $output .= '<td valign="top" align="right"><b>'.numberFormat($item['domnetworkvalue'],2).'</b></td>';
                $output .= '<td valign="top" align="right"><b>'.numberFormat($item['intltrafficvalue'],2).'</b></td>';
                $output .= '<td valign="top" align="right"><b>'.numberFormat($item['intlnetworkvalue'],2).'</b></td>';
                $output .= '<td valign="top" align="right"><b>'.numberFormat($item['intladjacentvalue'],2).'</b></td>';
                $output .= '<td valign="top" align="right"><b>'.numberFormat($item['towervalue'],2).'</b></td>';
                $output .= '<td valign="top" align="right"><b>'.numberFormat($item['infravalue'],2).'</b></td>';

                $output .= '</tr>';

                $subtotal['domtrafficvalue'] += $item['domtrafficvalue'];
                $subtotal['domnetworkvalue'] += $item['domnetworkvalue'];
                $subtotal['intltrafficvalue'] += $item['intltrafficvalue'];
                $subtotal['intlnetworkvalue'] += $item['intlnetworkvalue'];
                $subtotal['intladjacentvalue'] += $item['intladjacentvalue'];
                $subtotal['towervalue'] += $item['towervalue'];
                $subtotal['infravalue'] += $item['infravalue'];

            }

             $output .= '<tr>';
                $output .= '<td colspan="4" align="center"><b>Total</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($subtotal['domtrafficvalue'],2).'</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($subtotal['domnetworkvalue'],2).'</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($subtotal['intltrafficvalue'],2).'</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($subtotal['intlnetworkvalue'],2).'</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($subtotal['intladjacentvalue'],2).'</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($subtotal['towervalue'],2).'</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($subtotal['infravalue'],2).'</b></td>';
            $output .= '</tr>';

            $output .= '</table>';
            echo $output;
            exit;

    }

}

/* End of file Period_controller.php */