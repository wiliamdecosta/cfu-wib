<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_elimination_controller
* @version 2018-05-25 11:32:24
*/
class Tblt_elimination_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_process_control_id = getVarClean('processcontrolid_pk','int',0);
        $i_search = getVarClean('i_search','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_elimination');
            $table = new Tblt_elimination($i_process_control_id, $i_search);

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
             if(!empty($i_search)) {
                $table->setCriteria("( upper(s01) like upper('%".$i_search."%') OR
                                                upper(s02) like upper('%".$i_search."%') OR
                                                upper(s03) like upper('%".$i_search."%') OR
                                                upper(s04) like upper('%".$i_search."%')
                                            )");
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
            logging('view data tblt_elimination');
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


    function do_upload() {

        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        $processcode = getVarClean('processcode','str','');
        $i_batch_control_id = getVarClean('i_batch_control_id','int',0);
        $periodid_fk = getVarClean('periodid_fk','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_elimination');
            $table = new Tblt_elimination($i_process_control_id, '');

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

                // $table->db->set(array('description' => $config['file_name']));
                // $table->db->where("pprocesscontrolid_pk",$i_process_control_id);
                // $table->db->update('COLLTGROUP.TBLP_PROCESSCONTROL');

                $inputFileName = $config['upload_path'].$config['file_name'];
                include 'phpexcel/PHPExcel/IOFactory.php';
                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                $count = 0;
                foreach($sheetData as $row => $item) {
                    if(count($item) != 9) {
                        throw new Exception('Jumlah kolom file excel tidak sesuai');
                    }
                    if($row == 1) continue; //header

                    $record = array();
                    $record['periodid_fk'] = $periodid_fk;
                    $record['plitemname'] = $objPHPExcel->getActiveSheet()->getCell('A'.$row)->getValue();
                    $record['domtrafficamount'] = $objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue();
                    $record['domnetworkamount'] = $objPHPExcel->getActiveSheet()->getCell('C'.$row)->getValue();
                    $record['intltrafficamount'] = $objPHPExcel->getActiveSheet()->getCell('D'.$row)->getValue();
                    $record['intlnetworkamount'] = $objPHPExcel->getActiveSheet()->getCell('E'.$row)->getValue();
                    $record['totalcarrieramount'] = $objPHPExcel->getActiveSheet()->getCell('F'.$row)->getValue();
                    $record['intladjacentamount'] = $objPHPExcel->getActiveSheet()->getCell('G'.$row)->getValue();
                    $record['toweramount'] = $objPHPExcel->getActiveSheet()->getCell('H'.$row)->getValue();
                    $record['infraamount'] = $objPHPExcel->getActiveSheet()->getCell('I'.$row)->getValue();
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
                    . " pack_PLElimination.ProcessPLElimination("
                    . " :i_process_control_id, "
                    . " :i_user_name"
                    . "); END;";

                    $stmt = oci_parse($table->db->conn_id, $sql);

                    //  Bind the input parameter
                    oci_bind_by_name($stmt, ':i_process_control_id', $i_process_control_id);
                    oci_bind_by_name($stmt, ':i_user_name', $userdata['user_name']);


                    ociexecute($stmt);

                    // if($o_result_code == 0) {
                    //     $data['success'] = true;
                    // }

                    $data['success'] = true;
                    $data['message'] = 'Berhasil Upload File Excel';
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
            $ci->load->model('transaksi/tblt_elimination');
            $table = new Tblt_elimination($i_process_control_id, '');

            $userdata = $ci->session->userdata;

            cekCancel($i_process_control_id);

            $sql = "BEGIN "
                    . " pack_PLElimination.CancelPLElimination("
                    . " :i_process_control_id, "
                    . " :i_user_name"
                    . "); END;";

                    $stmt = oci_parse($table->db->conn_id, $sql);

                    //  Bind the input parameter
                    oci_bind_by_name($stmt, ':i_process_control_id', $i_process_control_id);
                    oci_bind_by_name($stmt, ':i_user_name', $userdata['user_name']);


                    ociexecute($stmt);

                    $data['success'] = true;
                    $data['message'] = 'Berhasil Cancel Upload File Excel';

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
            $ci->load->model('transaksi/tblt_elimination');
            $table = new Tblt_elimination($processcontrolid_pk, '');

            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            startExcel("elimination_".$periodid_fk.".xls");

            $output = '';
            $output .='<table  border="1">';

            $output.='<tr>';                         
            $output.='  <th>PL Item</th>
                        <th>Domestic Traffic</th>
                        <th>Domestic Network</th>
                        <th>International Traffic</th>
                        <th>International Network</th>
                        <th>Carrier Total</th>
                        <th>International Adjacent</th>
                        <th>Towers</th>
                        <th>Infrastructure</th>
                        <th>PL Item Group</th>
                        ';
            $output.='</tr>';

            if($count < 1)  {
                $output .= '</table>';
                echo $output;
                exit;
            }

            foreach($items as $item) {
                $output .= '<tr>';                    
                    $output .= '<td>'.$item['plitemname'].'</td>';
                    $output .= '<td align="right">'.numberFormat($item['domtrafficamount'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['domnetworkamount'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['intltrafficamount'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['intlnetworkamount'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['totalcarrieramount'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['intladjacentamount'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['toweramount'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['infraamount'],2).'</td>';
                    $output .= '<td>'.$item['plgroupname'].'</td>';
                $output .= '</tr>';

            }


            $output .= '</table>';
            echo $output;
            exit;

    }


}

/* End of file Tblt_elimination_controller.php */