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
            <span>PCA Activity Map</span>
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

<?php $this->load->view('lov/lov_tblm_wibunitbusiness'); ?>
<?php $this->load->view('lov/lov_tblm_activity'); ?>
<?php $this->load->view('lov/lov_bpc_neraca'); ?>
<?php $this->load->view('lov/lov_tblm_glplitem'); ?>

<script>
    function showLOVPLItem(id, code) {
        modal_lov_bpc_neraca_show(id, code);
    }

    function clearInputPLItem() {
        $('#form_plitemcode').val('');
        $('#form_plitemname').val('');
    }

    function showLOVBusinessUnit(id, code, name) {
        modal_lov_tblm_wibunitbusiness_show(id, code, name);
    }

    function clearInputBusinessUnit() {
        $('#form_wibunitbusinessid_pk').val('');
        $('#form_wibunitbusinesscode').val('');
        $('#form_wibunitbusinessname').val('');
    }

    function showLovActivity(id, code, name) {
        modal_lov_tblm_activity_show(id, code, name);
    }

    function clearInputActivity() {
        $('#form_activityid_fk').val('');
        $('#form_activitycode').val('');
        $('#form_activityname').val('');
    }

    function showLOVGLAccount(code, desc) {
        modal_lov_tblm_glplitem_show(code, desc);
    }

    function clearGLAccount() {
        $('#form_glplitemcode').val('');
        $('#form_glplitemname').val('');
    }
</script>

<script>
    function showData(){
        var i_search = $('#i_search').val();

        jQuery(function($) {

            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."parameter.tblm_pcaactivityplmap_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."parameter.tblm_pcaactivityplmap_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'activityplmapid_pk', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Ubis/Subsidiary', name: 'ubiscode_display', width: 120, editable: false, hidden: false},
                {label: 'Ubis/Subsidiary',
                    name: 'ubiscode',
                    width: 150,
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
                                        '<input id="form_wibunitbusinesscode" readonly style="background:#FFFFA2" type="text" class="FormElement form-control" placeholder="Choose Business Unit">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVBusinessUnit(\'form_wibunitbusinessid_pk\',\'form_wibunitbusinesscode\',\'form_wibunitbusinessname\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_wibunitbusinessname" readonly type="text" size="30" class="FormElement form-control" placeholder="Business Unit Name" style="display:none;>');
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
                                        // var name_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'ubisname');
                                        $("#form_wibunitbusinesscode").val( code_display );
                                        // $("#form_wibunitbusinessname").val( '' );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Activity Name', name: 'activityname', width: 350, editable: false, hidden: true},
                {label: 'Activity', name: 'activity_display', width: 350, editable: false, hidden: false},
                {label: 'Activity',
                    name: 'activitycode',
                    width: 100,
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
                                elm.append('<input id="form_activityid_fk" type="text"  style="display:none;">'+
                                        '<input id="form_activitycode" readonly style="background:#FFFFA2" type="text" class="FormElement form-control" placeholder="Choose Activity">'+
                                        '<button class="btn btn-success" type="button" onclick="showLovActivity(\'form_activityid_fk\',\'form_activitycode\',\'form_activityname\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_activityname" readonly type="text" size="30" class="FormElement form-control" placeholder="Activity Name">');
                                $("#form_activitycode").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_activitycode").val();
                            } else if( oper === 'set') {
                                $("#form_activitycode").val(gridval);
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
                {label: 'PL Item Name', name: 'plitemname', width: 300, editable: false, hidden: true},
                {label: 'PL Item', name: 'plitem_display', width: 300, editable: false, hidden: false},
                {label: 'PL Item',
                    name: 'plitemcode',
                    width: 200,
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
                {label: 'Indirect Cost?', name: 'isiccriteria_display', width: 100, editable: false, hidden: false},
                {label: 'Indirect Cost?',name: 'isiccriteria',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: true},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},
                {label: 'Network Related OM?', name: 'isnetworkcriteria_display', width: 120, editable: false, hidden: false},
                {label: 'Network Related OM?',name: 'isnetworkcriteria',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: true},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},
                {label: 'GL Account Name', name: 'gldesc', width: 100, editable: false, hidden: true},
                {label: 'GL Account',
                    name: 'glaccount',
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
                                elm.append('<input id="form_glplitemcode" type="text" readonly class="FormElement form-control" placeholder="Choose GL Account">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVGLAccount(\'form_glplitemcode\',\'form_glplitemname\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_glplitemname" readonly type="text" size="30" class="FormElement form-control" placeholder="GL Account Name">');
                                $("#form_glplitemcode").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_glplitemcode").val();
                            } else if( oper === 'set') {
                                $("#form_glplitemcode").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'gldesc');
                                        $("#form_glplitemname").val( code_display );
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
            editurl: '<?php echo WS_JQGRID."parameter.tblm_pcaactivityplmap_controller/crud"; ?>',
            caption: "PCA Activity Map"

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
                        clearInputPLItem();
                        clearInputBusinessUnit();
                        clearInputActivity();
                        clearGLAccount();
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
                    clearInputBusinessUnit();
                    clearInputActivity();
                    clearGLAccount();
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