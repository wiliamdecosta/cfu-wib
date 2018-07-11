<?php

/**
 * Tblm_contentsatellite Model
 *
 */
class Tblm_contentsatellite extends Abstract_model {

    public $table           = "tblm_contentsatellite";
    public $pkey            = "contentsatelliteid_pk";
    public $alias           = "";

    public $fields          = array(
                                'contentsatelliteid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'CONTENTSATELLITEID PK'),
                                'plitemgroupcode'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item Group'),
                                'plitemcode'         => array('nullable' =>  false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item'),
                                'valuesource'         => array('nullable' =>  true, 'type' => 'str', 'unique' => false, 'display' => 'Value Source'),
                                'listingno'         => array('nullable' =>  false, 'type' => 'int', 'unique' => false, 'display' => 'Listing No'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
                            );

    public $selectClause    = "contentsatelliteid_pk, plitemgroupcode, plitemcode, valuesource, listingno, description, creationdate, createdby, updateddate, updatedby";
    public $fromClause      = "tblm_contentsatellite";

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

            if(empty($this->record['listingno'])) {
                $this->db->set('listingno',"null",false);
                unset($this->record['listingno']);
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

            if(empty($this->record['listingno'])) {
                $this->db->set('listingno',"null",false);
                unset($this->record['listingno']);
            }


        }
        return true;
    }

}

/* End of file Tblm_contentsatellite.php */