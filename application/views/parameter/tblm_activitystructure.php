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
            <a href="#">Master</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Activity Structure</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <label class="control-label col-md-2">Pencarian :</label>
    <div class="col-md-3">
        <div class="input-group">
            <select class="FormElement form-control" id="search_activitytype">
            <?php
                $ci = & get_instance();
                $ci->load->model('parameter/tblm_activitytype');
                $table = $ci->tblm_activitytype;

                $items = $table->getAll(0,-1,'listingno','asc');

            ?>
            <option value=""> -- Choose Activity Type -- </option>
            <?php foreach($items as $item):?>
                <option value="<?php echo $item['activitytypeid_pk'];?>"> <?php echo $item['activitygabung'];?></option>
            <?php endforeach; ?>
            </select>
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


<?php $this->load->view('lov/lov_tblm_wibunitbusiness'); ?>
<?php $this->load->view('lov/lov_vwallactivity'); ?>
<?php $this->load->view('lov/lov_tblm_costdriver'); ?>

<script>

function onChangeUbis() {
    clearInputActivity();
    clearInputOverheadAct1();
    clearInputOverheadAct2();
    clearInputCostDriver();
}

function showLOVBusinessUnit(id, code, name) {
    modal_lov_tblm_wibunitbusiness_show(id, code, name);
}

function clearInputBusinessUnit() {
    $('#form_wibunitbusinessid_pk').val('');
    $('#form_wibunitbusinesscode').val('');
    $('#form_wibunitbusinessname').val('');
}

function showLOVAllActivity(id, code) {
    var activitytypeid_fk = $('#search_activitytype').val();
    var ubiscode = $('#form_wibunitbusinesscode').val();

    if(ubiscode == '') {
        swal('Info','Silahkan pilih BU/Subsidiary terlebih dahulu','info');
        return;
    }
    modal_lov_vw_allactivity_show(id, code, activitytypeid_fk, ubiscode);
}

function clearInputActivity() {
    $('#form_activityid').val('');
    $('#form_activityname').val('');
}

function clearInputOverheadAct1() {
    $('#form_ohactivityid1').val('');
    $('#form_ohactivityname1').val('');
}

function clearInputOverheadAct2() {
    $('#form_ohactivityid2').val('');
    $('#form_ohactivityname2').val('');
}

function showLOVCostDriver(id, code) {
    var ubiscode = $('#form_wibunitbusinesscode').val();

    if(ubiscode == '') {
        swal('Info','Silahkan pilih BU/Subsidiary terlebih dahulu','info');
        return;
    }

    modal_lov_tblm_costdriver_show(id, code, ubiscode);
}

function clearInputCostDriver() {
    $('#form_costdriverid_fk').val('');
    $('#form_costdrivercode').val('');
}



</script>

<script>
    function showData(){
        var i_search = $('#i_search').val();
        var activitytypeid_fk = $('#search_activitytype').val();

        if(activitytypeid_fk == '') {
            $('#table_placeholder').hide();
            return;
        }

        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."parameter.tblm_activitystructure_controller/read"; ?>',
            postData: {
                i_search : i_search,
                activitytypeid_fk : activitytypeid_fk
            }
        });
        $("#grid-table").trigger("reloadGrid");
        responsive_jqgrid('#grid-table', '#grid-pager');
        $('#table_placeholder').show();
    }
</script>


<script>
    $('#search_activitytype').on('change', function() {
        showData();
    });
</script>

<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."parameter.tblm_activitystructure_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'activitystructureid_pk', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Activity Type',name: 'activitytypeid_fk',width: 150, align: "left",editable: true, hidden:true,
                    editoptions: {
                        size: 30,
                        maxlength:10
                    },
                    editrules: {required: true}
                },

                {label: 'BU/Subsidiary',name: 'ubisname',width: 120, align: "left"},
                {label: 'BU/Subsidiary',
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
                                        '<input id="form_wibunitbusinesscode" onchange="onChangeUbis();" readonly style="background:#FFFFA2" type="text" class="FormElement form-control" placeholder="Choose Business Unit">'+
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
                {label: 'Activity',name: 'activitygabung',width: 200, align: "left", hidden:false},
                {label: 'Activity Code',
                    name: 'activityid',
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
                                elm.append('<input id="form_activityid" readonly size="30" type="text"  style="background:#FFFFA2" class="FormElement form-control" placeholder="Choose Activity">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVAllActivity(\'form_activityid\',\'form_activityname\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_activityname" size="30" readonly type="text" class="FormElement form-control" placeholder="Activity Name">');
                                $("#form_activityid").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_activityid").val();
                            } else if( oper === 'set') {
                                $("#form_activityid").val(gridval);
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



                {label: 'Overhead Act 1',name: 'ohactivitygabung1',width: 200, align: "left", hidden:false},
                {label: 'Overhead Act 1',
                    name: 'ohactivityid1',
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
                                elm.append('<input id="form_ohactivityid1" size="30" readonly type="text" class="FormElement form-control" placeholder="Choose Overhead Act 1">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVAllActivity(\'form_ohactivityid1\',\'form_ohactivityname1\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_ohactivityname1" size="30" readonly type="text" class="FormElement form-control" placeholder="Overhead Act 1 Name">');
                                $("#form_ohactivityid1").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_ohactivityid1").val();
                            } else if( oper === 'set') {
                                $("#form_ohactivityid1").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'ohactivityname1');
                                        $("#form_ohactivityname1").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Overhead Act 2',name: 'ohactivitygabung2',width: 200, align: "left", hidden:false},
                {label: 'Overhead Act 2',
                    name: 'ohactivityid2',
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
                                elm.append('<input id="form_ohactivityid2" size="30" readonly type="text"  class="FormElement form-control" placeholder="Choose Overhead Act 2">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVAllActivity(\'form_ohactivityid2\',\'form_ohactivityname2\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button> &nbsp;' +
                                        '<input id="form_ohactivityname2" size="30" readonly type="text" class="FormElement form-control" placeholder="Overhead Act 2 Name">');
                                $("#form_ohactivityid2").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_ohactivityid2").val();
                            } else if( oper === 'set') {
                                $("#form_ohactivityid2").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'ohactivityname2');
                                        $("#form_ohactivityname2").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Cost Driver',name: 'costdrivercode',width: 200, align: "left", hidden:false},
                {label: 'Cost Driver',
                    name: 'costdriverid_fk',
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
                                elm.append('<input id="form_costdriverid_fk" readonly type="text"  style="display:none;">'+
                                        '<input id="form_costdrivercode" style="background:#FFFFA2" size="30" readonly type="text" class="FormElement form-control" placeholder="Choose Cost Driver">'+
                                        '<button class="btn btn-success" type="button" onclick="showLOVCostDriver(\'form_costdriverid_fk\',\'form_costdrivercode\')">'+
                                        '   <span class="fa fa-search bigger-110"></span>'+
                                        '</button>'
                                        );
                                $("#form_costdriverid_fk").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);

                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {

                            if(oper === 'get') {
                                return $("#form_costdriverid_fk").val();
                            } else if( oper === 'set') {
                                $("#form_costdriverid_fk").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'costdrivercode');
                                        $("#form_costdrivercode").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
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
                            element.style.textAlign = 'right';
                            //$(element).number( true, 0, ",", "." );
                        }
                    },
                    editrules: {required: true, edithidden: true}
                },
                {label: 'Dom Traffic?',name: 'isdomtrafficdisplay',width: 120, align: "center"},
                {label: 'Dom Traffic?',name: 'isdomtraffic',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: false},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},

                {label: 'Dom Network?',name: 'isdomnetworkdisplay',width: 120, align: "center"},
                {label: 'Dom Network?',name: 'isdomnetwork',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: false},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},

                {label: 'Intl Traffic?',name: 'isintltrafficdisplay',width: 120, align: "center"},
                {label: 'Intl Traffic?',name: 'isintltraffic',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: false},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},

                {label: 'Intl Network?',name: 'isintlnetworkdisplay',width: 120, align: "center"},
                {label: 'Intl Network?',name: 'isintlnetwork',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: false},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},

                {label: 'Intl Adjacent?',name: 'isintladjacentdisplay',width: 120, align: "center"},
                {label: 'Intl Adjacent?',name: 'isintladjacent',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: false},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},

                {label: 'Tower?',name: 'istowerdisplay',width: 120, align: "center"},
                {label: 'Tower?',name: 'istower',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: false},
                    editoptions: {
                    value: "Y:YES;N:NO",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},

                {label: 'Infra?',name: 'isinfrastructuredisplay',width: 120, align: "center"},
                {label: 'Infra?',name: 'isinfrastructure',width: 100, align: "left",editable: true, edittype: 'select', hidden:true,
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

                {label: 'activityname',name: 'activityname',width: 120, align: "center", hidden:true},
                {label: 'ohactivityname1',name: 'ohactivityname1',width: 120, align: "center", hidden:true},
                {label: 'ohactivityname2',name: 'ohactivityname2',width: 120, align: "center", hidden:true},
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
            editurl: '<?php echo WS_JQGRID."parameter.tblm_activitystructure_controller/crud"; ?>',
            caption: "Activity Structure"

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

                    $('#activitytypeid_fk').val( $('#search_activitytype').val() );

                    setTimeout(function() {
                        clearInputBusinessUnit();
                        clearInputActivity();
                        clearInputOverheadAct1();
                        clearInputOverheadAct2();
                        clearInputCostDriver();
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


                    clearInputBusinessUnit();
                    clearInputActivity();
                    clearInputOverheadAct1();
                    clearInputOverheadAct2();
                    clearInputCostDriver();
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