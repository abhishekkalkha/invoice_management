
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("update_user_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
<?php $first_name = array(
              'name'        => 'first_name',
              'id'          => 'first_name',
			  'placeholder' => "First Name",
              'value'       => $user->first_name,
              'class'       => 'form-control'
            );
			$last_name = array(
              'name'        => 'last_name',
              'id'          => 'last_name',
              'value'       => $user->last_name,
              'class'       => 'form-control'
            );
			$company = array(
              'name'     => 'company',
              'id'          => 'company',
              'value'       => $user->company,
              'class'       => 'form-control',
            );
			$phone = array(
              'name'        => 'phone',
              'id'          => 'phone',
              'value'       => $user->phone,
              'class'       => 'form-control',
            );
			$email = array(
              'name'        => 'email',
              'id'          => 'email',
              'value'       => $user->email,
              'class'       => 'form-control',
            );
			
	?>
<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=auth&view=edit_user&id=".$id);?>
<div class="form-group">
  <label for="first_name"><?php echo $this->lang->line("first_name"); ?></label>
  <div class="controls"> <?php echo form_input($first_name);?> </div>
</div>
<div class="form-group">
  <label for="last_name"><?php echo $this->lang->line("last_name"); ?></label>
  <div class="controls"> <?php echo form_input($last_name);?> </div>
</div>
<div class="form-group">
  <label for="company"><?php echo $this->lang->line("company"); ?></label>
  <div class="controls"> <?php echo form_input($company);?> </div>
</div>
<div class="form-group">
  <label for="phone"><?php echo $this->lang->line("phone"); ?></label>
  <div class="controls"> <?php echo form_input($phone);?> </div>
</div>
<div class="form-group">
  <label for="email"><?php echo $this->lang->line("email_address"); ?></label>
  <div class="controls"> <?php echo form_input($email);?> </div>
</div>
<div class="form-group">
  <label for="phone"><?php echo $this->lang->line("user_role"); ?></label>
  <div class="controls"> 

<label class="radio">
        <input type="radio" name="role" id="optionsRadios1" value="1" <?php if($group->group_id == '1') { echo "checked=\"yes\""; } if(isset($_POST['submit']) && ($_POST['role'] == '1')) { echo "checked=\"yes\""; } ?>>
        <?php echo $this->lang->line("admin_role"); ?> </label>
      <label class="radio">
        <input type="radio" name="role" id="optionsRadios2" value="2" <?php if($group->group_id == '2') { echo "checked=\"yes\""; } if(isset($_POST['submit']) && ($_POST['role'] == '2')) { echo "checked=\"yes\""; } ?>>
        <?php echo $this->lang->line("sales_role"); ?> </label>
      <label class="radio">
        <input type="radio" name="role" id="optionsRadios3" value="3" <?php if($group->group_id == '3') { echo "checked=\"yes\""; } if(isset($_POST['submit']) && ($_POST['role'] == '3')) { echo "checked=\"yes\""; } ?>>
        <?php echo $this->lang->line("viewer_role"); ?> </label>
  </div>
</div>        
<div class="form-group">
  <label for="password"><?php echo $this->lang->line("pw"); ?></label>
  <div class="controls"> <?php echo form_input($password , '', 'class="form-control" id="password" placeholder="Optional"');?> </div>
</div>
<div class="form-group">
  <label for="confirm_pw"><?php echo $this->lang->line("confirm_pw"); ?></label>
  <div class="controls"> <?php echo form_input($password_confirm , '', 'class="form-control" id="confirm_pw" placeholder="Optional"');?> </div>
</div>
<div class="form-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("update_user"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?>

<div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
