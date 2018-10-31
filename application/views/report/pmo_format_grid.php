<style type="text/css">
    /* Bump up the font-size in the grid */
.ui-jqgrid .table thead tr th {
    font-size: 12px !important;
    /*padding: 1 2 1 2 !important;*/
}
.ui-jqgrid .table td {
    font-size: 11px !important;
    /*padding: 2px !important;*/
}

.myCustome {
    font-weight: bold;
    /*color: #000000;*/
    background-color: #E4EFC9 !important;
}

</style>

<div class="row">
    <div class="col-xs-12">
       <table id="grid-table"></table>
       <div id="grid-pager"></div>
    </div>
</div>

<script>

    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."report.pmo_format_controller/read"; ?>',
            datatype: "json",
            postData: {
                bl_id : "<?php echo $this->input->post('bl_id'); ?>",
                i_budget_ver : "<?php echo $this->input->post('i_budget_ver'); ?>",
                period : "<?php echo $this->input->post('period'); ?>"
            },
            mtype: "POST",
            colNames :['Financial', 'Unit', 'Fonttype', 'Bgtype', '<center> Period </center>', '<center>Target</center>', '<center>Real</center>', '<center>Ach.</center>', '<center>MoM</center>', '<center> Period </center>', '<center>Target</center>', '<center>Real</center>', '<center>Ach.</center>', '<center>MoM</center>'],
            colModel: [
                {name: 'pl_name',width: 250, align: "left", frozen:true},
                {name: 'unit', width: 250, align: "left"},
                {name: 'fonttype', width: 250, align: "left", hidden:true},
                {name: 'bgtype', width: 250, align: "left", hidden:true},
                {name: 'currenr_month_amt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.pl_name == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {name: 'currenr_month_target',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.pl_name == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {name: 'currenr_month_real',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.pl_name == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {name: 'currenr_month_ach',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.pl_name == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {name: 'currenr_month_mom',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.pl_name == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {name: 'last_year_amt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.pl_name == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {name: 'last_year_target',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.pl_name == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {name: 'last_year_real',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.pl_name == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {name: 'last_year_ach',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.pl_name == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {name: 'last_year_mom',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.pl_name == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }}
            ],
            height: 340,
            autowidth: true,
            viewrecords: false,
            rowNum: 100000000000000,
            rowList: [],
            rownumbers: false, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            pgbuttons: false,     // disable page control like next, back button
            pgtext: null,         // disable pager text like 'Page 0 of 10' 
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

                var rowData = jQuery("#grid-table").getDataIDs();
                // alert(rowData.length);
                for (var i = 0; i < rowData.length; i++) 
                {
                    // jQuery("#grid-table").jqGrid('setCell', rowData[i], "plgroupname", "", {'background-color':'#E4EFC9'});
                    var fonttype = jQuery("#grid-table").jqGrid('getCell', rowData[i], 'fonttype');
                    var bgtype = jQuery("#grid-table").jqGrid('getCell', rowData[i], 'bgtype');

                    if(fonttype == 'BOLD'){                        
                        jQuery("#grid-table").jqGrid('setRowData', rowData[i], false, 'myCustome');
                    }
                    if(bgtype == 'Y'){                        
                        jQuery("#grid-table").jqGrid('setRowData', rowData[i], false, 'myCustome');
                    }
                }

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."parameter.tblm_category_controller/crud"; ?>',
            caption: " "

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
                refresh: false,
                afterRefresh: function () {
                    // some code here
                    // jQuery("#detailsPlaceholder").hide();
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

		$("#grid-table").jqGrid("setLabel", "currenr_month_amt", "<center> <?php echo $this->input->post('currmonth');?> </center>");
		$("#grid-table").jqGrid("setLabel", "last_year_amt", "<center> <?php echo $this->input->post('year');?> </center>");

        jQuery("#grid-table").jqGrid('setGroupHeaders', {
            useColSpanStyle: true, 
            groupHeaders:[
                // {startColumnName: 'pl_name', numberOfColumns: 1, titleText: '<center> </center>', className: 'ui-th-column ui-th-ltr'},
                // {startColumnName: 'unit', numberOfColumns: 1, titleText: '<center> </center>', className: 'ui-th-column ui-th-ltr'},
                // {startColumnName: 'currenr_month_amt', numberOfColumns: 1, titleText: '<center> </center>', className: 'ui-th-column ui-th-ltr'},
                // {startColumnName: 'currenr_month_mom', numberOfColumns: 1, titleText: '<center> </center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'currenr_month_target', numberOfColumns: 3, titleText: '<center> <?php echo $this->input->post('month');?> </center> <hr style="margin:8px;"> <center>MtD</center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'last_year_target', numberOfColumns: 3, titleText: '<center> <?php echo $this->input->post('month');?> </center> <hr style="margin:8px;"> <center>YtD</center>', className: 'ui-th-column ui-th-ltr'},
                // {startColumnName: 'last_year_amt', numberOfColumns: 1, titleText: '<center> </center>', className: 'ui-th-column ui-th-ltr'},
                // {startColumnName: 'last_year_mom', numberOfColumns: 1, titleText: '<center> </center>', className: 'ui-th-column ui-th-ltr'}
            ]
        });

        // $("#grid-table").jqGrid('setLabel', 0, "test");

    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

    jQuery('#grid-table').jqGrid('setFrozenColumns');

</script>