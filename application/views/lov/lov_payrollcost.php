<div id="modal_lov_payrollcost" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog" style="width:1200px;">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Data Payroll Cost</span>
                </div>
            </div>

            <!-- modal body -->
            <div class="modal-body" style="height:400px; overflow-y:scroll;">
                <div class="table-responsive">
                    <table id="modal_lov_payrollcost_grid_selection" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th data-column-id="periodid_fk" data-sortable="false">PERIODID</th>
                            <th data-column-id="iddivisi">IDDIVISI</th>
                            <th data-column-id="nomor">NOMOR</th>
                            <th data-column-id="area">AREA</th>
                            <th data-column-id="subarea">SUBAREA</th>
                            <th data-column-id="bandposisi">BANDPOSISI</th>
                            <th data-column-id="hostgroup">HOSTGROUP</th>
                            <th data-column-id="hostcode">HOSTCODE</th>
                            <th data-column-id="baseslr" data-align="right">BASESLR</th>
                            <th data-column-id="mahal" data-align="right">MAHAL</th>
                            <th data-column-id="tunjanganpajak" data-align="right">TUNJANGANPAJAK</th>
                            <th data-column-id="premium" data-align="right">PREMIUM</th>
                            <th data-column-id="askedir" data-align="right">ASKEDIR</th>
                            <th data-column-id="bbp" data-align="right">BBP</th>
                            <th data-column-id="adjbbp" data-align="right">ADJBBP</th>
                            <th data-column-id="lembur" data-align="right">LEMBUR</th>
                            <th data-column-id="insjabatan" data-align="right">INSJABATAN</th>
                            <th data-column-id="adjinsjabatan" data-align="right">ADJINSJABATAN</th>
                            <th data-column-id="bpjs" data-align="right">BPJS</th>
                            <th data-column-id="dplk" data-align="right">DPLK</th>
                            <th data-column-id="jkk" data-align="right">JKK</th>
                            <th data-column-id="jht" data-align="right">JHT</th>
                            <th data-column-id="jkm" data-align="right">JKM</th>
                            <th data-column-id="bpjsjp" data-align="right">BPJSJP</th>
                            <th data-column-id="rapelbpjsjp" data-align="right">RAPELBPJSJP</th>
                            <th data-column-id="posaskedir" data-align="right">POSASKEDIR</th>
                            <th data-column-id="kopeg" data-align="right">KOPEG</th>
                            <th data-column-id="sumb" data-align="right">SUMB</th>
                            <th data-column-id="taspen" data-align="right">TASPEN</th>
                            <th data-column-id="rapeltaspen" data-align="right">RAPELTASPEN</th>
                            <th data-column-id="others" data-align="right">OTHERS</th>
                            <th data-column-id="totalsalary" data-align="right">TOTALSALARY</th>
                            <th data-column-id="idloker">IDLOKER</th>
                            <th data-column-id="idposisi">IDPOSISI</th>
                            <th data-column-id="ketarea">KETAREA</th>
                            <th data-column-id="cfucode">CFUCODE</th>
                            <th data-column-id="ubiscode">UBISCODE</th>
                            <th data-column-id="idactivity">IDACTIVITY</th>
                        </tr>
                        </thead>
                    </table>
                </div>

                <div class="row" id="btn-group-payroll-action" style="display:none;">
                    <div class="col-xs-4"></div>
                    <div class="col-xs-6">
                        <input type="hidden" id="temp_i_process_control_id">
                        <input type="hidden" id="temp_processcode">

                        <input type="hidden" id="temp_periodid_fk">
                        <input type="hidden" id="temp_cfucode">
                        <input type="hidden" id="temp_ubiscode">
                        <input type="hidden" id="temp_idactivity">
                    </div>
                </div>
            </div>

            <!-- modal footer -->
            <div class="modal-footer no-margin-top">
                <div class="bootstrap-dialog-footer">
                    <div class="bootstrap-dialog-footer-buttons">
                        <button class="btn btn-danger btn-sm radius-4" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.end modal -->


<script>
    function doProcess() {
            var processcode = $('#temp_processcode').val();
            var i_process_control_id = $('#temp_i_process_control_id').val();

            var ajaxOptions = {
                url: '<?php echo WS_JQGRID."transaksi.tblt_payrollcost_controller/do_process"; ?>',
                type: "POST",
                dataType: "json",
                data: { i_process_control_id:i_process_control_id,
                        processcode : processcode },
                success: function (data) {
                    if(data.success == true) {
                        swal('Success',data.message,'success');
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
                        text: 'Anda yakin ingin men-submit proses '+ processcode +'?',
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

    function cancelProcess() {
            var processcode = $('#temp_processcode').val();
            var i_process_control_id = $('#temp_i_process_control_id').val();

            var ajaxOptions = {
                url: '<?php echo WS_JQGRID."transaksi.tblt_payrollcost_controller/cancel_process"; ?>',
                type: "POST",
                dataType: "json",
                data: { i_process_control_id:i_process_control_id },
                success: function (data) {
                    if(data.success == true) {
                        swal('Success',data.message,'success');
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
                        text: 'Anda yakin ingin membatalkan proses?',
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

    function downloadSummary() {

            var periodid_fk = $('#temp_periodid_fk').val();
            var cfucode = $('#temp_cfucode').val();
            var ubiscode = $('#temp_ubiscode').val();
            var idactivity = $('#temp_idactivity').val();


            var url = "<?php echo WS_JQGRID . "transaksi.tblt_payrollcost_controller/download_summary/?"; ?>";
            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&periodid_fk="+periodid_fk;
            url += "&cfucode="+cfucode;
            url += "&ubiscode="+ubiscode;
            url += "&idactivity="+idactivity;

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

    function modal_lov_payrollcost_show(isupdatable, periodid_fk, cfucode, ubiscode, idactivity, i_process_control_id, processcode) {
        if(isupdatable == 'Y') {
            $('#btn-group-payroll-action').show();
            $('#temp_i_process_control_id').val(i_process_control_id);
            $('#temp_processcode').val(processcode);
        }else {
            $('#btn-group-payroll-action').hide();
        }

        $('#temp_periodid_fk').val(periodid_fk);
        $('#temp_cfucode').val(cfucode);
        $('#temp_ubiscode').val(ubiscode);
        $('#temp_idactivity').val(idactivity);

        $("#modal_lov_payrollcost").modal({backdrop: 'static'});
        modal_lov_payrollcost_prepare_table(periodid_fk, cfucode, ubiscode, idactivity);
    }

    function modal_lov_payrollcost_prepare_table(periodid_fk, cfucode, ubiscode, idactivity) {
        $("#modal_lov_payrollcost_grid_selection").bootgrid("destroy");
        $("#modal_lov_payrollcost_grid_selection").bootgrid({
             rowCount:[7],
             ajax: true,
             requestHandler:function(request) {
                if(request.sort) {
                    var sortby = Object.keys(request.sort)[0];
                    request.dir = request.sort[sortby];

                    delete request.sort;
                    request.sort = sortby;
                }
                return request;
             },
             responseHandler:function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }
                return response;
             },
             url: '<?php echo WS_BOOTGRID."transaksi.tblt_payrollcost_controller/readLov"; ?>',
             post: {
                 periodid_fk: periodid_fk,
                 cfucode: cfucode,
                 ubiscode: ubiscode,
                 idactivity: idactivity
             },
             selection: true,
             sorting:true
        });

        $('.bootgrid-header span.glyphicon-search').removeClass('glyphicon-search')
        .html('<i class="fa fa-search"></i>');
        $('.bootgrid-header .actionBar').hide();
    }
</script>