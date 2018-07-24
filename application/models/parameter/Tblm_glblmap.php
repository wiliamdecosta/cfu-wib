<?php

/**
 * Tblm_glblmap Model
 *
 */
class Tblm_glblmap extends Abstract_model {

    public $table           = "tblm_glblmap";
    public $pkey            = "glblmapid_pk";
    public $alias           = "a";

    public $fields          = array(
                                'glblmapid_pk'     => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'GLBLMAPID PK'),
                                'glaccount'        => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'GL Account'),
                                'gldesc'           => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'GL Desc'),
                                'acclevel'         => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Account Level'),
                                'gldesctelin'      => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'GL Desc Telin'),
                                'dwscategoryid_fk'         => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'DWS Category'),
                                'mitratelcategoryid_fk'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Mitratel Category'),
                                'infratelcategoryid_fk'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Infratel Category'),
                                'telincategoryid_fk'       => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Telin Category'),
                                'telinsgcategoryid_fk'     => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Telin SG Category'),
                                'isnetrelatedom'           => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Net Related OM'),
                                'description'      => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
                                'plitemtype'      => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'PL Item Type'),
                                'creationdate'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Creation Date'),
                                'createdby'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updateddate'      => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated Date'),
                                'updatedby'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
                            );


    public $selectClause    = "  a.glblmapid_pk,
                                 a.glaccount,
                                 a.gldesc,
                                 a.acclevel,
                                 a.gldesctelin,
                                 a.dwscategoryid_fk,
                                 a.mitratelcategoryid_fk,
                                 a.infratelcategoryid_fk,
                                 a.telincategoryid_fk,
                                 a.telinsgcategoryid_fk,
                                 a.isnetrelatedom,
                                 a.description,
                                 a.creationdate,
                                 a.createdby,
                                 a.updateddate,
                                 a.updatedby,
                                 a.plitemtype,
                                 DECODE(a.isnetrelatedom, 'Y', 'YES', 'N', 'NO', '') isnetrelatedom_display,
                                 b.code dwscategory_display,
                                 c.code mitratelcategory_display,
                                 d.code infratelcategory_display,
                                 e.code telincategory_display,
                                 f.code telinsgcategory_display";

    public $fromClause      = "tblm_glblmap a
                              left join tblm_category b ON a.dwscategoryid_fk = b.categoryid_pk
                              left join tblm_category c ON a.mitratelcategoryid_fk = c.categoryid_pk
                              left join tblm_category d ON a.infratelcategoryid_fk = d.categoryid_pk
                              left join tblm_category e ON a.telincategoryid_fk = e.categoryid_pk
                              left join tblm_category f ON a.telinsgcategoryid_fk = f.categoryid_pk";
                              
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