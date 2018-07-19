<?php

/**
 * Tblt_plbeforeelim Model
 *
 */
class Tblt_plbeforeelim extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "s01 ubiscode,
                                s02 plgroupname,
                                s03 plitemname,
                                n01 domtrafficamount,
                                n02 domnetworkamount,
                                n03 intltrafficamount,
                                n04 intlnetworkamount,
                                n05 intladjacentamount,
                                n06 toweramount,
                                n07 infraamount
                                        ";

    public $fromClause      = "table (f_ShowPLBeforeElim(%d, '%s'))";

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

/* End of file Tblt_plbeforeelim.php */