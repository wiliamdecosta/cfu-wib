<?php

/**
 * Exs_cc Model
 *
 */
class Exs_cc extends Abstract_model {

    public $table           = "rra.exs_cc";
    public $pkey            = "kode_cc";
    public $alias           = "exscc";

    public $fields          = array(

                            );

    public $selectClause    = "exscc.*";
    public $fromClause      = "rra.exs_cc exscc";

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