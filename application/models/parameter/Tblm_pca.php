<?php

/**
 * Tblm_pca Model
 *
 */
class Tblm_pca extends Abstract_model {

    public $table           = "tblm_pca";
    public $pkey            = "pcaid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'pcaid_pk'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'PCA ID PK'),
                                'wibunitbusinessid_pk'     => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Business Unit'),

                                'plitemcode'          => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item Code'),
                                'pcainsource'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PCA In Source'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),

                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );


    public $selectClause    = "a.pcaid_pk, a.wibunitbusinessid_pk, a.plitemcode, a.pcainsource,
                                    a.description, a.plitemcode plitemcodedisplay,
                                    a.pcainsource pcainsourcedisplay,
                                    a.creationdate, a.createdby, a.updateddate, a.updatedby,
                                        to_char(a.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, a.updatedby lastupdatedby,
                                    b.nama plitemname,
                                    c.code ubiscode, c.ubisname";

    public $fromClause      = "tblm_pca a
                                        inner join rra.bpc_neraca b on a.plitemcode = b.kode_neraca
                                        inner join tblm_wibunitbusiness c on a.wibunitbusinessid_pk = c.wibunitbusinessid_pk";
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