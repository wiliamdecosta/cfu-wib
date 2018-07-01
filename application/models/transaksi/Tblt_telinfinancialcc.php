<?php

/**
 * Tblt_telinfinancialcc Model
 *
 */
class Tblt_telinfinancialcc extends Abstract_model {

    public $table           = "tblt_telinfinancialcc";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "s01 costcentercode,
                                     s02 glaccount,
                                     n01 amount,
                                     s03 plitemcode,
                                     s04 plitemname,
                                     (s03 || ' - ' || s04) plitemgabung
                                        ";

    public $fromClause      = "table (f_ShowFinancialCC(%d, '%s'))";

    public $refs            = array();

    function __construct($i_process_control_id = '', $i_search = '') {
        if($i_search == '') $i_search = '';

        $this->fromClause = sprintf($this->fromClause, $i_process_control_id, $i_search);
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

/* End of file Tblt_telinfinancialcc.php */