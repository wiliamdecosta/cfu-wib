<?php

/**
 * Tblt_satellitedetail Model
 *
 */
class Tblt_satellitedetail extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "s01 ubiscode,
                                s02 plitemname,
                                s03 categorycode,
                                s04 columnname, 
                                s05 glaccount, 
                                s06 gldesc, 
                                n01 amount,
                                s07 description
                                        ";

    public $fromClause      = "table (f_ShowDetailAccount(%d, '%s', '%s'))";

    public $refs            = array();

    function __construct($i_period_id = '', $i_ubis_code = '', $i_search = '') {
        if($i_search == '') $i_search = '';

        $this->fromClause = sprintf($this->fromClause, $i_period_id, $i_ubis_code, $i_search);
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