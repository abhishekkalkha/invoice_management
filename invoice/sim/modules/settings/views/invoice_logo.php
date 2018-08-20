<script src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-fileupload.js"></script>
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-fileupload.css" rel="stylesheet">
<!-- Errors -->
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <?php $attrib = array('class' => 'form-horizontal'); echo form_open_multipart("module=settings&view=change_invoice_logo");?>
  <div class="control-group">
    <label class="form-label" for="copy"><?php echo $this->lang->line("upload_logo"); ?></label>
    <div class="controls">
      <div class="fileupload fileupload-new" data-provides="fileupload">
        <div class="input-append">
          <div class="uneditable-input span2"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div>
          <span class="btn btn-file btn-info"><span class="fileupload-new"><?php echo $this->lang->line("select_file"); ?></span><span class="fileupload-exists"><?php echo $this->lang->line("change"); ?></span>
          <input type="file" name="logo" />
          </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?php echo $this->lang->line("remove"); ?></a> </div>
      </div>
      <span class="help-block"><?php echo $this->lang->line("invoice_logo_tip"); ?></span> </div>
  </div>
  <div class="control-group">
    <div class="controls"> <?php echo form_submit('submit', $this->lang->line("upload_logo"), 'class="btn btn-primary"');?> </div>
  </div>
  <?php echo form_close();?>
  <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
