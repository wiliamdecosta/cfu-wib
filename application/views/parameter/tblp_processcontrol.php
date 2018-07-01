<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Process</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>CFU WIB</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-1">
                        <i class="blue"></i>
                        <strong> Batch Control </strong>
                    </a>
                </li>
                <li class="active">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-2">
                        <i class="blue"></i>
                        <strong> Process Control </strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-3">
                        <i class="blue"></i>
                        <strong> Process Log </strong>
                    </a>
                </li>

            </ul>
        </div>

        <div class="tab-content no-border">
            <div class="space-4"></div>
            <div class="row">
            <label class="control-label col-md-2">Pencarian :</label>
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group">
                    <input id="i_search" type="text" class="FormElement form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-success" type="button" id="btn-search" onclick="showData()">Cari</button>
                    </span>
                    </div>
                </div>
            </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                   <table id="grid-table"></table>
                   <div id="grid-pager"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $("#tab-1").on("click", function(event) {
        event.stopPropagation();
        loadContentWithParams("parameter.tblp_batchcontrol", {});
    });

    $("#tab-3").on("click", function(event) {

        event.stopPropagation();
        var grid = $('#grid-table');
        processcontrolid_pk = grid.jqGrid ('getGridParam', 'selrow');
        processcode = grid.jqGrid ('getCell', processcontrolid_pk, 'processcode');

        if(processcontrolid_pk == null) {
            swal('Informasi','Silahkan pilih salah satu baris process control','info');
            return false;
        }

        loadContentWithParams("parameter.tblp_logprocesscontrol", {
            processcontrolid_pk: processcontrolid_pk,
            processcode : processcode,
            i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
            periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>
        });
    });
</script>

<script>

    function showData(){
        var i_search = $('#i_search').val();

        jQuery(function($) {

            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."parameter.tblp_processcontrol_controller/read"; ?>',
                postData: {
                    i_search : $('#i_search').val(),
                    i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>
                }
            });
            $("#grid-table").trigger("reloadGrid");
        });
    }

</script>

<?php $this->load->view('lov/lov_show_detil_processcontrol'); ?>
<script>
    function showDetilProcessControl(id) {

        var rowData = jQuery("#grid-table").getRowData(id);
        modal_lov_show_detil_processcontrol_show(rowData);
    }

    function doProcess(id) {
        var rowData = jQuery("#grid-table").getRowData(id);
        str_processcode = rowData['processcode'].toUpperCase();

        var link_obj = {'TELIN_UPLOAD' : 'transaksi.tblt_telinstaff',
                            'STAFF_COMP_MAP' : 'transaksi.tblt_staffcompmap',
                            'COST_MAP' : 'transaksi.tblt_costmap',
                            'PCA' : 'transaksi.tblt_pca',
                            'VERTICAL_ALLOC' : 'transaksi.tblt_verticalalloc',
                            'COST_DRIVER_ENTRY' : 'transaksi.tblt_costdriverentry',
                            'SEGREGATION':'transaksi.tblt_segregationact'};

        /* var link_obj = {'STAFF_COMP_MAP' : 'transaksi.tblt_staffcompmap',
                            'COST_MAP' : 'transaksi.tblt_costmap',
                            'PCA' : 'transaksi.tblt_pca',
                            'VERTICAL_ALLOC' : 'transaksi.tblt_verticalalloc',
                            'COST_DRIVER_ENTRY' : 'transaksi.tblt_costdriverentry'}; */

        if(link_obj[str_processcode] === undefined) {
            return;
        }

        loadContentWithParams(link_obj[str_processcode], {
            processcontrolid_pk: rowData['processcontrolid_pk'],
            processcode : rowData['processcode'],
            isupdatable : rowData['isupdatable'],
            statuscode: rowData['statuscode'].toUpperCase(),
            tab_1 : link_obj[str_processcode],
            i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
            periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>
        });
    }
</script>

<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."parameter.tblp_processcontrol_controller/crud"; ?>',
            postData: { i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>},
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'processcontrolid_pk', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Detil',width: 80,align: "center",
                    formatter:function(cellvalue, options, rowObject) {
                        var key = rowObject['processcontrolid_pk'];
                        return '<button class="btn btn-primary btn-xs" onclick="showDetilProcessControl('+key+')">Detil</button>';
                    }
                },
                {label: 'Process Type',name: 'processtypecode',width: 150, align: "left", hidden: false},
                {label: 'Process Code',name: 'processcode',width: 150, align: "left", hidden: true},
                {label: 'Process Code(Link)',width: 180,align: "left",
                    formatter:function(cellvalue, options, rowObject) {
                        var processcode = rowObject['processcode'];
                        var isaccessible = rowObject['isaccessible'];
                        var key = rowObject['processcontrolid_pk'];

                        if(isaccessible == 'Y')
                            return '<button class="btn btn-link btn-xs" onclick="doProcess(\''+key+'\')">'+processcode+'</button>';
                        else
                            return processcode;
                            //return '<button class="btn btn-link btn-xs" onclick="doProcess(\''+key+'\')">'+processcode+'</button>';
                    }
                },
                {label: 'Process Status',name: 'statuscode',width: 150, align: "left"},
                {label: 'Verified?',name: 'isverified',width: 80, align: "left"},
                {label: 'Valid?',name: 'isvalid',width: 80, align: "left"},
                {label: 'IsAccessible',name: 'isaccessible',width: 80, align: "left", hidden:true},
                {label: 'IsUpdateable',name: 'isupdatable',width: 80, align: "left", hidden:true},

                {label: 'Verification Date',name: 'verificationdate',width: 150, align: "left"},
                {label: 'Verified By ',name: 'verifiedby',width: 150, align: "left"},

                {label: 'description',name: 'description',width: 150, align: "left", hidden: true},
                {label: 'creationdate',name: 'creationdate',width: 150, align: "left", hidden: true},
                {label: 'createdby',name: 'createdby',width: 150, align: "left", hidden: true},
                {label: 'processtypeid_fk,',name: 'processtypeid_fk,',width: 150, align: "left", hidden: true},
                {label: 'processid_fk,',name: 'processid_fk,',width: 150, align: "left", hidden: true},
                {label: 'statuslistid_fk,',name: 'statuslistid_fk,',width: 150, align: "left", hidden: true},
                {label: 'updateddate,',name: 'updateddate,',width: 150, align: "left", hidden: true},
                {label: 'updatedby,',name: 'updatedby,',width: 150, align: "left", hidden: true},
                {label: 'pbatchcontrolid_fk,',name: 'pbatchcontrolid_fk,',width: 150, align: "left", hidden: true},
                {label: 'startprocesstime,',name: 'startprocesstime,',width: 150, align: "left", hidden: true},
                {label: 'endprocesstime,',name: 'endprocesstime,',width: 150, align: "left", hidden: true},
                {label: 'procedurename,',name: 'procedurename,',width: 150, align: "left", hidden: true},
                {label: 'procedureparam,',name: 'procedureparam,',width: 150, align: "left", hidden: true},
            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 20,
            rowList: [20,50,100],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                /*do something when selected*/

            },
            sortorder:'',
            pager: '#grid-pager',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."parameter.tblp_processcontrol_controller/crud"; ?>',
            caption: "Process Control :: " + <?php echo $this->input->post('periodid_fk'); ?>

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: false,
                editicon: 'fa fa-pencil blue bigger-120',
                add: false,
                addicon: 'fa fa-plus-circle purple bigger-120',
                del: false,
                delicon: 'fa fa-trash-o red bigger-120',
                search: false,
                searchicon: 'fa fa-search orange bigger-120',
                refresh: true,
                afterRefresh: function () {
                    // some code here
                    jQuery("#detailsPlaceholder").hide();
                },

                refreshicon: 'fa fa-refresh green bigger-120',
                view: false,
                viewicon: 'fa fa-search-plus grey bigger-120'
            },

            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                closeOnEscape:true,
                recreateForm: true,
                serializeEditData: serializeJSON,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);

                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //new record form
                closeAfterAdd: false,
                clearAfterAdd : true,
                closeOnEscape:true,
                recreateForm: true,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                serializeEditData: serializeJSON,
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }

                    $(".tinfo").html('<div class="ui-state-success">' + response.message + '</div>');
                    var tinfoel = $(".tinfo").show();
                    tinfoel.delay(3000).fadeOut();


                    return [true,"",response.responseText];
                }
            },
            {
                //delete record form
                serializeDelData: serializeJSON,
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    style_delete_form(form);

                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                onClick: function (e) {
                    //alert(1);
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //search form
                closeAfterSearch: false,
                recreateForm: true,
                afterShowSearch: function (e) {
                    var form = $(e[0]);
                    style_search_form(form);
                    form.closest('.ui-jqdialog').center();
                },
                afterRedraw: function () {
                    style_search_filters($(this));
                }
            },
            {
                //view record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                }
            }
        );

    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

</script>