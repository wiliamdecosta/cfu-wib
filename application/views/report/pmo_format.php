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
            <span>PMO Format</span>
        </li>
        
    </ul>
    <div style="text-align: right; padding-top: 5px;">
        <button class="btn btn-warning btn-sm" type="button" id="btn-cetak" style="display: none;" onclick="cetak(1);">Preview</button>
        <button class="btn btn-success btn-sm" type="button" id="btn-download" style="display: none;" onclick="download(1);">Download</button>
        <button class="btn btn-primary btn-sm" type="button" onclick="customButtonClicked()"> <i class="fa fa-filter"></i> Filter </button>
    </div>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-xs-12">


        <div id="pmo-grid"></div>

    </div>
</div>

<?php $this->load->view('lov_search/lov_search_pmoformat'); ?>


<script>
    function showData(){
        var bl_id = $('#search_business_line').val();
        var i_budget_ver = $('#search_twibbudgetid_pk').val();
        var period = $('#periodid_fk').val();

        if(bl_id == ''){
            swal('Informasi','Bussiness Line is required','info');
            return false;
        }
        if (i_budget_ver == '') {
            swal('Informasi','Budget Version is required','info');
            return false;
        }
        if (period=='') {
            swal('Informasi','Period is required','info');
            return false;
        }
        $('#btn-cetak').show();
        $('#btn-download').show();
        $("#grid-toggle").show();

        loadHeader(bl_id, i_budget_ver, period);

        // jQuery("#grid-table").remove();
        // jQuery("#grid-table").jqGrid('setGridParam',{
        //     url: '<?php echo WS_JQGRID."report.pmo_format_controller/read"; ?>',
        //     postData: {
        //         bl_id : bl_id,
        //         i_budget_ver : i_budget_ver,
        //         period : period
        //     }
        // });

        // $("#grid-table").trigger("reloadGrid");

        
    }

    function openInNewTab(url) {
        window.open(url, 'Cetak', 'left=0,top=0,width=800,height=500,toolbar=no,scrollbars=yes,resizable=yes');
    }

    function cetak() {
            var bl_id = $('#search_business_line').val();
            var i_budget_ver = $('#search_twibbudgetid_pk').val();
            var period = $('#periodid_fk').val();

            var url = "<?php echo base_url(); ?>"+"pmo_format_pdf/pageCetak?";
            
            
            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&bl_id="+bl_id;
            url += "&i_budget_ver="+i_budget_ver;
            url += "&period="+period;

            openInNewTab(url);

    }

    function download() {

            var bl_id = $('#search_business_line').val();
            var i_budget_ver = $('#search_twibbudgetid_pk').val();
            var period = $('#periodid_fk').val();
            
           
            var url = "<?php echo WS_JQGRID . "report.pmo_format_controller/download_excel/?"; ?>";
            

            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&bl_id="+bl_id;
            url += "&i_budget_ver="+i_budget_ver;
            url += "&period="+period;

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

    function customButtonClicked(){
        // $('#pencarian').toggle();
        modal_lov_search_show();
    }

    function loadHeader(bl_id, i_budget_ver, period) {
        $.ajax({
            url: '<?php echo WS_JQGRID."report.pmo_format_controller/readHeader"; ?>',
            type: "POST",
            dataType: "json",
            data: {
                bl_id : bl_id, 
                i_budget_ver : i_budget_ver, 
                period : period
            },
            success: function (data) {
                loadGrid(bl_id, i_budget_ver, period, data.currmonth, data.tahun, data.bulan);
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    }

    function loadGrid(bl_id, i_budget_ver, period, currmonth, year, month){
         $.ajax({
            url: "<?php echo base_url().'home/load_content/report.pmo_format_grid'; ?>",
            type: "POST",
            data: {
                bl_id : bl_id, 
                i_budget_ver : i_budget_ver, 
                period : period,
                currmonth : currmonth,
                year : year,
                month : month
            },
            success: function (data) {
                $( "#pmo-grid" ).html( data );
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    }

    loadGrid('', '', '', 'Period', 'Period', 'Period');

</script>
