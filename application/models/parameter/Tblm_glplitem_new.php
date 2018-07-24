<?php

/**
 * Tblm_glplitem Model
 *
 */
class Tblm_glplitem_new extends Abstract_model {

    public $table           = "tblm_glplitem";
    public $pkey            = "";
    public $alias           = "a";

    public $fields          = array();


    public $selectClause    = "a.glaccount ,
                                a.gldesc";

    public $fromClause      = "tblm_glplitem a";
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