<?php

/**
 * Process_category Model
 *
 */
class Process_category extends Abstract_model {

    public $table           = "tblm_processcategory";
    public $pkey            = "processcategoryid_pk";
    public $alias           = "processcategory";

    public $fields          = array(
                                'processcategoryid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'statustypeid_pk'),
                                'parentid_fk'     => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Parent ID FK'),
                                'code'                  => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'CODE'),
                                'listingno'            => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'LISTINGNO'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'         => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "processcategory.*";
    public $fromClause      = "tblm_processcategory processcategory";

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

/* End of file Process_category.php */