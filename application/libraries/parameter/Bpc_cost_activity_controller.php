<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Bpc_cost_activity_controller
* @version 2018-06-16 09:12:54
*/
class Bpc_cost_activity_controller {

    function readLov() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','a.uraian');
        $dir  = getVarClean('dir','str','asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/bpc_cost_activity');
            $table = $ci->bpc_cost_activity;

            if(!empty($searchPhrase)) {
                $table->setCriteria("upper(a.id) like upper('%".$searchPhrase."%') OR
                                         upper(a.uraian) like upper('%".$searchPhrase."%')
                                         ");
            }

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