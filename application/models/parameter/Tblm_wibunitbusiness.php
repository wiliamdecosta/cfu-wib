<?php

/**
 * Tblm_wibunitbusiness Model
 *
 */
class Tblm_wibunitbusiness extends Abstract_model {

    public $table           = "tblm_wibunitbusiness";
    public $pkey            = "wibunitbusinessid_pk";
    public $alias           = "ub";

    public $fields          = array(

                            );

    public $selectClause    = "ub.*, to_char(updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, updatedby lastupdatedby";
    public $fromClause      = "tblm_wibunitbusiness ub";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
            //do something
            // example :

            unset($this->record['creationdate']);
            unset($this->record['updateddate']);

            $this->db->set('creationdate',"sysdate",false);
            $this->record['createdby'] = $userdata['user_name'];
            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            unset($this->record['creationdate']);
            unset($this->record['createdby']);
            unset($this->record['updateddate']);

            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];

        }
        return true;
    }

}

/* End of file Activity.php */