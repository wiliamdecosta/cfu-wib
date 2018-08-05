<?php

/**
 * Tblm_groupcost Model
 *
 */
class Tblm_groupcost extends Abstract_model {

    public $table           = "tblm_groupcost";
    public $pkey            = "groupcostid_pk";
    public $alias           = "x";

    public $fields          = array(
                                'groupcostid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'GROUPCOSTID_PK'),
                                'ubiscode'          => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Ubis/Subsidiary'),
                                'code'   => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Consol Activity'),
                                'segregationotherid_fk'     => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Activity Group|Activity|PL Item'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );


    public $selectClause    = " x.groupcostid_pk,
                                x.segregationotherid_fk,        
                                x.description,
                                x.ubiscode,
                                x.code,
                                x.creationdate,
                                x.createdby,
                                x.updateddate,
                                x.updatedby,
                                x.activitygroupcode,
                                x.actlistname,
                                x.plitemname,
                                x.costdrivercode ";

    public $fromClause      = "(select a.groupcostid_pk,
                                a.segregationotherid_fk,        
                                a.description,        
                                a.ubiscode,
                                a.code,
                                a.creationdate,
                                a.createdby,
                                a.updateddate,
                                a.updatedby,
                                b.activitygroupcode,
                                c.actlistname,
                                b.plitemname,
                                b.costdrivercode
                            from tblm_groupcost a,
                                tblm_segregationother b,
                                tblm_activitylist c    
                            where a.segregationotherid_fk = b.segregationotherid_pk and
                                b.activitycode = c.code) x";
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