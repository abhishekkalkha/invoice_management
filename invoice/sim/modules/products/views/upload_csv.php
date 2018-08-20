<script src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-fileupload.js"></script>
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-fileupload.css" rel="stylesheet">
    <?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <div class="well well-small"> <a href="<?php echo $this->config->base_url(); ?>assets/uploads/sample_products.csv" class="btn btn-info pull-right"><i class="icon-download icon-white"></i> Download Sample File</a> <span class="text-info">You can import maximum 999 products with single csv file.</span><br /><span class="text-warning"><?php echo $this->lang->line("csv1"); ?></span><br />
      <?php echo $this->lang->line("csv2"); ?> <span class="text-info">(<?php echo $this->lang->line("name"); ?>, <?php echo $this->lang->line("price"); ?>, <?php echo $this->lang->line("tax_rate"); ?>)</span> <?php echo $this->lang->line("csv3"); ?> </div>
    <?php $attrib = array('class' => 'form-horizontal'); echo form_open_multipart("module=products&view=import", $attrib); ?>
    <div class="control-group">
      <label class="control-label" for="csv_file"><?php echo $this->lang->line("upload_file"); ?></label>
      <div class="controls">
        <div class="fileupload fileupload-new" data-provides="fileupload"> <span class="btn btn-file btn-info"><span class="fileupload-new"><?php echo $this->lang->line("select_file"); ?></span><span class="fileupload-exists"><?php echo $this->lang->line("change"); ?></span>
          <input type="file" name="userfile" id="csv_file" onchange="checkfile(this);" required="required" data-error="<?php echo $this->lang->line("select_file")." ".$this->lang->line("is_required"); ?>" />
          </span> <span class="fileupload-preview"></span> <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a> </div>
      </div>
    </div>
    <div class="control-group">
      <div class="controls"> <?php echo form_submit('submit', $this->lang->line("add_products"), 'class="btn btn-primary"');?> </div>
    </div>
    <?php echo form_close();?>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
