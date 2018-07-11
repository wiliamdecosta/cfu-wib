<?php

/**
 * Pl_item_contentsatellite Model
 *
 */
class Pl_item_contentsatellite extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "a";

    public $fields          = array();

    public $selectClause    = "a.plitem, a.plitemgroup";
    public $fromClause      = "(select  
                                    a.nama plitem,
                                    b.nama plitemgroup
                                from rra.bpc_neraca a,
                                    rra.bpc_neraca b
                                where a.kode_fs='CCA' and
                                    a.kode_induk <> '00' and
                                    a.kode_induk = b.kode_neraca and
                                    b.kode_fs='CCA'
                                union all    
                                select  
                                    a.nama plitem,
                                    a.nama plitemgroup
                                from rra.bpc_neraca a
                                where a.kode_fs='CCA' and
                                    a.kode_induk = '00') a";

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

/* End of file Pl_item_contentsatellite.php */