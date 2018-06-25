<?php

/**
 * Bpc_cost_activity Model
 *
 */
class Bpc_cost_activity extends Abstract_model {

    public $table           = "rra.bpc_cost_activity";
    public $pkey            = "id";
    public $alias           = "a";

    public $fields          = array(

                            );

    public $selectClause    = "a.id,
                                        a.uraian
                                    ";
    public $fromClause      = "rra.bpc_cost_activity a";

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