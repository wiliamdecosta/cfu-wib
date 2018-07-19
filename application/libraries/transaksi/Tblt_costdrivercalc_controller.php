<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_costdrivercalc_controller
* @version 2018-05-24 16:18:32
*/
class Tblt_costdrivercalc_controller {

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
            $ci->load->model('transaksi/tblt_costdrivercalc');
            $table = new Tblt_costdrivercalc($i_process_control_id, $i_search);

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
            logging('view data tblt_costdrivercalc');
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
            $ci->load->model('transaksi/tblt_costdrivercalc');
            $table = new Tblt_costdrivercalc($i_process_control_id, '');

            $userdata = $ci->session->userdata;

           $sql = "BEGIN "
                    . " pack_CostDriver.ProcessCDCalc("
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
            $ci->load->model('transaksi/tblt_costdrivercalc');
            $table = new Tblt_costdrivercalc($i_process_control_id, '');

            $userdata = $ci->session->userdata;

            cekCancel($i_process_control_id);
            
            $sql = "BEGIN "
                    . " pack_CostDriver.CancelCDCalc("
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
            $ci->load->model('transaksi/tblt_costdrivercalc');
            $table = new Tblt_costdrivercalc($processcontrolid_pk, '');

            $count = $table->countAll();
            $items = $table->getAll(0, -1, 'n03', 'asc');
            $no = 1;

            startExcel("costdrivercalc_".$periodid_fk.".xls");

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

/* End of file Tblt_costdrivercalc_controller.php */