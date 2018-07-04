<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_segregationother_controller
* @version 2018-05-25 11:32:24
*/
class Tblt_segregationother_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','a.s01, a.s02');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_process_control_id = getVarClean('processcontrolid_pk','int',0);
        $i_search = getVarClean('i_search','str','');
        $ubiscode = getVarClean('ubiscode','str','');

        if(empty($ubiscode)) {
            $data['success'] = true;
            return $data;
        }

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_segregationother');
            $table = new Tblt_segregationother($i_process_control_id, $i_search);

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
                $table->setCriteria("upper(a.s01) = upper('".$ubiscode."')");
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
        $ubiscode = getVarClean('ubiscode','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_segregationother');
            $table = new Tblt_segregationother($i_process_control_id, $i_search);

            if(!empty($ubiscode)) {
                $table->setCriteria("upper(a.s01) = upper('".$ubiscode."')");
            }

            $count = $table->countAll();
            $items = $table->getAll(0, -1, 'a.s01, a.s02', 'asc');


            $output = '';

            foreach($items as $item) {
                $output .= '<tr>
                                    <td>'.$item['actlistname'].'</td>
                                    <td>'.$item['categorycode'].'</td>
                                    <td>'.$item['plitemname'].'</td>
                                    <td align="right">'.numberFormat($item['amount'],2).'</td>
                                    <td>'.$item['costdrivercode'].'</td>

                                    <td align="right">'.numberFormat($item['cd_domtraffic'],2).'</td>
                                    <td align="right">'.numberFormat($item['cd_domnetwork'],2).'</td>
                                    <td align="right">'.numberFormat($item['cd_intltraffic'],2).'</td>
                                    <td align="right">'.numberFormat($item['cd_intlnetwork'],2).'</td>
                                    <td align="right">'.numberFormat($item['cd_intladjacent'],2).'</td>
                                    <td align="right">'.numberFormat($item['cd_tower'],2).'</td>
                                    <td align="right">'.numberFormat($item['cd_infra'],2).'</td>

                                    <td align="right">'.numberFormat($item['pct_domtraffic'],2).'</td>
                                    <td align="right">'.numberFormat($item['pct_domnetwork'],2).'</td>
                                    <td align="right">'.numberFormat($item['pct_intltraffic'],2).'</td>
                                    <td align="right">'.numberFormat($item['pct_intlnetwork'],2).'</td>
                                    <td align="right">'.numberFormat($item['pct_intladjacent'],2).'</td>
                                    <td align="right">'.numberFormat($item['pct_tower'],2).'</td>
                                    <td align="right">'.numberFormat($item['pct_infra'],2).'</td>

                                    <td align="right">'.numberFormat($item['domtrafficamt'],2).'</td>
                                    <td align="right">'.numberFormat($item['domnetworkamt'],2).'</td>
                                    <td align="right">'.numberFormat($item['intltrafficamt'],2).'</td>
                                    <td align="right">'.numberFormat($item['intlnetworkamt'],2).'</td>
                                    <td align="right">'.numberFormat($item['intladjacentamt'],2).'</td>
                                    <td align="right">'.numberFormat($item['toweramt'],2).'</td>
                                    <td align="right">'.numberFormat($item['infraamt'],2).'</td>
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

}

/* End of file Tblp_tblt_segregationact_controller.php */