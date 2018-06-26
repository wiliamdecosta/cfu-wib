<?php

/**
 * Tblt_verticalalloc Model
 *
 */
class Tblt_verticalalloc extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "s01 ubiscode,
                                        s02 activityid,
                                        s03 activityname, (s02 || '-' || s03) activitygabung,
                                        s04 overheadid1,
                                        s05 overheadname1, (s04 || '-' || s05) overheadgabung1,
                                        s06 overheadid2,
                                        s07 overheadname2, (s06 || '-' || s07) overheadgabung2,
                                        s08 plitemcode,
                                        s09 plitemname, (s08 || '-' || s09) plitemgabung,
                                        n01 pcaamount,
                                        n02 pctohact1,
                                        n03 amountohact1,
                                        n04 vallocact1,
                                        n05 pctohact2,
                                        n06 amountohact2,
                                        n07 vallocact2
                                        ";

    public $fromClause      = "table (f_ShowVertAlloc(%d, '%s'))";

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