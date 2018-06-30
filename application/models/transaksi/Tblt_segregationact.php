<?php

/**
 * Tblt_segregationact Model
 *
 */
class Tblt_segregationact extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "s01 ubiscode,
                                    s02 activityid,
                                    s03 activityname, (s02 || ' - ' || s03) activitygabung,
                                    s04 plitemcode,
                                    s05 plitemname,
                                    n01 amount,
                                    n02 costdriverid_fk,
                                    s06 costdrivercode,
                                    n03 cd_domtraffic,
                                    n04 cd_domnetwork,
                                    n05 cd_intltraffic,
                                    n06 cd_intlnetwork,
                                    n07 cd_intladjacent,
                                    n08 cd_tower,
                                    n09 cd_infra,
                                    n10 pct_domtraffic,
                                    n11 pct_domnetwork,
                                    n12 pct_intltraffic,
                                    n13 pct_intlnetwork,
                                    n14 pct_intladjacent,
                                    n15 pct_tower,
                                    n16 pct_infra,
                                    n17 domtrafficamt,
                                    n18 domnetworkamt,
                                    n19 intltrafficamt,
                                    n20 intlnetworkamt,
                                    n21 intladjacentamt,
                                    n22 toweramt,
                                    n23 infraamt
                                        ";

    public $fromClause      = "table (f_ShowSegregationAct(%d, '%s'))";

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