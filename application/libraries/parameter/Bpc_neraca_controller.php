<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Bpc_neraca_controller
* @version 2018-06-16 09:12:54
*/
class Bpc_neraca_controller {

    function readLov() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','a.nama');
        $dir  = getVarClean('dir','str','asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/bpc_neraca');
            $table = $ci->bpc_neraca;

            $table->setCriteria("a.kode_fs = 'CCA'");

            if(!empty($searchPhrase)) {
                $table->setCriteria("(upper(a.kode_neraca) like upper('%".$searchPhrase."%') OR
                                         upper(a.nama) like upper('%".$searchPhrase."%')
                                         )");
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