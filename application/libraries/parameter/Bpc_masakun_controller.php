<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Bpc_masakun_controller
* @version 2018-06-16 09:12:54
*/
class Bpc_masakun_controller {

    function readLov() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','c.kode_akun');
        $dir  = getVarClean('dir','str','asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/bpc_masakun');
            $table = $ci->bpc_masakun;

            if(!empty($searchPhrase)) {
                $table->setCriteria("upper(c.kode_akun) like upper('%".$searchPhrase."%') OR
                                         upper(c.nama) like upper('%".$searchPhrase."%') OR
                                         upper(nr.nama) like upper('%".$searchPhrase."%')
                                         ");

            }

            $table->setCriteria("nr.kode_fs = 'CCA'");
            $table->setCriteria("c.kode_lokasi = '9000'");

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