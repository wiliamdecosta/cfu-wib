<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tblt_thodetail_controller
* @version 2018-05-25 11:32:24
*/
class Tblt_thodetail_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','');
        $sord = getVarClean('sord','str','');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $periodid_fk = getVarClean('periodid_fk','int',0);
        $ubiscode = getVarClean('ubiscode','str','');
        $pl_item_name = getVarClean('pl_item_name','str','');
        $column_name = getVarClean('column_name','str','');
        $i_search = getVarClean('i_search','str','');
        

        if(empty($periodid_fk) && empty($ubiscode) && empty($pl_item_name) && empty($column_name)) {
            $data['success'] = true;
            return $data;
        }

        try {

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_thodetail');
            $table = new Tblt_thodetail($periodid_fk, $ubiscode, $pl_item_name, $column_name, $i_search);

            $req_param = array(
                "sort_by" => $sidx,
                "sord" => $sord,
                "limit" => null,
                "field" => null,
                "where" => null,
                "where_in" => null,
                "where_not_in" => null,
                "search" => $_REQUEST['_search'],
                "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
                "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
                "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
            );

            $req_param['where'] = array();
            // Filter Table
            // if(!empty($i_search)) {
            //     $table->setCriteria("upper(s01) = upper('".$i_search."') OR
            //                          upper(s02) = upper('".$i_search."') OR
            //                          upper(s03) = upper('".$i_search."') OR
            //                          upper(s04) = upper('".$i_search."') OR 
            //                          upper(s05) = upper('".$i_search."') 
            //                         ");
            // }

            $table->setJQGridParam($req_param);
            $count = $table->countAll();

            if ($count > 0) $total_pages = ceil($count / $limit);
            else $total_pages = 1;

            if ($page > $total_pages) $page = $total_pages;
            $start = $limit * $page - ($limit); // do not put $limit*($page - 1)

            // $req_param['limit'] = array(
            //     'start' => $start,
            //     'end' => $limit
            // );

            // $table->setJQGridParam($req_param);

            if ($page == 0) $data['page'] = 1;
            else $data['page'] = $page;

            $data['total'] = $total_pages;
            $data['records'] = $count;

            $data['rows'] = $table->getAll(0, -1);
            $data['success'] = true;
            logging('view data tblt_tohideout');
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }


    function crud() {

        $data = array();
        $oper = getVarClean('oper', 'str', '');
        switch ($oper) {
            case 'add' :
                //permission_check('can-add-data-master-wib');
                $data = $this->create();
            break;

            case 'edit' :
                //permission_check('can-edit-data-master-wib');
                $data = $this->update();
            break;

            case 'del' :
                //permission_check('can-delete-data-master-wib');
                $data = $this->destroy();
            break;

            default :
                //permission_check('can-view-data-master-wib');
                $data = $this->read();
            break;
        }

        return $data;
    }




    function download_excel() {

            $periodid_fk = getVarClean('periodid_fk','int',0);
            $ubiscode = getVarClean('ubiscode','str','');
            $pl_item_name = getVarClean('pl_item_name','str','');
            $column_name = getVarClean('column_name','str','');
            $i_search = getVarClean('i_search','str','');
            

            $ci = & get_instance();
            $ci->load->model('transaksi/tblt_thodetail');
            $table = new Tblt_thodetail($periodid_fk, $ubiscode, $pl_item_name, $column_name, $i_search);

            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            startExcel("thodetail_".$periodid_fk.".xls");

            $output = '';
            $output .='<table  border="1">';

            $output.='<tr>';                         
            $output.='  <th>No.</th>
                        <th>BU/Subs</th>
                        <th>Category</th>
                        <th>GL Account</th>
                        <th>GL Name</th>
                        <th>Amount</th>
                        <th>Description</th>
                        ';
            $output.='</tr>';

            if($count < 1)  {
                $output .= '</table>';
                echo $output;
                exit;
            }

            $total = 0;
            $no = 1;
            foreach($items as $item) {
                $output .= '<tr>';
                    $output .= '<td>'.$no.'</td>';
                    $output .= '<td>'.$item['ubiscode'].'</td>';
                    $output .= '<td>'.$item['categorycode'].'</td>';
                    $output .= '<td>'.$item['glaccount'].'</td>';
                    $output .= '<td>'.$item['gldesc'].'</td>';                    
                    $output .= '<td align="right">'.numberFormat($item['amount'],2).'</td>';
                    $output .= '<td>'.$item['description'].'</td>';
                $output .= '</tr>';

                $total = $total + $item['amount'];
                $no++;
            }

                $output .= '<tr>';
                    $output .= '<td></td>';
                    $output .= '<td></td>';
                    $output .= '<td></td>';
                    $output .= '<td></td>';
                    $output .= '<td><strong>Total</strong></td>';                    
                    $output .= '<td align="right"><strong>'.numberFormat($total,2).'</strong></td>';
                    $output .= '<td></td>';
                $output .= '</tr>';

            $output .= '</table>';
            echo $output;
            exit;

    }

}

/* End of file Tblt_tohideout_controller.php */