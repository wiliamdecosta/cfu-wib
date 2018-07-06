<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Bpc_cost_payroll_loker_controller
* @version 2018-06-16 09:12:54
*/
class Bpc_cost_payroll_loker_controller {

    function readLov() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','id');
        $dir  = getVarClean('dir','str','asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        $id_divisi  = getVarClean('id_divisi','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/bpc_cost_payroll_loker');
            $table = $ci->bpc_cost_payroll_loker;

            if(!empty($searchPhrase)) {
                $table->setCriteria("( upper(id) like upper('%".$searchPhrase."%') OR
                                         upper(loker) like upper('%".$searchPhrase."%')
                                         )");

            }

            $table->setCriteria("EXISTS
                                            (SELECT 1
                                            FROM RRA.BPC_Cost_Payroll_Activity b
                                            WHERE organization.ID = b.ID_Loker AND
                                                b.ID_Divisi = '".$id_divisi."')
                                        ");

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

}

/* End of file Activity_controller.php */