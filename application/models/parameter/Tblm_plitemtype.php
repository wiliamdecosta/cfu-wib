<?php

/**
 * Tblm_plitemtype Model
 *
 */
class Tblm_plitemtype extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "a";

    public $fields          = array(

                            );

    public $selectClause    = "a.plitemtype";
    public $fromClause      = "(SELECT   'Amortization' plitemtype FROM DUAL
                                UNION ALL
                                SELECT   'Depreciation' plitemtype FROM DUAL
                                UNION ALL
                                SELECT   'Direct Cost' plitemtype FROM DUAL
                                UNION ALL
                                SELECT   'Indirect Cost' plitemtype FROM DUAL
                                UNION ALL
                                SELECT   'Revenue' plitemtype FROM DUAL) a";

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