<?php

/**
 * Tblt_groupcostadjust Model
 *
 */
class Tblt_groupcostadjust extends Abstract_model {

    public $table           = "tblt_groupcostadjust";
    public $pkey            = "";
    public $alias           = "a";

    public $fields          = array(
                                'periodid_fk'       => array('pkey' => false, 'type' => 'int', 'nullable' => false, 'unique' => false, 'display' => 'PERIODID FK'),
                                'cfucode'     => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'CFU Code'),
                                'ubiscode'     => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Subs/Ubis'),
                                'activitycode'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Activity Code'),
                                'activityname'   => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Activity Name'),
                                'activitygroupcode'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Activity Group'),
                                'costdrivercode'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Cost Driver'),
                                'origamount'        => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Orig Amount'),
                                'adjustamount'        => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Adjust Amount'),
                                'description'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),

                                'creationdate'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'createdby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = " a.periodid_fk, 
                                a.cfucode, 
                                a.ubiscode, 
                                a.activitycode, 
                                a.activityname, 
                                a.activitygroupcode, 
                                a.costdrivercode, 
                                a.origamount, 
                                a.adjustamount, 
                                a.description, 
                                a.creationdate, 
                                a.createdby, 
                                a.updateddate, 
                                a.updatedby ";

    public $fromClause      = "tblt_groupcostadjust a";

    public $refs            = array();

    public $multiUnique  = array('periodid_fk','cfucode','ubiscode','activitycode');

    function __construct() {
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
            if($this->isMultipleUnique()) {
                throw new Exception('Duplicate unique key');
            }
            //do something
            // example :
            //$this->record['creationdate'] = date('Y-m-d');
            //$this->record['updateddate'] = date('Y-m-d');
            $this->db->set('creationdate',"sysdate",false);
            $this->record['createdby'] = $userdata['user_name'];
            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];

            // $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            if($this->isMultipleUnique()) {
                throw new Exception('Duplicate unique key');
            }
            //do something
            //example:
            //$this->record['updateddate'] = date('Y-m-d');
            //if false please throw new Exception
            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];
        }
        return true;
    }

    function html_select_options_wibgroup() {
        try {

            $sql = "SELECT code FROM tblm_wibgroup where code='CFU501' ";
            $query = $this->db->query($sql);

            $items = $query->result_array();

            echo '<select>';
            foreach($items  as $item ){
                echo '<option value="'.$item['code'].'">'.$item['code'].'</option>';
            }
            echo '</select>';
            exit;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    function getData($periodid_fk){
        $sql = "select * from tblt_groupcostadjust where periodid_fk = ?";

        $query = $this->db->query($sql, array($periodid_fk));
        $row = $query->num_rows();

        return $row;
    }

}

/* End of file Organization.php */