<div id="modal_lov_seg_activity" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog" style="width:900px;">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Data Activity Group</span>
                </div>
            </div>
            <input type="hidden" id="modal_lov_seg_activity_id_val" value="" />
            <input type="hidden" id="modal_lov_seg_activity_code_val" value="" />
            <input type="hidden" id="modal_lov_seg_activity_name_val" value="" />
            <input type="hidden" id="modal_lov_seg_activity_pl_val" value="" />
            <input type="hidden" id="modal_lov_seg_activity_cost_val" value="" />

            <!-- modal body -->
            <div class="modal-body">
                <div>
                  <button type="button" class="btn btn-sm btn-success" id="modal_lov_seg_activity_btn_blank">
                    <span class="fa fa-pencil-square-o bigger-110" aria-hidden="true"></span> BLANK
                  </button>
                </div>
                <table id="modal_lov_seg_activity_grid_selection" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>                    
                     <th data-column-id="segregationotherid_pk" data-sortable="false" data-visible="false">ID</th>
                     <th data-header-align="center" data-align="center" data-formatter="opt-edit" data-sortable="false" data-width="100">Options</th>
                     <th data-column-id="activitygroupcode" data-sortable="false" data-width="180">Activity Group Code</th>
                     <th data-column-id="activityname" >Activity</th>
                     <th data-column-id="plitemname">PL Item</th>
                     <th data-column-id="costdrivercode">Cost Driver</th>
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
        $("#modal_lov_seg_activity_btn_blank").on('click', function() {
            $("#"+ $("#modal_lov_seg_activity_id_val").val()).val("");
            $("#"+ $("#modal_lov_seg_activity_code_val").val()).val("");
            $("#"+ $("#modal_lov_seg_activity_name_val").val()).val("");
            $("#"+ $("#modal_lov_seg_activity_pl_val").val()).val("");
            $("#"+ $("#modal_lov_seg_activity_cost_val").val()).val("");
            $("#modal_lov_seg_activity").modal("toggle");
        });
    });

    function modal_lov_seg_activity_show(the_id_field, the_code_field, the_name_field, the_pl_field, the_cost_field, ubiscode) {
        modal_lov_seg_activity_set_field_value(the_id_field, the_code_field, the_name_field, the_pl_field, the_cost_field);
        $("#modal_lov_seg_activity").modal({backdrop: 'static'});
        modal_lov_seg_activity_prepare_table(ubiscode);
    }


    function modal_lov_seg_activity_set_field_value(the_id_field, the_code_field, the_name_field, the_pl_field, the_cost_field) {
         $("#modal_lov_seg_activity_id_val").val(the_id_field);
         $("#modal_lov_seg_activity_code_val").val(the_code_field);
         $("#modal_lov_seg_activity_name_val").val(the_name_field);
         $("#modal_lov_seg_activity_pl_val").val(the_pl_field);
         $("#modal_lov_seg_activity_cost_val").val(the_cost_field);
    }

    function modal_lov_seg_activity_set_value(the_id_val, the_code_val, the_name_field, the_pl_field, the_cost_field) {
         $("#"+ $("#modal_lov_seg_activity_id_val").val()).val(the_id_val);
         $("#"+ $("#modal_lov_seg_activity_code_val").val()).val(the_code_val);
         $("#"+ $("#modal_lov_seg_activity_name_val").val()).val(the_name_field);
         $("#"+ $("#modal_lov_seg_activity_pl_val").val()).val(the_pl_field);
         $("#"+ $("#modal_lov_seg_activity_cost_val").val()).val(the_cost_field);
         $("#modal_lov_seg_activity").modal("toggle");

         $("#"+ $("#modal_lov_seg_activity_id_val").val()).change();
         $("#"+ $("#modal_lov_seg_activity_code_val").val()).change();
         $("#"+ $("#modal_lov_seg_activity_name_val").val()).change();
         $("#"+ $("#modal_lov_seg_activity_pl_val").val()).change();
         $("#"+ $("#modal_lov_seg_activity_cost_val").val()).change();
    }

    function modal_lov_seg_activity_prepare_table(ubiscode) {
        $("#modal_lov_seg_activity_grid_selection").bootgrid("destroy");
        $("#modal_lov_seg_activity_grid_selection").bootgrid({
             formatters: {
                "opt-edit" : function(col, row) {
                    return '<a href="javascript:;" title="Set Value" onclick="modal_lov_seg_activity_set_value(\''+ row.segregationotherid_pk +'\', \''+ row.activitygroupcode +'\', \''+ row.activityname +'\', \''+ row.plitemname +'\', \''+ row.costdrivercode +'\')" class="blue"><i class="fa fa-pencil-square-o bigger-130"></i></a>';
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
             url: '<?php echo WS_BOOTGRID."parameter.seg_activity_controller/readLov"; ?>',
             post: {
                 ubiscode : ubiscode
             },
             selection: true,
             sorting:true
        });

        $('.bootgrid-header span.glyphicon-search').removeClass('glyphicon-search')
        .html('<i class="fa fa-search"></i>');
    }
</script>