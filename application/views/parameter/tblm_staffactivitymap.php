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
            <span>Staff Component</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
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
    <div class="col-md-12">
        <table id="grid-table"></table>
        <div id="grid-pager"></div>
    </div>
</div>

<?php $this->load->view('lov/lov_tblm_activity'); ?>
<?php $this->load->view('lov/lov_bpc_cost_payroll_div'); ?>
<?php $this->load->view('lov/lov_bpc_cost_payroll_loker'); ?>
<?php $this->load->view('lov/lov_bpc_cost_payroll_posisi'); ?>

<script>
/**
 * [showLOVBusinessUnit called by input menu_icon to show List Of Value (LOV) of icon]
 * @param  {[type]} id   [description]
 * @param  {[type]} code [description]
 * @return {[type]}      [description]
 */
function showLovActivity(id, code, name) {
    modal_lov_tblm_activity_show(id, code, name);
}

function showLovDivisi(id, code) {
    modal_lov_bpc_cost_payroll_div_show(id, code);
}

function showLovLoker(id, code) {
    var id_divisi = $('#form_id_divisi').val();

    if(id_divisi == "") {
        swal("Info", "Silahkan pilih Division ID terlebih dahulu", "info");
        return;
    }
    modal_lov_bpc_cost_payroll_loker_show(id, code, id_divisi);
}


function showLovPosisi(id, code) {
    var id_divisi = $('#form_id_divisi').val();
    var id_loker = $('#form_id_loker').val();

    if(id_divisi == ""
            || id_loker == "") {
        swal("Info", "Silahkan pilih Division ID & Organization ID terlebih dahulu", "info");
        return;
    }
    modal_lov_bpc_cost_payroll_posisi_show(id, code, id_divisi, id_loker);
}

/**
 * [clearInputBusinessUnit called by beforeShowForm method to clean input of statustypeid_fk]
 * @return {[type]} [description]
 */
function clearInputActivity() {
    $('#form_activityid_fk').val('');
    $('#form_activitycode').val('');
}

function clearInputDivisi() {
    $('#form_id_divisi').val('');
    $('#form_nama_divisi').val('');
}

function clearInputLoker() {
    $('#form_id_loker').val('');
    $('#form_nama_loker').val('');
}

function clearInputPosisi() {
    $('#form_id_posisi').val('');
    $('#form_nama_posisi').val('');
}

function onChangeDivisi() {
    clearInputLoker();
    clearInputPosisi();
}

function onChangeLoker() {
    clearInputPosisi();
}
</script>

<script>
    function showData(){
        var i_search = $('#i_search').val();

        jQuery(function($) {

            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."parameter.tblm_staffactivitymap_controller/read"; ?>',
                postData: {
                    i_search : $('#i_search').val()
                }
            });
            $("#grid-table").trigger("reloadGrid");
        });
    }
</script>

<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."parameter.tblm_staffactivitymap_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'staffactivitymapid_pk', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Division ID',
                    name: 'id_divisi',
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
                                elm.append('<input id="form_id_divisi" type="text"  style="background:#FBEC88" readonly class="FormElement form-control" placeholder="Choose Division" onchange="onChangeDivisi();">'+
                                        '<button class="btn btn-success" type="button" onclick="showLovDivisi(\'form_id_divisi\',\'form_nama_divisi\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_nama_divisi" readonly type="text" size="30" class="FormElement form-control" placeholder="Division Name">');
                                $("#form_id_divisi").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_id_divisi").val();
                            } else if( oper === 'set') {
                                $("#form_id_divisi").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'division_name');
                                        $("#form_nama_divisi").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Organization ID',
                    name: 'id_loker',
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
                                elm.append('<input id="form_id_loker" type="text"  readonly style="background:#FBEC88" class="FormElement form-control" onchange="onChangeLoker();" placeholder="Choose Organization">'+
                                        '<button class="btn btn-success" type="button" onclick="showLovLoker(\'form_id_loker\',\'form_nama_loker\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>&nbsp; ' +
                                        '<input id="form_nama_loker" readonly type="text" size="30" class="FormElement form-control" placeholder="Organization Name">');
                                $("#form_id_loker").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_id_loker").val();
                            } else if( oper === 'set') {
                                $("#form_id_loker").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'org_name');
                                        $("#form_nama_loker").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Job Position ID',
                    name: 'id_posisi',
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
                                elm.append('<input id="form_id_posisi" readonly type="text" class="FormElement form-control" placeholder="Choose Job Position">'+
                                        '<button class="btn btn-success" type="button" onclick="showLovPosisi(\'form_id_posisi\',\'form_nama_posisi\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_nama_posisi" readonly size="30" type="text" class="FormElement form-control" placeholder="Job Position Name">');
                                $("#form_id_posisi").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_id_posisi").val();
                            } else if( oper === 'set') {
                                $("#form_id_posisi").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'job_posisition');
                                        $("#form_nama_posisi").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Activity Code',
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
                                        '<input id="form_activitycode" readonly style="background:#FBEC88" type="text" class="FormElement form-control" placeholder="Choose Activity">'+
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
                {label: 'Division',name: 'divisi_gabung',width: 300, align: "left"},
                {label: 'Organization',name: 'organization_gabung',width: 300, align: "left"},
                {label: 'Job Position',name: 'jobposition_gabung',width: 300, align: "left"},
                {label: 'Activity',name: 'activity_gabung',width: 200, align: "left"},
                {label: 'Last Updated Date',name: 'lastupdateddate',width: 180, align: "left"},
                {label: 'Last Updated By',name: 'lastupdatedby',width: 150, align: "left"},

                {label: 'activitycode',name: 'activitycode',width: 120, align: "left", hidden: true},
                {label: 'activityname',name: 'activityname',width: 120, align: "left", hidden: true},

                {label: 'division_name',name: 'division_name',width: 120, align: "left", hidden: true},
                {label: 'org_name',name: 'org_name',width: 120, align: "left", hidden: true},
                {label: 'job_posisition',name: 'job_posisition',width: 120, align: "left", hidden: true},

            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 10,
            rowList: [10,20,50],
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
            editurl: '<?php echo WS_JQGRID."parameter.tblm_staffactivitymap_controller/crud"; ?>',
            caption: "Staff Component"

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

                    setTimeout(function() {
                        clearInputActivity();
                        clearInputDivisi();
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

                    clearInputActivity();
                    clearInputDivisi();

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