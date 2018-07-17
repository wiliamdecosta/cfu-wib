<?php

/**
 * Tblt_costdrivercalc Model
 *
 */
class Tblt_costdrivercalc extends Abstract_model {

    public $table           = "tblt_costdrivercalc";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "n01 periodid_fk,
                                    s01 code, s01 costdriver,
                                    s02 ubiscode, s02 ubiscodedisplay,
                                    n02 unitid_fk,
                                    s03 unitcode, s03 unitcodedisplay,
                                    n03 listingno,
                                    n04 domtrafficvalue, n04 domtrafficvaluedisplay,
                                    n05 domnetworkvalue, n05 domnetworkvaluedisplay,
                                    n06 intltrafficvalue, n06 intltrafficvaluedisplay,
                                    n07 intlnetworkvalue, n07 intlnetworkvaluedisplay,
                                    n08 intladjacentvalue, n08 intladjacentvaluedisplay,
                                    n09 towervalue, n09 towervaluedisplay,
                                    n10 infravalue, n10 infravaluedisplay,
                                    n11 pprocesscontrolid_fk";

    public $fromClause      = "table (f_ShowCostDriverCalc(%d, '%s'))";

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

/* End of file Tblt_costdrivercalc.php */