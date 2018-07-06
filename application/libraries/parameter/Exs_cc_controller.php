<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Exs_cc_controller
* @version 2018-06-16 09:12:54
*/
class Exs_cc_controller {

    function readLov() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','kode_cc');
        $dir  = getVarClean('dir','str','asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');
        $ubiscode = getVarClean('ubiscode','str','');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/exs_cc');
            $table = $ci->exs_cc;

            if(!empty($searchPhrase)) {
                $table->setCriteria("(upper(kode_cc) like upper('%".$searchPhrase."%') OR
                                         upper(nama) like upper('%".$searchPhrase."%'))");

            }

            if(!empty($ubiscode)) {
                $table->setCriteria("kode_ubis IN ( select code2 from tblm_wibunitbusiness
                                                                        where upper(code) = upper('".$ubiscode."'))");
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

    function readLov2() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        //order dan dir pindah ke bawah

        $searchPhrase = getVarClean('searchPhrase', 'str', '');
        $ubiscode = getVarClean('ubiscode','str','');
        $wibunitbusinessid_fk = getVarClean('wibunitbusinessid_fk','int',0);


        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            if($wibunitbusinessid_fk != 3) { //bukan Telin JKT

                $ci = & get_instance();
                $ci->load->model('parameter/exs_cc');
                $table = $ci->exs_cc;

                if(!empty($searchPhrase)) {
                    $table->setCriteria("(upper(kode_cc) like upper('%".$searchPhrase."%') OR
                                            upper(nama) like upper('%".$searchPhrase."%')
                                            )");

                }

                if(!empty($ubiscode)) {
                    $table->setCriteria("kode_ubis IN ( select code2 from tblm_wibunitbusiness
                                                                            where upper(code) = upper('".$ubiscode."'))");
                }

                $sort = getVarClean('sort','str','kode_cc');
                $dir  = getVarClean('dir','str','asc');

                $start = ($start-1) * $limit;
                $items = $table->getAll($start, $limit, $sort, $dir);

            }else { //Telin JKT
                $ci = & get_instance();
                $ci->load->model('parameter/tblm_costcenter');
                $table = $ci->tblm_costcenter;

                if(!empty($searchPhrase)) {
                    $table->setCriteria("upper(cccode) like upper('%".$searchPhrase."%') OR
                                            upper(ccname) like upper('%".$searchPhrase."%')");
                }

                $sort = getVarClean('sort','str','cccode');
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