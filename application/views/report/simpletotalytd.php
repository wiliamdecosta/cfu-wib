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
            <span>CFU Simple Total</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-xs-12">

        <div class="tab-content no-border">
            <div class="row">
                <label class="control-label col-md-2">Pencarian :</label>
            </div>
            <div class="row">                
                <div class="col-md-3">
                    <div class="input-group">
                        <input id="year_id" type="text" class="FormElement form-control required" placeholder="Year (YYYY)">
                    </div>
                </div> 

                <div class="col-md-3">
                    <div class="input-group">
                        <select class="FormElement form-control required" id="jenis_lap">                        
                            <option value="1"> YTD </option>
                            <option value="2"> Current Month </option>
                        </select>
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" id="btn-search" onclick="showData()">Cari</button>
                        </span>
                    </div>
                </div>

            </div>
            <div class="space-4"></div>

            <h4><label id="label1" style="display: none;"></label></h4>
            <h5><label id="label2" style="display: none;"></label></h5>

            <div class="row" id="table-data" style="display: none;">
                <div class="col-xs-12">
                   <table class="table table-bordered table-hover table-condensed table-scrollable">
                        <thead>
                            <tr style="background-color: #D64635; color: #ffffff;">
                                <th style="vertical-align: middle;">P&L Line Item </th>
                                <th style="vertical-align: middle; text-align: center;">JANUARI</th>
                                <th style="vertical-align: middle; text-align: center;">FEBRUARI</th>
                                <th style="vertical-align: middle; text-align: center;">MARET</th>
                                <th style="vertical-align: middle; text-align: center;">APRIL</th>
                                <th style="vertical-align: middle; text-align: center;">MEI</th>
                                <th style="vertical-align: middle; text-align: center;">JUNI</th>
                                <th style="vertical-align: middle; text-align: center;">JULI</th>
                                <th style="vertical-align: middle; text-align: center;">AGUSTUS</th>
                                <th style="vertical-align: middle; text-align: center;">SEPTEMBER</th>
                                <th style="vertical-align: middle; text-align: center;">OKTOBER</th>
                                <th style="vertical-align: middle; text-align: center;">NOVEMBER</th>
                                <th style="vertical-align: middle; text-align: center;">DESEMBER</th>
                            </tr>
                        </thead>
                        <tbody id="simpletotalytd">

                        </tbody>
                    </table>
                </div>                
            </div>
            <div class="space-4"></div>
            <div class="row" id="btn-group-cetak1" style="display: none;">
                <div class="col-xs-4"></div>
                    <div class="col-xs-6">
                        <button class="btn btn-warning" id="btn-cetak-ytd" onclick="cetak(1);">Cetak</button>
                        <button class="btn btn-primary" id="btn-download-ytd" onclick="download(1);">Download</button>
                    </div>
                </div>
            </div>
            <div class="row" id="btn-group-cetak2" style="display: none;">
                <div class="col-xs-4"></div>
                    <div class="col-xs-6">
                        <button class="btn btn-warning" id="btn-cetak-cm" onclick="cetak(2);">Cetak</button>
                        <button class="btn btn-primary" id="btn-download-cm" onclick="download(2);">Download</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    function showData(){
        var year_id = $('#year_id').val();
        var jenis_lap = $('#jenis_lap').val();

        if (year_id == ''){
            $('#label1').hide();
            $('#label2').hide();
            $('#table-data').hide();
            $('#btn-group-cetak1').hide();
            $('#btn-group-cetak2').hide();        
            swal('Informasi','Year is required','info');
            return false;
        }else{
            $('#label1').show();
            $('#label2').show();
            $('#table-data').show();
        }


        if(jenis_lap == 2){
            $('#btn-group-cetak1').hide();
            $('#btn-group-cetak2').show();
            $('#label1').text('P&L CFU Simple Total');
            $('#label2').text('Model Current Month ' + year_id);
            loadDataTable2(year_id);
        }else{
            $('#btn-group-cetak1').show();
            $('#btn-group-cetak2').hide();
            $('#label1').text('P&L CFU Simple Total');
            $('#label2').text('Model Year to date ' + year_id);
            loadDataTable1(year_id);
        }

        
    }

    function openInNewTab(url) {
        window.open(url, 'Cetak', 'left=0,top=0,width=800,height=500,toolbar=no,scrollbars=yes,resizable=yes');
    }

    function cetak(dwn_type) {
            var year_id = $('#year_id').val();

            if(dwn_type == 2){
                var url = "<?php echo base_url(); ?>"+"simpletotalcm_pdf/pageCetak?";
            }else{
                var url = "<?php echo base_url(); ?>"+"simpletotalytd_pdf/pageCetak?";
            }
            
            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&year_id="+year_id;

            openInNewTab(url);

    }

    function download(dwn_type) {

            var year_id = $('#year_id').val();
            
            if(dwn_type == 2){
                var url = "<?php echo WS_JQGRID . "report.simpletotalcm_controller/download_excel/?"; ?>";
            }else{
                var url = "<?php echo WS_JQGRID . "report.simpletotalytd_controller/download_excel/?"; ?>";
            }

            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&year_id="+year_id;

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
    function loadDataTable1(year_id) {
        $( "#simpletotalytd" ).html( 'Loading...');
        $.ajax({
            url: '<?php echo WS_JQGRID."report.simpletotalytd_controller/readTable"; ?>',
            type: "POST",
            data: {
                year_id : year_id
            },
            success: function (data) {
                $( "#simpletotalytd" ).html( data );
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    }

    function loadDataTable2(year_id) {
        $( "#simpletotalytd" ).html( 'Loading...');
        $.ajax({
            url: '<?php echo WS_JQGRID."report.simpletotalcm_controller/readTable"; ?>',
            type: "POST",
            data: {
                year_id : year_id
            },
            success: function (data) {
                $( "#simpletotalytd" ).html( data );
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    }
</script>