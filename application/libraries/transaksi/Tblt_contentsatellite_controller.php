<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_contentsatellite_controller
* @version 2018-05-25 11:32:24
*/
class Tblt_contentsatellite_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','s01');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_process_control_id = getVarClean('i_process_control_id','int',0);
        $i_search = getVarClean('i_search','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_contentsatellite');
            $table = new Tblt_contentsatellite($i_process_control_id, $i_search);

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
            logging('view data tblt_pca');
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
            $ci->load->model('transaksi/tblt_contentsatellite');
            $table = new Tblt_contentsatellite($i_process_control_id, $i_search);

            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            if($count < 1) {  echo ''; exit; }

            $output = '';
            $total = array('totdomtrafficamt' => 0,
                              'totdomnetworkamt' => 0,
                              'totintltrafficamt' => 0,
                              'totintlnetworkamt' => 0,
                              'totintladjacentamt' => 0,
                              'tottoweramt' => 0,
                              'totinfraamt' => 0);


            foreach($items as $item) {

                $output .= '<tr>';
                    $output .= '<td nowrap>'.$item['plgroup'].'</td>';
                    $output .= '<td nowrap>'.$item['plitemname'].'</td>';
                    $output .= '<td nowrap align="right">'.numberFormat($item['domtrafficamt'],2).'</td>';
                    $output .= '<td nowrap align="right">'.numberFormat($item['domnetworkamt'],2).'</td>';
                    $output .= '<td nowrap align="right">'.numberFormat($item['intltrafficamt'],2).'</td>';
                    $output .= '<td nowrap align="right">'.numberFormat($item['intlnetworkamt'],2).'</td>';
                    $output .= '<td nowrap align="right">'.numberFormat($item['intladjacentamt'],2).'</td>';
                    $output .= '<td nowrap align="right">'.numberFormat($item['toweramt'],2).'</td>';
                    $output .= '<td nowrap align="right">'.numberFormat($item['infraamt'],2).'</td>';
                $output .= '</tr>';

                $total['totdomtrafficamt'] += $item['domtrafficamt'];
                $total['totdomnetworkamt'] += $item['domnetworkamt'];
                $total['totintltrafficamt'] += $item['intltrafficamt'];
                $total['totintlnetworkamt'] += $item['intlnetworkamt'];
                $total['totintladjacentamt'] += $item['intladjacentamt'];
                $total['tottoweramt'] += $item['toweramt'];
                $total['totinfraamt'] += $item['infraamt'];

            }

            $output .= '<tr>';
                $output .= '<td colspan="2" align="center"><b>Total</b></td>';
                $output .= '<td nowrap align="right"><b>'.numberFormat($total['totdomtrafficamt'],2).'</b></td>';
                $output .= '<td nowrap align="right"><b>'.numberFormat($total['totdomnetworkamt'],2).'</b></td>';
                $output .= '<td nowrap align="right"><b>'.numberFormat($total['totintltrafficamt'],2).'</b></td>';
                $output .= '<td nowrap align="right"><b>'.numberFormat($total['totintlnetworkamt'],2).'</b></td>';
                $output .= '<td nowrap align="right"><b>'.numberFormat($total['totintladjacentamt'],2).'</b></td>';
                $output .= '<td nowrap align="right"><b>'.numberFormat($total['tottoweramt'],2).'</b></td>';
                $output .= '<td nowrap align="right"><b>'.numberFormat($total['totinfraamt'],2).'</b></td>';

            $output .= '</tr>';



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
            $ci->load->model('transaksi/tblt_contentsatellite');
            $table = new Tblt_contentsatellite($i_process_control_id, '');

            $userdata = $ci->session->userdata;

           $sql = "BEGIN "
                    . " pack_ContentSatellite.ProcessSatellite("
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
            $ci->load->model('transaksi/tblt_contentsatellite');
            $table = new Tblt_contentsatellite($i_process_control_id, '');

            $userdata = $ci->session->userdata;

           $sql = "BEGIN "
                    . " pack_ContentSatellite.CancelSatellite("
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
            $ci->load->model('transaksi/tblt_contentsatellite');
            $table = new Tblt_contentsatellite($processcontrolid_pk, '');

            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            startExcel("pca_".$periodid_fk.".xls");

            $output = '';
            $output .='<table  border="1">';

            $output.='<tr>';
            $output.='  <th></th>
                        <th></th>
                        <th style="text-align: center;" colspan="4">Carrier</th>
                        <th>Intl Adjacent</th>
                        <th>Towers</th>
                        <th>Infrastructure</th>';
            $output.='</tr>';

            $output.='<tr>';                         
            $output.='  <th>Group</th>
                        <th>PL Item</th>
                        <th>Domestic Traffic</th>
                        <th>Domestic Network</th>
                        <th>Intl Traffic</th>
                        <th>Intl Network</th>
                        <th>Intl Adjacent</th>
                        <th>Towers</th>
                        <th>Infrastructure</th>
                        ';
            $output.='</tr>';

            if($count < 1)  {
                $output .= '</table>';
                echo $output;
                exit;
            }

            $total = array('totdomtrafficamt' => 0,
                              'totdomnetworkamt' => 0,
                              'totintltrafficamt' => 0,
                              'totintlnetworkamt' => 0,
                              'totintladjacentamt' => 0,
                              'tottoweramt' => 0,
                              'totinfraamt' => 0);

            foreach($items as $item) {
                $output .= '<tr>';
                    $output .= '<td>'.$item['plgroup'].'</td>';
                    $output .= '<td>'.$item['plitemname'].'</td>';
                    $output .= '<td align="right">'.numberFormat($item['domtrafficamt'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['domnetworkamt'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['intltrafficamt'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['intlnetworkamt'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['intladjacentamt'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['toweramt'],2).'</td>';
                    $output .= '<td align="right">'.numberFormat($item['infraamt'],2).'</td>';
                $output .= '</tr>';

                $total['totdomtrafficamt'] += $item['domtrafficamt'];
                $total['totdomnetworkamt'] += $item['domnetworkamt'];
                $total['totintltrafficamt'] += $item['intltrafficamt'];
                $total['totintlnetworkamt'] += $item['intlnetworkamt'];
                $total['totintladjacentamt'] += $item['intladjacentamt'];
                $total['tottoweramt'] += $item['toweramt'];
                $total['totinfraamt'] += $item['infraamt'];
            }

            $output .= '<tr>';
                $output .= '<td colspan="2" align="center"><b>Total</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($total['totdomtrafficamt'],2).'</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($total['totdomnetworkamt'],2).'</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($total['totintltrafficamt'],2).'</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($total['totintlnetworkamt'],2).'</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($total['totintladjacentamt'],2).'</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($total['tottoweramt'],2).'</b></td>';
                $output .= '<td align="right"><b>'.numberFormat($total['totinfraamt'],2).'</b></td>';

            $output .= '</tr>';

            $output .= '</table>';
            echo $output;
            exit;

    }

}

/* End of file Tblp_logprocesscontrol_controller.php */