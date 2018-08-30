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
            <span>Group Cost</span>
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
        <div class="row" id="btn-group-cpallpcadjust-action" style="display:none;">
            <div class="col-xs-4"></div>
            <div class="col-xs-6">
                <button class="btn btn-success" id="btn-process" onclick="doProcess();">Get Data</button>
                <button class="btn btn-warning" id="btn-cancel" onclick="cancelProcess();">Clear Data</button>
                <button class="btn btn-primary" id="btn-download" onclick="downloadExcel();">Download</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('lov/lov_tblm_period'); ?>
<?php $this->load->view('lov/lov_tblm_wibunitbusiness'); ?>
<?php $this->load->view('lov/lov_bpc_cost_activity'); ?>
<?php $this->load->view('lov/lov_tblm_segregationother_new'); ?>

<script>
/**
 * [showLOVPeriod called by input menu_icon to show List Of Value (LOV) of icon]
 * @param  {[type]} id   [description]
 * @param  {[type]} code [description]
 * @return {[type]}      [description]
 */
function showSegOther(groupcode, drivercode) {
    var ubiscode = $('#form_busscode').val();

    if(ubiscode == "") {
        swal('Informasi','BU/Subs tidak boleh kosong','info');
        return false;
    }

    modal_lov_tblm_segregationother_show(groupcode, drivercode, ubiscode);
}

function showLOVCostActivity(id, code) {
    modal_lov_bpc_cost_activity_show(id, code);
}

function showLOVBusinessUnit(id, code, name) {
    modal_lov_tblm_wibunitbusiness_show(id, code, name);
}

function showLOVPeriod(id, code, status) {
    modal_lov_tblt_cpallocadjust_show(id, code, status);
}
</script>
<script>
    function cekStatus(status, periodid_fk){
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: '<?php echo WS_JQGRID."transaksi.tblt_groupcostadjust_controller/cekstatus"; ?>',
            data: {periodid_fk : periodid_fk},
            success: function(response) {
                buttonMode(status, response.total);
            }
        });
    }
</script>

<script>
    function showData(){
        var i_search = $('#i_search').val();
        var periodid_fk = $('#search_periodid_pk').val();
        var status = $('#search_status').val();
        var statuscode = $('#search_statuscode').val();
        cekStatus(status, periodid_fk);

        jQuery(function($) {
            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."transaksi.tblt_groupcostadjust_controller/read"; ?>',
                postData: {
                    i_search : i_search,
                    periodid_fk: periodid_fk
                }
            });
            $("#grid-table").trigger("reloadGrid");
        });

        
        
    }
</script>



<script>
    function buttonMode(status, statuscode) {

        if(status == 'OPEN') {        
            $('#edit_grid-table').show();
            $('#add_grid-table').show();
            $('#del_grid-table').show();
            $('#btn-group-cpallpcadjust-action').show();
            
            if(statuscode > 0) {
                $('#btn-cancel').show();
                $('#btn-process').hide();
                $('#btn-download').show();
            }else {
                $('#btn-process').show();
                $('#btn-cancel').hide();
                $('#btn-download').hide();
            }
        }else{
            $('#btn-group-cpallpcadjust-action').hide();
            $('#edit_grid-table').hide();
            $('#add_grid-table').hide();
            $('#del_grid-table').hide();
        }
    }

    function loadForm(i_search, periodid_fk, status, statuscode){
        // $('#i_search').val(i_search);
        // $('#search_periodid_pk').val(periodid_fk);
        // $('#search_status').val(status);
        // $('#search_statuscode').val(statuscode);        

        jQuery(function($) {
            // jQuery("#grid-table").jqGrid('setGridParam',{
            //     url: '<?php echo WS_JQGRID."transaksi.tblt_groupcostadjust_controller/read"; ?>',
            //     postData: {
            //         i_search : i_search,
            //         periodid_fk: periodid_fk
            //     }
            // });
            $("#grid-table").trigger("reloadGrid");
        });

        cekStatus(status, periodid_fk);
        // buttonMode(status, statuscode);
    }
</script>

<script>

    function doProcess() {
            var periodid_fk = $('#search_periodid_pk').val();
            var status = $('#search_status').val();
            var statuscode = $('#search_statuscode').val();
            var i_search = $('#i_search').val();

            var ajaxOptions = {
                url: '<?php echo WS_JQGRID."transaksi.tblt_groupcostadjust_controller/do_process"; ?>',
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
                url: '<?php echo WS_JQGRID."transaksi.tblt_groupcostadjust_controller/cancel_process"; ?>',
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
            url: '<?php echo WS_JQGRID."transaksi.tblt_groupcostadjust_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'Period', name: 'periodid_fk', width: 5, sorttype: 'number', hidden: true, editable: true,
                    editoptions: {
                        size: 15
                    },
                    editrules: {edithidden: false, required:true}},
                {label: 'CFU Code',name: 'cfucode', width: 100, sortable: true, editable: true,
                    editrules: {required: true},
                    edittype: 'select',
                    editoptions: {
                        style: "width: 150px", 
                        dataUrl: '<?php echo WS_JQGRID."transaksi.tblt_groupcostadjust_controller/combo_wibgroup"; ?>'
                    }
                },
                {label: 'BU/Subs',
                    name: 'ubiscode',
                    width: 200,
                    sortable: true,
                    editable: true,
                    editrules: {required:true},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_bussid" type="text" style="display:none;" readonly class="FormElement form-control">'+
                                    '<input id="form_busscode" type="text" style="background:#FFFFA2" readonly class="FormElement form-control" placeholder="Choose BU/Subs">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVBusinessUnit(\'form_bussid\',\'form_busscode\',\'form_bussname\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_bussname" style="display:none;" readonly type="text" size="30" class="FormElement form-control">');
                                $("#form_busscode").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_busscode").val();
                            } else if( oper === 'set') {
                                $("#form_busscode").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        // var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'plitemname');
                                        // $("#form_plitemname").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Activity Code',
                    name: 'activitycode',
                    width: 200,
                    sortable: true,
                    editable: true,
                    editrules: {required:true},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_idactivity" type="text"  style="background:#FFFFA2" readonly class="FormElement form-control" placeholder="Choose Activity Code">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVCostActivity(\'form_idactivity\',\'activityname\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_idactivity").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_idactivity").val();
                            } else if( oper === 'set') {
                                $("#form_idactivity").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'activityname');
                                        $("#activityname").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Activity Name',name: 'activityname',width: 200, align: "left", editable: true,
                    editoptions: {
                        size: 30
                    },
                    editrules: {edithidden: false, required:true}},
                {label: 'Activity Group',
                    name: 'activitygroupcode',
                    width: 350,
                    sortable: true,
                    editable: true,
                    editrules: {edithidden: false, required:false},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_activitygroup" readonly size="40" type="text" class="FormElement form-control" placeholder="Choose Activity Group">'+
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
                {label: 'Cost Driver',name: 'costdrivercode',width: 250, align: "left", editable: true,
                    editoptions: {
                        size: 40
                    },
                    editrules: {edithidden: false, required:false}},       
                {label: 'Orig Amount',name: 'origamount',width: 150, align: "right", editable: false, formatter:'currency', formatoptions: {prefix:"", thousandsSeparator:','}},
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
                    editrules: {required: true, edithidden:true}
                },
                {label: 'Adjust Amount',name: 'adjustamount',width: 150, align: "right", editable: false, formatter:'currency', formatoptions: {prefix:"", thousandsSeparator:','}},
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
                {label: 'Description',name: 'description',width: 150, align: "left", hidden: true, editable: true,
                    edittype:'textarea',
                    editoptions: {
                        rows: 2,
                        cols:30,
                        maxlength:128
                    },
                    editrules: {edithidden: true}
                },
                {label: 'Creation Date',name: 'creationdate',width: 150, hidden: true,  align: "left",editable: true,
                    editoptions: {
                        size: 15,
                        maxlength:10,
                        defaultValue: 'By System'
                    },
                    editrules: {edithidden: true}
                },
                {label: 'Created By',name: 'createdby',width: 150, hidden: true,  align: "left",editable: true,
                    editoptions: {
                        size: 15,
                        maxlength:10,
                        defaultValue: 'By System'
                    },
                    editrules: {edithidden: true}
                },
                {label: 'Updated Date',name: 'updateddate',width: 150, hidden: true,  align: "left",editable: true,
                    editoptions: {
                        size: 15,
                        maxlength:10,
                        defaultValue: 'By System'
                    },
                    editrules: {edithidden: true}
                },
                {label: 'Updated By',name: 'updatedby',width: 150, hidden: true,  align: "left",editable: true,
                    editoptions: {
                        size: 15,
                        maxlength:10,
                        defaultValue: 'By System'
                    },
                    editrules: {edithidden: true}
                }

            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 10000000000,
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
                // $(this).jqGrid('setGridParam', 'rowNum', response.total);
                var rowData = jQuery("#grid-table").getDataIDs();
                // alert(rowData.length);
                totorigamount = 0;
                totadjustamount = 0;
                for (var i = 0; i < rowData.length; i++) 
                {
                    var origamount = jQuery("#grid-table").jqGrid('getCell', rowData[i], 'origamount');
                    var adjustamount = jQuery("#grid-table").jqGrid('getCell', rowData[i], 'adjustamount');

                    totorigamount = totorigamount + parseFloat(origamount);
                    totadjustamount = totadjustamount + parseFloat(adjustamount);

                    // alert(totorigamount);
                }

                $("#grid-table").jqGrid('footerData', 'set', { "costdrivercode":"Total:"}, true);
                $("#grid-table").jqGrid('footerData', 'set', { "origamount": totorigamount}, true);
                $("#grid-table").jqGrid('footerData', 'set', { "adjustamount": totadjustamount}, true);



            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."transaksi.tblt_groupcostadjust_controller/crud"; ?>',
            caption: "Group Cost"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: true,
                editicon: 'fa fa-pencil blue bigger-120',
                add: true,
                addicon: 'fa fa-plus-circle purple bigger-120',
                del: true,
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
                serializeEditData: serializeJSONGroupAdj,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);

                    var status = $('#search_status').val();

                    $('#activityname').attr('readonly', true);
                    $('#costdrivercode').attr('readonly', true);
                    $('#creationdate').attr('readonly', true);
                    $('#createdby').attr('readonly', true);
                    $('#updateddate').attr('readonly', true);
                    $('#updatedby').attr('readonly', true);


                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').css('max-height','500px');
                    form.closest('.ui-jqdialog').css('overflow','scroll');

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
                closeAfterAdd: true,
                clearAfterAdd : true,
                closeOnEscape:true,
                recreateForm: true,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                serializeEditData: serializeJSONGroupAdj,
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);
                    var period = $('#search_periodid_pk').val();

                    $('#periodid_fk').val(period);
                    
                    $('#activityname').attr('readonly', true);
                    $('#costdrivercode').attr('readonly', true);
                    $('#creationdate').attr('readonly', true);
                    $('#createdby').attr('readonly', true);
                    $('#updateddate').attr('readonly', true);
                    $('#updatedby').attr('readonly', true);

                    setTimeout(function() {
                        $('#activityname').val('');
                        $('#costdrivercode').val('');
                    },100);
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').css('max-height','500px');
                    form.closest('.ui-jqdialog').css('overflow','scroll');

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
                serializeDelData: serializeJSONGroupAdj,
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

    function serializeJSONGroupAdj(postdata) {
        var items;
        if(postdata.oper != 'del') {
            items = JSON.stringify(postdata, function(key,value){
                if (typeof value === 'function') {
                    return value();
                } else {
                  return value;
                }
            });
        }else {
            var rowData = jQuery("#grid-table").getRowData(postdata.id);
            items = JSON.stringify(rowData);
        }

        var jsondata = {items:items, oper:postdata.oper, '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};
        return jsondata;
    }

    if($('#search_periodid_pk').val() == ""){
        buttonMode('CLOSE', 0);
    }

    function downloadExcel() {

            var periodid_fk = $('#search_periodid_pk').val();

            var url = "<?php echo WS_JQGRID . "transaksi.tblt_groupcostadjust_controller/download_excel/?"; ?>";
            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&periodid_fk="+periodid_fk;

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