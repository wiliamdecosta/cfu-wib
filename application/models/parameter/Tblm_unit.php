<?php

/**
 * Tblm_unit Model
 *
 */
class Tblm_unit extends Abstract_model {

    public $table           = "tblm_unit";
    public $pkey            = "unitid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'unitid_pk'  => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Activity Type'),
                                'code'                  => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'CODE'),
                                'unitname'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'unitname'),
                                'listingno'         => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'LISTINGNO'),

                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "a.unitid_pk, a.code, a.unitname, a.listingno,
                                    a.description, a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                    to_char(a.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, a.updatedby lastupdatedby";
    public $fromClause      = "tblm_unit a";

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

/* End of file Status_type.php */