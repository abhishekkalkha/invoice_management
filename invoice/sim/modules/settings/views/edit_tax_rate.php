<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("update_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=settings&view=edit_tax_rate&id=".$id);?>
    <div class="form-group"> <labelfor="title"><?php echo $this->lang->line("title"); ?>
      </label>
      <div class="controls"> <?php echo form_input('name', $tax_rate->name, 'id="title" class="form-control"');?> </div>
    </div>
    <div class="form-group">
      <label for="type"><?php echo $this->lang->line("rate"); ?></label>
      <div class="controls controls-row"> <?php echo form_input('rate', $tax_rate->rate, 'class="form-control"'); ?> </div>
    </div>
    <div class="form-group">
      <label for="type"><?php echo $this->lang->line("type"); ?></label>
      <div class="controls controls-row">
        <?php 
      $type = array ('' => $this->lang->line("select").' '.$this->lang->line("type"), '1' => $this->lang->line("percenage").' (%)', '2' => $this->lang->line("fixed").' ($)');
		echo form_dropdown('type', $type, $tax_rate->type, 'class="form-control"'); ?>
      </div>
    </div>
    <div class="control-group">
      <div class="controls"> <?php echo form_submit('submit', $this->lang->line("update_tax_rate"), 'class="btn btn-primary"');?> </div>
    </div>
    <?php echo form_close();?>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
