<?php

/**
 * Tblm_segregationmap Model
 *
 */

class Tblm_segregationmap extends Abstract_model {

    public $table           = "tblm_segregationmap";
    public $pkey            = "segregationmapid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'segregationmapid_pk'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ACTIVITYLISTID_PK'),

                                'activitylistid_fk'     => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Activity'),
                                'activitygroupid_fk'     => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Activity Group'),

                                'plitemcode'    => array('nullable' => true, 'type' => 'str', 'unique' => true, 'display' => 'PL Item'),

                                'description'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'  => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created Date'),
                                'createdby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'  => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "a.segregationmapid_pk, a.activitylistid_fk, a.activitygroupid_fk, a.plitemcode, a.description, a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                    to_char(a.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, a.updatedby lastupdatedby,
                                    b.actlistname, b.ubiscode, b.actlistname activitydisplay,
                                    c.acttypename, c.acttypename activitytypedisplay,
                                    d.code activitygroup, d.code activitygroupdisplay,
                                    e.nama plitemname
                                    ";
    public $fromClause      = "tblm_segregationmap a
                                        left join tblm_activitylist b on a.activitylistid_fk = b.activitylistid_pk
                                        left join tblm_activitytype c on b.activitytypeid_fk = c.activitytypeid_pk
                                        left join tblm_activitygroup d on a.activitygroupid_fk = d.activitygroupid_pk
                                        left join rra.bpc_neraca e on a.plitemcode = e.kode_neraca and e.kode_fs = 'CCA'
                                        ";

    public $refs            = array();

    public $multiUnique  = array('activitylistid_fk',
                                            'activitygroupid_fk');



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

        }
        return true;
    }

}

/* End of file Organization.php */