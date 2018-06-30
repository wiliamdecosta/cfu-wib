<?php

/**
 * Tblt_segregationother Model
 *
 */
class Tblt_segregationother extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "   a.s01 ubiscode,
                                        a.s02 actlistname,
                                        a.s03 plitemcode,
                                        a.s04 plitemname,
                                        a.s05 categorycode,
                                        a.n01 amount,
                                        a.n02 costdriverid_fk,
                                        a.n03 cd_domtraffic,
                                        a.n04 cd_domnetwork,
                                        a.n05 cd_intltraffic,
                                        a.n06 cd_intlnetwork,
                                        a.n07 cd_intladjacent,
                                        a.n08 cd_tower,
                                        a.n09 cd_infra,
                                        a.n10 pct_domtraffic,
                                        a.n11 pct_domnetwork,
                                        a.n12 pct_intltraffic,
                                        a.n13 pct_intlnetwork,
                                        a.n14 pct_intladjacent,
                                        a.n15 pct_tower,
                                        a.n16 pct_infra,
                                        a.n17 domtrafficamt,
                                        a.n18 domnetworkamt,
                                        a.n19 intltrafficamt,
                                        a.n20 intlnetworkamt,
                                        a.n21 intladjacentamt,
                                        a.n22 toweramt,
                                        a.n23 infraamt,
                                        b.code costdrivercode
                                        ";

    public $fromClause      = "table (f_ShowSegregationOther(%d, '%s')) a
                                        left join tblm_costdriver b on a.n02 = b.costdriverid_pk";

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