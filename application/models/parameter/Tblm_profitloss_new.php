<?php

/**
 * Tblm_profitloss Model
 *
 */
class Tblm_profitloss_new extends Abstract_model {

    public $table           = "tblm_profitloss";
    public $pkey            = "profitlossid_pk";
    public $alias           = "a";

    public $fields          = array();

    public $selectClause    = "a.plitemname,
                               a.listingno";
    public $fromClause      = "(select plitemname, listingno from tblm_profitloss where profitlossid_pk between 1 and 7) a";

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


        }else {
            //do something
            //example:


        }
        return true;
    }

}

/* End of file Tblm_profitloss.php */