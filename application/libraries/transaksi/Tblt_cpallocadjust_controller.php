<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_cpallocadjust_controller
* @version 2018-05-25 11:32:24
*/
class Tblt_cpallocadjust_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','a.ubiscode, a.activityname');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');
        $periodid_fk = getVarClean('periodid_fk','str','');

        if(empty($periodid_fk)) {
            $data['success'] = true;
            return $data;
        }

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_cpallocadjust');
            $table = $ci->tblt_cpallocadjust;

            $req_param = array(
                "sort_by" => $sidx,
                "sord" => $sord,
                "limit" => null,
                "field" => null,
                "where" => null,
                "where_in" => null,
                "where_not_in" => null,
                "search" => $_REQUEST['_search'],
                "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
                "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
                "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
            );

            $req_param['where'] = array();
            // Filter Table
            if(!empty($periodid_fk)) {
                $table->setCriteria("a.periodid_fk = ".$periodid_fk);
            }

            // Filter Table
             if(!empty($i_search)) {
                $table->setCriteria("( upper(a.ubiscode) like upper('%".$i_search."%') OR
                                                upper(a.activitycode) like upper('%".$i_search."%') OR
                                                upper(a.activityname) like upper('%".$i_search."%') OR
                                                upper(a.plitemcode) like upper('%".$i_search."%') OR
                                                upper(a.plitemnme) like upper('%".$i_search."%')
                                            )");
            }

            $table->setJQGridParam($req_param);
            $count = $table->countAll();

            if ($count > 0) $total_pages = ceil($count / $limit);
            else $total_pages = 1;

            if ($page > $total_pages) $page = $total_pages;
            $start = $limit * $page - ($limit); // do not put $limit*($page - 1)

            $req_param['limit'] = array(
                'start' => $start,
                'end' => $limit
            );

            $table->setJQGridParam($req_param);

            if ($page == 0) $data['page'] = 1;
            else $data['page'] = $page;

            $data['total'] = $total_pages;
            $data['records'] = $count;

            $data['rows'] = $table->getAll();
            $data['success'] = true;
            logging('view data tblt_cpallocadjust');
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }


    function crud() {

        $data = array();
        $oper = getVarClean('oper', 'str', '');
        switch ($oper) {
            case 'add' :
                //permission_check('can-add-data-master-wib');
                $data = $this->create();
            break;

            case 'edit' :
                //permission_check('can-edit-data-master-wib');
                $data = $this->update();
            break;

            case 'del' :
                //permission_check('can-delete-data-master-wib');
                $data = $this->destroy();
            break;

            default :
                //permission_check('can-view-data-master-wib');
                $data = $this->read();
            break;
        }

        return $data;
    }

    function update() {


        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        if (isset($items[0])){

        }else {

            try{

                $ci = & get_instance();
                $ci->load->model('transaksi/tblt_cpallocadjust');
                $table = $ci->tblt_cpallocadjust;
                $userdata = $ci->session->userdata;

                $table->db->trans_begin(); //Begin Trans

                    $keys = array();
                    $keys['periodid_fk'] = $items['periodid_fk'];
                    $keys['ubiscode'] = $items['ubiscode'];
                    $keys['activitycode'] = $items['activitycode'];


                    $record = array();
                    $record['origamount'] = $items['origamount'];
                    $record['adjustamount'] = $items['adjustamount'];
                    $record['description'] = $items['description'];
                    $record['updatedby'] = $userdata['user_name'];
                    $table->db->set('updateddate',"sysdate",false);

                    $table->db->set($record);
                    $table->db->where("periodid_fk",$keys['periodid_fk']);
                    $table->db->where("ubiscode",$keys['ubiscode']);
                    $table->db->where("activitycode",$keys['activitycode']);
                    $table->db->update($table->table);

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data update successfully';
                logging('update data tblt_cpallocadjust');

            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }


    function readLovPeriod(){
        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','period.periodid_pk');
        $dir  = getVarClean('dir','str','desc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/tblm_period_new');
            $table = $ci->tblm_period_new;

            if(!empty($searchPhrase)) {
                $table->setCriteria("( upper(period.periodid_pk) like upper('%".$searchPhrase."%') OR
                                         upper(period.code) like upper('%".$searchPhrase."%') OR
                                         upper(statuslist.code) like upper('%".$searchPhrase."%') 
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


    function do_process() {

        $periodid_fk = getVarClean('periodid_fk','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_cpallocadjust');
            $table = $ci->tblt_cpallocadjust;
            $table->setCriteria("a.periodid_fk = ".$periodid_fk);
            $count = $table->countAll();

            $userdata = $ci->session->userdata;

           $sql = "BEGIN "
                    . " pack_Adjustment.GetPCAHighlight("
                    . " :i_period_id, "
                    . " :i_user_name,"
                    . " :o_result_msg,"
                    . " :o_result_code"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_period_id', $periodid_fk);
            oci_bind_by_name($stmt, ':i_user_name', $userdata['user_name']);

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_result_msg', $o_result_msg, 2000000);
            oci_bind_by_name($stmt, ':o_result_code', $o_result_code, 2000000);


            ociexecute($stmt);

            if($o_result_code == 1){
                $data['records'] = $count;
                $data['success'] = true;
                $data['message'] = $o_result_msg;
            }else{
                $data['records'] = $count;
                $data['success'] = false;
                $data['message'] = $o_result_msg;
            }

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function cancel_process() {

        $periodid_fk = getVarClean('periodid_fk','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_cpallocadjust');
            $table = $ci->tblt_cpallocadjust;
            $table->setCriteria("a.periodid_fk = ".$periodid_fk);
            $count = $table->countAll();

            $userdata = $ci->session->userdata;


            $sql = "BEGIN "
                    . " pack_Adjustment.ClearPCAHighlight("
                    . " :i_period_id, "
                    . " :i_user_name,"
                    . " :o_result_msg,"
                    . " :o_result_code"
                    . "); END;";
            
            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_period_id', $periodid_fk);
            oci_bind_by_name($stmt, ':i_user_name', $userdata['user_name']);

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_result_msg', $o_result_msg, 2000000);
            oci_bind_by_name($stmt, ':o_result_code', $o_result_code, 2000000);

            ociexecute($stmt);

            if($o_result_code == 1){
                $data['records'] = $count;
                $data['success'] = true;
                $data['message'] = $o_result_msg;
            }else{
                $data['records'] = $count;
                $data['success'] = false;
                $data['message'] = $o_result_msg;
            }

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

}

/* End of file Tblt_tohideout_controller.php */