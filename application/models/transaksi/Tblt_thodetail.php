<?php

/**
 * Tblt_thodetail Model
 *
 */
class Tblt_thodetail extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "s01 ubiscode,
                               s02 categorycode,
                               s03 glaccount,
                               s04 gldesc, 
                               n01 amount,
                               s05 description
                                        ";

    public $fromClause      = "table (f_ShowDetailTHO(%d, '%s', '%s', '%s', '%s'))";

    public $refs            = array();

    function __construct($i_period_id = '', $i_ubis_code = '', $i_pl_item_name = '', $i_column_name = '', $i_search = '') {
        if($i_search == '') $i_search = '';

        $this->fromClause = sprintf($this->fromClause, $i_period_id, $i_ubis_code, $i_pl_item_name, $i_column_name, $i_search);
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

/* End of file Tblt_tohideout.php */