<?php

/**
 * Tblm_segregationact Model
 *
 */
class Tblm_segregationact extends Abstract_model {

    public $table           = "tblm_segregationact";
    public $pkey            = "segregationactid_pk";
    public $alias           = "x";

    public $fields          = array(
                                'segregationactid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'SEGREGATIONACTID_PK'),
                                'ubiscode'          => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Ubis/Subsidiary'),                                
                                'activitycode'     => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Activity Code'),
                                'plitemcode'   => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item Code'),
                                'costdrivercode'   => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Cost Driver'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );


    public $selectClause    = " x.segregationactid_pk,
                                x.ubiscode,        
                                x.activitycode,
                                x.plitemcode,
                                x.plitemname,
                                x.costdrivercode,
                                x.description,
                                x.creationdate,
                                x.createdby,
                                x.updateddate,
                                x.updatedby ";

    public $fromClause      = "(select a.segregationactid_pk,
                                    a.ubiscode,
                                    a.activitycode,
                                    a.plitemcode,
                                    nr.nama plitemname,
                                    a.costdrivercode,
                                    a.description,
                                    a.creationdate,
                                    a.createdby,
                                    a.updateddate,
                                    a.updatedby
                                from tblm_segregationact a,
                                    rra.bpc_neraca nr
                                where a.plitemcode = nr.kode_neraca and
                                    nr.kode_fs = 'CCA'        
                                order by a.activitycode
                                ) x";
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