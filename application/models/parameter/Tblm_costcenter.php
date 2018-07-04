<?php

/**
 * Tblm_costcenter Model
 *
 */
class Tblm_costcenter extends Abstract_model {

    public $table           = "tblm_costcenter";
    public $pkey            = "costcenterid_pk";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "costcenterid_pk, cccode kode, ccname nama, parentcode, orglevel, sourcetype, description, creationdate, createdby, updateddate, updatedby";
    public $fromClause      = "tblm_costcenter";

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
            $this->db->set('creationdate',"sysdate",false);
            $this->record['createdby'] = $userdata['user_name'];
            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:

            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];
        }
        return true;
    }

}

/* End of file Status_type.php */