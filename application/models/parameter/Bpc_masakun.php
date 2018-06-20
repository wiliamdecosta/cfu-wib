<?php

/**
 * Bpc_masakun Model
 *
 */
class Bpc_masakun extends Abstract_model {

    public $table           = "rra.exs_cc";
    public $pkey            = "kode_cc";
    public $alias           = "exscc";

    public $fields          = array(

                            );

    public $selectClause    = "c.kode_akun accountcode,
                                        c.nama accountname,
                                        nr.nama plitem";
    public $fromClause      = "rra.bpc_masakun c
                                        inner join rra.bpc_relakun rel on c.kode_akun = rel.kode_akun
                                        inner join rra.bpc_neraca nr on rel.kode_neraca = nr.kode_neraca and
                                                                                rel.kode_fs = nr.kode_fs";

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