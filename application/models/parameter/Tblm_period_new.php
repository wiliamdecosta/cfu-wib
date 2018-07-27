<?php

/**
 * Tblm_period_new Model
 *
 */
class Tblm_period_new extends Abstract_model {

    public $table           = "tblm_period";
    public $pkey            = "periodid_pk";
    public $alias           = "period";

    public $fields          = array();

    public $selectClause    = "period.*, 
                               initcap(to_char(to_date(period.month, 'mm'), 'month')) as month_name,
                               period.periodid_pk as periodid_pk_display, 
                               statuslist.code as periodstatus_display, 
                               statuslist.code as periodstatuscode,
                               (select count(1) from tblt_cpallocadjust x where period.periodid_pk = x.periodid_fk ) count_cpallocadjust
                               ";

    public $fromClause      = "tblm_period period
                                        left join tblm_statuslist statuslist on period.statuslistid_fk = statuslist.statuslistid_pk";

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
            $this->db->set('creationdate',"sysdate",false);
            $this->record['createdby'] = $userdata['user_name'];
            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->record['year'].str_pad($this->record['month'],2,"0",STR_PAD_LEFT);

        }else {
            //do something
            //example:

            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];


        }
        return true;
    }

}

/* End of file Period.php */