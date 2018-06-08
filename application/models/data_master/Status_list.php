<?php

/**
 * Status_list Model
 *
 */
class Status_list extends Abstract_model {

    public $table           = "tblm_statuslist";
    public $pkey            = "statuslistid_pk";
    public $alias           = "status_list";

    public $fields          = array(
                                'statuslistid_pk'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'STATUSLISTID_PK'),
                                'statustypeid_fk'     => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'STATUSTYPEID_FK'),

                                'code'    => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'CODE'),
                                'isfinishstatus'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ISFINISHSTATUS'),
                                'isfailstatus'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ISFAILSTATUS'),
                                'iscancelstatus'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ISCANCELSTATUS'),

                                'description'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'createdby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "status_list.*, status_type.code as statustypecode";
    public $fromClause      = "tblm_statuslist status_list
                                        left join tblm_statustype status_type on status_list.statustypeid_fk = status_type.statustypeid_pk";

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

        }else {
            //do something
            //example:
            //$this->record['updateddate'] = date('Y-m-d');
            //if false please throw new Exception
            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];
        }
        return true;
    }

}

/* End of file Organization.php */