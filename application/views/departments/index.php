<script type="text/javascript" src="<?php echo JS_URL; ?>departments/index.js"></script>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            
            <div class="col-sm-8">
                <h4 class="page-title">Department</h4>
            </div>
            <div class="col-sm-4 text-right m-b-30">
                <a href="#" class="btn btn-primary rounded" data-toggle="modal" data-target="#add_department"><i class="fa fa-plus"></i> Add New Department</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <table class="table table-striped custom-table m-b-0 datatable" id="departments">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Department Title</th>
                                <th>Sub Title Title</th>
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

<div id="add_department" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content modal-md">
            <div id='validation_msg'></div>
            <div class="modal-header">
                <h4 class="modal-title">Add Department</h4>
            </div>
            <?php echo form_open("", array("action" => '', "name" => "frm_add_department", "id" => "frm_add_department", "method" => "post")); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label>Department Title <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" id="title" name="title">
                </div>

                <div class="form-group">
                    <label>Department Sub-title <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" id="sub_title" name="sub_title">
                </div>
                <div class="m-t-20 text-center">
                    <input type='button' value="create department" class="btn btn-primary" onclick="add_department();">
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div id="edit_department" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content modal-md">
            <div id='validation_msg_edit'></div>
            <div class="modal-header">
                <h4 class="modal-title">Edit Department</h4>
            </div>
            <?php echo form_open("", array("action" => '', "name" => "frm_edit_department", "id" => "frm_edit_department", "method" => "post")); ?>
            <div class="modal-body">
                <div class="form-group">
					
                    <label>Department Title <span class="text-danger">*</span></label>
					<input type="hidden" name="department_id" id="department_id_edit">
                    <input class="form-control" type="text" id="title_edit" name="title">
                </div>

                <div class="form-group">
                    <label>Department Sub-title <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" id="sub_title_edit" name="sub_title">
                </div>
                <div class="m-t-20 text-center">
                    <input type='button' value="Save department" class="btn btn-primary" onclick="edit_department();">
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
			
<script>
//    $(document).ready(function () {
//        showDepartments('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
//    });
</script>