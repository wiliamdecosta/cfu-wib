<?php

/**
 * Tblm_glplitem Model
 *
 */
class Tblm_glplitem extends Abstract_model {

    public $table           = "tblm_glplitem";
    public $pkey            = "costcenterid_pk";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "a.glaccount accountcode,
                                        a.gldesc accountname,
                                        a.plitemcode,
                                        nr.nama plitem
                                    ";
    public $fromClause      = "tblm_glplitem a
                                        inner join rra.bpc_neraca nr on a.plitemcode = nr.kode_neraca
                                        and nr.kode_fs = 'CCA'";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            $this->db->set('creationdate',"sysdate",false);
            $this->record['createdby'] = $userdata['user_name'];
            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:

            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];
        }
        return true;
    }

}

/* End of file Status_type.php */