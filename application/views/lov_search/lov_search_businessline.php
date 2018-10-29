<div id="modal_lov_search" class="modal fade" tabindex="-1" style="overflow-y: scroll; left: 70%; top: 10%;">
    <div class="modal-dialog" style="width:400px;">
        <div class="modal-content">
            <!-- modal title -->
          <!--   <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Filter </span>
                </div>
            </div> -->

            <!-- modal body -->
            <div class="modal-body">
                <div class="space-1"></div>
                <div class="row">
                    <div class="col-md-3"><label> Model </label></div>
                    <div class="col-md-8">
                        <div class="input-group col-md-12">
                            <select class="FormElement form-control required" id="jenis_lap">                        
                                <option value="1"> YTD </option>
                                <option value="2"> Current Month </option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="space-1"></div>
                <div class="row">
                    <div class="col-md-3"><label> Period </label></div>
                    <div class="col-md-8">
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
    
                </div>
            </div>

            <!-- modal footer -->
            <div class="modal-footer no-margin-top">
                <div class="bootstrap-dialog-footer">
                    <div class="bootstrap-dialog-footer-buttons">
                        <button class="btn btn-primary btn-sm radius-4" type="button" onclick="showData()">
                            <i class="fa fa-search"></i>
                            Search
                        </button>
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
    function modal_lov_search_show() {
        // $("#modal_lov_search").modal('toggle', {keyboard: false, backdrop: false});
        $("#modal_lov_search").modal('toggle');
        // modal_lov_search_prepare_table();
    }

</script>

<?php $this->load->view('lov/lov_period'); ?>

<script>
/**
 * [showLOVPeriod called by input menu_icon to show List Of Value (LOV) of icon]
 * @param  {[type]} id   [description]
 * @param  {[type]} code [description]
 * @return {[type]}      [description]
 */
function showLOVPeriod(id, code) {
    modal_lov_period_show(id, code);
}

</script>