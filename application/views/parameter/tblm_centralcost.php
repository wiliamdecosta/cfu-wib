<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Parameter</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Mapping</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Cost Map</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
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
<div class="row"  id="table_placeholder" style="display:none;">
    <div class="col-md-12">
        <table id="grid-table"></table>
        <div id="grid-pager"></div>
    </div>
</div>

<?php $this->load->view('lov/lov_tblm_activity_extra'); ?>
<?php $this->load->view('lov/lov_exs_cc'); ?>
<?php $this->load->view('lov/lov_bpc_masakun'); ?>
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

function showLovActivity(id, code, name) {
    var ubiscode = $('#search_wibunitbusinesscode').val();
    modal_lov_tblm_activity_show(id, code, name, ubiscode);
}

function showLOVExsCC(id, name) {
    var ubiscode = $('#search_wibunitbusinesscode').val();
    modal_lov_exs_cc_show(id, name, ubiscode);
}

function showLOVBpcMasakun(id, code, name) {
    modal_lov_bpc_masakun_show(id, code, name);
}


function clearInputCostCenter() {
    $('#form_cc_code').val('');
    $('#form_cc_name').val('');
}

function clearInputActivity() {
    $('#form_activityid_fk').val('');
    $('#form_activitycode').val('');
    $('#form_activityname').val('');
}

function clearInputAkun() {
    $('#form_accountcode').val('');
    $('#form_accountname').val('');
    $('#form_plitem').val('');
}

</script>

<script>
    function showData(){
        var i_search = $('#i_search').val();
        var ubiscode = $('#search_wibunitbusinesscode').val();

        if(ubiscode == '') {
            $('#table_placeholder').hide();
            return;
        }

        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."parameter.tblm_centralcost_controller/read"; ?>',
            postData: {
                i_search : i_search,
                ubiscode : ubiscode
            }
        });
        $("#grid-table").trigger("reloadGrid");
        responsive_jqgrid('#grid-table', '#grid-pager');
        $('#table_placeholder').show();
    }
</script>

<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."parameter.tblm_centralcost_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'centralcostid_pk', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                /*{label: 'BU/Subsidiary',
                    name: 'ubiscode',
                    width: 200,
                    sortable: true,
                    editable: true,
                    hidden: true,
                    editrules: {edithidden: true, required:false},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_wibunitbusinessid_pk" type="text"  style="display:none;">'+
                                        '<input id="form_wibunitbusinesscode" readonly style="background:#FBEC88" type="text" class="FormElement form-control" placeholder="Choose Business Unit">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVBusinessUnit(\'form_wibunitbusinessid_pk\',\'form_wibunitbusinesscode\',\'form_wibunitbusinessname\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_wibunitbusinessname" readonly type="text" size="30" class="FormElement form-control" placeholder="Business Unit Name">');
                                $("#form_wibunitbusinesscode").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_wibunitbusinesscode").val();
                            } else if( oper === 'set') {
                                $("#form_wibunitbusinesscode").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'ubiscode');
                                        var name_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'ubisname');
                                        $("#form_wibunitbusinesscode").val( code_display );
                                        $("#form_wibunitbusinessname").val( name_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                */
                {label: 'Cost Center',name: 'ccgabung',width: 250, align: "left"},
                {label: 'Cost Center Code',
                    name: 'cccode',
                    width: 200,
                    sortable: true,
                    editable: true,
                    hidden: true,
                    editrules: {edithidden: true, required:false},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_cc_code" type="text"  style="background:#FBEC88" readonly class="FormElement form-control" placeholder="Choose Cost Center">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVExsCC(\'form_cc_code\',\'form_cc_name\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_cc_name" readonly type="text" size="30" class="FormElement form-control" placeholder="Cost Center Name">');
                                $("#form_cc_code").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_cc_code").val();
                            } else if( oper === 'set') {
                                $("#form_cc_code").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'ccname');
                                        $("#form_cc_name").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'GL Account',name: 'accountgabung',width: 250, align: "left"},
                {label: 'Account',
                    name: 'accountcode',
                    width: 200,
                    sortable: true,
                    editable: true,
                    hidden: true,
                    editrules: {edithidden: true, required:false},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_accountcode" type="text" style="background:#FBEC88" readonly class="FormElement form-control" placeholder="Choose Account">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVBpcMasakun(\'form_accountcode\',\'form_accountname\',\'form_plitem\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_accountname" readonly type="text" size="45" class="FormElement form-control" placeholder="Account Name"> &nbsp;'+
                                        '<input id="form_plitem" readonly type="text" size="15" class="FormElement form-control" placeholder="PL Item">');
                                $("#form_accountcode").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_accountcode").val();
                            } else if( oper === 'set') {
                                $("#form_accountcode").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'accountname');
                                        var name_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'plitem');
                                        $("#form_accountname").val( code_display );
                                        $("#form_plitem").val( name_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'PL Item',name: 'plitem',width: 150, align: "left"},
                {label: 'BU/Subsidiary',name: 'wibunitbusinessid_fk',width: 150, align: "left",editable: true, hidden:true,
                    editoptions: {
                        size: 30,
                        maxlength:10
                    },
                    editrules: {required: true}
                },
                {label: 'Indirect Cost?',name: 'isindirectcost',width: 120, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: false},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},

                {label: 'Activity',
                    name: 'activityid_fk',
                    width: 200,
                    sortable: true,
                    editable: true,
                    hidden: true,
                    editrules: {edithidden: true, required:false},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_activityid_fk" type="text"  style="display:none;">'+
                                        '<input id="form_activitycode" readonly type="text" class="FormElement form-control" placeholder="Choose Activity">'+
                                        '<button class="btn btn-success" type="button" onclick="showLovActivity(\'form_activityid_fk\',\'form_activitycode\',\'form_activityname\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_activityname" readonly type="text" size="30" class="FormElement form-control" placeholder="Activity Name">');
                                $("#form_activityid_fk").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_activityid_fk").val();
                            } else if( oper === 'set') {
                                $("#form_activityid_fk").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'activitycode');
                                        var name_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'activityname');
                                        $("#form_activitycode").val( code_display );
                                        $("#form_activityname").val( name_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Need PCA?',name: 'isneedpca',width: 120, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: false},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},

                {label: 'Description',name: 'description',width: 200, hidden:true, align: "left",editable: true,
                    edittype:'textarea',
                    editoptions: {
                        rows: 2,
                        cols:50,
                        maxlength:64
                    },
                    editrules: {required: false, edithidden: true}
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
                },
                {label: 'Indirect Cost?',name: 'isindirectcost_display',width: 120, align: "center"},
                {label: 'Activity',name: 'activity_display',width: 120, align: "left"},
                {label: 'Need PCA?',name: 'isneedpca_display',width: 120, align: "center"},
                {label: 'activityname',name: 'activityname',width: 120, align: "left", hidden:true},
                {label: 'activitycode',name: 'activitycode',width: 120, align: "left", hidden:true},
                {label: 'ccname',name: 'ccname',width: 120, align: "left", hidden:true},
                {label: 'accountname',name: 'accountname',width: 120, align: "left", hidden:true},

            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 10,
            rowList: [10,20,50],
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
            editurl: '<?php echo WS_JQGRID."parameter.tblm_centralcost_controller/crud"; ?>',
            caption: "Cost Map"

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
                serializeEditData: serializeJSON,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);

                    $('#creationdate').attr('readonly', true);
                    $('#createdby').attr('readonly', true);
                    $('#updateddate').attr('readonly', true);
                    $('#updatedby').attr('readonly', true);

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

                    $('#creationdate').attr('readonly', true);
                    $('#createdby').attr('readonly', true);
                    $('#updateddate').attr('readonly', true);
                    $('#updatedby').attr('readonly', true);

                    $('#wibunitbusinessid_fk').val( $('#search_wibunitbusinessid_pk').val() );

                    setTimeout(function() {
                        clearInputCostCenter();
                        clearInputActivity();
                        clearInputAkun();
                    },100);

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

                    clearInputCostCenter();
                    clearInputActivity();
                    clearInputAkun();

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