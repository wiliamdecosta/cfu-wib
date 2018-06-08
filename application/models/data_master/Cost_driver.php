<?php

/**
 * Cost_driver Model
 *
 */
class Cost_driver extends Abstract_model {

    public $table           = "tblm_costdriver_12";
    public $pkey            = "costdriverid_pk";
    public $alias           = "costdriver";

    public $fields          = array(
                                'costdriverid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'PLGROUPID_PK'),
                                'code'                  => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'CODE'),
                                'businessunitid_fk'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'BUSINESSUNITID_FK'),
                                'unitid_fk'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'UNITID_FK'),
                                'listingno'            => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'LISTINGNO'),
                                'domtrafficvalue'            => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'DOMTRAFFICVALUE'),
                                'domnetworkvalue'            => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'DOMNETWORKVALUE'),
                                'intltrafficvalue'            => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'INTLTRAFFICVALUE'),
                                'intlnetworkvalue'            => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'INTLNETWORKVALUE'),
                                'intladjacentvalue'            => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'INTLADJACENTVALUE'),
                                'infravalue'            => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'INFRAVALUE'),
                                'description'                  => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'DESCRIPTION'),

                                'creationdate'         => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "costdriver.*, businessunit.code as businessunitcode, unit.code as unitcode";
    public $fromClause      = "tblm_costdriver_12 costdriver
                                        left join tblm_businessunit businessunit on costdriver.businessunitid_fk = businessunit.businessunitid_pk
                                        left join tblm_unit unit on costdriver.unitid_fk = unit.unitid_pk";

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

/* End of file Cost_driver.php */