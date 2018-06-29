<?php

/**
 * Tblm_cpallocationmap Model
 *
 */
class Tblm_cpallocationmap extends Abstract_model {

    public $table           = "tblm_cpallocationmap";
    public $pkey            = "cpallocationmapid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'cpallocationmapid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'PCA ID PK'),
                                'wibunitbusinessid_fk'     => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Business Unit'),

                                'idactivityext'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'ID Activity Ext'),
                                'plitemcode'          => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item Code'),

                                'pctallocation'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PCT Allocation'),

                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );


    public $selectClause    = "a.cpallocationmapid_pk, a.wibunitbusinessid_fk, a.idactivityext, a.plitemcode,
                                    a.idactivityext idactivityextdisplay, a.pctallocation, a.pctallocation pctallocationdisplay,
                                    a.plitemcode plitemcodedisplay,
                                    a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                        to_char(a.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, a.updatedby lastupdatedby,
                                    b.nama plitemname,
                                    c.code ubiscode, c.ubisname,
                                    d.uraian activityname";

    public $fromClause      = "tblm_cpallocationmap a
                                        inner join rra.bpc_neraca b on a.plitemcode = b.kode_neraca and b.kode_fs = 'CCA'
                                        inner join tblm_wibunitbusiness c on a.wibunitbusinessid_fk = c.wibunitbusinessid_pk
                                        inner join rra.bpc_cost_activity d on a.idactivityext = d.id";
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

            if($this->record['pctallocation'] < 0 or
                    $this->record['pctallocation'] > 100) {
                throw new Exception('Nilai PCT Allocation antara 0 - 100');
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

            if($this->record['pctallocation'] < 0 or
                    $this->record['pctallocation'] > 100) {
                throw new Exception('Nilai PCT Allocation antara 0 - 100');
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

/* End of file Activity.php */