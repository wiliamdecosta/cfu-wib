<div id="modal_lov_show_detil_batchcontrol" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="width:700px;">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Data Batch Control</span>
                </div>
            </div>

            <!-- modal body -->
            <div class="modal-body" style="height:400px; overflow-y: scroll;">
                <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Period</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="detil_periodid_fk" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Period Code</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="detil_periodidcode" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Process Category</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="detil_processcategorycode" readonly="">
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label">Group Code</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="detil_groupcode" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Batch Status</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="detil_statuscode" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="detil_description" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Creation Date</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="detil_creationdate" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Created By</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="detil_createdby" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Last Updated Date</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="detil_updateddate" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Last Updated By</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="detil_updatedby" readonly="">
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

    function modal_lov_show_detil_batchcontrol_show(record) {
        modal_lov_show_detil_batchcontrol_set_field_value(record);
        $("#modal_lov_show_detil_batchcontrol").modal({backdrop: 'static'});
    }


    function modal_lov_show_detil_batchcontrol_set_field_value(record) {
        $('#detil_periodid_fk').val( record['periodid_fk'] );
        $('#detil_periodidcode').val( record['periodcode'] );
        $('#detil_processcategorycode').val( record['processcategorycode'] );
        $('#detil_groupcode').val( record['groupcode'] );
        $('#detil_statuscode').val( record['statuscode'] );
        $('#detil_description').val( record['description'] );
        $('#detil_creationdate').val( record['creationdate'] );
        $('#detil_createdby').val( record['createdby'] );
        $('#detil_updateddate').val( record['updateddate'] );
        $('#detil_updatedby').val( record['updatedby'] );
    }


</script>