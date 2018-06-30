<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Process</a>
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
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true">
                        <i class="blue"></i>
                        <strong> Indirect Cost Segregation </strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-othersegregation">
                        <i class="blue"></i>
                        <strong> Other Segregation</strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-2">
                        <i class="blue"></i>
                        <strong> Process Summary </strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-3">
                        <i class="blue"></i>
                        <strong> Process Log </strong>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content no-border">
            <div class="space-4"></div>

            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-primary" type="button" id="btn-back" onclick="backToProcessControl()"><i class="fa fa-arrow-left"></i> Kembali Process Control</button>
                </div>
            </div>

            <h3> <?php echo 'Indirect Cost Segregation'.' ('.$this->input->post('periodid_fk').')'; ?></h3>

            <div class="row">
            <label class="control-label col-md-2">Pencarian :</label>
            <div class="col-md-3">
                <div class="input-group">
                    <input id="search_wibunitbusinessid_pk" type="text"  style="display:none;">
                    <input id="search_wibunitbusinessname" type="text" style="display:none;" class="FormElement form-control" placeholder="Business Unit Name">
                    <input id="search_wibunitbusinesscode" type="text" class="FormElement form-control" placeholder="Business Unit" onchange="showData();">
                    <span class="input-group-btn">
                        <button class="btn btn-success" type="button" onclick="showLOVBusinessUnit('search_wibunitbusinessid_pk','search_wibunitbusinesscode','search_wibunitbusinessname')">
                            <span class="fa fa-search bigger-110"></span>
                        </button>
                    </span>
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
            <div class="row">
                <div class="col-xs-12 table-responsive">
                   <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th rowspan="2">Activity</th>
                                <th rowspan="2">PL Item</th>
                                <th rowspan="2">Amount</th>
                                <th rowspan="2">Cost Driver</th>
                                <th colspan="7" style="text-align:center;">Cost Driver</th>
                                <th colspan="7" style="text-align:center;">Cost Driver Proportion</th>
                                <th colspan="7" style="text-align:center;">After Segregation</th>
                            </tr>
                            <tr>
                                <th>Dom Traffic</th>
                                <th>Dom Network</th>
                                <th>Intl Traffic</th>
                                <th>Intl Network</th>
                                <th>Intl Adjacent</th>
                                <th>Tower</th>
                                <th>Infrastructure</th>

                                <th>Dom Traffic</th>
                                <th>Dom Network</th>
                                <th>Intl Traffic</th>
                                <th>Intl Network</th>
                                <th>Intl Adjacent</th>
                                <th>Tower</th>
                                <th>Infrastructure</th>

                                <th>Dom Traffic</th>
                                <th>Dom Network</th>
                                <th>Intl Traffic</th>
                                <th>Intl Network</th>
                                <th>Intl Adjacent</th>
                                <th>Tower</th>
                                <th>Infrastructure</th>
                            </tr>
                        </thead>
                        <tbody id="tbl-segregation">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="row" id="btn-group-segregation-action" style="display:none;">
                <div class="col-xs-4"></div>
                <div class="col-xs-6">
                    <button class="btn btn-success" id="btn-process" onclick="doProcess();">Process</button>
                    <button class="btn btn-warning" id="btn-cancel" onclick="cancelProcess();">Cancel Process</button>
                    <button class="btn btn-primary" id="btn-download" onclick="downloadSegregation();">Download</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$("#tab-othersegregation").on("click", function(event) {
    event.stopPropagation();

    loadContentWithParams("transaksi.tblt_segregationother", {
        i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
        periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
        isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
        statuscode : '<?php echo $this->input->post('statuscode'); ?>',
        processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
        processcode : '<?php echo $this->input->post('processcode'); ?>',
        tab_1 : '<?php echo $this->input->post('tab_1'); ?>'
    });

});

$("#tab-2").on("click", function(event) {
    event.stopPropagation();

    loadContentWithParams("transaksi.tblt_processsummary_segregation", {
        i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
        periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
        isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
        statuscode : '<?php echo $this->input->post('statuscode'); ?>',
        processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
        processcode : '<?php echo $this->input->post('processcode'); ?>',
        tab_1 : '<?php echo $this->input->post('tab_1'); ?>'
    });

});


$("#tab-3").on("click", function(event) {
    event.stopPropagation();

    loadContentWithParams("transaksi.tblp_logprocesscontrol_segregation", {
        i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
        periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
        isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
        statuscode : '<?php echo $this->input->post('statuscode'); ?>',
        processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
        processcode : '<?php echo $this->input->post('processcode'); ?>',
        tab_1 : '<?php echo $this->input->post('tab_1'); ?>'
    });
});

</script>


<script>

    function buttonMode(statuscode) {
        var isupdatable = "<?php echo $this->input->post('isupdatable'); ?>";

        if(isupdatable == 'Y') {
            $('#btn-group-segregation-action').show();

            if(statuscode == 'FINISH' || statuscode == 'IN PROGRESS') {
                $('#btn-process').hide();
            }else if(statuscode == 'INITIAL') {
                $('#btn-cancel').hide();
                $('#btn-download').hide();
            }
        }
    }

    function loadForm(statuscode) {
        loadContentWithParams("transaksi.tblt_segregationact", {
            i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
            periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>,
            isupdatable : '<?php echo $this->input->post('isupdatable'); ?>',
            statuscode : statuscode,
            processcontrolid_pk : <?php echo $this->input->post('processcontrolid_pk'); ?>,
            processcode : '<?php echo $this->input->post('processcode'); ?>',
            tab_1 : '<?php echo $this->input->post('tab_1'); ?>'
        });
    }

    $(function() {
        showData();
        var statuscode = "<?php echo $this->input->post('statuscode'); ?>";
        buttonMode(statuscode);
    });
</script>

<?php $this->load->view('lov/lov_tblm_wibunitbusiness'); ?>

<script>
/**
 * [showLOVBusinessUnit called by input menu_icon to show List Of Value (LOV) of icon]
 * @param  {[type]} id   [description]
 * @param  {[type]} code [description]
 * @return {[type]}      [description]
 */
function showLOVBusinessUnit(id, code, name) {
    modal_lov_tblm_wibunitbusiness_show(id, code, name);
}
</script>

<script>
    function backToProcessControl() {
        loadContentWithParams("parameter.tblp_processcontrol", {
            i_batch_control_id : <?php echo $this->input->post('i_batch_control_id'); ?>,
            periodid_fk : <?php echo $this->input->post('periodid_fk'); ?>
        });
    }
</script>

<script>
    function showData(){
        var i_search = $('#i_search').val();
        var ubiscode = $('#search_wibunitbusinesscode').val();

        if(ubiscode == '') {
            $('#tbl-segregation').hide();
            return;
        }
        $('#tbl-segregation').show();

        loadDataTable(i_search, ubiscode);
    }
</script>


<script>

    function loadDataTable(i_search, ubiscode) {
        $( "#tbl-segregation" ).html( 'Loading...');
        $.ajax({
            url: '<?php echo WS_JQGRID."transaksi.tblt_segregationact_controller/readTable"; ?>',
            type: "POST",
            data: {
                i_search : i_search,
                i_process_control_id : <?php echo $this->input->post('processcontrolid_pk'); ?>,
                ubiscode : ubiscode
            },
            success: function (data) {
                $( "#tbl-segregation" ).html( data );
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    }
</script>

<script>

    function doProcess() {
            var processcode = "<?php echo $this->input->post('processcode'); ?>";
            var i_process_control_id = <?php echo $this->input->post('processcontrolid_pk'); ?>;
            var i_batch_control_id =  <?php echo $this->input->post('i_batch_control_id'); ?>;

            var ajaxOptions = {
                url: '<?php echo WS_JQGRID."transaksi.tblt_segregationact_controller/do_process"; ?>',
                type: "POST",
                dataType: "json",
                data: { i_process_control_id:i_process_control_id,
                        processcode : processcode,
                        i_batch_control_id : i_batch_control_id },
                success: function (data) {
                    if(data.success == true) {
                        swal('Success',data.message,'success');
                        loadForm(data.statuscode);
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
            var processcode = "<?php echo $this->input->post('processcode'); ?>";
            var i_process_control_id = <?php echo $this->input->post('processcontrolid_pk'); ?>;
            var i_batch_control_id =  <?php echo $this->input->post('i_batch_control_id'); ?>;

            var ajaxOptions = {
                url: '<?php echo WS_JQGRID."transaksi.tblt_segregationact_controller/cancel_process"; ?>',
                type: "POST",
                dataType: "json",
                data: { i_process_control_id: i_process_control_id,
                             i_batch_control_id: i_batch_control_id},
                success: function (data) {
                    if(data.success == true) {
                        swal('Success',data.message,'success');
                        loadForm(data.statuscode);
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

    function downloadSegregation() {

            var processcontrolid_pk = <?php echo $this->input->post('processcontrolid_pk'); ?>;
            var periodid_fk = <?php echo $this->input->post('periodid_fk'); ?>;
            var ubiscode = $('#search_wibunitbusinesscode').val();

            var url = "<?php echo WS_JQGRID . "transaksi.tblt_segregationact_controller/download_excel/?"; ?>";
            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&processcontrolid_pk="+processcontrolid_pk;
            url += "&periodid_fk="+periodid_fk;
            url += "&ubiscode="+ubiscode;

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