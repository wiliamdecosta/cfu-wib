<?php

/**
 * Tblm_profitloss Model
 *
 */
class Tblm_profitloss extends Abstract_model {

    public $table           = "tblm_profitloss";
    public $pkey            = "profitlossid_pk";
    public $alias           = "";

    public $fields          = array(
                                'profitlossid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'PROFITLOSSID PK'),
                                'plgroupname'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PL Group Name'),
                                'plitemname'         => array('nullable' =>  false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item Name'),
                                'plitemcode'         => array('nullable' =>  true, 'type' => 'str', 'unique' => false, 'display' => 'PL Item Code'),
                                'levelno'         => array('nullable' =>  false, 'type' => 'int', 'unique' => false, 'display' => 'Level No'),
                                'listingno'         => array('nullable' =>  false, 'type' => 'str', 'unique' => false, 'display' => 'Listing No'),
                                'isdetail'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Detail?'),
                                'isprocessed'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Processed?'),
                                'sumto'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Sum To'),
                                'plusminus'         => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Plus/Minus'),
                                'istohideoutshow'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'To Hide Out?'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
                            );

    public $selectClause    = "profitlossid_pk, plitemname, plgroupname, plitemcode, plitemgroupcode, levelno, listingno, isdetail, isprocessed, sumto, procedurename, plusminus, istohideoutshow, description, creationdate, createdby, updateddate, updatedby,
        decode(isdetail, 'Y', 'YES', 'NO') isdetail_display, decode(isprocessed, 'Y', 'YES', 'NO') isprocessed_display";
    public $fromClause      = "tblm_profitloss";

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

            if(empty($this->record['listingno'])) {
                $this->db->set('listingno',"null",false);
                unset($this->record['listingno']);
            }

          
            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
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

/* End of file Tblm_profitloss.php */