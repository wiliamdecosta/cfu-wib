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
            <span>To Hide Out – Detail</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-xs-12">

        <div class="tab-content no-border">
            <div class="row">          
                <label class="control-label col-md-1">Period:</label>      
                <div class="col-md-3">
                    <div class="input-group">
                        <input id="period_code" type="hidden" class="FormElement form-control">
                        <input id="periodid_fk" type="text" class="FormElement form-control required" placeholder="Period">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" onclick="showLOVPeriod('periodid_fk','period_code')">
                                <span class="fa fa-search bigger-110"></span>
                            </button>
                        </span>
                    </div>
                </div> 

                <label class="control-label col-md-2">PL Item:</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input id="search_plitem" type="text" class="FormElement form-control required" placeholder="PL Item">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" onclick="showLOVProfitLos('search_plitem')">
                                <span class="fa fa-search bigger-110"></span>
                            </button>
                        </span>
                    </div>
                </div>  

            </div>

            <div class="row">
                <label class="control-label col-md-1">BU/Subs:</label>
                <div class="col-md-3">
                    <div class="input-group">
                        <input id="search_wibunitbusinessid_pk" type="text"  style="display:none;">
                        <input id="search_wibunitbusinessname" type="text" style="display:none;" class="FormElement form-control" placeholder="Business Unit Name">
                        <input id="search_wibunitbusinesscode" type="text" class="FormElement form-control required" placeholder="BU/Subs">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" onclick="showLOVBusinessUnit('search_wibunitbusinessid_pk','search_wibunitbusinesscode','search_wibunitbusinessname')">
                                <span class="fa fa-search bigger-110"></span>
                            </button>
                        </span>
                    </div>
                </div> 

                <label class="control-label col-md-2">Business Line:</label>
                <div class="col-md-3">
                    <div class="input-group">
                        <select class="FormElement form-control required" id="search_business_line">                        
                            <option value="Domestic_Traffic"> Domestic_Traffic </option>
                            <option value="Domestic_Network"> Domestic_Network </option>
                            <option value="International_Traffic"> International_Traffic </option>
                            <option value="International_Network"> International_Network </option>
                            <option value="International_Adjacent"> International_Adjacent </option>
                            <option value="Towers"> Towers </option>
                            <option value="Infrastructure"> Infrastructure </option>
                        </select>
                    </div>
                </div>                    
            </div>

            <div class="row">
                <label class="control-label col-md-1">Filter:</label>
                <div class="col-md-6">
                    <input id="i_search" type="text" class="FormElement form-control">
                </div>
            </div>
            <div class="space-4"></div>
            <div class="row" id="btn-group-tohideout-action">
                <!-- <div class="col-xs-4"></div> -->
                <div class="col-xs-6">
                    <button class="btn btn-success" type="button" id="btn-search" onclick="showData()">Cari</button>
                    <button class="btn btn-primary" type="button" id="btn-download" onclick="downloadExcel();">Download</button>
                    <button class="btn btn-default" type="button" id="btn-download2" onclick="downloadExcel2();">Download Subs</button>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="row">
                <div class="col-xs-12">
                    <table id="grid-table"></table>
                    <div id="grid-pager"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('lov/lov_period'); ?>
<?php $this->load->view('lov/lov_tblm_wibunitbusiness'); ?>
<?php $this->load->view('lov/lov_tblm_profitloss_new'); ?>

<script>

    function showLOVPeriod(id, code) {
        modal_lov_period_show(id, code);
    }

    function showLOVBusinessUnit(id, code, name) {
        modal_lov_tblm_wibunitbusiness_show(id, code, name);
    }

    function showLOVProfitLos(code) {
        modal_lov_tblm_profitloss_show(code);
    }

</script>

<script>
    function showData(){
        var i_search = $('#i_search').val();
        var ubiscode = $('#search_wibunitbusinesscode').val();
        var pl_item_name = $('#search_plitem').val();
        var column_name = $('#search_business_line').val();
        var periodid_fk = $('#periodid_fk').val();

        if (periodid_fk == '' ){
            swal('Informasi','Period is required','info');
            return false;
        }

        if (ubiscode == '' ){
            swal('Informasi','BU/Subs is required','info');
            return false;
        }

        if (pl_item_name == ''){
            swal('Informasi','PL Item is required','info');
            return false;
        }

        if (column_name == ''){
            swal('Informasi','Business Line is required','info');
            return false;
        }

        jQuery(function($) {
            jQuery("#grid-table").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."transaksi.tblt_thodetail_controller/read"; ?>',
                postData: {
                    i_search : i_search,
                    periodid_fk : periodid_fk,
                    ubiscode: ubiscode,
                    pl_item_name: pl_item_name,
                    column_name: column_name,
                }
            });
            $("#grid-table").trigger("reloadGrid");
        });
    }
</script>

<script>
    function downloadExcel(){
        var i_search = $('#i_search').val();
        var ubiscode = $('#search_wibunitbusinesscode').val();
        var pl_item_name = $('#search_plitem').val();
        var column_name = $('#search_business_line').val();
        var periodid_fk = $('#periodid_fk').val();

        if (periodid_fk == '' ){
            swal('Informasi','Period is required','info');
            return false;
        }

        if (ubiscode == '' ){
            swal('Informasi','BU/Subs is required','info');
            return false;
        }

        if (pl_item_name == ''){
            swal('Informasi','PL Item is required','info');
            return false;
        }

        if (column_name == ''){
            swal('Informasi','Business Line is required','info');
            return false;
        }

        var url = "<?php echo WS_JQGRID . "transaksi.tblt_thodetail_controller/download_excel/?"; ?>";
        url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
        url += "&periodid_fk="+periodid_fk;
        url += "&ubiscode="+ubiscode;
        url += "&pl_item_name="+pl_item_name;
        url += "&column_name="+column_name;
        url += "&i_search="+i_search;

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

    function downloadExcel2(){
        var i_search = $('#i_search').val();
        var ubiscode = $('#search_wibunitbusinesscode').val();
        var pl_item_name = $('#search_plitem').val();
        var column_name = $('#search_business_line').val();
        var periodid_fk = $('#periodid_fk').val();

        if (periodid_fk == '' ){
            swal('Informasi','Period is required','info');
            return false;
        }

        if (ubiscode == '' ){
            swal('Informasi','BU/Subs is required','info');
            return false;
        }


        var url = "<?php echo WS_JQGRID . "transaksi.tblt_thodetail_controller/download_excel2/?"; ?>";
        url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
        url += "&periodid_fk="+periodid_fk;
        url += "&ubiscode="+ubiscode;
        url += "&pl_item_name="+pl_item_name;
        url += "&column_name="+column_name;
        url += "&i_search="+i_search;

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
            url: '<?php echo WS_JQGRID."transaksi.tblt_thodetail_controller/crud"; ?>',
            postData: { periodid_fk : 0},
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'BU/Subs',name: 'ubiscode',width: 100, align: "left"},
                {label: 'Category',name: 'categorycode',width: 200, align: "left"},
                {label: 'GL Account',name: 'glaccount',width: 200, align: "left"},
                {label: 'GL Name',name: 'gldesc',width: 350, align: "left"},
                {label: 'Amount',name: 'amount',width: 150, align: "right", editable: false, formatter:'currency', formatoptions: {prefix:"", thousandsSeparator:','}},
                {label: 'Description',name: 'description',width: 200, align: "left"},

            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 10000000000000,
            rowList: [],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            footerrow: true,
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
                totalamount = 0;

                for (var i = 0; i < rowData.length; i++) 
                {
                    var amount = jQuery("#grid-table").jqGrid('getCell', rowData[i], 'amount');

                    totalamount = totalamount + parseFloat(amount);
                }

                $("#grid-table").jqGrid('footerData', 'set', { "gldesc":"Total :"}, true);
                $("#grid-table").jqGrid('footerData', 'set', { "amount": totalamount}, true);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."transaksi.tblt_thodetail_controller/crud"; ?>',
            caption: "To Hide Out – Detail"

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

        // jQuery(".ui-th-column-header ui-th-ltr").addClass("active");

    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

</script>