<?php

/**
 * Tblm_centralcost Model
 *
 */
class Tblm_centralcost extends Abstract_model {

    public $table           = "tblm_centralcost";
    public $pkey            = "centralcostid_pk";
    public $alias           = "centralcost";

    public $fields          = array(
                                'centralcostid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Central Cost ID PK'),

                                'cccode'                        => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'CC Code'),
                                'accountcode'                 => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Account Code'),
                                'wibunitbusinessid_fk'     => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Business Unit'),
                                'isindirectcost'                => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Indirect Cost'),
                                'activityid_fk'                 => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Activity Code'),
                                'isneedpca'                 => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Need PCA'),

                                'description'               => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),

                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );


    public $selectClause    = "a.centralcostid_pk, a.cccode, a.accountcode, a.wibunitbusinessid_fk, a.isindirectcost, a.activityid_fk, a.isneedpca, a.description, a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                    to_char(a.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, a.updatedby lastupdatedby,
                                       ub.code ubiscode, ub.ubisname,
                                       d.code activitycode, d.activityname,
                                       b.nama ccname, (a.cccode || ' - ' || b.nama) ccgabung,
                                       c.nama accountname, (a.accountcode || ' - ' || c.nama) accountgabung,
                                       nr.nama plitem,
                                       decode(a.isindirectcost, 'Y','YES','N','NO') isindirectcost_display,
                                       d.activityname activity_display,
                                       decode(a.isneedpca, 'Y','YES','N','NO') isneedpca_display
                                       ";

    public $fromClause      = "tblm_centralcost a
                                        inner join rra.exs_cc b on a.cccode = b.kode_cc
                                        inner join tblm_wibunitbusiness ub on b.kode_ubis = ub.code2
                                                    and a.wibunitbusinessid_fk = ub.wibunitbusinessid_pk
                                        inner join rra.bpc_masakun c on a.accountcode = c.kode_akun
                                        inner join rra.bpc_relakun rel on a.accountcode = rel.kode_akun
                                        inner join rra.bpc_neraca nr on rel.kode_neraca = nr.kode_neraca
                                                    and rel.kode_fs = nr.kode_fs
                                        left join tblm_activity d on a.activityid_fk = d.activityid_pk
                                        ";
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

/* End of file Activity.php */