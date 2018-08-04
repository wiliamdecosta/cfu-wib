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
            <a href="#">Adjustment</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Depreciation</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-xs-12">        
        <div class="space-4"></div>

        <div class="row">
        <label class="control-label col-md-2">Pencarian :</label>
        <div class="col-md-3">
            <div class="input-group">
                <input id="search_periodid_pk" type="text" class="FormElement form-control" placeholder="Period" onchange="showData();">
                <span class="input-group-btn">
                    <input id="search_statuscode" type="text"  style="display:none;">
                    <input id="search_status" style="display:none;" type="text" class="FormElement form-control" placeholder="Status">
                    <button class="btn btn-success" type="button" onclick="showLOVPeriod('search_periodid_pk','search_statuscode','search_status')">
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
        <div class="row" id="btn-group-ccadepreadjust-action" style="display:none;">
            <div class="col-xs-4"></div>
            <div class="col-xs-6">
                <button class="btn btn-success" id="btn-process" onclick="doProcess();">Get Data</button>
                <button class="btn btn-warning" id="btn-cancel" onclick="cancelProcess();">Clear Data</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('lov/lov_tblm_period'); ?>
<?php $this->load->view('lov/lov_tblm_segregationother'); ?>

<script>
/**
 * [showLOVPeriod called by input menu_icon to show List Of Value (LOV) of icon]
 * @param  {[type]} id   [description]
 * @param  {[type]} code [description]
 * @return {[type]}      [description]
 */
function showLOVPeriod(id, code, status) {
    modal_lov_tblt_cpallocadjust_show(id, code, status);
}

function showSegOther(groupcode, drivercode) {
    var grid = $('#grid-table');
    var rowId = grid.jqGrid ('getGridParam', 'selrow');
    var ubiscode = grid.jqGrid ('getCell', rowId, 'ubiscode');

    if(ubiscode == null) {
        swal('Informasi','Subs/Ubis tidak boleh kosong','info');
        return false;
    }

    modal_lov_tblm_segregationother_show(groupcode, drivercode, ubiscode);
}

</script>

<script>
    function showData(){
        var i_search = $('#i_search').val();
        var periodid_fk = $('#search_periodid_pk').val();
        var status = $('#search_status').val();
        var statuscode = $('#search_statuscode').val();


        jQuery(function($) {
            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."transaksi.tblt_ccadepreadjust_controller/read"; ?>',
                postData: {
                    i_search : i_search,
                    periodid_fk: periodid_fk
                }
            });
            $("#grid-table").trigger("reloadGrid");
        });

        buttonMode(status, statuscode);
    }
</script>



<script>
    function buttonMode(status, statuscode) {

        if(status == 'OPEN') {           
            $('#edit_grid-table').show();
            $('#btn-group-ccadepreadjust-action').show();

            if(statuscode > 0) {
                $('#btn-process').hide();
            }else {
                $('#btn-cancel').hide();
            }
        }else{
            $('#btn-group-ccadepreadjust-action').hide();
            $('#edit_grid-table').hide();
        }
    }

    function loadForm(i_search, periodid_fk, status, statuscode){
        $('#i_search').val(i_search);
        $('#search_periodid_pk').val(periodid_fk);
        $('#search_status').val(status);
        $('#search_statuscode').val(statuscode);

        jQuery(function($) {
            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."transaksi.tblt_ccadepreadjust_controller/read"; ?>',
                postData: {
                    i_search : i_search,
                    periodid_fk: periodid_fk
                }
            });
            $("#grid-table").trigger("reloadGrid");
        });

        buttonMode(status, statuscode);
    }
</script>

<script>

    function doProcess() {
            var periodid_fk = $('#search_periodid_pk').val();
            var status = $('#search_status').val();
            var statuscode = $('#search_statuscode').val();
            var i_search = $('#i_search').val();

            var ajaxOptions = {
                url: '<?php echo WS_JQGRID."transaksi.tblt_ccadepreadjust_controller/do_process"; ?>',
                type: "POST",
                dataType: "json",
                data: { periodid_fk:periodid_fk },
                success: function (data) {
                    if(data.success == true) {
                        swal('Success',data.message,'success');
                        loadForm(i_search, periodid_fk, status, data.records);
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
                        text: 'Anda yakin ingin melakukan Get Data?',
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
            var periodid_fk = $('#search_periodid_pk').val();
            var status = $('#search_status').val();
            var statuscode = $('#search_statuscode').val();
            var i_search = $('#i_search').val();


            var ajaxOptions = {
                url: '<?php echo WS_JQGRID."transaksi.tblt_ccadepreadjust_controller/cancel_process"; ?>',
                type: "POST",
                dataType: "json",
                data: { periodid_fk:periodid_fk },
                success: function (data) {
                    if(data.success == true) {
                        swal('Success',data.message,'success');
                        loadForm(i_search, periodid_fk, status, data.records);
                    }else {  
                        // console.log(data.records);                
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
                        text: 'Anda yakin ingin melakukan Clear Data?',
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


</script>

<script>
    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."transaksi.tblt_ccadepreadjust_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'Period', name: 'periodid_fk', width: 5, sorttype: 'number', hidden: true, editable: true,
                    editoptions: {
                        size: 15
                    },
                    editrules: {edithidden: true}},
                {label: 'Subs/Ubis',name: 'ubiscode',width: 100, align: "left", editable: true,
                    editoptions: {
                        size: 20
                    },
                    editrules: {edithidden: false}},
                {label: 'CCA Code',name: 'ccacode',width: 350, align: "left", editable: true,
                    editoptions: {
                        size: 40
                    },
                    editrules: {edithidden: false}},
                {label: 'Activity Group',
                    name: 'activitygroupcode',
                    width: 350,
                    sortable: true,
                    editable: true,
                    hidden: true,
                    editrules: {edithidden: true, required:true},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_activitygroup" readonly style="background:#FFFFA2" size="40" type="text" class="FormElement form-control" placeholder="Choose Activity Group">'+
                                        '<button class="btn btn-success" type="button" onclick="showSegOther(\'form_activitygroup\',\'costdrivercode\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_activitygroup").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_activitygroup").val();
                            } else if( oper === 'set') {
                                $("#form_activitygroup").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'costdrivercode');
                                        $("#costdrivercode").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Driver Code',name: 'costdrivercode',width: 250, align: "left", editable: true,
                    editoptions: {
                        size: 40
                    },
                    editrules: {edithidden: false}},         
                {label: 'CCA Amount',name: 'ccaamount',width: 150, align: "right", editable: false, formatter:function(cellvalue, options, rowObject) {
                    if(cellvalue != null){
                        return $.number(cellvalue, 2);
                    }else{
                        return '';
                    }
                }},
                {label: 'CCA Amount',name: 'ccaamount',width: 150, align: "right", hidden: true, editable: true, number:true,
                    editoptions: {
                        size: 30,
                        maxlength:255,
                        dataInit: function(element) {
                            $(element).keypress(function(e){
                                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                    return false;
                                 }
                            });
                            element.style.textAlign = 'right';
                            $(element).number( true, 2);
                        }
                    },
                    editrules: {required: false, edithidden:true}
                },
                {label: 'Orig Amount',name: 'origamount',width: 150, align: "right", editable: false, formatter:function(cellvalue, options, rowObject) {
                    if(cellvalue != null){
                        return $.number(cellvalue, 2);
                    }else{
                        return '';
                    }
                }},
                {label: 'Orig Amount',name: 'origamount',width: 150, align: "right", hidden: true, editable: true, number:true,
                    editoptions: {
                        size: 30,
                        maxlength:255,
                        dataInit: function(element) {
                            $(element).keypress(function(e){
                                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                    return false;
                                 }
                            });
                            element.style.textAlign = 'right';
                            $(element).number( true, 2);
                        }
                    },
                    editrules: {required: false, edithidden:true}
                },
                {label: 'Adjust Amount',name: 'adjustamount',width: 150, align: "right", editable: false, formatter:function(cellvalue, options, rowObject) {
                    if(cellvalue != null){
                        return $.number(cellvalue, 2);
                    }else{
                        return '';
                    }
                }},
                {label: 'Adjust Amount',name: 'adjustamount',width: 150, align: "right", hidden: true, editable: true, number:true,
                    editoptions: {
                        size: 30,
                        maxlength:255,
                        dataInit: function(element) {
                            $(element).keypress(function(e){
                                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                    return false;
                                 }
                            });
                            element.style.textAlign = 'right';
                            $(element).number( true, 2);
                        }
                    },
                    editrules: {required: true, edithidden:true}
                },
                {label: 'Description',name: 'description',width: 150, align: "left", editable: true,
                    edittype:'textarea',
                    editoptions: {
                        rows: 2,
                        cols:30,
                        maxlength:128
                    }
                }

            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 15,
            rowList: [15,50,100],
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
            editurl: '<?php echo WS_JQGRID."transaksi.tblt_ccadepreadjust_controller/crud"; ?>',
            caption: "Depreciation"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: true,
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

                    var status = $('#search_status').val();

                    // if(status == 'OPEN'){
                    //     swal('Attention', 'Maaf anda tidak bisa melakukan Edit data \n Status period sudah Close','warning');
                    //     return false;
                    // }

                    $('#periodid_fk').attr('readonly', true);
                    $('#ubiscode').attr('readonly', true);
                    $('#ccacode').attr('readonly', true);
                    $('#activitygroupcode').attr('readonly', true);
                    $('#costdrivercode').attr('readonly', true);
                    
                    $('#ccaamount').attr('readonly', true);
                    $('#origamount').attr('readonly', true);


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