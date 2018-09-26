<?php

/**
 * Tblm_activitystructure Model
 *
 */
class Tblm_activitystructure extends Abstract_model {

    public $table           = "tblm_activitystructure";
    public $pkey            = "activitystructureid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'activitystructureid_pk'  => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ActivityID_PK'),

                                'activityid'                  => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Activity Code'),

                                'ubiscode'                    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'BU/Subsidiary'),
                                'activitytypeid_fk'         => array('nullable' =>  false, 'type' => 'int', 'unique' => false, 'display' => 'activitytypeid_fk'),

                                'listingno'                  => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Listing No'),

                                'ohactivityid1'                  => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Overhead Act 1'),
                                'ohactivityid2'                  => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Overhead Act 2'),

                                'costdriverid_fk'         => array('nullable' =>  false, 'type' => 'int', 'unique' => false, 'display' => 'Cost Driver'),


                                'isdomtraffic'            => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'ISDOMTRAFFIC'),
                                'isdomnetwork'            => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'ISDOMNETWORK'),
                                'isintltraffic'             => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'ISINTLTRAFFIC'),
                                'isintlnetwork'            => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'ISINTLNETWORK'),
                                'isintladjacent'           => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'ISINTLADJACENT'),
                                'istower'                   => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'ISTOWER'),
                                'isinfrastructure'        => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'ISINFRASTRUCTURE'),

                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'DESCRIPTION'),

                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "a.activitystructureid_pk, a.activityid,
                                    a.ubiscode, a.activitytypeid_fk, a.listingno,
                                    a.ohactivityid1, a.ohactivityid2, a.costdriverid_fk,
                                    a.isdomtraffic, a.isdomnetwork, a.isintltraffic, a.isintlnetwork,
                                    a.isintladjacent, a.istower, a.isinfrastructure,
                                    decode(a.isdomtraffic, 'Y','YES','N','NO') isdomtrafficdisplay,
                                    decode(a.isdomnetwork, 'Y','YES','N','NO') isdomnetworkdisplay,
                                    decode(a.isintltraffic, 'Y','YES','N','NO') isintltrafficdisplay,
                                    decode(a.isintlnetwork, 'Y','YES','N','NO') isintlnetworkdisplay,
                                    decode(a.isintladjacent, 'Y','YES','N','NO') isintladjacentdisplay,
                                    decode(a.istower, 'Y','YES','N','NO') istowerdisplay,
                                    decode(a.isinfrastructure, 'Y','YES','N','NO') isinfrastructuredisplay,

                                    a.description, a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                    to_char(a.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, a.updatedby lastupdatedby,
                                    a.ubiscode ubiscodedisplay,
                                    b.ubisname,
                                    c.code costdrivercode,
                                    d.activityname, (a.activityid || ' - ' || d.activityname) activitygabung,
                                    e.activityname ohactivityname1, (a.ohactivityid1 || ' - ' || e.activityname) ohactivitygabung1,
                                    f.activityname ohactivityname2, (a.ohactivityid2 || ' - ' || f.activityname) ohactivitygabung2,
                                    (g.code || ' - ' || g.acttypename) activittypeygabung
                                    ";
    public $vw_allactivity = "(
                                        select
                                            a.code activitycode,
                                            1 activitytype,
                                            a.activityname activityname,
                                            a.ubiscode  ubiscode,
                                            a.listingno
                                        from tblm_activity a
                                        union all
                                        select
                                            b.code activitycode,
                                            b.activitytypeid_fk activitytype,
                                            b.actlistname  activityname,
                                            b.ubiscode  ubiscode,
                                            b.listingno
                                        from tblm_activitylist b
                                        ) ";

    public $fromClause      = "tblm_activitystructure a
                                        inner join tblm_wibunitbusiness b on a.ubiscode = b.code
                                        inner join tblm_costdriver c on a.costdriverid_fk = c.costdriverid_pk
                                        left join tblm_activitytype g on a.activitytypeid_fk = g.activitytypeid_pk
                                        ";

    public $refs            = array();

    public $multiUnique  = array('activityid','ubiscode');

    function __construct() {
        $this->fromClause .= " inner join ".$this->vw_allactivity."d on a.activityid = d.activitycode";
        $this->fromClause .= " left join ".$this->vw_allactivity."e on a.ohactivityid1 = e.activitycode";
        $this->fromClause .= " left join ".$this->vw_allactivity."f on a.ohactivityid2 = f.activitycode";

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

            if(empty($this->record['listingno'])) {
                $this->db->set('listingno',"null",false);
                unset($this->record['listingno']);
            }

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {

            if($this->isMultipleUnique()) {
                throw new Exception('Duplicate unique key');
            }

            //do something
            //example:
            unset($this->record['creationdate']);
            unset($this->record['createdby']);
            unset($this->record['updateddate']);

            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];


            if(empty($this->record['listingno'])) {
                $this->db->set('listingno',"null",false);
                unset($this->record['listingno']);
            }

        }
        return true;
    }

}

/* End of file Activity.php */