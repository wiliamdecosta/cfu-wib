<?php

/**
 * Tblm_glplitem Model
 *
 */
class Tblm_glplitem extends Abstract_model {

    public $table           = "tblm_glplitem";
    public $pkey            = "glplitemid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'glplitemid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'GLPLITEMID PK'),
                                'glaccount'          => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'GL Account'),
                                'gldesc'             => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'GL Desc'),
                                'plitemcode'             => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item'),
                                'plitemgroupid_fk'     => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'PL Item Group'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );


    public $selectClause    = "a.glplitemid_pk, a.glaccount, a.gldesc, a.plitemcode,
                                    a.plitemgroupid_fk, a.description,                                    
                                    a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                        to_char(a.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, a.updatedby lastupdatedby,
                                    b.nama plitemname,
                                    a.plitemcode||' - '||b.nama plitemcodedisplay,
                                    c.code plitemgroupdisplay";

    public $fromClause      = "tblm_glplitem a
                                        inner join rra.bpc_neraca b on a.plitemcode = b.kode_neraca and b.kode_fs = 'CCA'
                                        left join tblm_plitemgroup c on a.plitemgroupid_fk = c.plitemgroupid_pk";
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

            unset($this->record['creationdate']);
            unset($this->record['updateddate']);

            $this->db->set('creationdate',"sysdate",false);
            $this->record['createdby'] = $userdata['user_name'];
            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];

          
            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            unset($this->record['creationdate']);
            unset($this->record['createdby']);
            unset($this->record['updateddate']);

            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];


        }
        return true;
    }

}

/* End of file Activity.php */