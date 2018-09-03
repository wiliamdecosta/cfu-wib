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
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-3">
                        <i class="blue"></i>
                        <strong> Process Log </strong>
                    </a>
                </li>
                <li class="active">
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

            <div class="row">
                <label class="control-label col-md-2">BU/Subs :</label>
                <div class="col-md-3">
                    <div class="input-group">
                        <input id="search_wibunitbusinessid_pk" type="text"  style="display:none;">
                        <input id="search_wibunitbusinessname" type="text" style="display:none;" class="FormElement form-control" placeholder="Business Unit Name">
                        <input id="search_wibunitbusinesscode" type="text" class="FormElement form-control required" placeholder="BU/Subs">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" onclick="showLOVBusinessUnit('search_wibunitbusinessid_pk','search_wibunitbusinesscode','search_wibunitbusinessname')">
                                <span class="fa fa-search bigger-110"></span>
                            </button>
                        </span>
                    </div>
                </div> 

                <label class="control-label col-md-1">PL Item :</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input id="search_plitem" type="text" class="FormElement form-control required" placeholder="PL Item">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" onclick="showLOVProfitLos('search_plitem')">
                                <span class="fa fa-search bigger-110"></span>
                            </button>
                        </span>
                    </div>
                </div> 
                          
            </div>
            <div class="row">
                <label class="control-label col-md-2">Business Line :</label>
                <div class="col-md-3">
                    <div class="input-group">
                        <select class="FormElement form-control required" id="search_business_line">                        
                            <option value="Domestic_Traffic"> Domestic_Traffic </option>
                            <option value="Domestic_Network"> Domestic_Network </option>
                            <option value="International_Traffic"> International_Traffic </option>
                            <option value="International_Network"> International_Network </option>
                            <option value="International_Adjacent"> International_Adjacent </option>
                            <option value="Towers"> Towers </option>
                            <option value="Infrastructure"> Infrastructure </option>
                        </select>
                    </div>
                </div>

                <label class="control-label col-md-1">Filter :</label>
                <div class="col-md-4">
                    <input id="i_search" type="text" class="FormElement form-control">
                </div>
            </div>
            <div class="space-4"></div>
            <div class="row" id="btn-group-tohideout-action">
                <!-- <div class="col-xs-4"></div> -->
                <div class="col-xs-6">
                    <button class="btn btn-success" type="button" id="btn-search" onclick="showData()">Cari</button>
                    <button class="btn btn-primary" type="button" id="btn-download" onclick="downloadExcel();">Download</button>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="row">
                <div class="col-xs-12">
                    <table id="grid-table"></table>
                    <div id="grid-pager"></div>
                </div>
            </div>
       
        </div>
    </div>
</div>

<?php $this->load->view('lov/lov_tblm_wibunitbusiness'); ?>
<?php $this->load->view('lov/lov_tblm_profitloss_new'); ?>

<script>
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


$("#tab-3").on("click", function(event) {
    event.stopPropagation();

    loadContentWithParams("transaksi.tblp_logprocesscontrol_tohideout", {
        i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
        periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
        isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
        statuscode : '<?php echo $this->input->post('statuscode'); ?>',
        processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
        processcode : '<?php echo $this->input->post('processcode'); ?>',
        tab_1 : '<?php echo $this->input->post('tab_1'); ?>'
    });
});

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

</script>

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

function showLOVProfitLos(code) {
    modal_lov_tblm_profitloss_show(code);
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
        var pl_item_name = $('#search_plitem').val();
        var column_name = $('#search_business_line').val();

        if (ubiscode == '' ){
            swal('Informasi','BU/Subs is required','info');
            return false;
        }

        if (pl_item_name == ''){
            swal('Informasi','PL Item is required','info');
            return false;
        }

        if (column_name == ''){
            swal('Informasi','Business Line is required','info');
            return false;
        }

        jQuery(function($) {
            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."transaksi.tblt_thodetail_controller/read"; ?>',
                postData: {
                    i_search : i_search,
                    periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
                    ubiscode: ubiscode,
                    pl_item_name: pl_item_name,
                    column_name: column_name,
                }
            });
            $("#grid-table").trigger("reloadGrid");
        });
    }
</script>
<script>
    function downloadExcel(){
        var i_search = $('#i_search').val();
        var ubiscode = $('#search_wibunitbusinesscode').val();
        var pl_item_name = $('#search_plitem').val();
        var column_name = $('#search_business_line').val();

        if (ubiscode == '' ){
            swal('Informasi','BU/Subs is required','info');
            return false;
        }

        if (pl_item_name == ''){
            swal('Informasi','PL Item is required','info');
            return false;
        }

        if (column_name == ''){
            swal('Informasi','Business Line is required','info');
            return false;
        }

        var periodid_fk = <?php echo $this->input->post('periodid_fk'); ?>;

        var url = "<?php echo WS_JQGRID . "transaksi.tblt_thodetail_controller/download_excel/?"; ?>";
        url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
        url += "&periodid_fk="+periodid_fk;
        url += "&ubiscode="+ubiscode;
        url += "&pl_item_name="+pl_item_name;
        url += "&column_name="+column_name;

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
            url: '<?php echo WS_JQGRID."transaksi.tblt_thodetail_controller/crud"; ?>',
            postData: { periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>},
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'BU/Subs',name: 'ubiscode',width: 100, align: "left"},
                {label: 'Category',name: 'categorycode',width: 200, align: "left"},
                {label: 'GL Account',name: 'glaccount',width: 200, align: "left"},
                {label: 'GL Name',name: 'gldesc',width: 350, align: "left"},
                {label: 'Amount',name: 'amount',width: 150, align: "right", editable: false, formatter:'currency', formatoptions: {prefix:"", thousandsSeparator:','}},
                {label: 'Description',name: 'description',width: 200, align: "left"},

            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 10000000000000,
            rowList: [],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            footerrow: true,
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

                var rowData = jQuery("#grid-table").getDataIDs();
                totalamount = 0;

                for (var i = 0; i < rowData.length; i++) 
                {
                    var amount = jQuery("#grid-table").jqGrid('getCell', rowData[i], 'amount');

                    totalamount = totalamount + parseFloat(amount);
                }

                $("#grid-table").jqGrid('footerData', 'set', { "gldesc":"Total :"}, true);
                $("#grid-table").jqGrid('footerData', 'set', { "amount": totalamount}, true);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."transaksi.tblt_thodetail_controller/crud"; ?>',
            caption: "<?php echo $this->input->post('processcode'); ?>"

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

        // jQuery(".ui-th-column-header ui-th-ltr").addClass("active");

    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

</script>