<?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>



<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">


   	<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=products&view=add");?>

<div class="form-group">
  <label for="name"><?php echo $this->lang->line("name"); ?></label>
  <div class="controls"> <?php echo form_input('name', '', 'class="form-control" id="name"');?>
  </div>
</div> 
<div class="form-group">
  <label for="price"><?php echo $this->lang->line("price"); ?></label>
  <div class="controls"> <?php echo form_input('price', '', 'class="form-control" id="price"');?>
  </div>
</div> 
<div class="form-group">
      <label for="tax_rate"><?php echo $this->lang->line("tax_rate"); ?></label>
      <div class="controls">
        <?php 
	  foreach($tax_rates as $rate){
    		$tr[$rate->id] = $rate->name;
		}
		
		echo form_dropdown('tax_rate', $tr, '', 'class="form-control" id"tax_rate"'); ?>
      </div>
    </div>

<div class="form-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("add_product"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
   
   <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
