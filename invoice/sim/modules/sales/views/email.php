<!-- Errors -->
<?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

	<?php if($id) { $no = $id; } if($quote_id) { $no = $quote_id; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title." No. ".$no; ?> <span class="page-meta"><?php echo $this->lang->line("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">    

    <?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=sales&view=email_invoice&id=".$id); ?>
<div class="form-group">
  <label for="from"><?php echo $this->lang->line("from"); ?></label>
  <div class="controls"> <strong><?php echo $from_name; echo " &lt;".$from_email."&gt;"; /*form_input($from_name, '', 'class="text"'); */ ?></strong></div>
</div>
<div class="form-group">
  <label for="to"><?php echo $this->lang->line("to"); ?></label>
  <div class="controls"> <?php echo form_input('to', $cus->email, 'class="form-control" id="to"');?></div>
</div>
<div class="form-group">
  <label for="subject"><?php echo $this->lang->line("subject"); ?></label>
  <div class="controls"> <?php if($id) { $txt = $this->lang->line("invoice")." ".$this->lang->line("no")." ".$id; } ?>
  <?php echo form_input('subject', $txt, 'class="form-control" id="subject"');?> </div>
</div>
<div class="form-group">
  <label for="message"><?php echo $this->lang->line("message"); ?></label>
  <div class="controls"> <?php echo form_textarea($note, '', 'class="form-control" placeholder="'.$this->lang->line("add_note").'" rows="3" style="margin-top: 10px; height: 100px;"');?> </div>
</div>
    

<div class="form-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("email_invoice"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
<div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
