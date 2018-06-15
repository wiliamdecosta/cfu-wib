<?php

/**
 * Tblp_logprocesscontrol Model
 *
 */
class Tblp_logprocesscontrol extends Abstract_model {

    public $table           = "tblp_logprocesscontrol";
    public $pkey            = "";
    public $alias           = "lpc";

    public $fields          = array(

                            );

    public $selectClause    = "pprocesscontrolid_fk,
                                    counterno,
                                    to_char(logdate,'DD-MON-YYYY HH24:MI:SS') logdate,
                                    logmessage,
                                    logtype";

    public $fromClause      = "tblp_logprocesscontrol";

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