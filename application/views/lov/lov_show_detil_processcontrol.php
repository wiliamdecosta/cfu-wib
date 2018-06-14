<div id="modal_lov_show_detil_processcontrol" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="width:700px;">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Data Process Control</span>
                </div>
            </div>

            <!-- modal body -->
            <div class="modal-body" style="height:400px; overflow-y: scroll;">
                <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Process Group</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="detil_processtypecode" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Process</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="detil_processcode" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Process Status</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="detil_statuscode" readonly="">
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label">Verified?</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="detil_isverified" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Valid?</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="detil_isvalid" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Verified By</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="detil_verifiedby" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Verification Date</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="detil_verificationdate" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Procedure Name</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="detil_procedurename" readonly="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Pasing Parameter</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="detil_procedureparam" readonly="">
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

    function modal_lov_show_detil_processcontrol_show(record) {
        modal_lov_show_detil_processcontrol_set_field_value(record);
        $("#modal_lov_show_detil_processcontrol").modal({backdrop: 'static'});
    }


    function modal_lov_show_detil_processcontrol_set_field_value(record) {
        $('#detil_processtypecode').val( record['processtypecode'] );
        $('#detil_processcode').val( record['processcode'] );
        $('#detil_statuscode').val( record['statuscode'] );
        $('#detil_isverified').val( record['isverified'] );
        $('#detil_isvalid').val( record['isvalid'] );
        $('#detil_verifiedby').val( record['verifiedby'] );
        $('#detil_verificationdate').val( record['verificationdate'] );
        $('#detil_procedurename').val( record['procedurename'] );
        $('#detil_procedureparam').val( record['procedureparam'] );

        $('#detil_description').val( record['description'] );
        $('#detil_creationdate').val( record['creationdate'] );
        $('#detil_createdby').val( record['createdby'] );
        $('#detil_updateddate').val( record['updateddate'] );
        $('#detil_updatedby').val( record['updatedby'] );

    }


</script>