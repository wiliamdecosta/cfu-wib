<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_costdriverpl_controller
* @version 2018-05-24 16:18:32
*/
class Tblt_costdriverpl_controller {

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
            $ci->load->model('transaksi/tblt_costdriverpl');
            $table = new Tblt_costdriverpl($i_process_control_id, $i_search);

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
            logging('view data tblt_costdriverpl');
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

    function download_excel() {

            $processcontrolid_pk = getVarClean('processcontrolid_pk', 'int', 0);
            $periodid_fk = getVarClean('periodid_fk', 'int', 0);

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_costdriverpl');
            $table = new Tblt_costdriverpl($processcontrolid_pk, '');


            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            startExcel("cost_driver_pl".$periodid_fk.".xls");

            $output = '<table border="1">';
            $output .= '<tr>
                            <th>Ubis/Subsidiary</th>
                            <th>Cost Driver</th>
                            <th>Unit</th>
                            <th>Dom Traffic</th>
                            <th>Dom Network</th>
                            <th>Intl Traffic</th>
                            <th>Intl Network</th>
                            <th>Intl Adjacent</th>
                            <th>Tower</th>
                            <th>Infrastructure</th>
                        </tr>';


            foreach($items as $item) {

                $output .= '<tr>
                                    <td valign="top">'.$item['ubiscodedisplay'].'</td>
                                    <td valign="top">'.$item['costdriver'].'</td>
                                    <td valign="top">'.$item['unitcodedisplay'].'</td>
                                    <td valign="top" align="right">'.numberFormat($item['domtrafficvaluedisplay'],2).'</td>
                                    <td valign="top" align="right">'.numberFormat($item['domnetworkvaluedisplay'],2).'</td>
                                    <td valign="top" align="right">'.numberFormat($item['intltrafficvaluedisplay'],2).'</td>
                                    <td valign="top" align="right">'.numberFormat($item['intlnetworkvaluedisplay'],2).'</td>
                                    <td valign="top" align="right">'.numberFormat($item['intladjacentvaluedisplay'],2).'</td>
                                    <td valign="top" align="right">'.numberFormat($item['towervaluedisplay'],2).'</td>
                                    <td valign="top" align="right">'.numberFormat($item['infravaluedisplay'],2).'</td>
                                </tr>';

            }


            $output .= '</table>';
            echo $output;
            exit;

    }

}

/* End of file Tblt_costdrivercalc_controller.php */