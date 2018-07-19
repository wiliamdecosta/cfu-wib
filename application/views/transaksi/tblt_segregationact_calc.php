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
                <li class="active">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true">
                        <i class="blue"></i>
                        <strong> Segregation_Calc </strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-othersegregation">
                        <i class="blue"></i>
                        <strong> Other Segregation</strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-2">
                        <i class="blue"></i>
                        <strong> Process Summary </strong>
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
                <div class="col-md-3">
                    <button class="btn btn-primary" type="button" id="btn-back" onclick="backToProcessControl()"><i class="fa fa-arrow-left"></i> Kembali Process Control</button>
                </div>
            </div>

            <h3> <?php echo 'Segregation_Calc'.' ('.$this->input->post('periodid_fk').')'; ?></h3>

            <div class="row">
            <label class="control-label col-md-2">Pencarian :</label>
            <div class="col-md-3">
                <div class="input-group">
                    <input id="search_wibunitbusinessid_pk" type="text"  style="display:none;">
                    <input id="search_wibunitbusinessname" type="text" style="display:none;" class="FormElement form-control" placeholder="Business Unit Name">
                    <input id="search_wibunitbusinesscode" type="text" class="FormElement form-control" placeholder="Business Unit" onchange="showData();">
                    <span class="input-group-btn">
                        <button class="btn btn-success" type="button" onclick="showLOVBusinessUnit('search_wibunitbusinessid_pk','search_wibunitbusinesscode','search_wibunitbusinessname')">
                            <span class="fa fa-search bigger-110"></span>
                        </button>
                    </span>
                </div>
            </div>
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
            <div class="space-4"></div>
            <div class="row" id="btn-group-segregation-action" style="display:none;">
                <div class="col-xs-4"></div>
                <div class="col-xs-6">
                    <button class="btn btn-success" id="btn-process" onclick="doProcess();">Process</button>
                    <button class="btn btn-warning" id="btn-cancel" onclick="cancelProcess();">Cancel Process</button>
                    <button class="btn btn-primary" id="btn-download" onclick="downloadSegregation();">Download</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$("#tab-othersegregation").on("click", function(event) {
    event.stopPropagation();

    loadContentWithParams("transaksi.tblt_segregationother_calc", {
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

    loadContentWithParams("transaksi.tblt_processsummary_segregation_calc", {
        i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
        periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
        isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
        statuscode : '<?php echo $this->input->post('statuscode'); ?>',
        processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
        processcode : '<?php echo $this->input->post('processcode'); ?>',
        tab_1 : '<?php echo $this->input->post('tab_1'); ?>'
    });

});


$("#tab-3").on("click", function(event) {
    event.stopPropagation();

    loadContentWithParams("transaksi.tblp_logprocesscontrol_segregation_calc", {
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

    function buttonMode(statuscode) {
        var isupdatable = "<?php echo $this->input->post('isupdatable'); ?>";

        if(isupdatable == 'Y') {
            $('#btn-group-segregation-action').show();

            if(statuscode == 'FINISH' || statuscode == 'IN PROGRESS') {
                $('#btn-process').hide();
            }else if(statuscode == 'INITIAL') {
                $('#btn-cancel').hide();
                $('#btn-download').hide();
            }
        }
    }

    function loadForm(statuscode) {
        loadContentWithParams("transaksi.tblt_segregationact_calc", {
            i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
            periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
            isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
            statuscode : statuscode,
            processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
            processcode : '<?php echo $this->input->post('processcode'); ?>',
            tab_1 : '<?php echo $this->input->post('tab_1'); ?>'
        });
    }

    $(function() {
        var statuscode = "<?php echo $this->input->post('statuscode'); ?>";
        buttonMode(statuscode);
    });
</script>

<?php $this->load->view('lov/lov_tblm_wibunitbusiness'); ?>

<script>
/**
 * [showLOVBusinessUnit called by input menu_icon to show List Of Value (LOV) of icon]
 * @param  {[type]} id   [description]
 * @param  {[type]} code [description]
 * @return {[type]}      [description]
 */
function showLOVBusinessUnit(id, code, name) {
    modal_lov_tblm_wibunitbusiness_show(id, code, name);
}
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
        var ubiscode = $('#search_wibunitbusinesscode').val();


        jQuery(function($) {
            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."transaksi.tblt_segregationact_controller/read"; ?>',
                postData: {
                    i_search : i_search,
                    processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
                    ubiscode: ubiscode
                }
            });
            $("#grid-table").trigger("reloadGrid");
        });
    }
</script>

<script>

    function doProcess() {
            var processcode = "<?php echo $this->input->post('processcode'); ?>";
            var i_process_control_id = <?php echo $this->input->post('processcontrolid_pk'); ?>;
            var i_batch_control_id =  <?php echo $this->input->post('i_batch_control_id'); ?>;

            var ajaxOptions = {
                url: '<?php echo WS_JQGRID."transaksi.tblt_segregationact_controller/do_process_calc"; ?>',
                type: "POST",
                dataType: "json",
                data: { i_process_control_id:i_process_control_id,
                        processcode : processcode,
                        i_batch_control_id : i_batch_control_id },
                success: function (data) {
                    if(data.success == true) {
                        swal('Success',data.message,'success');
                        loadForm(data.statuscode);
                    }else {
                        swal('Attention',data.message,'warning');
                    }
                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            };

            $.ajax({
                beforeSend: function( xhr ) {
                    swal({
                        title: "Konfirmasi",
                        text: 'Anda yakin ingin men-submit proses '+ processcode +'?',
                        type: "info",
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        confirmButtonText: "Ya, Yakin",
                        confirmButtonColor: "#e80c1c",
                        cancelButtonText: "Tidak",
                        closeOnConfirm: false,
                        closeOnCancel: true,
                        html: true
                    },
                    function(isConfirm){
                        if(isConfirm) {
                            $.ajax(ajaxOptions);
                            return true;
                        }else {
                            return false;
                        }
                    });
                }
            });
    }

    function cancelProcess() {
            var processcode = "<?php echo $this->input->post('processcode'); ?>";
            var i_process_control_id = <?php echo $this->input->post('processcontrolid_pk'); ?>;
            var i_batch_control_id =  <?php echo $this->input->post('i_batch_control_id'); ?>;

            var ajaxOptions = {
                url: '<?php echo WS_JQGRID."transaksi.tblt_segregationact_controller/cancel_process_calc"; ?>',
                type: "POST",
                dataType: "json",
                data: { i_process_control_id: i_process_control_id,
                             i_batch_control_id: i_batch_control_id},
                success: function (data) {
                    if(data.success == true) {
                        swal('Success',data.message,'success');
                        loadForm(data.statuscode);
                    }else {
                        swal('Attention',data.message,'warning');
                    }
                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            };

            $.ajax({
                beforeSend: function( xhr ) {
                    swal({
                        title: "Konfirmasi",
                        text: 'Anda yakin ingin membatalkan proses?',
                        type: "info",
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        confirmButtonText: "Ya, Yakin",
                        confirmButtonColor: "#e80c1c",
                        cancelButtonText: "Tidak",
                        closeOnConfirm: false,
                        closeOnCancel: true,
                        html: true
                    },
                    function(isConfirm){
                        if(isConfirm) {
                            $.ajax(ajaxOptions);
                            return true;
                        }else {
                            return false;
                        }
                    });
                }
            });
    }

    function downloadSegregation() {

            var processcontrolid_pk = <?php echo $this->input->post('processcontrolid_pk'); ?>;
            var periodid_fk = <?php echo $this->input->post('periodid_fk'); ?>;
            var ubiscode = $('#search_wibunitbusinesscode').val();

            var url = "<?php echo WS_JQGRID . "transaksi.tblt_segregationact_controller/download_excel_calc/?"; ?>";
            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&processcontrolid_pk="+processcontrolid_pk;
            url += "&periodid_fk="+periodid_fk;
            url += "&ubiscode="+ubiscode;

            swal({
                title: "Konfirmasi",
                text: 'Anda yakin ingin melakukan download data?',
                type: "info",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: "Ya, Yakin",
                confirmButtonColor: "#538cf6",
                cancelButtonText: "Tidak",
                closeOnConfirm: true,
                closeOnCancel: true,
                html: true
            },
            function(isConfirm){
                if(isConfirm) {
                    window.location = url;
                    return true;
                }else {
                    return false;
                }
            });
    }

</script>


<script>
    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."transaksi.tblt_segregationact_controller/crud"; ?>',
            postData: { processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>},
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'Activity',name: 'activitygabung',width: 250, align: "left"},
                {label: 'PL Item',name: 'plitemname',width: 250, align: "left"},
                {label: 'Amount',name: 'amount',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Cost Driver',name: 'costdrivercode',width: 250, align: "left"},
                /**Cost Driver */
                {label: 'Dom Traffic',name: 'cd_domtraffic',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Dom Network',name: 'cd_domnetwork',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Intl Traffic',name: 'cd_intltraffic',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Intl Network',name: 'cd_intlnetwork',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Intl Adjacent',name: 'cd_intladjacent',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Tower',name: 'cd_tower',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Infrastructure',name: 'cd_infra',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},

                /**Cost Driver Proportion*/
                {label: 'Dom Traffic',name: 'pct_domtraffic',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Dom Network',name: 'pct_domnetwork',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Intl Traffic',name: 'pct_intltraffic',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Intl Network',name: 'pct_intlnetwork',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Intl Adjacent',name: 'pct_intladjacent',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Tower',name: 'pct_tower',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Infrastructure',name: 'pct_infra',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},


                /**After Segregation*/
                {label: 'Dom Traffic',name: 'domtrafficamt',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Dom Network',name: 'domnetworkamt',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Intl Traffic',name: 'intltrafficamt',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Intl Network',name: 'intlnetworkamt',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Intl Adjacent',name: 'intladjacentamt',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Tower',name: 'toweramt',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'Infrastructure',name: 'infraamt',width: 150, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }}

            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 20,
            rowList: [20,50,100],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
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
            editurl: '<?php echo WS_JQGRID."transaksi.tblt_segregationact_controller/crud"; ?>',
            caption: "Segregation_Calc"

        });

        jQuery("#grid-table").jqGrid('setGroupHeaders', {
            useColSpanStyle: true,
            groupHeaders:[
                {startColumnName: 'cd_domtraffic', align:'center', numberOfColumns: 7, titleText: 'Cost Driver'},
                {startColumnName: 'pct_domtraffic', align:'center', numberOfColumns: 7, titleText: 'Cost Driver Proportion'},
                {startColumnName: 'domtrafficamt', align:'center', numberOfColumns: 7, titleText: 'After Segregation'}
            ]
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