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
            <span>GL BL Map</span>
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

<?php $this->load->view('lov/lov_tblm_category'); ?>
<?php $this->load->view('lov/lov_tblm_plitemtype'); ?>
<?php $this->load->view('lov/lov_tblm_glplitem_new'); ?>

<script>
    function showLOVPLItem(glacc, gldesc) {
        modal_lov_tblm_glplitem_show(glacc, gldesc);
    }

    function clearInputPLItem() {
        $('#form_glacc').val('');
        $('#gldesc').val('');
    }

    function showLOVPLItemType(code) {
        modal_lov_tblm_plitemtype_show(code);
    }

    function clearInputPLItemType() {
        $('#form_plitemtype').val('');
    }

    function showLOVCategroy(id, code) {
        modal_lov_tblm_category_show(id, code);
    }

    function clearInputDWSCategroy() {
        $('#form_dwscategoryid_fk').val('');
        $('#form_dwscategory_code').val('');
    }

    function clearInputMitratelCategroy() {
        $('#form_mitratelcategoryid_fk').val('');
        $('#form_mitratelcategory_code').val('');
    }

    function clearInputInfratelCategroy() {
        $('#form_infratelcategoryid_fk').val('');
        $('#form_infratelcategory_code').val('');
    }

    function clearInputTelinCategroy() {
        $('#form_telincategoryid_fk').val('');
        $('#form_telincategory_code').val('');
    }

    function clearInputTelinSGCategroy() {
        $('#form_telinsgcategoryid_fk').val('');
        $('#form_telinsgcategory_code').val('');
    }

  
</script>

<script>
    function showData(){
        var i_search = $('#i_search').val();

        jQuery(function($) {

            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."parameter.tblm_glblmap_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."parameter.tblm_glblmap_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'glblmapid_pk', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'GL Account',name: 'glaccount',width: 150, align: "left",editable: false },                
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
                                elm.append('<input id="form_glacc" readonly type="text" style="background:#FFFFA2;" size="30" class="FormElement form-control" placeholder="Choose GL Account">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVPLItem(\'form_glacc\',\'gldesc\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>'
                                        );
                                $("#form_glacc").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_glacc").val();
                            } else if( oper === 'set') {
                                $("#form_glacc").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'gldesc');
                                        $("#form_gldesc").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'GL Desc',name: 'gldesc',width: 250, align: "left",editable: true,
                    editoptions: {
                        size: 60,
                        maxlength:96
                    },
                    editrules: {required: false}
                },
                {label: 'GL Desc Telin',name: 'gldesctelin',width: 300, align: "left",editable: true,
                    editoptions: {
                        size: 60,
                        maxlength:96
                    },
                    editrules: {required: false}
                },          
                {label: 'PL Item Type',
                    name: 'plitemtype',
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
                                elm.append('<input id="form_plitemtype" size="35" readonly type="text" class="FormElement form-control" placeholder="Choose PL Item Type">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVPLItemType(\'form_plitemtype\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_plitemtype").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_plitemtype").val();
                            } else if( oper === 'set') {
                                $("#form_plitemtype").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        // var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'form_plitemtype');
                                        // $("#form_plitemtype").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },      
                {label: 'DWS Categroy', name: 'dwscategory_display',width: 250, align: "left"},
                {label: 'DWS Categroy',
                    name: 'dwscategoryid_fk',
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
                                elm.append('<input id="form_dwscategoryid_fk" type="text"  style="display:none">'+
                                        '<input id="form_dwscategory_code" size="35" readonly type="text" class="FormElement form-control" placeholder="Choose DWS Categroy">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVCategroy(\'form_dwscategoryid_fk\',\'form_dwscategory_code\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_dwscategoryid_fk").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_dwscategoryid_fk").val();
                            } else if( oper === 'set') {
                                $("#form_dwscategoryid_fk").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'dwscategory_display');
                                        $("#form_dwscategory_code").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Mitratel Categroy', name: 'mitratelcategory_display',width: 250, align: "left"},
                {label: 'Mitratel Categroy',
                    name: 'mitratelcategoryid_fk',
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
                                elm.append('<input id="form_mitratelcategoryid_fk" type="text"  style="display:none">'+
                                        '<input id="form_mitratelcategory_code" size="35" readonly type="text" class="FormElement form-control" placeholder="Choose Mitratel Categroy">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVCategroy(\'form_mitratelcategoryid_fk\',\'form_mitratelcategory_code\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_mitratelcategoryid_fk").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_mitratelcategoryid_fk").val();
                            } else if( oper === 'set') {
                                $("#form_mitratelcategoryid_fk").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'mitratelcategory_display');
                                        $("#form_mitratelcategory_code").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Infratel Categroy', name: 'infratelcategory_display',width: 250, align: "left"},
                {label: 'Infratel Categroy',
                    name: 'infratelcategoryid_fk',
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
                                elm.append('<input id="form_infratelcategoryid_fk" type="text"  style="display:none">'+
                                        '<input id="form_infratelcategory_code" size="35" readonly type="text" class="FormElement form-control" placeholder="Choose Infratel Categroy">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVCategroy(\'form_infratelcategoryid_fk\',\'form_infratelcategory_code\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_infratelcategoryid_fk").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_infratelcategoryid_fk").val();
                            } else if( oper === 'set') {
                                $("#form_infratelcategoryid_fk").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'infratelcategory_display');
                                        $("#form_infratelcategory_code").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Telin Categroy', name: 'telincategory_display',width: 250, align: "left"},
                {label: 'Telin Categroy',
                    name: 'telincategoryid_fk',
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
                                elm.append('<input id="form_telincategoryid_fk" type="text"  style="display:none">'+
                                        '<input id="form_telincategory_code" size="35" readonly type="text" class="FormElement form-control" placeholder="Choose Telin Categroy">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVCategroy(\'form_telincategoryid_fk\',\'form_telincategory_code\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_telincategoryid_fk").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_telincategoryid_fk").val();
                            } else if( oper === 'set') {
                                $("#form_telincategoryid_fk").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'telincategory_display');
                                        $("#form_telincategory_code").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Telin SG Categroy', name: 'telinsgcategory_display',width: 250, align: "left"},
                {label: 'Telin SG Categroy',
                    name: 'telinsgcategoryid_fk',
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
                                elm.append('<input id="form_telinsgcategoryid_fk" type="text"  style="display:none">'+
                                        '<input id="form_telinsgcategory_code" size="35" readonly type="text" class="FormElement form-control" placeholder="Choose Telin SG Categroy">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVCategroy(\'form_telinsgcategoryid_fk\',\'form_telinsgcategory_code\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_telinsgcategoryid_fk").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_telinsgcategoryid_fk").val();
                            } else if( oper === 'set') {
                                $("#form_telinsgcategoryid_fk").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'telinsgcategory_display');
                                        $("#form_telinsgcategory_code").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Net Related OM?', name: 'isnetrelatedom_display',width: 130, align: "center"},
                {label: 'Net Related OM?',name: 'isnetrelatedom',width: 120, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: false},
                    editoptions: {
                    value: ":-- Choose --;Y:YES;N:NO",
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
            editurl: '<?php echo WS_JQGRID."parameter.tblm_glblmap_controller/crud"; ?>',
            caption: "GL BL Map"

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
                    $('#gldesc').attr('readonly', true);

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
                    $('#gldesc').attr('readonly', true);

                    setTimeout(function() {
                        clearInputDWSCategroy();
                        clearInputMitratelCategroy();
                        clearInputInfratelCategroy();
                        clearInputTelinCategroy();
                        clearInputTelinSGCategroy();
                        clearInputPLItemType();
                        clearInputPLItem();
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

                    clearInputDWSCategroy();
                    clearInputMitratelCategroy();
                    clearInputInfratelCategroy();
                    clearInputTelinCategroy();
                    clearInputTelinSGCategroy();
                    clearInputPLItemType();
                    clearInputPLItem();
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