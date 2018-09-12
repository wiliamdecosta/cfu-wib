<?php

/**
 * Simpletotalcm Model
 *
 */
class Simpletotalcm extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "n01 counterno,
                                s01 plitemname,
                                s02 fonttype,
                                s03 dbgtype,
                                n02 janamt,
                                n03 febamt,
                                n04 maramt,
                                n05 apramt,
                                n06 mayamt,
                                n07 junamt,
                                n08 julamt,
                                n09 augamt,
                                n10 sepamt,
                                n11 octamt,
                                n12 novamt,
                                n13 decamt
                                        ";

    public $fromClause      = "table (f_SimpleTotalCM(%d))";

    public $refs            = array();

    function __construct($year_id = '') {

        $this->fromClause = sprintf($this->fromClause, $year_id);
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