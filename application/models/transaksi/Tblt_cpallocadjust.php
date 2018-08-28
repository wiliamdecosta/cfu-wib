<?php

/**
 * Tblt_cpallocadjust Model
 *
 */
class Tblt_cpallocadjust extends Abstract_model {

    public $table           = "tblt_cpallocadjust";
    public $pkey            = "";
    public $alias           = "a";

    public $fields          = array(
                                'periodid_fk'       => array('pkey' => false, 'type' => 'int', 'nullable' => false, 'unique' => false, 'display' => 'PERIODID FK'),
                                'ubiscode'     => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Subs/Ubis'),
                                'activitycode'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Activity Code'),
                                'activityname'   => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Activity Name'),
                                'plitemcode'        => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item Code'),
                                'plitemnme'        => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item Name'),
                                'origamount'        => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Origin Amount'),
                                'adjustamount'        => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Adjustment Amount'),
                                'description'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'createdby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = " a.periodid_fk, 
                                a.ubiscode, 
                                a.activitycode, 
                                a.activityname, 
                                a.plitemcode, 
                                a.plitemnme, 
                                a.origamount, 
                                a.adjustamount, 
                                a.description, 
                                a.creationdate, 
                                a.createdby, 
                                a.updateddate, 
                                a.updatedby ";

    public $fromClause      = "tblt_cpallocadjust a";

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
            //$this->record['creationdate'] = date('Y-m-d');
            //$this->record['updateddate'] = date('Y-m-d');
            $this->db->set('creationdate',"sysdate",false);
            $this->record['createdby'] = $userdata['user_name'];
            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            //$this->record['updateddate'] = date('Y-m-d');
            //if false please throw new Exception
            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];
        }
        return true;
    }

    function getData($periodid_fk){
        $sql = "select * from tblt_cpallocadjust where periodid_fk = ?";

        $query = $this->db->query($sql, array($periodid_fk));
        $row = $query->num_rows();

        return $row;
    }

}

/* End of file Organization.php */