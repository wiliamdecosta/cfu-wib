<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Parameters</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Mapping</a>
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

<?php $this->load->view('lov/lov_seg_activity'); ?>
<?php $this->load->view('lov/lov_tblm_wibunitbusiness'); ?>
<?php $this->load->view('lov/lov_bpc_cost_activity_new'); ?>

<script>
    function showLOVBusinessUnit(id, code, name) {
        modal_lov_tblm_wibunitbusiness_show(id, code, name);
    }

    function showLovSegActivity(id, code, name, plitem, costdriver){
         var ubiscode = $('#search_wibunitbusinesscode').val();

        if(ubiscode == "") {
            swal('Informasi','BU/Subs tidak boleh kosong','info');
            return false;
        }
        
        modal_lov_seg_activity_show(id, code, name, plitem, costdriver, ubiscode);
    }

    function showLOVCostActivity(id, code) {
        modal_lov_bpc_cost_activity_show(id, code);
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
            url: '<?php echo WS_JQGRID."parameter.tblm_groupcost_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."parameter.tblm_groupcost_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'groupcostid_pk', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'BU/Subsidiary',name: 'ubiscode',width: 150, align: "left",editable: true, hidden:true,
                    editoptions: {
                        size: 30,
                        maxlength:10
                    },
                    editrules: {required: true}
                },
                {label: 'Consol Activity',
                    name: 'code',
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
                                elm.append('<input id="form_id" type="text" style="display:none;">'+
                                         '<input id="form_code" type="text" size="30" style="background:#FFFFA2" readonly class="FormElement form-control" placeholder="Choose Activity Code">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVCostActivity(\'form_id\',\'form_code\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_code").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_code").val();
                            } else if( oper === 'set') {
                                $("#form_code").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        // var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'activityname');
                                        // $("#activityname").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'SEGREGATIONOTHERID_FK',name: 'segregationotherid_fk',width: 150, align: "left",editable: true, hidden:true,
                    editoptions: {
                        size: 30,
                        maxlength:10
                    },
                    editrules: {required: true}
                },
                {label: 'Activity Group',
                    name: 'activitygroupcode',
                    width: 200,
                    sortable: true,
                    editable: true,
                    editrules: {edithidden: true, required:true},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_activitygroup_code" type="text" size="40" style="background:#FFFFA2" readonly class="FormElement form-control" placeholder="Choose Activity Group">'+
                                        '<button class="btn btn-success" type="button" onclick="showLovSegActivity(\'segregationotherid_fk\',\'form_activitygroup_code\',\'actlistname\',\'plitemname\',\'costdrivercode\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_activitygroup_code").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_activitygroup_code").val();
                            } else if( oper === 'set') {
                                $("#form_activitygroup_code").val(gridval);
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
                {label: 'Activity',name: 'actlistname',width: 200, align: "left", editable: true,
                    editoptions: {
                        size: 55
                    },
                    editrules: {edithidden: false, required:true}},
                {label: 'PL Item',name: 'plitemname',width: 200, align: "left", editable: true,
                    editoptions: {
                        size: 30
                    },
                    editrules: {edithidden: false, required:true}},
                {label: 'Cost Driver',name: 'costdrivercode',width: 200, align: "left", editable: true,
                    editoptions: {
                        size: 70
                    },
                    editrules: {edithidden: false, required:true}},
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
                }
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
            editurl: '<?php echo WS_JQGRID."parameter.tblm_groupcost_controller/crud"; ?>',
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

                    $('#ubiscode').val( $('#search_wibunitbusinesscode').val() );

                    // setTimeout(function() {
                    //     clearInputPLItem();
                    // },100);

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

                    // clearInputPLItem();

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