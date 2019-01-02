<script type="text/javascript" src="<?php echo JS_URL; ?>designations/index.js"></script>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            
            <div class="col-sm-8">
                <h4 class="page-title">Designations</h4>
            </div>
            <div class="col-sm-4 text-right m-b-30">
                <a href="#" class="btn btn-primary rounded" data-toggle="modal" data-target="#add_designation"><i class="fa fa-plus"></i> Add New designation</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <table class="table table-striped custom-table m-b-0 datatable" id="designations">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Designation Title</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name='csrf_token_hash' id="csrf_token_hash" value="<?php echo $this->security->get_csrf_hash(); ?>">
</div>

<div id="add_designation" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content modal-md">
            <div id='validation_msg'></div>
            <div class="modal-header">
                <h4 class="modal-title">Add Designation</h4>
            </div>
            <?php echo form_open("", array("action" => '', "name" => "frm_add_designation", "id" => "frm_add_designation", "method" => "post")); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label>Designation Title <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" id="title" name="title">
                </div>
              
                <div class="m-t-20 text-center">
                    <input type='button' value="create designation" class="btn btn-primary" onclick="add_designation();">
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div id="edit_designation" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content modal-md">
            <div id='validation_msg_edit'></div>
            <div class="modal-header">
                <h4 class="modal-title">Edit Designation</h4>
            </div>
            <?php echo form_open("", array("action" => '', "name" => "frm_edit_designation", "id" => "frm_edit_designation", "method" => "post")); ?>
            <div class="modal-body">
                <div class="form-group">
					
                    <label>Designationt Title <span class="text-danger">*</span></label>
					<input type="hidden" name="designation_id" id="designation_id_edit">
                    <input class="form-control" type="text" id="title_edit" name="title">
                </div>
                
                <div class="m-t-20 text-center">
                    <input type='button' value="Save designation" class="btn btn-primary" onclick="edit_designation();">
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
			
<script>
//    $(document).ready(function () {
//        showdesignations('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
//    });
</script>