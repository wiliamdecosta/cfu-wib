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
            <span>Cost Primary</span>
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

<?php $this->load->view('lov/lov_bpc_cost_activity'); ?>
<?php $this->load->view('lov/lov_bpc_neraca'); ?>
<?php $this->load->view('lov/lov_tblm_wibunitbusiness'); ?>

<script>
    function showLOVBusinessUnit(id, code, name) {
        modal_lov_tblm_wibunitbusiness_show(id, code, name);
    }

    function showLOVPLItem(id, code) {
        modal_lov_bpc_neraca_show(id, code);
    }

    function showLOVCostActivity(id, code) {
        modal_lov_bpc_cost_activity_show(id, code);
    }

    function clearInputPLItem() {
        $('#form_plitemcode').val('');
        $('#form_plitemname').val('');
    }

    function clearInputCostActivity() {
        $('#form_idactivityext').val('');
        $('#form_activityname').val('');
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
            url: '<?php echo WS_JQGRID."parameter.tblm_cpallocationmap_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."parameter.tblm_cpallocationmap_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'cpallocationmapid_pk', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'BU/Subsidiary',name: 'wibunitbusinessid_fk',width: 150, align: "left",editable: true, hidden:true,
                    editoptions: {
                        size: 30,
                        maxlength:10
                    },
                    editrules: {required: true}
                },
                {label: 'Activity ID',name: 'idactivityextdisplay',width: 100, align: "left"},
                {label: 'ID Activity',
                    name: 'idactivityext',
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
                                elm.append('<input id="form_idactivityext" type="text"  style="background:#FFFFA2" readonly class="FormElement form-control" placeholder="Choose Activity">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVCostActivity(\'form_idactivityext\',\'form_activityname\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_activityname" readonly type="text" size="30" class="FormElement form-control" placeholder="Activity Name">');
                                $("#form_idactivityext").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_idactivityext").val();
                            } else if( oper === 'set') {
                                $("#form_idactivityext").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'activityname');
                                        $("#form_activityname").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Activity Name',name: 'activityname',width: 100, align: "left"},

                {label: 'PL Item Code',name: 'plitemcodedisplay',width: 80, align: "left"},
                {label: 'PL Item Code',
                    name: 'plitemcode',
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
                                elm.append('<input id="form_plitemcode" type="text"  style="background:#FFFFA2" readonly class="FormElement form-control" placeholder="Choose PL Item">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVPLItem(\'form_plitemcode\',\'form_plitemname\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_plitemname" readonly type="text" size="30" class="FormElement form-control" placeholder="PL Item Name">');
                                $("#form_plitemcode").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_plitemcode").val();
                            } else if( oper === 'set') {
                                $("#form_plitemcode").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'plitemname');
                                        $("#form_plitemname").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'PL Item Name',name: 'plitemname',width: 120, align: "left"},

                {label: 'Allocation(%)',name: 'pctallocationdisplay',width: 80, align: "right", formatter:function(cellvalue, options, rowObject) {
                    return $.number(cellvalue, 2);
                }},
                {label: 'PCT Allocation (%)',name: 'pctallocation',width: 150, hidden:true, align: "right",editable: true,
                    editoptions: {
                        size: 10,
                        maxlength:3,
                        dataInit: function(element) {
                            $(element).keypress(function(e){
                                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                    return false;
                                 }
                            });
                            element.style.textAlign = 'right';
                            $(element).number( true, 0 );
                        }
                    },
                    editrules: {required: true, edithidden: true},
                    formoptions: {
                        elmsuffix:'<i data-placement="left" class="orange"> (0 - 100) </i>'
                    }
                },
                // {label: 'Description',name: 'description',width: 200, hidden:true, align: "left",editable: true,
                //     edittype:'textarea',
                //     editoptions: {
                //         rows: 2,
                //         cols:50,
                //         maxlength:64
                //     },
                //     editrules: {required: false, edithidden: true}
                // },
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
                {label: 'Last Updated Date',name: 'lastupdateddate',width: 120, align: "center"},
                {label: 'Last Updated By',name: 'lastupdatedby',width: 120, align: "center"}
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
            editurl: '<?php echo WS_JQGRID."parameter.tblm_cpallocationmap_controller/crud"; ?>',
            caption: "Cost Primary"

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

                    $('#pctallocation').val(100);
                    $('#wibunitbusinessid_fk').val( $('#search_wibunitbusinessid_pk').val() );

                    setTimeout(function() {
                        clearInputPLItem();
                        clearInputCostActivity();
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

                    clearInputPLItem();
                    clearInputCostActivity();

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