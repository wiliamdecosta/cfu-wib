<div id="modal_lov_tblm_costdriver" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog" style="width:1200px;">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Data Cost Driver</span>
                </div>
            </div>
            <input type="hidden" id="modal_lov_tblm_costdriver_id_val" value="" />
            <input type="hidden" id="modal_lov_tblm_costdriver_code_val" value="" />

            <!-- modal body -->
            <div class="modal-body">
                <div>
                  <button type="button" class="btn btn-sm btn-success" id="modal_lov_tblm_costdriver_btn_blank">
                    <span class="fa fa-pencil-square-o bigger-110" aria-hidden="true"></span> BLANK
                  </button>
                </div>

                <table id="modal_lov_tblm_costdriver_grid_selection" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                     <th data-column-id="costdriverid_pk" data-sortable="false" data-visible="false">ID Cost Driver</th>
                     <th data-header-align="center" data-align="center" data-formatter="opt-edit" data-sortable="false" data-width="100">Options</th>
                     <th data-column-id="code" data-width="150">Code</th>
                     <th data-column-id="ubiscode" data-width="150">BU/Subsidiary</th>
                     <th data-column-id="unitname" data-width="200">Unit</th>
                     <th data-header-align="right" data-column-id="domtrafficvalue">Dom Traffic</th>
                     <th data-header-align="right" data-column-id="domnetworkvalue">Dom Network</th>
                     <th data-header-align="right" data-column-id="intltrafficvalue">Intl Traffic</th>
                     <th data-header-align="right" data-column-id="intlnetworkvalue">Intl Network</th>
                     <th data-header-align="right" data-column-id="intladjacentvalue">Intl Adjacent</th>
                     <th data-header-align="right" data-column-id="towervalue">Tower</th>
                     <th data-header-align="right" data-column-id="infravalue">Infra</th>
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
        $("#modal_lov_tblm_costdriver_btn_blank").on('click', function() {
            $("#"+ $("#modal_lov_tblm_costdriver_id_val").val()).val("");
            $("#"+ $("#modal_lov_tblm_costdriver_code_val").val()).val("");
            $("#modal_lov_tblm_costdriver").modal("toggle");
        });
    });

    function modal_lov_tblm_costdriver_show(the_id_field, the_code_field, ubiscode = '') {
        modal_lov_tblm_costdriver_set_field_value(the_id_field, the_code_field);
        $("#modal_lov_tblm_costdriver").modal({backdrop: 'static'});
        modal_lov_tblm_costdriver_prepare_table(ubiscode);
    }


    function modal_lov_tblm_costdriver_set_field_value(the_id_field, the_code_field) {
         $("#modal_lov_tblm_costdriver_id_val").val(the_id_field);
         $("#modal_lov_tblm_costdriver_code_val").val(the_code_field);
    }

    function modal_lov_tblm_costdriver_set_value(the_id_val, the_code_val) {
         $("#"+ $("#modal_lov_tblm_costdriver_id_val").val()).val(the_id_val);
         $("#"+ $("#modal_lov_tblm_costdriver_code_val").val()).val(the_code_val);
         $("#modal_lov_tblm_costdriver").modal("toggle");

         $("#"+ $("#modal_lov_tblm_costdriver_id_val").val()).change();
         $("#"+ $("#modal_lov_tblm_costdriver_code_val").val()).change();
    }

    function modal_lov_tblm_costdriver_prepare_table(ubiscode) {
        $("#modal_lov_tblm_costdriver_grid_selection").bootgrid('destroy');
        $("#modal_lov_tblm_costdriver_grid_selection").bootgrid({
             formatters: {
                "opt-edit" : function(col, row) {
                    return '<a href="javascript:;" title="Set Value" onclick="modal_lov_tblm_costdriver_set_value(\''+ row.costdriverid_pk +'\', \''+ row.code +'\')" class="blue"><i class="fa fa-pencil-square-o bigger-130"></i></a>';
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
             url: '<?php echo WS_BOOTGRID."parameter.tblm_costdriver_controller/readLov"; ?>',
             post: {
                 ubiscode: ubiscode
             },
             selection: true,
             sorting:true
        });

        $('.bootgrid-header span.glyphicon-search').removeClass('glyphicon-search')
        .html('<i class="fa fa-search"></i>');
    }
</script>