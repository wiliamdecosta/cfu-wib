<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_payrollcost_controller
* @version 2018-05-24 14:29:35
*/
class Tblt_payrollcost_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','periodif_fk');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_payrollcost');
            $table = $ci->tblt_payrollcost;

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
            logging('view data master activity');
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }



    function readLov() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',1000);

        $sort = getVarClean('sort','str','periodid_fk');
        $dir  = getVarClean('dir','str','asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $periodid_fk = getVarClean('periodid_fk', 'int', 0);
        $cfucode = getVarClean('cfucode', 'str', '');
        $ubiscode = getVarClean('ubiscode', 'str', '');
        $idactivity = getVarClean('idactivity', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_payrollcost');
            $table = $ci->tblt_payrollcost;

            if(!empty($searchPhrase)) {
                /*$table->setCriteria("upper(code) like upper('%".$searchPhrase."%') OR
                                         upper(buname) like upper('%".$searchPhrase."%')");
                */
            }

            $table->setCriteria("periodid_fk = ".$periodid_fk);
            $table->setCriteria("cfucode = '".$cfucode."'");
            $table->setCriteria("ubiscode = '".$ubiscode."'");
            $table->setCriteria("idactivity = '".$idactivity."'");

            $start = ($start-1) * $limit;
            $items = $table->getAll($start, $limit, $sort, $dir);
            $totalcount = $table->countAll();

            $data['rows'] = $items;
            $data['success'] = true;
            $data['total'] = $totalcount;

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
                permission_check('can-add-data-master-wib');
                $data = $this->create();
            break;

            case 'edit' :
                permission_check('can-edit-data-master-wib');
                $data = $this->update();
            break;

            case 'del' :
                permission_check('can-delete-data-master-wib');
                $data = $this->destroy();
            break;

            default :
                permission_check('can-view-data-master-wib');
                $data = $this->read();
            break;
        }

        return $data;
    }

    function download_summary() {

            $periodid_fk = getVarClean('periodid_fk', 'int', 0);
            $cfucode = getVarClean('cfucode', 'str', '');
            $ubiscode = getVarClean('ubiscode', 'str', '');
            $idactivity = getVarClean('idactivity', 'str', '');


            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_payrollcost');
            $table = $ci->tblt_payrollcost;

            if(!empty($searchPhrase)) {
                /*$table->setCriteria("upper(code) like upper('%".$searchPhrase."%') OR
                                         upper(buname) like upper('%".$searchPhrase."%')");
                */
            }

            $table->setCriteria("periodid_fk = ".$periodid_fk);
            $table->setCriteria("cfucode = '".$cfucode."'");
            $table->setCriteria("ubiscode = '".$ubiscode."'");
            $table->setCriteria("idactivity = '".$idactivity."'");

            $items = $table->getAll(0, -1, 'periodid_fk', 'asc');
            $no = 1;

            startExcel("payroll_cost_".$periodid_fk.".xls");

            $output = '';
            $output .='<table  border="1">';

            $output.='<tr>';
                $output.='<th>NO</th>
                            <th>PERIODID</th>
                            <th>IDDIVISI</th>
                            <th>NOMOR</th>
                            <th>AREA</th>
                            <th>SUBAREA</th>
                            <th>BANDPOSISI</th>
                            <th>HOSTGROUP</th>
                            <th>HOSTCODE</th>
                            <th>BASESLR</th>
                            <th>MAHAL</th>
                            <th>TUNJANGANPAJAK</th>
                            <th>PREMIUM</th>
                            <th>ASKEDIR</th>
                            <th>BBP</th>
                            <th>ADJBBP</th>
                            <th>LEMBUR</th>
                            <th>INSJABATAN</th>
                            <th>ADJINSJABATAN</th>
                            <th>BPJS</th>
                            <th>DPLK</th>
                            <th>JKK</th>
                            <th>JHT</th>
                            <th>JKM</th>
                            <th>BPJSJP</th>
                            <th>RAPELBPJSJP</th>
                            <th>POSASKEDIR</th>
                            <th>KOPEG</th>
                            <th>SUMB</th>
                            <th>TASPEN</th>
                            <th>RAPELTASPEN</th>
                            <th>OTHERS</th>
                            <th>TOTALSALARY</th>
                            <th>IDLOKER</th>
                            <th>IDPOSISI</th>
                            <th>KETAREA</th>
                            <th>CFUCODE</th>
                            <th>UBISCODE</th>
                            <th>IDACTIVITY</th>';
            $output.='</tr>';

            foreach($items as $item) {
                $output .= '<tr>';
                $output .= '<td>'.$no++.'</td>';
                $output .= '<td>'.$item['periodid_fk'].'</td>';
                $output .= '<td>'.$item['iddivisi'].'</td>';
                $output .= '<td>'.$item['nomor'].'</td>';
                $output .= '<td>'.$item['area'].'</td>';
                $output .= '<td>'.$item['subarea'].'</td>';
                $output .= '<td>'.$item['bandposisi'].'</td>';
                $output .= '<td>'.$item['hostgroup'].'</td>';
                $output .= '<td>'.$item['hostcode'].'</td>';
                $output .= '<td align="right">'.$item['baseslr'].'</td>';
                $output .= '<td align="right">'.$item['mahal'].'</td>';
                $output .= '<td align="right">'.$item['tunjanganpajak'].'</td>';
                $output .= '<td align="right">'.$item['premium'].'</td>';
                $output .= '<td align="right">'.$item['askedir'].'</td>';
                $output .= '<td align="right">'.$item['bbp'].'</td>';
                $output .= '<td align="right">'.$item['adjbbp'].'</td>';
                $output .= '<td align="right">'.$item['lembur'].'</td>';
                $output .= '<td align="right">'.$item['insjabatan'].'</td>';
                $output .= '<td align="right">'.$item['adjinsjabatan'].'</td>';
                $output .= '<td align="right">'.$item['bpjs'].'</td>';
                $output .= '<td align="right">'.$item['dplk'].'</td>';
                $output .= '<td align="right">'.$item['jkk'].'</td>';
                $output .= '<td align="right">'.$item['jht'].'</td>';
                $output .= '<td align="right">'.$item['jkm'].'</td>';
                $output .= '<td align="right">'.$item['bpjsjp'].'</td>';
                $output .= '<td align="right">'.$item['rapelbpjsjp'].'</td>';
                $output .= '<td align="right">'.$item['posaskedir'].'</td>';
                $output .= '<td align="right">'.$item['kopeg'].'</td>';
                $output .= '<td align="right">'.$item['sumb'].'</td>';
                $output .= '<td align="right">'.$item['taspen'].'</td>';
                $output .= '<td align="right">'.$item['rapeltaspen'].'</td>';
                $output .= '<td align="right">'.$item['others'].'</td>';
                $output .= '<td align="right">'.$item['totalsalary'].'</td>';
                $output .= '<td>'.$item['idloker'].'</td>';
                $output .= '<td>'.$item['idposisi'].'</td>';
                $output .= '<td>'.$item['ketarea'].'</td>';
                $output .= '<td>'.$item['cfucode'].'</td>';
                $output .= '<td>'.$item['ubiscode'].'</td>';
                $output .= '<td>'.$item['idactivity'].'</td>';
                $output .= '</tr>';
            }

            $output .= '</table>';
            echo $output;
            exit;

    }


    function do_process() {

        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        $processcode = getVarClean('processcode','str','');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_payrollcost');
            $table = $ci->tblt_payrollcost;

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

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function cancel_process() {

        $i_process_control_id = getVarClean('i_process_control_id','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_payrollcost');
            $table = $ci->tblt_payrollcost;

            $userdata = $ci->session->userdata;

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

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

}

/* End of file Activity_controller.php */