<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Processes</a>
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
                        <strong> <?php echo $this->input->post('processcode'); ?> </strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-cost-driver">
                        <i class="blue"></i>
                        <strong> Cost Driver PL </strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-ind-cost-seg">
                        <i class="blue"></i>
                        <strong> Indirect Cost Segregation </strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-other-seg">
                        <i class="blue"></i>
                        <strong> Other Segregation </strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-2">
                        <i class="blue"></i>
                        <strong> Process Summary </strong>
                    </a>
                </li>
                <li class="active">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-3">
                        <i class="blue"></i>
                        <strong> Process Log </strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-4">
                        <i class="blue"></i>
                        <strong> Detail Data </strong>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content no-border">
            <div class="space-4"></div>
            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-primary" type="button" id="btn-back" onclick="backToProcessControl()"><i class="fa fa-arrow-left"></i> Kembali Process Control</button>
                </div>
            </div>
            <h3> <?php echo $this->input->post('processcode').' ('.$this->input->post('periodid_fk').')'; ?></h3>
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
        var tab_1 = "<?php echo $this->input->post('tab_1'); ?>";
        loadContentWithParams( tab_1, {
            i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
            periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
            isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
            statuscode : '<?php echo $this->input->post('statuscode'); ?>',
            processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
            processcode : '<?php echo $this->input->post('processcode'); ?>',
            tab_1 : tab_1
        });

    });

    $("#tab-cost-driver").on("click", function(event) {
        event.stopPropagation();

        loadContentWithParams("transaksi.tblt_costdriverpl", {
            i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
            periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
            isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
            statuscode : '<?php echo $this->input->post('statuscode'); ?>',
            processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
            processcode : '<?php echo $this->input->post('processcode'); ?>',
            tab_1 : '<?php echo $this->input->post('tab_1'); ?>'
        });

    });

    $("#tab-ind-cost-seg").on("click", function(event) {
        event.stopPropagation();

        loadContentWithParams("transaksi.tblt_segregationact_tohideout", {
            i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
            periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
            isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
            statuscode : '<?php echo $this->input->post('statuscode'); ?>',
            processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
            processcode : '<?php echo $this->input->post('processcode'); ?>',
            tab_1 : '<?php echo $this->input->post('tab_1'); ?>'
        });

    });

    $("#tab-other-seg").on("click", function(event) {
        event.stopPropagation();

        loadContentWithParams("transaksi.tblt_segregationother_tohideout", {
            i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
            periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
            isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
            statuscode : '<?php echo $this->input->post('statuscode'); ?>',
            processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
            processcode : '<?php echo $this->input->post('processcode'); ?>',
            tab_1 : '<?php echo $this->input->post('tab_1'); ?>'
        });

    });


    $("#tab-2").on("click", function(event) {
        event.stopPropagation();

        loadContentWithParams("transaksi.tblt_processsummary_tohideout", {
            i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
            periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
            isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
            statuscode : '<?php echo $this->input->post('statuscode'); ?>',
            processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
            processcode : '<?php echo $this->input->post('processcode'); ?>',
            tab_1 : '<?php echo $this->input->post('tab_1'); ?>'
        });

    });

    $("#tab-4").on("click", function(event) {
        event.stopPropagation();

        loadContentWithParams("transaksi.tblt_thodetail", {
            i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
            periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
            isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
            statuscode : '<?php echo $this->input->post('statuscode'); ?>',
            processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
            processcode : '<?php echo $this->input->post('processcode'); ?>',
            tab_1 : '<?php echo $this->input->post('tab_1'); ?>'
        });
    });
</script>

<script>
    function backToProcessControl() {
        loadContentWithParams("parameter.tblp_processcontrol", {
            i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
            periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>
        });
    }
</script>

<script>

    function showData(){
        var i_search = $('#i_search').val();

        jQuery(function($) {

            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."parameter.tblp_logprocesscontrol_controller/read"; ?>',
                postData: {
                    i_search : $('#i_search').val(),
                    processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>
                }
            });
            $("#grid-table").trigger("reloadGrid");
        });
    }

</script>

<?php //$this->load->view('lov/lov_show_detil_batchcontrol'); ?>


<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."parameter.tblp_logprocesscontrol_controller/crud"; ?>',
            postData: { processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>},
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'processcontrolid_pk', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Counter No',name: 'counterno',width: 50, align: "left", hidden:true},
                {label: 'Log Date',name: 'logdate',width: 100, align: "left"},
                {label: 'Log Message',name: 'logmessage',width: 150, align: "left"},
                {label: 'Log Type',name: 'logtype',width: 150, align: "left"}
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
            editurl: '<?php echo WS_JQGRID."parameter.tblp_logprocesscontrol_controller/crud"; ?>',
            caption: "Log Process Control :: <?php echo $this->input->post('processcode'); ?>"

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