<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_staffcompmap_controller
* @version 2018-05-25 11:32:24
*/
class Tblt_staffcompmap_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','s02');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        $i_search = getVarClean('i_search','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_staffcompmap');
            $table = new Tblt_staffcompmap($i_process_control_id);

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
        $i_search = getVarClean('i_search','str','');
        $ubiscode = getVarClean('ubiscode','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_staffcompmap');
            $table = new Tblt_staffcompmap($i_process_control_id);

            if(!empty($ubiscode)) {
                $table->setCriteria("upper(s02) = upper('".$ubiscode."')");
            }


            if(!empty($i_search)) {
                $table->setCriteria("upper(s04) like '%".strtoupper($i_search)."%'");
            }

            $count = $table->countAll();
            $items = $table->getAll(0, -1, 's02', 'asc');

            if($count < 1) {  echo ''; exit; }

            $output = '';
            $subtotal = array('staffqty' => 0,
                                 'staffpct' => 0,
                                'compensationvalue' => 0,
                                'compensationpct' => 0);

            $grandtotal = array('staffqty' => 0,
                                 'staffpct' => 0,
                                'compensationvalue' => 0,
                                'compensationpct' => 0);

            $initubiscode = $items[0]['ubiscode'];

            foreach($items as $item) {

                if($initubiscode != $item['ubiscode']) {
                    $output .= '<tr>';
                        $output .= '<td colspan="3" align="center"><b>Total</b></td>';
                        $output .= '<td align="right"><b>'.$subtotal['staffqty'].'</b></td>';
                        $output .= '<td align="right"><b>'.($subtotal['staffpct'] * 100).' %</b></td>';
                        $output .= '<td align="right"><b>'.numberFormat($subtotal['compensationvalue']).'</b></td>';
                        $output .= '<td align="right"><b>'.($subtotal['compensationpct'] * 100).' %</b></td>';
                    $output .= '</tr>';

                    $subtotal = array('staffqty' => 0,
                                 'staffpct' => 0,
                                'compensationvalue' => 0,
                                'compensationpct' => 0);

                    $initubiscode = $item['ubiscode'];
                }

                $output .= '<tr>';
                    $output .= '<td>'.$item['cfucode'].'</td>';
                    $output .= '<td>'.$item['ubiscode'].'</td>';
                    $output .= '<td><a href="javascript:;" onclick="showIndirectCostActivitiesDetail('.$item['periodid_fk'].',\''.$item['cfucode'].'\',\''.$item['ubiscode'].'\',\''.$item['idactivity'].'\');">'.$item['uraian'].'</a></td>';
                    $output .= '<td align="right">'.$item['staffqty'].'</td>';
                    $output .= '<td align="right">'.($item['staffpct'] * 100).' %</td>';
                    $output .= '<td align="right">'.numberFormat($item['compensationvalue']).'</td>';
                    $output .= '<td align="right">'.($item['compensationpct'] * 100).' %</td>';
                $output .= '</tr>';

                $subtotal['staffqty'] += $item['staffqty'];
                $subtotal['staffpct'] += $item['staffpct'];
                $subtotal['compensationvalue'] += $item['compensationvalue'];
                $subtotal['compensationpct'] += $item['compensationpct'];

                $grandtotal['staffqty'] += $item['staffqty'];
                $grandtotal['staffpct'] += $item['staffpct'];
                $grandtotal['compensationvalue'] += $item['compensationvalue'];
                $grandtotal['compensationpct'] += $item['compensationpct'];

            }

            $output .= '<tr>';
                        $output .= '<td colspan="3" align="center"><b>Total</b></td>';
                        $output .= '<td align="right"><b>'.$subtotal['staffqty'].'</b></td>';
                        $output .= '<td align="right"><b>'.($subtotal['staffpct'] * 100).' %</b></td>';
                        $output .= '<td align="right"><b>'.numberFormat($subtotal['compensationvalue']).'</b></td>';
                        $output .= '<td align="right"><b>'.($subtotal['compensationpct'] * 100).' %</b></td>';
                    $output .= '</tr>';

           /*  $output .= '<tr class="success">';
                        $output .= '<td colspan="3" align="center"><b>Grand Total</b></td>';
                        $output .= '<td align="right"><b>'.$grandtotal['staffqty'].'</b></td>';
                        $output .= '<td align="right"><b>'.($grandtotal['staffpct'] * 100).' %</b></td>';
                        $output .= '<td align="right"><b>'.numberFormat($grandtotal['compensationvalue']).'</b></td>';
                        $output .= '<td align="right"><b>'.($grandtotal['compensationpct'] * 100).' %</b></td>';
                    $output .= '</tr>';
 */
        }catch (Exception $e) {
            $data = array();
            $data['message'] = $e->getMessage();
            return $data;
        }

        echo $output;
        exit;

    }

    function do_process() {

        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        $processcode = getVarClean('processcode','str','');
        $i_batch_control_id = getVarClean('i_batch_control_id','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_staffcompmap');
            $table = new Tblt_staffcompmap($i_process_control_id);

            $userdata = $ci->session->userdata;

           $sql = "BEGIN "
                    . " pack_StaffCompMap.InsertStaffCompMap("
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
            $ci->load->model('transaksi/tblt_staffcompmap');
            $table = new Tblt_staffcompmap($i_process_control_id);

            $userdata = $ci->session->userdata;

            cekCancel($i_process_control_id);
            
            $sql = "BEGIN "
                    . " pack_StaffCompMap.CancelStaffCompMap("
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
            $ci->load->model('transaksi/tblt_staffcompmap');
            $table = new Tblt_staffcompmap($processcontrolid_pk);

            //$table->setCriteria("upper(s01) = upper('".$ubiscode."')");

            $count = $table->countAll();
            $items = $table->getAll(0, -1, 's02', 'asc');

            startExcel("staffcompmap".$periodid_fk.".xls");

            $output = '<table border="1">';
            $output .= '<tr>
                                <th>CFU</th>
                                <th>BU/Subsidiary</th>
                                <th>Indirect Cost Activities</th>
                                <th>No of Staff</th>
                                <th>% of Total Staff</th>
                                <th>Total Compensation</th>
                                <th>% of Total Compensation</th>
                            </tr>';

            $subtotal = array('staffqty' => 0,
                                 'staffpct' => 0,
                                'compensationvalue' => 0,
                                'compensationpct' => 0);

            $grandtotal = array('staffqty' => 0,
                                 'staffpct' => 0,
                                'compensationvalue' => 0,
                                'compensationpct' => 0);

            if($count < 1)  {
                $output .= '</table>';
                echo $output;
                exit;
            }

            $initubiscode = $items[0]['ubiscode'];

            foreach($items as $item) {

                if($initubiscode != $item['ubiscode']) {
                    $output .= '<tr>';
                        $output .= '<td colspan="3" align="center"><b>Total</b></td>';
                        $output .= '<td align="right"><b>'.$subtotal['staffqty'].'</b></td>';
                        $output .= '<td align="right"><b>'.($subtotal['staffpct'] * 100).' %</b></td>';
                        $output .= '<td align="right"><b>'.numberFormat($subtotal['compensationvalue']).'</b></td>';
                        $output .= '<td align="right"><b>'.($subtotal['compensationpct'] * 100).' %</b></td>';
                    $output .= '</tr>';

                    $subtotal = array('staffqty' => 0,
                                 'staffpct' => 0,
                                'compensationvalue' => 0,
                                'compensationpct' => 0);

                    $initubiscode = $item['ubiscode'];
                }

                $output .= '<tr>';
                    $output .= '<td>'.$item['cfucode'].'</td>';
                    $output .= '<td>'.$item['ubiscode'].'</td>';
                    $output .= '<td>'.$item['uraian'].'</a></td>';
                    $output .= '<td align="right">'.$item['staffqty'].'</td>';
                    $output .= '<td align="right">'.($item['staffpct'] * 100).' %</td>';
                    $output .= '<td align="right">'.numberFormat($item['compensationvalue']).'</td>';
                    $output .= '<td align="right">'.($item['compensationpct'] * 100).' %</td>';
                $output .= '</tr>';

                $subtotal['staffqty'] += $item['staffqty'];
                $subtotal['staffpct'] += $item['staffpct'];
                $subtotal['compensationvalue'] += $item['compensationvalue'];
                $subtotal['compensationpct'] += $item['compensationpct'];

                $grandtotal['staffqty'] += $item['staffqty'];
                $grandtotal['staffpct'] += $item['staffpct'];
                $grandtotal['compensationvalue'] += $item['compensationvalue'];
                $grandtotal['compensationpct'] += $item['compensationpct'];

            }

            $output .= '<tr>';
                        $output .= '<td colspan="3" align="center"><b>Total</b></td>';
                        $output .= '<td align="right"><b>'.$subtotal['staffqty'].'</b></td>';
                        $output .= '<td align="right"><b>'.($subtotal['staffpct'] * 100).' %</b></td>';
                        $output .= '<td align="right"><b>'.numberFormat($subtotal['compensationvalue']).'</b></td>';
                        $output .= '<td align="right"><b>'.($subtotal['compensationpct'] * 100).' %</b></td>';
                    $output .= '</tr>';

            $output .= '</table>';
            echo $output;
            exit;

    }
}

/* End of file Tblp_logprocesscontrol_controller.php */