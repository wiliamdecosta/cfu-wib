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
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-1">
                        <i class="blue"></i>
                        <strong> Staff Comp Map </strong>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" data-toggle="tab" aria-expanded="true" id="tab-2">
                        <i class="blue"></i>
                        <strong> Process Summary </strong>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content no-border">
            <div class="space-4"></div>

            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-primary" type="button" id="btn-back" onclick="backToProcessControl()"><i class="fa fa-arrow-left"></i> Kembali </button>
                </div>
            </div>

            <h3> <?php echo $this->input->post('processcode').' ('.$this->input->post('periodid_fk').')'; ?></h3>

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
                   <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>CFU</th>
                                <th>BU/Subsidiary</th>
                                <th>Indirect Cost Activities</th>
                                <th>No of Staff</th>
                                <th>% of Total Staff</th>
                                <th>Total Compensation</th>
                                <th>% of Total Compensation</th>
                            </tr>
                        </thead>
                        <tbody id="tbl-staffcompmap">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('lov/lov_payrollcost'); ?>

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
        loadDataTable(i_search);
    }
</script>

<script>
        function showIndirectCostActivitiesDetail(periodid_fk, cfucode, ubiscode, idactivity) {
            var isupdatable = '<?php echo $this->input->post('isupdatable'); ?>';
            var i_process_control_id = '<?php echo $this->input->post('processcontrolid_pk'); ?>';
            var processcode =  '<?php echo $this->input->post('processcode'); ?>';
            modal_lov_payrollcost_show(isupdatable, periodid_fk, cfucode, ubiscode, idactivity, i_process_control_id, processcode);
        }
</script>

<script>

    function loadDataTable(i_search) {
        $( "#tbl-staffcompmap" ).html( 'Loading...');
        $.ajax({
            url: '<?php echo WS_JQGRID."transaksi.tblt_staffcompmap_controller/readTable"; ?>',
            type: "POST",
            data: {
                i_search : i_search,
                i_process_control_id : <?php echo $this->input->post('processcontrolid_pk'); ?>
            },
            success: function (data) {
                $( "#tbl-staffcompmap" ).html( data );
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    }
</script>

<script>
    $(function() {
        loadDataTable('');
    });
</script>