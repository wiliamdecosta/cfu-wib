<?php

/**
 * Tblm_activitylist Model
 *
 */
class Tblm_activitylist extends Abstract_model {

    public $table           = "tblm_activitylist";
    public $pkey            = "activitylistid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'activitylistid_pk'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ACTIVITYLISTID_PK'),
                                'activitytypeid_fk'     => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ACTIVITYTYPEID_FK'),

                                'code'    => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'CODE'),
                                'ubiscode'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'UBISCODE'),
                                'actlistname'     => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'ACTLISTNAME'),
                                'listingno'         => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'LISTINGNO'),

                                'description'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'  => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created Date'),
                                'createdby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'  => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "a.activitylistid_pk, a.activitytypeid_fk, a.code, a.ubiscode, a.actlistname, a.listingno, a.description,
                                    a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                        to_char(a.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, a.updatedby lastupdatedby,
                                        a.ubiscode ubiscodedisplay";
    public $fromClause      = "tblm_activitylist a";

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

/* End of file Organization.php */