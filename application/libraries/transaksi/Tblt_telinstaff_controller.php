<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_telinstaff_controller
* @version 2018-05-25 11:32:24
*/
class Tblt_telinstaff_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','s02');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_process_control_id = getVarClean('processcontrolid_pk','int',0);
        $i_search = getVarClean('i_search','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_telinstaff');
            $table = new Tblt_telinstaff($i_process_control_id, $i_search);

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
            logging('view data tblt_segregationact');
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

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_telinstaff');
            $table = new Tblt_telinstaff($i_process_control_id, $i_search);


            $count = $table->countAll();
            $items = $table->getAll(0, -1, 's02', 'asc');

            $output = '';

            foreach($items as $item) {
                $output .= '<tr>
                                    <td>'.$item['activityname'].'</td>
                                    <td align="right">'.numberFormat($item['pctstaff'],2).'</td>
                                    <td align="right">'.numberFormat($item['pctcompensation'],2).'</td>
                                    <td>'.$item['activitycode'].'</td>
                                </tr>';
            }

        }catch (Exception $e) {
            $data = array();
            $data['message'] = $e->getMessage();
            return $data;
        }

        echo $output;
        exit;

    }


    function do_upload() {

        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        $processcode = getVarClean('processcode','str','');
        $i_batch_control_id = getVarClean('i_batch_control_id','int',0);
        $periodid_fk = getVarClean('periodid_fk','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_telinstaff');
            $table = new Tblt_telinstaff($i_process_control_id, '');

            $path = $_FILES['filename']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);

            $config = array();

            $config['upload_path'] = 'upload/telin/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '10000000';
            $config['overwrite'] = TRUE;
            $config['file_name'] = str_replace(" ","_",strtolower($path));

            $ci->load->library('upload');
            $ci->upload->initialize($config);

            if (!$ci->upload->do_upload("filename")) {
                throw new Exception( $ci->upload->display_errors() );
            }else{

                $table->db->set(array('description' => $config['file_name']));
                $table->db->where("pprocesscontrolid_pk",$i_process_control_id);
                $table->db->update('COLLTGROUP.TBLP_PROCESSCONTROL');

                $inputFileName = $config['upload_path'].$config['file_name'];
                include 'phpexcel/PHPExcel/IOFactory.php';
                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                $count = 0;
                foreach($sheetData as $row => $item) {

                    if(count($item) != 3) {
                        throw new Exception('Jumlah kolom file excel tidak sesuai');
                    }
                    if($row == 1) continue; //header

                    $record = array();
                    $record['periodid_fk'] = $periodid_fk;

                    $record['activityname'] = $objPHPExcel->getActiveSheet()->getCell('A'.$row)->getValue();
                    $record['pctstaff'] = (float) str_replace('%','',$objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue()); //number
                    $record['pctcompensation'] = (float) str_replace('%','',$objPHPExcel->getActiveSheet()->getCell('C'.$row)->getValue()); //number
                    $record['pprocesscontrolid_fk'] = $i_process_control_id;

                    $table->db->set( $record );
                    $table->db->insert( $table->table );

                    $count++;
                }

                if($count == 0) {
                    throw new Exception('Data excel kosong');
                }else {
                    $userdata = $ci->session->userdata;

                    $sql = "BEGIN "
                    . " pack_TelinUpload.FillActivityIdStaff("
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
                }

            }


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
            $ci->load->model('transaksi/tblt_telinstaff');
            $table = new Tblt_telinstaff($i_process_control_id, '');

            $userdata = $ci->session->userdata;

            $sql = "BEGIN "
                    . " pack_TelinUpload.CancelTelinStaff("
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



}

/* End of file Tblp_tblt_segregationact_controller.php */