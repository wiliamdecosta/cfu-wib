<?php

/**
 * Unit Model
 *
 */
class Unit extends Abstract_model {

    public $table           = "tblm_unit";
    public $pkey            = "unitid_pk";
    public $alias           = "unit";

    public $fields          = array(
                                'unitid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'UNITID_PK'),
                                'code'                      => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'CODE'),
                                'unitname'                  => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'UNITNAME'),
                                'listingno'               => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'LISTINGNO'),
                                'description'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'            => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'               => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'            => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'              => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "unit.*";
    public $fromClause      = "tblm_unit unit";

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

/* End of file Activity.php */