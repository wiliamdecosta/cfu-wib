<?php

/**
 * Gl_acc_pl_map Model
 *
 */
class Gl_acc_pl_map extends Abstract_model {

    public $table           = "tblm_glaccplmap_31";
    public $pkey            = "glaccplmapid_pk";
    public $alias           = "glaccplmap";

    public $fields          = array(
                                'glaccplmapid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'GLACCPLMAPID_PK'),
                                'glaccount'               => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'CODE'),
                                'plitemid_fk'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'PLITEMID_FK'),
                                'description'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'         => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "glaccplmap.*, plitem.code as plitemcode, plgroup.code as plgroupcode
                                        ";

    public $fromClause      = "tblm_glaccplmap_31 glaccplmap
                                        left join tblm_plitem_1 plitem on glaccplmap.plitemid_fk = plitem.plitemid_pk
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

/* End of file Pl_group.php */