<?php

/**
 * Pl_item Model
 *
 */
class Pl_item extends Abstract_model {

    public $table           = "tblm_plitem_1";
    public $pkey            = "plitemid_pk";
    public $alias           = "plitem";

    public $fields          = array(
                                'plitemid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'PLGROUPID_PK'),
                                'code'                  => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'CODE'),
                                'plgroupid_fk'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'PLGROUPID_FK'),
                                'listingno'            => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'LISTINGNO'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'         => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "plitem.*, plgroup.code as plgroupcode";
    public $fromClause      = "tblm_plitem_1 plitem
                                        left join tblm_plgroup_1 plgroup on plitem.plgroupid_fk = plgroup.plgroupid_pk";

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

            if(empty($this->record['listingno'])) {
                $this->db->set('listingno',"null",false);
                unset($this->record['listingno']);
            }

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:

            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];


            if(empty($this->record['listingno'])) {
                $this->db->set('listingno',"null",false);
                unset($this->record['listingno']);
            }

        }
        return true;
    }

}

/* End of file Pl_group.php */