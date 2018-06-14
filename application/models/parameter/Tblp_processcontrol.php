<?php

/**
 * Tblp_processcontrol Model
 *
 */
class Tblp_processcontrol extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "n01 processcontrolid_pk,
                                            n02 processtypeid_fk,
                                            s01 processtypecode,
                                            n03 processid_fk,
                                            s02 processcode,
                                            s03 isaccessible,
                                            s04 isupdatable,
                                            n04 statuslistid_fk,
                                            s05 statuscode,
                                            s06 isverified,
                                            s07 isvalid,
                                            s08 verifiedby,
                                            s09 verificationdate,
                                            s10 updateddate,
                                            s11 updatedby,

                                            b.pbatchcontrolid_fk,
                                            b.startprocesstime,
                                            b.endprocesstime,
                                            b.procedurename,
                                            b.procedureparam,
                                            b.description,
                                            b.creationdate,
                                            b.createdby
                                            ";

    public $fromClause      = "table(f_ShowProcessControl(%d,%s)) a
                                        left join tblp_processcontrol b on a.n01 = b.pprocesscontrolid_pk";

    public $refs            = array();

    function __construct($i_batch_control_id = -999, $i_search = '') {

        if(empty($i_search))
            $i_search = 'null';
        else
            $i_search = "'".$i_search."'";

        $this->fromClause = sprintf($this->fromClause, $i_batch_control_id, $i_search);
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