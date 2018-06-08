<?php

/**
 * Gl_account Model
 *
 */
class Gl_account extends Abstract_model {

    public $table           = "tblm_glaccount";
    public $pkey            = "glaccountid_pk";
    public $alias           = "glaccount";

    public $fields          = array(
                                'glaccountid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ActivityID_PK'),
                                'code'                  => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'CODE'),
                                'accountname'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ACCOUNTNAME'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'         => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "glaccount.*";
    public $fromClause      = "tblm_glaccount glaccount";

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

/* End of file Activity.php */