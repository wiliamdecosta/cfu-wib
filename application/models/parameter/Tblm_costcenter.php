<?php

/**
 * Tblm_costcenter Model
 *
 */
class Tblm_costcenter extends Abstract_model {

    public $table           = "tblm_costcenter";
    public $pkey            = "costcenterid_pk";
    public $alias           = "";

    public $fields          = array(
                                'costcenterid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'COSTCENTERID PK'),
                                'cccode'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Cost Center Code'),
                                'ccname'         => array('nullable' =>  false, 'type' => 'str', 'unique' => false, 'display' => 'Cost Center Name'),
                                'parentcode'         => array('nullable' =>  true, 'type' => 'str', 'unique' => false, 'display' => 'Parent Code'),
                                'orglevel'         => array('nullable' =>  true, 'type' => 'int', 'unique' => false, 'display' => 'Level'),
                                'sourcetype'         => array('nullable' =>  false, 'type' => 'str', 'unique' => false, 'display' => 'Source'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),
                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
                            );

    public $selectClause    = "costcenterid_pk, cccode kode, ccname nama, parentcode, orglevel, sourcetype, description, creationdate, createdby, updateddate, updatedby, cccode, ccname";
    public $fromClause      = "tblm_costcenter";

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

            if(empty($this->record['orglevel'])) {
                $this->db->set('orglevel',"null",false);
                unset($this->record['orglevel']);
            }

          
            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            unset($this->record['creationdate']);
            unset($this->record['createdby']);
            unset($this->record['updateddate']);

            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];

            if(empty($this->record['orglevel'])) {
                $this->db->set('orglevel',"null",false);
                unset($this->record['orglevel']);
            }


        }
        return true;
    }

}

/* End of file Status_type.php */