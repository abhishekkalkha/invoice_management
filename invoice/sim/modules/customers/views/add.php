<?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>



<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">


   	<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=customers&view=add");?>

<div class="form-group">
  <label for="name"><?php echo $this->lang->line("name"); ?></label>
  <div class="controls"> <?php echo form_input($name, '', 'class="form-control" id="name"');?>
  </div>
</div> 
<div class="form-group">
  <label for="email_address"><?php echo $this->lang->line("email_address"); ?></label>
  <div class="controls"> <?php echo form_input($email, '', 'class="form-control" id="email_address"');?>
  </div>
</div> 
<div class="form-group">
  <label for="phone"><?php echo $this->lang->line("phone"); ?></label>
  <div class="controls"> <?php echo form_input($phone, '', 'class="form-control" id="phone"');?>
  </div>
</div> 
<div class="form-group">
  <label for="company"><?php echo $this->lang->line("company"); ?></label>
  <div class="controls"> <?php echo form_input($company, '', 'class="form-control" id="company"');?>
  </div>
</div> 
<div class="form-group">
  <label for="address"><?php echo $this->lang->line("address"); ?></label>
  <div class="controls"> <?php echo form_input($address, '', 'class="form-control" id="address"');?>
  </div>
</div>  
<div class="form-group">
  <label for="city"><?php echo $this->lang->line("city"); ?></label>
  <div class="controls"> <?php echo form_input($city, '', 'class="form-control" id="city"');?>
  </div>
</div> 
<div class="form-group">
  <label for="state"><?php echo $this->lang->line("state"); ?></label>
  <div class="controls"> <?php echo form_input($state, '', 'class="form-control" id="state"');?>
  </div>
</div> 
<div class="form-group">
  <label for="postal_code"><?php echo $this->lang->line("postal_code"); ?></label>
  <div class="controls"> <?php echo form_input($postal_code, '', 'class="form-control" id="postal_code"');?>
  </div>
</div> 
<div class="form-group">
  <label for="country"><?php echo $this->lang->line("country"); ?></label>
  <div class="controls"> <?php echo form_input($country, '', 'class="form-control" id="country"');?>
  </div>
</div> 
<div class="form-group">
  <label for="cf1"><?php echo $this->lang->line("cf1"); ?></label>
  <div class="controls"> <?php echo form_input($cf1, '', 'class="form-control" id="cf1"');?>
  </div>
</div> 
<div class="form-group">
  <label for="cf2"><?php echo $this->lang->line("cf2"); ?></label>
  <div class="controls"> <?php echo form_input($cf2, '', 'class="form-control" id="cf2"');?>
  </div>
</div> 
<div class="form-group">
  <label for="cf3"><?php echo $this->lang->line("cf3"); ?></label>
  <div class="controls"> <?php echo form_input($cf3, '', 'class="form-control" id="cf3"');?>
  </div>
</div> 
<div class="form-group">
  <label for="cf4"><?php echo $this->lang->line("cf4"); ?></label>
  <div class="controls"> <?php echo form_input($cf4, '', 'class="form-control" id="cf4"');?>
  </div>
</div> 
<div class="form-group">
  <label for="cf5"><?php echo $this->lang->line("cf5"); ?></label>
  <div class="controls"> <?php echo form_input($cf5, '', 'class="form-control" id="cf5"');?>
  </div>
</div> 
<div class="form-group">
  <label for="cf6"><?php echo $this->lang->line("cf6"); ?></label>
  <div class="controls"> <?php echo form_input($cf6, '', 'class="form-control" id="cf6"');?>
  </div>
</div> 

<div class="form-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("add_customer"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
   
   <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
