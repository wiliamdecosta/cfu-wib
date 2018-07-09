<?php

/**
 * Tblt_contentsatellite Model
 *
 */
class Tblt_contentsatellite extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "s01 plgroup,
                                s02 plitemname,
                                n01 domtrafficamt,
                                n02 domnetworkamt,
                                n03 intltrafficamt,
                                n04 intlnetworkamt,
                                n05 intladjacentamt,
                                n06 toweramt,
                                n07 infraamt
                                        ";

    public $fromClause      = "table (f_ShowContentSatellite(%d, '%s'))";

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