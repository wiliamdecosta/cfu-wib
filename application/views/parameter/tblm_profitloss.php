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
            <a href="#">Master</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Profit Loss</span>
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
    </div>
</div>

<?php $this->load->view('lov/lov_bpc_neraca'); ?>
<?php $this->load->view('lov/lov_tblm_profitloss'); ?>
<script>
    function showLOVPLItem(id, code) {
        modal_lov_bpc_neraca_show(id, code);
    }

    function clearInputPLItem() {
        $('#form_plitemcode').val('');
        $('#form_plitemname').val('');
    }

    function showLOVProfitLos(code) {
        modal_lov_tblm_profitloss_show(code);
    }

    function clearInputProfitLos() {
        $('#form_plitemname_sumto').val('');
    }

</script>
<script>
    function showData(){
        var i_search = $('#i_search').val();

        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."parameter.tblm_profitloss_controller/read"; ?>',
            postData: {
                i_search : i_search
            }
        });
        $("#grid-table").trigger("reloadGrid");
    }
</script>

<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."parameter.tblm_profitloss_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'profitlossid_pk', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'PL Group',name: 'plgroupname',width: 200, align: "left",editable: true, hidden: false,
                    editoptions: {
                        size: 40,
                        maxlength:96
                    },
                    editrules: {required: true, edithidden: true}
                },
                {label: 'PL Item',name: 'plitemname',width: 200, align: "left",editable: true, hidden: false,
                    editoptions: {
                        size: 40,
                        maxlength:96
                    },
                    editrules: {required: true, edithidden: true}
                },
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
                                elm.append('<input id="form_plitemcode" type="text"  readonly class="FormElement form-control" placeholder="Choose PL Item">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVPLItem(\'form_plitemcode\',\'form_plitemname\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_plitemname" readonly type="text" size="30" class="FormElement form-control" placeholder="PL Item Name" style="display:none;">');
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
                {label: 'Level No',name: 'levelno',width: 150, align: "left", hidden:true, editable: true, number:true,
                    editoptions: {
                        size: 15,
                        maxlength:255,
                        dataInit: function(element) {
                            $(element).keypress(function(e){
                                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                    return false;
                                 }
                            });
                        }
                    },
                    editrules: {required: true, edithidden: true}
                },
                {label: 'Listing No',name: 'listingno',width: 150, align: "left", hidden:true, editable: true, number:true,
                    editoptions: {
                        size: 15,
                        maxlength:255,
                        dataInit: function(element) {
                            $(element).keypress(function(e){
                                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                    return false;
                                 }
                            });
                        }
                    },
                    editrules: {required: true, edithidden: true}
                },
                {label: 'Detail?',name: 'isdetail_display',width: 100, align: "left",editable: false, hidden:false},
                {label: 'Detail?',name: 'isdetail',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: true},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},
                {label: 'Processed?',name: 'isprocessed_display',width: 100, align: "left",editable: false, hidden:false},
                {label: 'Processed?',name: 'isprocessed',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: true},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},
                {label: 'Sum To',
                    name: 'sumto',
                    width: 200,
                    sortable: true,
                    editable: true,
                    hidden: false,
                    editrules: {edithidden: true, required:false},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {
                            var elm = $('<span></span>');

                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_plitemname_sumto" type="text" readonly class="FormElement form-control" placeholder="Choose PL Item">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVProfitLos(\'form_plitemname_sumto\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>');
                                $("#form_plitemname_sumto").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_plitemname_sumto").val();
                            } else if( oper === 'set') {
                                $("#form_plitemname_sumto").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                // setTimeout(function(){
                                //     var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                //     if(selectedRowId != null) {
                                //         var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'plitemname');
                                //         $("#form_plitemname_sumto").val( code_display );
                                //     }
                                // },100);
                            }
                        }
                    }
                },
                {label: 'Plus/Minus',name: 'plusminus',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: false},
                    editoptions: {
                    value: "1:1;-1:-1",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},
                {label: 'To Hide Out?',name: 'istohideoutshow',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: true},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},
                {label: 'Description',name: 'description',width: 200, align: "left",editable: true, hidden:true,
                    edittype:'textarea',
                    editoptions: {
                        rows: 2,
                        cols:50,
                        maxlength:128
                    }
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
            editurl: '<?php echo WS_JQGRID."parameter.tblm_profitloss_controller/crud"; ?>',
            caption: "Profit Loss"

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

                    setTimeout(function() {
                        clearInputPLItem();
                        clearInputProfitLos();
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

                    clearInputPLItem();
                    clearInputProfitLos();

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