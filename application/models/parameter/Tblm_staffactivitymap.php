<?php

/**
 * Tblm_staffactivitymap Model
 *
 */
class Tblm_staffactivitymap extends Abstract_model {

    public $table           = "tblm_staffactivitymap";
    public $pkey            = "staffactivitymapid_pk";
    public $alias           = "sam";

    public $fields          = array(
                                'staffactivitymapid_pk'   => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'GLACCPLMAPID_PK'),

                                'id_divisi'             => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Division ID'),
                                'id_loker'             => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Organization ID'),
                                'id_posisi'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Job Position ID'),
                                'activityid_fk'             => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Activity Code'),

                                'description'               => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "sam.staffactivitymapid_pk, sam.id_divisi, sam.id_loker, sam.id_posisi, sam.activityid_fk, sam.description, sam.creationdate, sam.createdby, sam.updateddate, sam.updatedby ,
                                 to_char(sam.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, sam.updatedby lastupdatedby,
                                    divisi.nama division_name, (sam.id_divisi || ' - ' || divisi.nama) divisi_gabung,
                                    org.loker org_name, (sam.id_loker || ' - ' || org.loker) organization_gabung,
                                    jobposition.posisi job_posisition, (sam.id_posisi || ' - ' || jobposition.posisi) jobposition_gabung,
                                    activity.code activitycode, activity.activityname, (activity.code || ' - ' || activity.activityname) activity_gabung,
                                    sam.id_divisi iddivisi";

    public $fromClause      = "tblm_staffactivitymap sam
                                        inner join RRA.bpc_cost_payroll_div divisi on sam.id_divisi = divisi.kode_div
                                        inner join RRA.bpc_cost_payroll_loker org on sam.id_loker = org.id
                                        left join RRA.bpc_cost_payroll_posisi jobposition on sam.id_posisi =  jobposition.id
                                        inner join tblm_activity activity on sam.activityid_fk = activity.activityid_pk";

    public $refs            = array();
    public $multiUnique  = array('id_divisi',
                                        'id_loker',
                                        'id_posisi');


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

/* End of file Pl_group.php */