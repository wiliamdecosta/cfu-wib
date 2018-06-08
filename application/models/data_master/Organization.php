<?php

/**
 * Organization Model
 *
 */
class Organization extends Abstract_model {

    public $table           = "tblm_organization_41";
    public $pkey            = "organizationid_pk";
    public $alias           = "organization";

    public $fields          = array(
                                'organizationid_pk'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Business Unit ID'),
                                'parentid_fk'     => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Parent ID FK'),
                                'organizationgroupid_fk'     => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ORGANIZATIONGROUPID_FK'),

                                'organizationcode'    => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'CODE'),
                                'organizationname'      => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'BUNAME'),
                                'listingno'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'LISTINGNO'),
                                'description'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'createdby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "organization.*";
    public $fromClause      = "tblm_organization_41 organization";

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
            //$this->record['creationdate'] = date('Y-m-d');
            //$this->record['updateddate'] = date('Y-m-d');
            $this->db->set('creationdate',"sysdate",false);
            $this->record['createdby'] = $userdata['user_name'];
            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

            if(empty($this->record['parentid_fk']))
                unset($this->record['parentid_fk']);

            if(empty($this->record['listingno'])) {
                $this->db->set('listingno',"null",false);
                unset($this->record['listingno']);
            }

        }else {
            //do something
            //example:
            //$this->record['updateddate'] = date('Y-m-d');
            //if false please throw new Exception
            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];

            if(empty($this->record['parentid_fk']))
                unset($this->record['parentid_fk']);

            if(empty($this->record['listingno'])) {
                $this->db->set('listingno',"null",false);
                unset($this->record['listingno']);
            }
        }
        return true;
    }

    function emptyChildren($organizationid_pk) {
        $sql = "select count(1) as total from ".$this->table." where parentid_fk = ?";

        $query = $this->db->query($sql, array($organizationid_pk));
        $row = $query->row_array();

        return $row['total'] == 0;
    }

}

/* End of file Organization.php */