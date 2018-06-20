<?php

/**
 * Tblt_costmap Model
 *
 */
class Tblt_costmap extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "s01 cccode,
                                        s02 ccname,
                                        (s01 || ' - ' || s02) costcenter,
                                        s03 accountcode,
                                        s04 accountname,
                                        (s03 || ' - ' || s04) glaccount,
                                        n01 amount,
                                        s05 plitemname,
                                        s06 isindirectcost,
                                        s07 activityname,
                                        s08 isneedpca
                                        ";

    public $fromClause      = "table (f_ShowCostMap(%d, '%s'))";

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

/* End of file Organization.php */