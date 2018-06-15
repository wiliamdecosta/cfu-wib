<?php

/**
 * Tblt_processsummary Model
 *
 */
class Tblt_processsummary extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "n01 NUM,
                                        s01 SUMMARYCODE,
                                        n02 INAMOUNT,
                                        s02 OBJECTCODE,
                                        n03 OUTAMOUNT
                                        ";

    public $fromClause      = "table (f_showProcessSummary(%d))";

    public $refs            = array();

    function __construct($i_process_control_id = '') {
        $this->fromClause = sprintf($this->fromClause, $i_process_control_id);
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            //$this->record['creationdate'] = date('Y-m-d');
            //$this->record['updateddate'] = date('Y-m-d');

        }else {
            //do something
            //example:
            //$this->record['updateddate'] = date('Y-m-d');
            //if false please throw new Exception
        }
        return true;
    }

}

/* End of file Organization.php */