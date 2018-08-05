<?php

/**
 * Tblm_segregationother Model
 *
 */

class Tblm_segregationother extends Abstract_model {

    public $table           = "tblm_segregationother";
    public $pkey            = "segregationotherid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'segregationotherid_pk'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'SEGREGATIONOTHERID_PK'),
                                'ubiscode'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Ubis Code'),
                                'activitygroupcode'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Activity Group'),
                                'activitycode'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Activity Code'),
                                'plitemname'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item Name'),
                                'costdrivercode'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Cost Driver'),

                                'description'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),

                                'creationdate'  => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created Date'),
                                'createdby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'  => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "a.segregationotherid_pk,
                               a.ubiscode,
                               a.activitygroupcode,
                               a.activitycode,
                               a.plitemname,
                               a.costdrivercode,
                               a.description,
                               a.creationdate,
                               a.createdby,
                               a.updateddate,
                               a.updatedby,
                               a.actlistname ";

    public $fromClause      = "(SELECT c.segregationotherid_pk,
                                       c.ubiscode,
                                       c.activitygroupcode,
                                       c.activitycode,
                                       c.plitemname,
                                       c.costdrivercode,
                                       c.description,
                                       c.creationdate,
                                       c.createdby,
                                       c.updateddate,
                                       c.updatedby,
                                       b.actlistname
                                FROM   tblm_segregationother c, tblm_activitylist b
                               WHERE   c.activitycode = b.code) a ";

    public $refs            = array();

    public $multiUnique  = array('ubiscode', 'activitygroupcode');



    function __construct() {
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            if($this->isMultipleUnique()) {
                throw new Exception('Duplicate unique key');
            }

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
            // if($this->isMultipleUnique()) {
            //     throw new Exception('Duplicate unique key');
            // }

            unset($this->record['creationdate']);
            unset($this->record['createdby']);
            unset($this->record['updateddate']);

            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];

        }
        return true;
    }

}

/* End of file Organization.php */