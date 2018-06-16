<?php

/**
 * Bpc_cost_payroll_loker Model
 *
 */
class Bpc_cost_payroll_loker extends Abstract_model {

    public $table           = "rra.bpc_cost_payroll_loker";
    public $pkey            = "id";
    public $alias           = "organization";

    public $fields          = array(

                            );

    public $selectClause    = "organization.*";
    public $fromClause      = "rra.bpc_cost_payroll_loker organization";

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

            if(empty($this->record['listingno'])) {
                $this->db->set('listingno',"null",false);
                unset($this->record['listingno']);
            }

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            unset($this->record['creationdate']);
            unset($this->record['createdby']);
            unset($this->record['updateddate']);

            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];


            if(empty($this->record['listingno'])) {
                $this->db->set('listingno',"null",false);
                unset($this->record['listingno']);
            }

        }
        return true;
    }

}

/* End of file Activity.php */