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


    /*public $selectClause    = "a.centralcostid_pk, a.cccode, a.accountcode, a.wibunitbusinessid_fk, a.isindirectcost, a.activityid_fk, a.isneedpca, a.description, a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                    to_char(a.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, a.updatedby lastupdatedby,
                                       ub.code ubiscode, ub.ubisname,
                                       d.code activitycode, d.activityname,
                                       b.nama ccname, (a.cccode || ' - ' || b.nama) ccgabung,
                                       c.nama accountname, (a.accountcode || ' - ' || c.nama) accountgabung,
                                       nr.nama plitem,
                                       decode(a.isindirectcost, 'Y','YES','N','NO') isindirectcost_display,
                                       d.activityname activity_display,
                                       decode(a.isneedpca, 'Y','YES','N','NO') isneedpca_display
                                       ";*/


    /*public $fromClause      = "tblm_centralcost a
                                        inner join rra.exs_cc b on a.cccode = b.kode_cc
                                        inner join tblm_wibunitbusiness ub on b.kode_ubis = ub.code2
                                                    and a.wibunitbusinessid_fk = ub.wibunitbusinessid_pk
                                        inner join rra.bpc_masakun c on a.accountcode = c.kode_akun and c.kode_lokasi ='9000'
                                        inner join rra.bpc_relakun rel on a.accountcode = rel.kode_akun
                                        inner join rra.bpc_neraca nr on rel.kode_neraca = nr.kode_neraca
                                                    and rel.kode_fs = nr.kode_fs and nr.kode_fs = 'CCA'
                                        left join tblm_activity d on a.activityid_fk = d.activityid_pk
                                        ";*/

    public $selectClause = "centralcostid_pk, cccode, accountcode, wibunitbusinessid_fk, isindirectcost, activityid_fk, isneedpca, description, creationdate, createdby, updateddate, updatedby,
                                    to_char(updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, updatedby lastupdatedby,
                                    ubiscode,
                                    activitycode, activityname,
                                    ccname, (cccode || ' - ' || ccname) ccgabung,
                                    accountname, (accountcode || ' - ' || accountname) accountgabung,
                                    plitem,
                                    decode(isindirectcost, 'Y','YES','N','NO') isindirectcost_display,
                                    activityname activity_display,
                                    decode(isneedpca, 'Y','YES','N','NO') isneedpca_display
                                    ";


    public $fromClause = "(select  a.CENTRALCOSTID_PK,
                                    a.CCCODE,
                                    b.Nama CCName,
                                    a.ACCOUNTCODE,
                                    c.Nama AccountName,
                                    nr.Nama PLItem,
                                    a.WIBUNITBUSINESSID_FK,
                                    a.ISINDIRECTCOST,
                                    a.ACTIVITYID_FK,
                                    d.code activitycode,
                                    d.ActivityName ActivityName,
                                    a.ISNEEDPCA,
                                    ub.Code UbisCode,
                                    a.description, a.creationdate, a.createdby, a.updateddate, a.updatedby
                                    from tblM_CentralCost a,
                                        tblm_WIBUnitBusiness ub,
                                        rra.exs_cc b,
                                        rra.bpc_masakun c,
                                        rra.bpc_relakun rel,
                                        rra.bpc_neraca nr,
                                        tblM_Activity d
                                    where a.ccCode = b.Kode_CC and
                                        b.Kode_UBIS = ub.Code2 and
                                        a.WIBUnitbusinessid_FK = ub.WIBUnitBusinessID_PK and
                                        ub.WIBUnitBusinessID_PK <> 3 AND
                                        a.AccountCode = c.Kode_Akun and
                                        c.kode_lokasi ='9000' and
                                        a.AccountCode = rel.kode_akun and
                                        rel.kode_neraca = nr.kode_neraca and
                                        rel.kode_fs = nr.kode_fs and
                                        nr.kode_fs = 'CCA' and
                                        a.ACTIVITYID_FK = d.ACTIVITYID_PK (+)
                                    UNION ALL
                                    select  a.CENTRALCOSTID_PK,
                                    a.CCCODE,
                                    cc.CCName,
                                    a.ACCOUNTCODE,
                                    gl.GLDesc AccountName,
                                    nr.Nama PLItem,
                                    a.WIBUNITBUSINESSID_FK,
                                    a.ISINDIRECTCOST,
                                    a.ACTIVITYID_FK,
                                    d.code activitycode,
                                    d.ActivityName ActivityName,
                                    a.ISNEEDPCA,
                                    ub.Code UbisCode,
                                    a.description, a.creationdate, a.createdby, a.updateddate, a.updatedby
                                    from tblM_CentralCost a,
                                        tblM_CostCenter cc,
                                        tblm_WIBUnitBusiness ub,
                                        tblM_GLPLItem gl,
                                        rra.bpc_neraca nr,
                                        tblM_Activity d
                                    where a.ccCode = cc.CCCode and
                                        a.WIBUnitbusinessid_FK = ub.WIBUnitBusinessID_PK and
                                        ub.WIBUnitBusinessID_PK = 3 AND
                                        a.AccountCode = gl.GLAccount and
                                        gl.PLItemCode = nr.kode_neraca and
                                        nr.kode_fs = 'CCA' and
                                        a.ACTIVITYID_FK = d.ACTIVITYID_PK (+)
                                    )";


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