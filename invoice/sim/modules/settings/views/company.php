<?php $name = array(
              'name'        => 'name',
              'id'          => 'name',
              'value'       => $details->name,
              'class'       => 'form-control',
            );
			$email = array(
              'name'        => 'email',
              'id'          => 'email',
              'value'       => $details->email,
              'class'       => 'form-control',
            );
			$company = array(
              'name'     => 'company',
              'id'          => 'company',
              'value'       => $details->company,
              'class'       => 'form-control',
            );
			$cf1 = array(
              'name'        => 'cf1',
              'id'          => 'cf1',
              'value'       => $details->cf1,
              'class'       => 'form-control',
            );
			$cf2 = array(
              'name'        => 'cf2',
              'id'          => 'cf2',
              'value'       => $details->cf2,
              'class'       => 'form-control',
            );
			$cf3 = array(
              'name'        => 'cf3',
              'id'          => 'cf3',
              'value'       => $details->cf3,
              'class'       => 'form-control',
            );
			$cf4 = array(
              'name'        => 'cf4',
              'id'          => 'cf4',
              'value'       => $details->cf4,
              'class'       => 'form-control',
            );
            $cf5 = array(
              'name'        => 'cf5',
              'id'          => 'cf5',
              'value'       => $details->cf5,
              'class'       => 'form-control',
            );
			$cf6 = array(
              'name'        => 'cf6',
              'id'          => 'cf6',
              'value'       => $details->cf6,
              'class'       => 'form-control',
            );
			$address = array(
              'name'        => 'address',
              'id'          => 'address',
              'value'       => $details->address,
              'class'       => 'form-control',
            );
			$city = array(
              'name'        => 'city',
              'id'          => 'city',
              'value'       => $details->city,
              'class'       => 'form-control',
            );
			$state = array(
              'name'     => 'state',
              'id'          => 'state',
              'value'       => $details->state,
              'class'       => 'form-control',
            );
			$postal_code = array(
              'name'        => 'postal_code',
              'id'          => 'postal_code',
              'value'       => $details->postal_code,
              'class'       => 'form-control',
            );
			$country = array(
              'name'        => 'country',
              'id'          => 'country',
              'value'       => $details->country,
              'class'       => 'form-control',
            );
			$phone = array(
              'name'        => 'phone',
              'id'          => 'phone',
              'value'       => $details->phone,
              'class'       => 'form-control',
            );
			
		?>
        
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("update_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
   	<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=settings&view=company_details");?>

<div class="form-group">
  <label for="name"><?php echo $this->lang->line("name"); ?></label>
  <div class="controls"> <?php echo form_input($name);?>
  </div>
</div> 
<div class="form-group">
  <label for="email_address"><?php echo $this->lang->line("email_address"); ?></label>
  <div class="controls"> <?php echo form_input($email);?>
  </div>
</div> 
<div class="form-group">
  <label for="phone"><?php echo $this->lang->line("phone"); ?></label>
  <div class="controls"> <?php echo form_input($phone);?>
  </div>
</div> 
<div class="form-group">
  <label for="company"><?php echo $this->lang->line("company"); ?></label>
  <div class="controls"> <?php echo form_input($company);?>
  </div>
</div> 
<div class="form-group">
  <label for="address"><?php echo $this->lang->line("address"); ?></label>
  <div class="controls"> <?php echo form_input($address);?>
  </div>
</div>  
<div class="form-group">
  <label for="city"><?php echo $this->lang->line("city"); ?></label>
  <div class="controls"> <?php echo form_input($city);?>
  </div>
</div> 
<div class="form-group">
  <label for="state"><?php echo $this->lang->line("state"); ?></label>
  <div class="controls"> <?php echo form_input($state);?>
  </div>
</div> 
<div class="form-group">
  <label for="postal_code"><?php echo $this->lang->line("postal_code"); ?></label>
  <div class="controls"> <?php echo form_input($postal_code);?>
  </div>
</div> 
<div class="form-group">
  <label for="country"><?php echo $this->lang->line("country"); ?></label>
  <div class="controls"> <?php echo form_input($country);?>
  </div>
</div> 
<div class="form-group">
  <label for="cf1"><?php echo $this->lang->line("cf1"); ?></label>
  <div class="controls"> <?php echo form_input($cf1);?>
  </div>
</div> 
<div class="form-group">
  <label for="cf2"><?php echo $this->lang->line("cf2"); ?></label>
  <div class="controls"> <?php echo form_input($cf2);?>
  </div>
</div> 
<div class="form-group">
  <label for="cf3"><?php echo $this->lang->line("cf3"); ?></label>
  <div class="controls"> <?php echo form_input($cf3);?>
  </div>
</div> 
<div class="form-group">
  <label for="cf4"><?php echo $this->lang->line("cf4"); ?></label>
  <div class="controls"> <?php echo form_input($cf4);?>
  </div>
</div> 
<div class="form-group">
  <label for="cf5"><?php echo $this->lang->line("cf5"); ?></label>
  <div class="controls"> <?php echo form_input($cf5);?>
  </div>
</div> 
<div class="form-group">
  <label for="cf6"><?php echo $this->lang->line("cf6"); ?></label>
  <div class="controls"> <?php echo form_input($cf6);?>
  </div>
</div> 

<div class="form-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("update_customer"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
     <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>