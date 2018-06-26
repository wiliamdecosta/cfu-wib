<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Vw_allactivity_controller
* @version 2018-06-26 10:59:00
*/
class Vw_allactivity_controller {


    function readLov() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','c.activitycode');
        $dir  = getVarClean('dir','str','asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');
        $activitytype = getVarClean('activitytype', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/vw_allactivity');
            $table = $ci->vw_allactivity;

            if(!empty($searchPhrase)) {
                $table->setCriteria(" ( upper(c.activitycode) like upper('%".$searchPhrase."%') OR
                                         upper(c.activityname) like upper('%".$searchPhrase."%') OR
                                         upper(c.ubiscode) like upper('%".$searchPhrase."%')
                                         ) ");

            }

            if(!empty($activitytype)) {
                $table->setCriteria("c.activitytype = ".$activitytype);
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

/* End of file Status_type_controller.php */