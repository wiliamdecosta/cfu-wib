<?php

/**
 * Tblt_staffcompmap Model
 *
 */
class Tblt_staffcompmap extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "n01 tstaffcompmapid_pk,
                                            n02 periodid_fk,
                                            s01 cfucode,
                                            s02 ubiscode,
                                            s03 idactivity,
                                            s04 uraian,
                                            n03 staffqty,
                                            n04 staffpct,
                                            n06 compensationvalue,
                                            n07 compensationpct
                                        ";

    public $fromClause      = "table (f_ShowCompMap(%d))";

    public $refs            = array();

    function __construct($i_process_control_id = '') {
        $this->fromClause = sprintf($this->fromClause, $i_process_control_id);
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

/* End of file Organization.php */