<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_costmap_controller
* @version 2018-05-25 11:32:24
*/
class Tblt_costmap_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','s09, s01, s03');
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
            $ci->load->model('transaksi/tblt_costmap');
            $table = new Tblt_costmap($processcontrolid_pk, $i_search);

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

            if(!empty($ubiscode)) {
                $table->setCriteria("upper(s09) = upper('".$ubiscode."')");
            }

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
            logging('view data tblt_costmap');
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
            $ci->load->model('transaksi/tblt_costmap');
            $table = new Tblt_costmap($i_process_control_id, '');

            $userdata = $ci->session->userdata;

           $sql = "BEGIN "
                    . " pack_CostMap.ProcessCostMap("
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
            $ci->load->model('transaksi/tblt_costmap');
            $table = new Tblt_costmap($i_process_control_id, '');

            $userdata = $ci->session->userdata;

           $sql = "BEGIN "
                    . " pack_CostMap.CancelCostMap("
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
            $ci->load->model('transaksi/tblt_costmap');
            $table = new Tblt_costmap($processcontrolid_pk, '');

            $items = $table->getAll(0, -1, 's09, s01, s03', 'asc');
            $no = 1;

            startExcel("cost_map_".$periodid_fk.".xls");

            $output = '';
            $output .='<table  border="1">';

            $output.='<tr>';
                $output.='<th>NO</th>
                            <th>BU/SUBSIDIARY</th>
                            <th>CCCODE</th>
                            <th>CCNAME</th>
                            <th>ACCOUNTCODE</th>
                            <th>ACCOUNTNAME</th>
                            <th>AMOUNT</th>
                            <th>PLITEMNAME</th>
                            <th>ISINDIRECTCOST</th>
                            <th>ACTIVITYNAME</th>
                            <th>ISNEEDPCA</th>
                            ';
            $output.='</tr>';

            foreach($items as $item) {
                $output .= '<tr>';
                $output .= '<td valign="top">'.$no++.'</td>';
                $output .= '<td valign="top">'.$item['ubiscode'].'</td>';
                $output .= '<td valign="top">'.$item['cccode'].'</td>';
                $output .= '<td valign="top">'.$item['ccname'].'</td>';
                $output .= '<td valign="top">'.$item['accountcode'].'</td>';
                $output .= '<td valign="top">'.$item['accountname'].'</td>';
                $output .= '<td valign="top" align="right">'.numberFormat($item['amount'],2).'</td>';
                $output .= '<td valign="top">'.$item['plitemname'].'</td>';
                $output .= '<td valign="top" align="center">'.$item['isindirectcost_display'].'</td>';
                $output .= '<td valign="top">'.$item['activityname'].'</td>';
                $output .= '<td valign="top" align="center">'.$item['isneedpca_display'].'</td>';
                $output .= '</tr>';
            }

            $output .= '</table>';
            echo $output;
            exit;

    }

}

/* End of file Tblp_logprocesscontrol_controller.php */