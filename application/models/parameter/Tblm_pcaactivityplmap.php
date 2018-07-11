<?php

/**
 * Tblm_pcaactivityplmap Model
 *
 */
class Tblm_pcaactivityplmap extends Abstract_model {

    public $table           = "tblm_pcaactivityplmap";
    public $pkey            = "activityplmapid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'activityplmapid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ACTIVITYPLMAPID PK'),
                                'ubiscode'          => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Ubis/Subsidiary'),
                                'activitycode'             => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Activity'),
                                'plitemcode'             => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item'),
                                'isnetworkcriteria'     => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Network Related OM?'),
                                'isiccriteria'     => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Indirect Cost?'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
                                'glaccount'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Gl Account'),
                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );


    public $selectClause    = "a.activityplmapid_pk, a.ubiscode, a.activitycode, a.plitemcode,
                                    a.isnetworkcriteria, a.description, a.glaccount, a.isiccriteria, 
                                    a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                     b.wibunitbusinessid_pk, b.ubisname, c.activityid_pk, c.activityname, d.nama plitemname,
                                    decode(a.isnetworkcriteria, 'Y', 'YES', 'NO') isnetworkcriteria_display, 
                                    decode(a.isiccriteria, 'Y', 'YES', 'NO') isiccriteria_display, e.gldesc,                                   
                                    a.ubiscode ubiscode_display, a.activitycode||'-'||c.activityname activity_display,
                                    a.plitemcode||'-'||d.nama plitem_display";

    public $fromClause      = "tblm_pcaactivityplmap a
                               inner join tblm_wibunitbusiness b on a.ubiscode = b.code
                                inner join tblm_activity c on a.activitycode = c.code
                                inner join rra.bpc_neraca d on a.plitemcode = d.kode_neraca and d.kode_fs = 'CCA'
                                left join tblm_glplitem e on a.glaccount = e.glaccount";
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

/* End of file Tblm_pcaactivityplmap.php */