<?php

/**
 * Depreactivity Model
 *
 */
class Depreactivity extends Abstract_model {

    public $table           = "tblm_depreactivity_11";
    public $pkey            = "depreactivityid_pk";
    public $alias           = "depreactivity";

    public $fields          = array(
                                'depreactivityid_pk'         => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'DEPREACTIVITYID_PK'),
                                'businessunitid_fk'      => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'BUSINESSUNITID_PK'),
                                'depreciationid_fk'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'DEPRECIATIONID_FK'),
                                'costdriverid_fk'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'COSTDRIVERID_FK'),

                                'isdomtraffic'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ISDOMTRAFFIC'),
                                'isdomnetwork'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ISDOMNETWORK'),
                                'isintltraffic'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ISINTLTRAFFIC'),
                                'isintlnetwork'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ISINTLNETWORK'),
                                'isintladjacent'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ISINTLADJACENT'),
                                'istower'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ISTOWER'),
                                'isinfrastructure'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ISINFRASTRUCTURE'),

                                'description'                 => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'DESCRIPTION'),

                                'creationdate'         => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "depreactivity.*, businessunit.code as businessunitcode, depreciation.code as depreciationcode, costdriver.code as costdrivercode";
    public $fromClause      = "tblm_depreactivity_11 depreactivity
                                        left join tblm_businessunit businessunit on depreactivity.businessunitid_fk = businessunit.businessunitid_pk
                                        left join tblm_depreciation_1 depreciation on depreactivity.depreciationid_fk = depreciation.depreciationid_pk
                                        left join tblm_costdriver_12 costdriver on depreactivity.costdriverid_fk = costdriver.costdriverid_pk";

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

/* End of file Gl_category.php */