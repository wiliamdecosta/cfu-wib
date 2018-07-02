<?php

/**
 * Tblm_activitygroup Model
 *
 */
class Tblm_category extends Abstract_model {

    public $table           = "tblm_category";
    public $pkey            = "categoryid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'categoryid_pk'  => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ACTIVITYGROUPID_PK'),
                                'code'                  => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'CODE'),
                                'listingno'         => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'LISTINGNO'),

                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "a.categoryid_pk, a.code, a.listingno, a.description, a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                        to_char(a.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, a.updatedby lastupdatedby
                                    ";
    public $fromClause      = "tblm_category a";

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

/* End of file Status_type.php */