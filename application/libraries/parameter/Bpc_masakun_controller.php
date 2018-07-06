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
                $table->setCriteria("(upper(c.kode_akun) like upper('%".$searchPhrase."%') OR
                                         upper(c.nama) like upper('%".$searchPhrase."%') OR
                                         upper(nr.nama) like upper('%".$searchPhrase."%')
                                         )");

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


    function readLov2() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $searchPhrase = getVarClean('searchPhrase', 'str', '');
        $wibunitbusinessid_fk = getVarClean('wibunitbusinessid_fk','int',0);

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            if($wibunitbusinessid_fk != 3) { //bukan Telin JKT

                $ci = & get_instance();
                $ci->load->model('parameter/bpc_masakun');
                $table = $ci->bpc_masakun;

                $table->setCriteria("nr.kode_fs = 'CCA'");
                $table->setCriteria("c.kode_lokasi = '9000'");

                if(!empty($searchPhrase)) {
                    $table->setCriteria("(upper(c.kode_akun) like upper('%".$searchPhrase."%') OR
                                            upper(c.nama) like upper('%".$searchPhrase."%') OR
                                            upper(nr.nama) like upper('%".$searchPhrase."%')
                                            )");

                }

                $sort = getVarClean('sort','str','c.kode_akun');
                $dir  = getVarClean('dir','str','asc');

                $start = ($start-1) * $limit;
                $items = $table->getAll($start, $limit, $sort, $dir);

            } else { //Telin JKT

                $ci = & get_instance();
                $ci->load->model('parameter/tblm_glplitem');
                $table = $ci->tblm_glplitem;

                if(!empty($searchPhrase)) {
                    $table->setCriteria("(upper(a.glaccount) like upper('%".$searchPhrase."%') OR
                                            upper(a.gldesc) like upper('%".$searchPhrase."%') OR
                                            upper(nr.nama) like upper('%".$searchPhrase."%')
                                            )");
                }

                $sort = getVarClean('sort','str','a.glaccount');
                $dir  = getVarClean('dir','str','asc');

                $start = ($start-1) * $limit;
                $items = $table->getAll($start, $limit, $sort, $dir);
            }

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