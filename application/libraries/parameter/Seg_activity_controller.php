<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Seg_activity_controller
* @version 2018-06-28 12:35:39
*/
class Seg_activity_controller {


    function readLov() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','a.activitygroupcode');
        $dir  = getVarClean('dir','str','asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $ubiscode = getVarClean('ubiscode','str','');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/seg_activity');
            $table = $ci->seg_activity;

            if(!empty($ubiscode)) {
                $table->setCriteria("upper(a.ubiscode) = upper('".$ubiscode."')");
            }

            if(!empty($searchPhrase)) {
                $table->setCriteria("(upper(a.activitygroupcode) like upper('%".$searchPhrase."%') OR 
                                      upper(a.activityname) like upper('%".$searchPhrase."%') OR
                                      upper(a.plitemname) like upper('%".$searchPhrase."%') OR
                                      upper(a.costdrivercode) like upper('%".$searchPhrase."%')
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

/* End of file Status_type_controller.php */