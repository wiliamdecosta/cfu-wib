<div id="modal_lov_tblm_costdriverentry" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog" style="width:1200px;">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Data Cost Driver</span>
                </div>
            </div>
            <input type="hidden" id="modal_lov_tblm_costdriverentry_codecostdriver_val" value="" />
            <input type="hidden" id="modal_lov_tblm_costdriverentry_ubiscode_val" value="" />
            <input type="hidden" id="modal_lov_tblm_costdriverentry_unitidfk_val" value="" />
            <input type="hidden" id="modal_lov_tblm_costdriverentry_unitcode_val" value="" />

            <!-- modal body -->
            <div class="modal-body">
                <div>
                  <button type="button" class="btn btn-sm btn-success" id="modal_lov_tblm_costdriverentry_btn_blank">
                    <span class="fa fa-pencil-square-o bigger-110" aria-hidden="true"></span> BLANK
                  </button>
                </div>

                <table id="modal_lov_tblm_costdriverentry_grid_selection" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                     <th data-column-id="costdriverid_pk" data-sortable="false" data-visible="false">ID Cost Driver</th>
                     <th data-header-align="center" data-align="center" data-formatter="opt-edit" data-sortable="false" data-width="100">Options</th>
                     <th data-column-id="code" data-width="300">Cost Driver</th>
                     <th data-column-id="ubiscode" data-width="150">BU/Subsidiary</th>
                     <th data-column-id="unitid_fk" data-visible="false">UnitID_FK</th>
                     <th data-column-id="unitcode" data-width="150">Unit Code</th>
                  </tr>
                </thead>
                </table>

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
    $(function($) {
        $("#modal_lov_tblm_costdriverentry_btn_blank").on('click', function() {
            $("#"+ $("#modal_lov_tblm_costdriverentry_codecostdriver_val").val()).val("");
            $("#"+ $("#modal_lov_tblm_costdriverentry_ubiscode_val").val()).val("");
            $("#"+ $("#modal_lov_tblm_costdriverentry_unitidfk_val").val()).val("");
            $("#"+ $("#modal_lov_tblm_costdriverentry_unitcode_val").val()).val("");

            $("#modal_lov_tblm_costdriverentry").modal("toggle");
        });
    });

    function modal_lov_tblm_costdriverentry_show(costdriver, ubiscode, unitidfk, unitcode, costdrivertype) {
        modal_lov_tblm_costdriverentry_set_field_value(costdriver, ubiscode, unitidfk, unitcode);
        $("#modal_lov_tblm_costdriverentry").modal({backdrop: 'static'});
        modal_lov_tblm_costdriverentry_prepare_table(costdrivertype);
    }


    function modal_lov_tblm_costdriverentry_set_field_value(costdriver, ubiscode, unitidfk, unitcode) {
         $("#modal_lov_tblm_costdriverentry_codecostdriver_val").val(costdriver);
         $("#modal_lov_tblm_costdriverentry_ubiscode_val").val(ubiscode);
         $("#modal_lov_tblm_costdriverentry_unitidfk_val").val(unitidfk);
         $("#modal_lov_tblm_costdriverentry_unitcode_val").val(unitcode);
    }

    function modal_lov_tblm_costdriverentry_set_value(costdriver, ubiscode, unitidfk, unitcode) {
         $("#"+ $("#modal_lov_tblm_costdriverentry_codecostdriver_val").val()).val(costdriver);
         $("#"+ $("#modal_lov_tblm_costdriverentry_ubiscode_val").val()).val(ubiscode);
         $("#"+ $("#modal_lov_tblm_costdriverentry_unitidfk_val").val()).val(unitidfk);
         $("#"+ $("#modal_lov_tblm_costdriverentry_unitcode_val").val()).val(unitcode);
         $("#modal_lov_tblm_costdriverentry").modal("toggle");

         $("#"+ $("#modal_lov_tblm_costdriverentry_codecostdriver_val").val()).change();
         $("#"+ $("#modal_lov_tblm_costdriverentry_ubiscode_val").val()).change();
         $("#"+ $("#modal_lov_tblm_costdriverentry_unitidfk_val").val()).change();
         $("#"+ $("#modal_lov_tblm_costdriverentry_unitcode_val").val()).change();
    }

    function modal_lov_tblm_costdriverentry_prepare_table(costdrivertype) {
        $("#modal_lov_tblm_costdriverentry_grid_selection").bootgrid('destroy');
        $("#modal_lov_tblm_costdriverentry_grid_selection").bootgrid({
             formatters: {
                "opt-edit" : function(col, row) {
                    return '<a href="javascript:;" title="Set Value" onclick="modal_lov_tblm_costdriverentry_set_value(\''+ row.code +'\', \''+ row.ubiscode +'\', \''+ row.unitid_fk +'\', \''+ row.unitcode +'\')" class="blue"><i class="fa fa-pencil-square-o bigger-130"></i></a>';
                }
             },
             rowCount:[5,10],
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
             url: '<?php echo WS_BOOTGRID."parameter.tblm_costdriver_controller/readLovCostDriverEntry"; ?>',
             post: {
                 costdrivertype: costdrivertype
             },
             selection: true,
             sorting:true
        });

        $('.bootgrid-header span.glyphicon-search').removeClass('glyphicon-search')
        .html('<i class="fa fa-search"></i>');
    }
</script>