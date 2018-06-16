<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Bpc_cost_payroll_posisi_controller
* @version 2018-06-16 09:12:54
*/
class Bpc_cost_payroll_posisi_controller {

    function readLov() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','id');
        $dir  = getVarClean('dir','str','asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        $id_divisi  = getVarClean('id_divisi','str','');
        $id_loker  = getVarClean('id_loker','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/bpc_cost_payroll_posisi');
            $table = $ci->bpc_cost_payroll_posisi;

            if(!empty($searchPhrase)) {
                $table->setCriteria("upper(id) like upper('%".$searchPhrase."%') OR
                                         upper(posisi) like upper('%".$searchPhrase."%')");

            }

            $table->setCriteria("EXISTS
                                        (SELECT 1
                                        FROM RRA.BPC_Cost_Payroll_Activity b
                                        WHERE jobposition.ID = b.ID_Posisi AND
                                            b.ID_Divisi = '".$id_divisi."' AND
                                            b.ID_Loker = '".$id_loker."')
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