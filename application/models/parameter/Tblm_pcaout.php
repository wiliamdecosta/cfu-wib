<?php

/**
 * Tblm_pcaout Model
 *
 */
class Tblm_pcaout extends Abstract_model {

    public $table           = "tblm_pcaout";
    public $pkey            = "pcaoutid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'pcaoutid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'PCAOUTID PK'),
                                'ubiscode'          => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Ubis/Subsidiary'),
                                'activitycode'             => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Activity'),
                                'plitemcode'             => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item'),
                                'casetype'     => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Data Source'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
                                'glaccount'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Gl Account'),
                                'correctactivity'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Correct Activity'),
                                'correctplitem'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Correct PL Item'),
                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );


    public $selectClause    = "a.pcaoutid_pk, a.ubiscode, a.activitycode, a.plitemcode,
                                    a.casetype, a.description, a.glaccount, a.correctactivity, a.correctplitem,                                  
                                    a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                     b.wibunitbusinessid_pk, b.ubisname, c.activityid_pk, c.activityname, d.nama plitemname,
                                    decode(a.casetype, 1, 'Cost Map', 'Financial GL') casetype_display, e.gldesc,
                                    f.activityid_pk corractivityid_pk, f.activityname corractivityname, g.nama corrplitemname,
                                    a.ubiscode ubiscode_display, a.activitycode||'-'||c.activityname activity_display,
                                    a.plitemcode||'-'||d.nama plitem_display,
                                    a.correctactivity||'-'||f.activityname corractivity_display,
                                    a.correctplitem||'-'||g.nama correctplitem_display";

    public $fromClause      = "tblm_pcaout a
                               inner join tblm_wibunitbusiness b on a.ubiscode = b.code
                                inner join tblm_activity c on a.activitycode = c.code
                                inner join rra.bpc_neraca d on a.plitemcode = d.kode_neraca and d.kode_fs = 'CCA'
                                left join tblm_glplitem e on a.glaccount = e.glaccount
                                left join tblm_activity f on a.correctactivity = f.code
                                left join rra.bpc_neraca g on a.correctplitem = g.kode_neraca and g.kode_fs = 'CCA'";
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

 

    function html_select_options_casetype() {
        try {

             $sql = "SELECT
                        1 casetype,
                        'Cost Map' casename
                        FROM dual
                        UNION ALL
                        SELECT
                        2 casetype,
                        'Financial GL' casename
                        FROM dual
                         ";
            $query = $this->db->query($sql);

            $items = $query->result_array();

            echo '<select>';
            foreach($items  as $item ){
                echo '<option value="'.$item['casetype'].'">'.$item['casename'].'</option>';
            }
            echo '</select>';
            exit;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

}

/* End of file Activity.php */