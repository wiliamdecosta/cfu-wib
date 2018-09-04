<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Period_controller
* @version 2018-05-24 16:18:32
*/
class Period_controller {

    function readLov() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','periodid_pk');
        $dir  = getVarClean('dir','str','desc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/period');
            $table = $ci->period;

            if(!empty($searchPhrase)) {
                $table->setCriteria("(upper(periodid_pk) like upper('%".$searchPhrase."%') OR
                                         upper(code) like upper('%".$searchPhrase."%')
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

/* End of file Period_controller.php */