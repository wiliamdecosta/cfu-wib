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
            <span>Period</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <table id="grid-table"></table>
        <div id="grid-pager"></div>
    </div>
</div>


<?php $this->load->view('lov/lov_statuslist'); ?>


<script>
function showLovStatusList(id, code) {
    modal_lov_statuslist_show(id, code, 'Status Period');
}
function clearInputStatusList() {
    $('#form_periodstatus').val('');
    $('#form_periodstatuscode').val('');
    $('#form_periodstatuscons').val('');
    $('#form_periodstatuscodecons').val('');
}

</script>

<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        var date = new Date();
        var currentMonth = date.getMonth()+1;
        var currentYear = date.getFullYear();


        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."parameter.tblm_period_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'periodid_pk', key: true, width: 100, sorttype: 'number', editable: true, hidden: true},
                {label: 'ID', name: 'periodid_pk_display', width: 100, sorttype: 'number', editable: false, hidden: false},
                {label: 'Periode Code',name: 'code',width: 150, align: "left",editable: true,
                    editoptions: {
                        size: 30,
                        maxlength:32
                    },
                    editrules: {required: true}
                },
                {label: 'Year',name: 'year',width: 150, align: "left",editable: true, number:true,
                    editoptions: {
                        size: 15,
                        maxlength:255,
                        dataInit: function(element) {
                            $(element).keypress(function(e){
                                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                    return false;
                                 }
                            });
                            $(element).val(currentYear);
                        }
                    },
                    editrules: {required: true}
                },
                {label: 'Month',name: 'month',width: 120, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: true},
                    editoptions: {
                    value: "1:January;2:February;3:March;4:April;5:May;6:June;7:July;8:August;9:September;10:October;11:November;12:December",
                    defaultValue: currentMonth,
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},
                {label: 'Month', name: 'month_name', width: 120, align: "left", editable: false},
                {label: 'WIB Status',
                    name: 'statuslistid_fk',
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
                                elm.append('<input id="form_periodstatus" type="text"  style="display:none;">'+
                                        '<input id="form_periodstatuscode" readonly type="text" class="FormElement form-control" placeholder="Pilih Status">'+
                                        '<button class="btn btn-success" type="button" onclick="showLovStatusList(\'form_periodstatus\',\'form_periodstatuscode\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_periodstatus").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_periodstatus").val();
                            } else if( oper === 'set') {
                                $("#form_periodstatus").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'periodstatuscode');
                                        $("#form_periodstatuscode").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'WIB Status', name: 'periodstatuscode', width: 120, align: "left", editable: false},
                {label: 'Consumer Status',
                    name: 'consstatuslistid_fk',
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
                                elm.append('<input id="form_periodstatuscons" type="text"  style="display:none;">'+
                                        '<input id="form_periodstatuscodecons" readonly type="text" class="FormElement form-control" placeholder="Pilih Status">'+
                                        '<button class="btn btn-success" type="button" onclick="showLovStatusList(\'form_periodstatuscons\',\'form_periodstatuscodecons\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_periodstatuscons").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_periodstatuscons").val();
                            } else if( oper === 'set') {
                                $("#form_periodstatuscons").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'periodstatuscodecons');
                                        $("#form_periodstatuscodecons").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Consumer Status', name: 'periodstatuscodecons', width: 120, align: "left", editable: false},
                {label: 'Description',name: 'description',width: 200, align: "left",editable: true,
                    edittype:'textarea',
                    editoptions: {
                        rows: 2,
                        cols:50,
                        maxlength:128
                    }
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
            editurl: '<?php echo WS_JQGRID."parameter.tblm_period_controller/crud"; ?>',
            caption: "Period"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: true,
                editicon: 'fa fa-pencil blue bigger-120',
                add: true,
                addicon: 'fa fa-plus-circle purple bigger-120',
                del: true,
                delicon: 'fa fa-trash-o red bigger-120',
                search: true,
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

                    setTimeout(function() {
                        clearInputStatusList();
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

                    clearInputStatusList();

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