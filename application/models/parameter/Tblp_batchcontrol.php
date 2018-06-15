<?php

/**
 * Tblp_batchcontrol Model
 *
 */
class Tblp_batchcontrol extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "n01 pbatchcontrolid_pk,
                                        s01 treatmentcode,
                                        n02 periodid_fk,
                                        s02 periodcode,
                                        s03 groupcode,
                                        n03 statuslistid_fk,
                                        s04 statuscode,
                                        s05 updateddate,
                                        to_char(to_date( s05, 'DD-MON-YYYY HH24:MI:SS'), 'DD-MON-YYYY HH24:MI') updateddateminute,
                                        s06 updatedby,
                                        b.orgcode,
                                        b.description,
                                        b.creationdate,
                                        b.createdby,
                                        b.processcategoryid_fk,
                                        c.code as processcategorycode";

    public $fromClause      = "table (f_showbatchcontrol (%s)) a
                                        left join tblp_batchcontrol b
                                            on a.n01 = b.pbatchcontrolid_pk
                                        left join tblm_processcategory c
                                            on b.processcategoryid_fk = c.processcategoryid_pk";

    public $refs            = array();

    function __construct($i_search = '') {
        if (!empty($i_search)){
			$this->fromClause = sprintf($this->fromClause, $i_search);
		}else{
			$this->fromClause = sprintf($this->fromClause, 'null');
		}
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