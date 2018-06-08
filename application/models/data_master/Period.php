<?php

/**
 * Period Model
 *
 */
class Period extends Abstract_model {

    public $table           = "tblm_period";
    public $pkey            = "periodid_pk";
    public $alias           = "period";

    public $fields          = array(
                                'periodid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'PeriodID_PK'),
                                'code'                  => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'CODE'),
                                'year'                  => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'YEAR'),
                                'month'                => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'MONTH'),
                                'periodstatus'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'PERIODSTATUS'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => true, 'display' => 'DESCRIPTION'),


                                'creationdate'         => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "period.*, initcap(to_char(to_date(period.month, 'mm'), 'month')) as month_name,
                                        period.periodid_pk as periodid_pk_display, period.periodstatus as periodstatus_display";
    public $fromClause      = "tblm_period period";

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