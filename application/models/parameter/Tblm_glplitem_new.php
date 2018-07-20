<?php

/**
 * Tblm_glplitem Model
 *
 */
class Tblm_glplitem_new extends Abstract_model {

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


    public $selectClause    = "a.accountcode ,
                                a.accountname,
                                a.plitemcode,
                                a.plitem";

    public $fromClause      = "(select x.glaccount accountcode,
                                    x.gldesc accountname,
                                    x.plitemcode,
                                    nr.nama plitem
                                from tblm_glplitem x,
                                    rra.bpc_neraca nr
                                where x.plitemcode = nr.kode_neraca and
                                    nr.kode_fs = 'CCA'
                                order by x.glaccount
                                ) a";
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