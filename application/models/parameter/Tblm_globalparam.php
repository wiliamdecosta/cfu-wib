<?php

/**
 * Tblm_globalparam Model
 *
 */
class Tblm_globalparam extends Abstract_model {

    public $table           = "tblm_globalparam";
    public $pkey            = "globalparamid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'globalparamid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'GLOBALPARAMID PK'),
                                'code'          => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Parameter Code'),
                                'value1'  => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Value 1'),
                                'value2'  => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Value 2'),
                                'isrange'  => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Is Range'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );


    public $selectClause    = "a.globalparamid_pk, a.code, a.value1, a.isrange,
                                    decode(a.isrange, 'Y', 'YES', 'NO') isrange_display,
                                    a.value2, a.description,                                    
                                    a.creationdate, a.createdby, a.updateddate, a.updatedby";

    public $fromClause      = "tblm_globalparam a";
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