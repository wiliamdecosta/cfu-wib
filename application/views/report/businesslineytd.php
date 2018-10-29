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
.ui-jqgrid .ui-jqgrid-htable .ui-th-div {
    height:auto;
}

.myCustome {
    font-weight: bold;
    /*color: #000000;*/
    background-color: #E4EFC9 !important;
}

</style>
<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Reports</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Business Line – Line Up</span>
        </li>        
    </ul>
    <div style="text-align: right; padding-top: 5px;">
        <button class="btn btn-warning btn-sm" type="button" id="btn-cetak-ytd" style="display: none;" onclick="cetak(1);">Preview</button>
        <button class="btn btn-success btn-sm" type="button" id="btn-download-ytd" style="display: none;" onclick="download(1);">Download</button>
        <button class="btn btn-warning btn-sm" type="button" id="btn-cetak-cm" style="display: none;" onclick="cetak(2);">Preview</button>
        <button class="btn btn-success btn-sm" type="button" id="btn-download-cm" style="display: none;" onclick="download(2);">Download</button>
        <button class="btn btn-primary btn-sm" type="button" onclick="customButtonClicked()"> <i class="fa fa-filter"></i> Filter </button>
    </div>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-xs-12">

        <div class="tab-content no-border">

            <div class="row">
                <div class="col-xs-12">
                   <table id="grid-table"></table>
                   <div id="grid-pager"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view('lov_search/lov_search_businessline'); ?>

<script>

    function showData(){
        var periodid_fk = $('#periodid_fk').val();
        var period_code = $('#period_code').val();
        var jenis_lap = $('#jenis_lap').val();

        if (periodid_fk == ''){
            $('#label1').hide();
            $('#label2').hide();
            // $('#table-data').hide();
            $('#btn-cetak-ytd').hide();
            $('#btn-download-ytd').hide();
            $('#btn-cetak-cm').hide();        
            $('#btn-download-cm').hide();        
            swal('Informasi','Period is required','info');
            return false;
        }else{
            $('#label1').show();
            $('#label2').show();
            // $('#table-data').show();
        }


        if(jenis_lap == 2){
            $('#btn-cetak-ytd').hide();
            $('#btn-download-ytd').hide();
            $('#btn-cetak-cm').show();
            $('#btn-download-cm').show();
            // $('#label1').text('Business Line - Line Up');
            // $('#label2').text('Model Current Month ' + period_code.replace("YTD ",""));

            $("#grid-table").jqGrid('setCaption', '<center>'+ 'Business Line - Line Up : Model Current Month '  + period_code.replace("YTD ","") +'</center>');

            // loadDataTable2(periodid_fk);
            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."report.businesslinecm_controller/read"; ?>',
                postData: {
                    periodid_fk : periodid_fk
                }
            });
            $("#grid-table").trigger("reloadGrid");
        }else{
            $('#btn-cetak-ytd').show();
            $('#btn-download-ytd').show();
            $('#btn-cetak-cm').hide();
            $('#btn-download-cm').hide();
            // $('#label1').text('Business Line - Line Up');
            // $('#label2').text('Model Year to date ' + period_code.replace("YTD ",""));

            $("#grid-table").jqGrid('setCaption', '<center>'+ 'Business Line - Line Up : Model Year to date '  + period_code.replace("YTD ","") +'</center>');
            // loadDataTable1(periodid_fk);
            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."report.businesslineytd_controller/read"; ?>',
                postData: {
                    periodid_fk : periodid_fk
                }
            });
            $("#grid-table").trigger("reloadGrid");

        }

        
    }

    function openInNewTab(url) {
        window.open(url, 'Cetak', 'left=0,top=0,width=800,height=500,toolbar=no,scrollbars=yes,resizable=yes');
    }

    function cetak(dwn_type) {
            var periodid_fk = $('#periodid_fk').val();
            var period_code = $('#period_code').val().replace("YTD ","");

            if(dwn_type == 2){
                var url = "<?php echo base_url(); ?>"+"businesslinecm_pdf/pageCetak?";
            }else{
                var url = "<?php echo base_url(); ?>"+"businesslineytd_pdf/pageCetak?";
            }
            
            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&periodid_fk="+periodid_fk;
            url += "&period_code="+period_code;

            openInNewTab(url);

    }

    function download(dwn_type) {

            var periodid_fk = $('#periodid_fk').val();
            var period_code = $('#period_code').val().replace("YTD ","");
            
            if(dwn_type == 2){
                var url = "<?php echo WS_JQGRID . "report.businesslinecm_controller/download_excel/?"; ?>";
            }else{
                var url = "<?php echo WS_JQGRID . "report.businesslineytd_controller/download_excel/?"; ?>";
            }

            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&periodid_fk="+periodid_fk;
            url += "&period_code="+period_code;

            swal({
                title: "Konfirmasi",
                text: 'Anda yakin ingin melakukan download data?',
                type: "info",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: "Ya, Yakin",
                confirmButtonColor: "#538cf6",
                cancelButtonText: "Tidak",
                closeOnConfirm: true,
                closeOnCancel: true,
                html: true
            },
            function(isConfirm){
                if(isConfirm) {
                    window.location = url;
                    return true;
                }else {
                    return false;
                }
            });
    }

</script>

<script>

    jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."report.businesslineytd_controller/read"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'P&L Line Item',name: 'plitemname',width: 250, align: "left", frozen:false},
                {label: 'Fonttype',name: 'fonttype', width: 250, align: "left", hidden:true},
                {label: '<center>Domestic<br>Traffic</center>',name: 'domtrafficamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Domestic<br>Network</center>',name: 'domnetworkamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>International<br>Traffic</center>',name: 'intltrafficamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>International<br>Network</center>',name: 'intlnetworkamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Carrier<br>Total</center>',name: 'carrieramt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>International<br>Adjacent</center>',name: 'intladjacentamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Towers</center>',name: 'toweramt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Infrastructure</center>',name: 'infraamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Simple Total</center>',name: 'totalamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
            ],
            height: 350,
            autowidth: true,
            viewrecords: false,
            rowNum: 100000000000000,
            rowList: [],
            rownumbers: false, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: false,
            shrinkToFit: true,
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

                    if(fonttype == 'BOLD'){                        
                        jQuery("#grid-table").jqGrid('setRowData', rowData[i], false, 'myCustome');
                    }
                }

            },
            //memanggil controller jqgrid yang ada di controller crud
            // editurl: '<?php echo WS_JQGRID."parameter.tblm_category_controller/crud"; ?>',
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

        // $('#grid-table').navButtonAdd('#grid-pager',
        // {
        //     id: "btn-filter",
        //     buttonicon: "fa fa-search orange bigger-120",
        //     title: "Filter",
        //     caption: "",
        //     position: "last",
        //     onClickButton: customButtonClicked
        // });


        jQuery("#grid-table").jqGrid('setGroupHeaders', {
            useColSpanStyle: true, 
            groupHeaders:[
                {startColumnName: 'domtrafficamt', numberOfColumns: 5, titleText: '<center>Carrier</center>', className: 'ui-th-column ui-th-ltr'},
            ]
        });

    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

    // jQuery('#grid-table').jqGrid('setFrozenColumns');

    function customButtonClicked(){
        // $('#pencarian').toggle();
        modal_lov_search_show();
    }

</script>