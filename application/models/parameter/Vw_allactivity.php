<?php

/**
 * Vw_allactivity Model
 *
 */
class Vw_allactivity extends Abstract_model {

    public $table           = "";
    public $pkey            = "activitycode";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "c.activitycode, c.activitytype, c.activityname, c.ubiscode, c.listingno,
                                    d.acttypename";
    public $fromClause      = "(
                                        SELECT
                                            a.CODE ActivityCode,
                                            1 ActivityType,
                                            a.ACTIVITYNAME ActivityName,
                                            a.UBISCODE  Ubiscode,
                                            a.ListingNo
                                        FROM tblM_Activity a
                                        UNION ALL
                                        SELECT
                                            b.CODE ActivityCode,
                                            b.ACTIVITYTYPEID_FK ActivityType,
                                            b.ACTLISTNAME  ActivityName,
                                            b.UBISCODE  Ubiscode,
                                            b.ListingNo
                                        FROM tblm_ActivityList b
                                        ) c
                                        left join tblm_activitytype d on c.activitytype = d.activitytypeid_pk";

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

/* End of file Status_type.php */