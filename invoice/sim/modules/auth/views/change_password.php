<!-- Errors -->
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
  <?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=auth&view=change_password");?>
<div class="form-group">
  <label for="old_password"><?php echo $this->lang->line("old_pw"); ?></label>
  <div class="controls"> <?php echo form_input($old_password , '', 'class="form-control" id="old_password"');?> </div>
</div>
<div class="form-group">
  <label for="new_password"><?php echo $this->lang->line("new_pw"); ?></label>
  <div class="controls"> <?php echo form_input($new_password , '', 'class="form-control" id="new_password"');?> </div>
</div>
<div class="form-group">
  <label for="new_password_confirm"><?php echo $this->lang->line("confirm_pw"); ?></label>
  <div class="controls"> <?php echo form_input($new_password_confirm , '', 'class="form-control" id="new_password_confirm"');?> </div>
</div>
<?php echo form_input($user_id);?>
<div class="form-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("change_password"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
<div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
