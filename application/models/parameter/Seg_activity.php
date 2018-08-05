<?php

/**
 * seg_activity Model
 *
 */
class Seg_activity extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "a";

    public $fields          = array();


    public $selectClause    = " a.segregationotherid_pk,
                                a.activitygroupcode,
                                a.activityname,
                                a.plitemname,
                                a.costdrivercode,
                                a.ubiscode";

    public $fromClause      = "(select b.segregationotherid_pk,
                                    b.activitygroupcode,
                                    c.actlistname activityname,
                                    b.plitemname,
                                    b.costdrivercode,
                                    b.ubiscode
                                from 
                                    tblm_segregationother b,
                                    tblm_activitylist c    
                                where b.activitycode = c.code) a";
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