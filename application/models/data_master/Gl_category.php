<?php

/**
 * Gl_category Model
 *
 */
class Gl_category extends Abstract_model {

    public $table           = "tblm_glcategory_32";
    public $pkey            = "glcategoryid_pk";
    public $alias           = "glcategory";

    public $fields          = array(
                                'glcategoryid_pk'         => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'GLCATEGORYID_PK'),
                                'businessunitid_pk'      => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'BUSINESSUNITID_pk'),
                                'categoryid_pk'            => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'CATEGORYID_pk'),

                                'accountcode'                 => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'ACCOUNTCODE'),
                                'accountname'                => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'ACCOUNTNAME'),
                                'isomnetworkrelated'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ISOMNETWORKRELATED'),
                                'description'                 => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'DESCRIPTION'),

                                'creationdate'         => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'             => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')

                            );

    public $selectClause    = "gl_category.*, businessunit.code as businessunitcode, category.code as categorycode";
    public $fromClause      = "tblm_glcategory_32 gl_category
                                        left join tblm_businessunit businessunit on gl_category.businessunitid_pk = businessunit.businessunitid_pk
                                        left join tblm_category_1 category on gl_category.categoryid_pk = category.categoryid_pk";

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

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:

            $this->db->set('updateddate',"sysdate",false);
            $this->record['updatedby'] = $userdata['user_name'];
        }
        return true;
    }

}

/* End of file Gl_category.php */