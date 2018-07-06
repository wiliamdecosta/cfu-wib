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
                                'wibunitbusinessid_fk'     => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Business Unit'),

                                'plitemcode'          => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PL Item Code'),
                                'pcainsource'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'PCA In Source'),
                                'description'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),

                                'listingno'         => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'LISTINGNO'),

                                'creationdate'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );


    public $selectClause    = "a.pcaid_pk, a.wibunitbusinessid_fk, a.plitemcode, a.pcainsource,
                                    a.description, a.plitemcode plitemcodedisplay,
                                    a.pcainsource pcainsourcedisplay,
                                    a.creationdate, a.createdby, a.updateddate, a.updatedby, a.listingno,
                                        to_char(a.updateddate, 'DD-MON-YYYY HH24:MI') lastupdateddate, a.updatedby lastupdatedby,
                                    b.nama plitemname,
                                    c.code ubiscode, c.ubisname";

    public $fromClause      = "tblm_pca a
                                        inner join rra.bpc_neraca b on a.plitemcode = b.kode_neraca
                                        inner join tblm_wibunitbusiness c on a.wibunitbusinessid_fk = c.wibunitbusinessid_pk";
    public $refs            = array();

    public $multiUnique  = array('wibunitbusinessid_fk',
                                        'plitemcode');


    function __construct() {
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            if($this->isMultipleUnique()) {
                throw new Exception('Duplicate unique key');
            }

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

            if($this->isMultipleUnique()) {
                throw new Exception('Duplicate unique key');
            }

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

/* End of file Activity.php */