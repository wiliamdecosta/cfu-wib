<?php

/**
 * Period Model
 *
 */
class Period extends Abstract_model {

    public $table           = "tblm_period";
    public $pkey            = "periodid_pk";
    public $alias           = "";

    public $fields          = array();

    public $selectClause    = "periodid_pk,     
                               code, 
                               year, 
                               month, 
                               statuslistid_fk, 
                               description, 
                               creationdate, 
                               createdby, 
                               updateddate, 
                               updatedby";

    public $fromClause      = "tblm_period";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
            //do something
         

        }else {
            //do something
            //example:




        }
        return true;
    }

}

/* End of file Period.php */