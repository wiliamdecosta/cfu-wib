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
            <span>Specific BL</span>
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


        <div class="row">
            <div class="col-xs-12">
               <table id="grid-table"></table>
               <div id="grid-pager"></div>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view('lov_search/lov_search_specificbl'); ?>

<script>
    function showData(){
        var year_id = $('#year_id').val();
        var jenis_lap = $('#jenis_lap').val();
        var bl_id = $('#search_business_line').val();

        // alert(bl_id);
        if (year_id == ''){
            $('#btn-cetak-ytd').hide();
            $('#btn-download-ytd').hide();
            $('#btn-cetak-cm').hide();        
            $('#btn-download-cm').hide();

            swal('Informasi','Year is required','info');
            return false;
        }


        if(jenis_lap == 2){
           $('#btn-cetak-ytd').hide();
            $('#btn-download-ytd').hide();
            $('#btn-cetak-cm').show();
            $('#btn-download-cm').show();

            $("#grid-table").jqGrid('setCaption', '<center>'+ $("#search_business_line option:selected").text() +' : Performance Growth YoY Model Current Month ' + year_id +'</center>');

            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."report.spesificbl_cm_controller/read"; ?>',
                postData: {
                    year_id : year_id,
                    bl_id : bl_id
                }
            });
            $("#grid-table").trigger("reloadGrid");
        }else{
            $('#btn-cetak-ytd').show();
            $('#btn-download-ytd').show();
            $('#btn-cetak-cm').hide();
            $('#btn-download-cm').hide();

            $("#grid-table").jqGrid('setCaption', '<center>'+ $("#search_business_line option:selected").text() +' : Performance Growth YoY Model YTD ' + year_id +'</center>');

            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."report.spesificbl_ytd_controller/read"; ?>',
                postData: {
                    year_id : year_id,
                    bl_id : bl_id
                }
            });
            $("#grid-table").trigger("reloadGrid"); 

        }

        
    }

    function openInNewTab(url) {
        window.open(url, 'Cetak', 'left=0,top=0,width=800,height=500,toolbar=no,scrollbars=yes,resizable=yes');
    }

    function cetak(dwn_type) {
            var year_id = $('#year_id').val();
            var bl_id = $('#search_business_line').val();

            if(dwn_type == 2){
                var url = "<?php echo base_url(); ?>"+"spesificblcm_pdf/pageCetak?";
            }else{
                var url = "<?php echo base_url(); ?>"+"spesificblytd_pdf/pageCetak?";
            }
            
            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&year_id="+year_id;
            url += "&bl_id="+bl_id;
            url += "&blname="+$("#search_business_line option:selected").text();

            openInNewTab(url);

    }

    function download(dwn_type) {

            var year_id = $('#year_id').val();
            var bl_id = $('#search_business_line').val();
            
            if(dwn_type == 2){
                var url = "<?php echo WS_JQGRID . "report.spesificbl_cm_controller/download_excel/?"; ?>";
            }else{
                var url = "<?php echo WS_JQGRID . "report.spesificbl_ytd_controller/download_excel/?"; ?>";
            }

            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&year_id="+year_id;
            url += "&bl_id="+bl_id;
            url += "&blname="+$("#search_business_line option:selected").text();

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
            url: '<?php echo WS_JQGRID."report.spesificbl_ytd_controller/read"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'P&L Line Item',name: 'plitemname',width: 250, align: "left", frozen:true},
                {label: 'Fonttype',name: 'fonttype', width: 250, align: "left", hidden:true},
                {label: '<center>Amount</center>',name: 'janamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Growth</center>',name: 'jangrowt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0) + ' %';
                    }
                }},
                {label: '<center>Amount</center>',name: 'febamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Growth</center>',name: 'febgrowt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0) + ' %';
                    }
                }},
                {label: '<center>Amount</center>',name: 'maramt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Growth</center>',name: 'margrowt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0) + ' %';
                    }
                }},
                {label: '<center>Amount</center>',name: 'apramt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Growth</center>',name: 'aprgrowt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0) + ' %';
                    }
                }},
                {label: '<center>Amount</center>',name: 'mayamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Growth</center>',name: 'maygrowt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0) + ' %';
                    }
                }},
                {label: '<center>Amount</center>',name: 'junamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Growth</center>',name: 'jungrowt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0) + ' %';
                    }
                }},
                {label: '<center>Amount</center>',name: 'julamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Growth</center>',name: 'julgrowt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0) + ' %';
                    }
                }},
                {label: '<center>Amount</center>',name: 'augamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Growth</center>',name: 'auggrowt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0) + ' %';
                    }
                }},
                {label: '<center>Amount</center>',name: 'sepamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Growth</center>',name: 'sepgrowt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0) + ' %';
                    }
                }},
                {label: '<center>Amount</center>',name: 'octamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Growth</center>',name: 'octgrowt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0) + ' %';
                    }
                }},
                {label: '<center>Amount</center>',name: 'novamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Growth</center>',name: 'novgrowt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0) + ' %';
                    }
                }},
                {label: '<center>Amount</center>',name: 'decamt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0);
                    }
                }},
                {label: '<center>Growth</center>',name: 'decgrowt',width: 100, align: "right", formatter:function(cellvalue, options, rowObject) {
                    if(rowObject.plitemname == null){
                        return '';
                    }else{
                        return $.number(cellvalue, 0) + ' %';
                    }
                }},
            ],
            height: 370,
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

                    if(fonttype == 'BOLD'){                        
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


        jQuery("#grid-table").jqGrid('setGroupHeaders', {
            useColSpanStyle: true, 
            groupHeaders:[
                {startColumnName: 'janamt', numberOfColumns: 2, titleText: '<center>Januari</center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'febamt', numberOfColumns: 2, titleText: '<center>Februari</center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'maramt', numberOfColumns: 2, titleText: '<center>Maret</center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'apramt', numberOfColumns: 2, titleText: '<center>April</center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'mayamt', numberOfColumns: 2, titleText: '<center>Mei</center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'junamt', numberOfColumns: 2, titleText: '<center>Juni</center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'julamt', numberOfColumns: 2, titleText: '<center>Juli</center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'augamt', numberOfColumns: 2, titleText: '<center>Agustus</center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'sepamt', numberOfColumns: 2, titleText: '<center>September</center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'octamt', numberOfColumns: 2, titleText: '<center>Oktober</center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'novamt', numberOfColumns: 2, titleText: '<center>November</center>', className: 'ui-th-column ui-th-ltr'},
                {startColumnName: 'decamt', numberOfColumns: 2, titleText: '<center>Desember</center>', className: 'ui-th-column ui-th-ltr'},
            ]
        });        


    });
    

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

    jQuery('#grid-table').jqGrid('setFrozenColumns');

    function customButtonClicked(){
        // $('#pencarian').toggle();
        modal_lov_search_show();
    }

</script>