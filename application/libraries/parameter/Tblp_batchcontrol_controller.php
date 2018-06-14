<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblp_batchcontrol_controller
* @version 2018-05-24 16:18:32
*/
class Tblp_batchcontrol_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',12);
        $sidx = getVarClean('sidx','str','n02');
        $sord = getVarClean('sord','str','desc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/tblp_batchcontrol');
            $table = new Tblp_batchcontrol($i_search);

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

            // Filter Table
            $req_param['where'] = array();

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
            logging('view data batch control');
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


    function treatment() {

        $periodid_fk = getVarClean('periodid_fk','int',0);
        $treatmentcode = getVarClean('treatmentcode','str','');
        $i_batch_control_id = getVarClean('i_batch_control_id','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/tblp_batchcontrol');
            $table = new Tblp_batchcontrol('');

            $userdata = $ci->session->userdata;

            if($treatmentcode == 'REOPEN') {

                $sql = "BEGIN "
                    . " pack_BatchMonitoring.pr_ReOpenBatchControl("
                    . " :i_batch_control_id, "
                    . " :i_user_name, "
                    . " :o_result_msg, "
                    . " :o_result_code "
                    . "); END;";

            }else if($treatmentcode == 'CLOSE') {

                $sql = "BEGIN "
                    . " pack_BatchMonitoring.pr_CloseBatchControl("
                    . " :i_batch_control_id, "
                    . " :i_user_name, "
                    . " :o_result_msg, "
                    . " :o_result_code "
                    . "); END;";

            } else {
                $data['message'] = 'Wrong treatment code';
                return $data;
            }

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_batch_control_id', $i_batch_control_id);
            oci_bind_by_name($stmt, ':i_user_name', $userdata['user_name']);

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_result_msg', $o_result_msg, 2000000);
            oci_bind_by_name($stmt, ':o_result_code', $o_result_code, 2000000);

            ociexecute($stmt);

            if($o_result_code == 0) {
                $data['success'] = true;
            }

            $data['o_result_code'] = $o_result_code;
            $data['message'] = $o_result_msg;

            //$data['message'] = 'Good Job'.$periodid_fk.' - '.$treatmentcode.' - '.$i_batch_control_id;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }


}

/* End of file Tblp_batchcontrol_controller.php */