<?php

/**
 * Tblm_costdriver Model
 *
 */
class Tblm_costdriver extends Abstract_model {

    public $table           = "tblm_costdriver";
    public $pkey            = "costdriverid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'costdriverid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ActivityID_PK'),

                                'code'                  => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Cost Driver'),

                                'ubiscode'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'BU/Subsidiary'),
                                'unitid_fk'         => array('nullable' =>  false, 'type' => 'str', 'unique' => false, 'display' => 'Unit Code'),

                                'listingno'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Listing No'),

                                'domtrafficvalue'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'DOMTRAFFICVALUE'),
                                'domnetworkvalue'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'DOMNETWORKVALUE'),
                                'intltrafficvalue'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'INTLTRAFFICVALUE'),
                                'intlnetworkvalue'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'INTLNETWORKVALUE'),
                                'intladjacentvalue'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'INTLADJACENTVALUE'),
                                'towervalue'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'TOWERVALUE'),
                                'infravalue'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'INFRAVALUE'),

                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                                'costdrivertype'            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Cost Driver Type')
                            );

    public $selectClause    = "a.costdriverid_pk, a.code, a.ubiscode, a.unitid_fk,
                                    a.listingno,
                                    a.domtrafficvalue, a.domnetworkvalue, a.intltrafficvalue,
                                    a.intlnetworkvalue, a.intladjacentvalue, a.towervalue, a.infravalue,
                                    a.description, a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                    to_char(a.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, a.updatedby lastupdatedby,
                                    a.ubiscode ubiscodedisplay,
                                    b.ubisname,
                                    c.code unitcode, c.unitname,
                                    a.costdrivertype,

                                    a.domtrafficvalue domtrafficvaluedisplay, a.domnetworkvalue domnetworkvaluedisplay, a.intltrafficvalue intltrafficvaluedisplay,
                                    a.intlnetworkvalue intlnetworkvaluedisplay, a.intladjacentvalue intladjacentvaluedisplay, a.towervalue towervaluedisplay, a.infravalue infravaluedisplay
                                    ";
    public $fromClause      = "tblm_costdriver a
                                        inner join tblm_wibunitbusiness b on a.ubiscode = b.code
                                        inner join tblm_unit c on a.unitid_fk = c.unitid_pk";

    public $refs            = array();
    public $multiUnique  = array('code', 'ubiscode');

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

            if(empty($this->record['listingno'])) {
                $this->db->set('listingno',"null",false);
                unset($this->record['listingno']);
            }

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            if($this->isMultipleUnique()) {
                throw new Exception('Duplicate unique key');
            }

            unset($this->record['creationdate']);
            unset($this->record['createdby']);
            unset($this->record['updateddate']);

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

/* End of file Activity.php */