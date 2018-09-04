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
                        <input id="period_code" type="hidden" class="FormElement form-control">
                        <input id="periodid_fk" type="text" class="FormElement form-control required" placeholder="Period">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" onclick="showLOVPeriod('periodid_fk','period_code')">
                                <span class="fa fa-search bigger-110"></span>
                            </button>
                        </span>
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
                                <th rowspan="2" style="vertical-align: middle;">P&L Line Item </th>
                                <th colspan="5" style="text-align: center;">Carrier</th>
                                <th rowspan="2" style="vertical-align: middle; text-align: center;">International <br> Adjacent</th>
                                <th rowspan="2" style="vertical-align: middle; text-align: center;">Towers</th>
                                <th rowspan="2" style="vertical-align: middle; text-align: center;">Infrastructure</th>
                                <th rowspan="2" style="vertical-align: middle; text-align: center;">Simple <br> Total</th>
                            </tr>
                            <tr style="background-color: #D64635; color: #ffffff;">
                                <th style="text-align: center;">Domestic <br> Traffic</th>
                                <th style="text-align: center;">Domestic <br> Network</th>
                                <th style="text-align: center;">International <br> Traffic</th>
                                <th style="text-align: center;">International <br> Network</th>
                                <th style="text-align: center;">Carrier <br> Total</th>
                            </tr>
                        </thead>
                        <tbody id="businesslineytd">

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

<?php $this->load->view('lov/lov_period'); ?>

<script>

    function showLOVPeriod(id, code) {
        modal_lov_period_show(id, code);
    }

    function showData(){
        var periodid_fk = $('#periodid_fk').val();
        var period_code = $('#period_code').val();
        var jenis_lap = $('#jenis_lap').val();

        if (periodid_fk == ''){
            $('#label1').hide();
            $('#label2').hide();
            $('#table-data').hide();
            $('#btn-group-cetak1').hide();
            $('#btn-group-cetak2').hide();        
            swal('Informasi','Period is required','info');
            return false;
        }else{
            $('#label1').show();
            $('#label2').show();
            $('#table-data').show();
        }


        if(jenis_lap == 2){
            $('#btn-group-cetak1').hide();
            $('#btn-group-cetak2').show();
            $('#label1').text('Business Line - Line Up');
            $('#label2').text('Model Current Month ' + period_code.replace("YTD ",""));
            loadDataTable2(periodid_fk);
        }else{
            $('#btn-group-cetak1').show();
            $('#btn-group-cetak2').hide();
            $('#label1').text('Business Line - Line Up');
            $('#label2').text('Model Year to date ' + period_code.replace("YTD ",""));
            loadDataTable1(periodid_fk);
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
    function loadDataTable1(periodid_fk) {
        $( "#businesslineytd" ).html( 'Loading...');
        $.ajax({
            url: '<?php echo WS_JQGRID."report.businesslineytd_controller/readTable"; ?>',
            type: "POST",
            data: {
                periodid_fk : periodid_fk
            },
            success: function (data) {
                $( "#businesslineytd" ).html( data );
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    }

    function loadDataTable2(periodid_fk) {
        $( "#businesslineytd" ).html( 'Loading...');
        $.ajax({
            url: '<?php echo WS_JQGRID."report.businesslinecm_controller/readTable"; ?>',
            type: "POST",
            data: {
                periodid_fk : periodid_fk
            },
            success: function (data) {
                $( "#businesslineytd" ).html( data );
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    }
</script>