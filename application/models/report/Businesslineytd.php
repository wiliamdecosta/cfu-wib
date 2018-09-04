<?php

/**
 * Businesslineytd Model
 *
 */
class Businesslineytd extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "s01 plitemname,
                                s02 fonttype,
                                s03 dbgtype,
                                n01 domtrafficamt,
                                n02 domnetworkamt,
                                n03 intltrafficamt,
                                n04 intlnetworkamt,
                                n05 carrieramt,
                                n06 intladjacentamt,
                                n07 toweramt,
                                n08 infraamt,
                                n09 totalamt
                                        ";

    public $fromClause      = "table (f_ShowBusinessLineYTD(%d))";

    public $refs            = array();

    function __construct($periodid_fk = '') {

        $this->fromClause = sprintf($this->fromClause, $periodid_fk);
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

/* End of file Pl_final.php */