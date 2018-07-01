<?php

/**
 * Tblt_telinstaff Model
 *
 */
class Tblt_telinstaff extends Abstract_model {

    public $table           = "tblt_telinstaff";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "n01 periodid_fk,
                                        s01 activityname,
                                        n02 pctstaff,
                                        n03 pctcompensation,
                                        n04 activityid_fk,
                                        n05 pprocesscontrolid_fk,
                                        s02 activitycode
                                        ";

    public $fromClause      = "table (f_ShowTelinStaff(%d, '%s'))";

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

/* End of file Tblt_pca.php */