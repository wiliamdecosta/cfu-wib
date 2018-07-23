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
            <span>CFU WIB</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-1">
                        <i class="blue"></i>
                        <strong> Batch Control </strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-2">
                        <i class="blue"></i>
                        <strong> Process Control </strong>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content no-border">
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
</div>


<script>
$("#tab-2").on("click", function(event) {
    event.stopPropagation();
    var grid = $('#grid-table');
    pbatchcontrolid_pk = grid.jqGrid ('getGridParam', 'selrow');
    periodid_fk = grid.jqGrid ('getCell', pbatchcontrolid_pk, 'periodid_fk');

    if(pbatchcontrolid_pk == null) {
        swal('Informasi','Silahkan pilih salah satu baris period','info');
        return false;
    }

    loadContentWithParams("parameter.tblp_processcontrol", {
        i_batch_control_id: pbatchcontrolid_pk,
        periodid_fk : periodid_fk
    });
});
</script>

<script>
    function doTreatment(treatmentcode, periodid_fk, pbatchcontrolid_pk) {

            var question_text = '';
            var next_period = parseInt(periodid_fk) + 1;
            if(treatmentcode == 'REOPEN') {
                question_text = 'Anda yakin ingin membuka kembali periode ' + periodid_fk;
            }else if(treatmentcode == 'CLOSE') {
                question_text = 'Anda yakin ingin menutup periode ' + periodid_fk + ' dan membuka periode ' + next_period + ' ?';
            }

            var grid = $("#grid-table");
            var ajaxOptions = {
                url: '<?php echo WS_JQGRID."parameter.tblp_batchcontrol_controller/treatment"; ?>',
                type: "POST",
                dataType: "json",
                data: { treatmentcode:treatmentcode, periodid_fk:periodid_fk, i_batch_control_id: pbatchcontrolid_pk },
                success: function (data) {
                    if(data.success == true) {
                        swal('Success',data.message,'success');
                        grid.trigger("reloadGrid");
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
                        text: question_text,
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

    function showData(){
        var i_search = $('#i_search').val();

        jQuery(function($) {

            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."parameter.tblp_batchcontrol_controller/read"; ?>',
                postData: {
                    i_search : $('#i_search').val()
                }
            });
            $("#grid-table").trigger("reloadGrid");
        });
    }

</script>

<?php $this->load->view('lov/lov_show_detil_batchcontrol'); ?>

<script>
    function showDetilBatchControl(id) {

        var rowData = jQuery("#grid-table").getRowData(id);
        modal_lov_show_detil_batchcontrol_show(rowData);
    }
</script>

<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."parameter.tblp_batchcontrol_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'pbatchcontrolid_pk', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Detil',width: 80,align: "center",
                    formatter:function(cellvalue, options, rowObject) {
                        var key = rowObject['pbatchcontrolid_pk'];
                        return '<button class="btn btn-primary btn-xs" onclick="showDetilBatchControl('+key+')">Detil</button>';
                    }
                },
                {label: 'Treatment',name: 'treatmentcode',width: 150, align: "left", hidden: true},
                {label: 'Treatment(Link)',width: 100,align: "center",
                    formatter:function(cellvalue, options, rowObject) {
                        var treatmentcode = rowObject['treatmentcode'];
                        var periodid_fk = rowObject['periodid_fk'];
                        var pbatchcontrolid_pk = rowObject['pbatchcontrolid_pk'];

                        if(treatmentcode == '' || treatmentcode == null || treatmentcode == 'null') return '';
                        return '<button class="btn btn-link btn-xs" onclick="doTreatment(\''+treatmentcode+'\', '+periodid_fk+', '+pbatchcontrolid_pk+')">'+treatmentcode+'</button>';
                    }
                },
                {label: 'Period',name: 'periodid_fk',width: 150, align: "left",editable: true,
                    editoptions: {
                        size: 30,
                        maxlength:64
                    },
                    editrules: {required: true}
                },
                {label: 'Batch Status',name: 'statuscode',width: 150, align: "left",editable: true,
                    editoptions: {
                        size: 30,
                        maxlength:64
                    },
                    editrules: {required: true}
                },
                {label: 'Last Updated',name: 'updateddateminute',width: 150, align: "left"},
                {label: 'Last Updated',name: 'updateddate',width: 150, align: "left", hidden:true},
                {label: 'Last Updated By ',name: 'updatedby',width: 150, align: "left"},

                {label: 'periodcode',name: 'periodcode',width: 150, align: "left", hidden: true},
                {label: 'processcategoryid_fk',name: 'processcategoryid_fk',width: 150, align: "left", hidden: true},
                {label: 'processcategorycode',name: 'processcategorycode',width: 150, align: "left", hidden: true},
                {label: 'groupcode',name: 'groupcode',width: 150, align: "left", hidden: true},
                {label: 'statuslistid_fk',name: 'statuslistid_fk',width: 150, align: "left", hidden: true},
                {label: 'orgcode',name: 'orgcode',width: 150, align: "left", hidden: true},
                {label: 'description',name: 'description',width: 150, align: "left", hidden: true},
                {label: 'creationdate',name: 'creationdate',width: 150, align: "left", hidden: true},
                {label: 'createdby',name: 'createdby',width: 150, align: "left", hidden: true}
            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 20,
            rowList: [20,50,100],
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
            editurl: '<?php echo WS_JQGRID."parameter.tblp_batchcontrol_controller/crud"; ?>',
            caption: "Batch Control"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: false,
                editicon: 'fa fa-pencil blue bigger-120',
                add: false,
                addicon: 'fa fa-plus-circle purple bigger-120',
                del: false,
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