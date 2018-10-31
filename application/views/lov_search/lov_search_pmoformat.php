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


                <div class="space-1"></div>
                <div class="row">
                    <div class="col-md-3"><label> Budget </label></div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input id="search_budgetversion" type="text" class="FormElement form-control required" placeholder="Budget Version">
                            <span class="input-group-btn">
                                <input id="search_twibbudgetid_pk" style="display:none;" type="text" class="FormElement form-control" placeholder="Status">
                                <button class="btn btn-success" type="button" onclick="showLOVBudget('search_twibbudgetid_pk','search_budgetversion')">
                                    <span class="fa fa-search bigger-110"></span>
                                </button>
                            </span>
                        </div>
                    </div>
    
                </div>

                <div class="space-1"></div>
                <div class="row">                    
                    <div class="col-md-3"><label> Bus Line </label></div>
                    <div class="col-md-8">
                        <div class="input-group col-md-12">
                            <select class="FormElement form-control required" id="search_business_line">                        
                                <option value="0"> ALL </option>
                                <option value="1"> Carrier </option>
                                <option value="2"> International Adjacent </option>
                                <option value="3"> Towers </option>
                                <option value="4"> Infrastructure </option>
                            </select>
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

<?php $this->load->view('lov/lov_tblt_wibbudget'); ?>
<?php $this->load->view('lov/lov_period'); ?>
<script>
/**
 * [showLOVPeriod called by input menu_icon to show List Of Value (LOV) of icon]
 * @param  {[type]} id   [description]
 * @param  {[type]} code [description]
 * @return {[type]}      [description]
 */
function showLOVBudget(id, code) {
    modal_lov_tblt_wibbudget_show(id, code);
}

function showLOVPeriod(id, code) {
        modal_lov_period_show(id, code);
    }
</script>