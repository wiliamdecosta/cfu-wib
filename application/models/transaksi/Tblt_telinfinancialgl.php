<?php

/**
 * Tblt_telinfinancialgl Model
 *
 */
class Tblt_telinfinancialgl extends Abstract_model {

    public $table           = "tblt_telinfinancialgl";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );


    public $selectClause    = "s01 glaccount,
                                        s02 gldesc,
                                        n01 telinjkt,
                                        n02 telinsg,
                                        n03 telinhk,
                                        n04 ttl,
                                        n05 telinau,
                                        n06 telinus,
                                        n07 tsgn,
                                        s03 plitemcode,
                                        s04 plitemname,
                                        (s03 || ' - ' || s04) plitemgabung
                                        ";

    public $fromClause      = "table (f_ShowFinancialGL(%d, '%s'))";

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