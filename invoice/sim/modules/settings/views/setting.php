
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>
<?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("update_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=settings&view=system_setting");?>
    <div class="row">
    <div class="col-md-5">
    <div class="form-group">
      <label for="site_name"><?php echo $this->lang->line("site_name"); ?></label>
      <div class="controls"> <?php echo form_input('site_name', $settings->site_name, 'class="form-control" id="site_name"');?> </div>
    </div>
    <div class="form-group">
      <label for="language"><?php echo $this->lang->line("language"); ?></label>
      <div class="controls">
        <?php 
	  	$lang = array ('english' => 'English');
		echo form_dropdown('language', $lang, $settings->language, 'class="form-control" id="language"'); ?>
      </div>
    </div>
    <div class="form-group">
      <label for="currency_prefix"><?php echo $this->lang->line("currency_code"); ?></label>
      <div class="controls"> <?php echo form_input('currency_prefix', $settings->currency_prefix, 'class="form-control" id="currency_prefix"');?> </div>
    </div>
    <div class="form-group">
      <label for="major"><?php echo $this->lang->line("currency_major"); ?></label>
      <div class="controls"> <?php echo form_input('major', $settings->major, 'class="form-control" id="major"');?> </div>
    </div>
    <div class="form-group">
      <label for="minor"><?php echo $this->lang->line("currency_minor"); ?></label>
      <div class="controls"> <?php echo form_input('minor', $settings->minor, 'class="form-control" id="minor"');?> </div>
    </div>
    <div class="form-group">
      <label for="tax_rate"><?php echo $this->lang->line("tax_rate"); ?></label>
      <div class="controls">
        <?php 
	  foreach($tax_rates as $rate){
    		$tr[$rate->id] = $rate->name;
		}
		
		echo form_dropdown('tax_rate', $tr, $settings->default_tax_rate, 'class="form-control" id"tax_rate"'); ?>
      </div>
    </div>
    
        <div class="form-group">
      <label for="tax_rate"><?php echo $this->lang->line("display_to_words"); ?></label>
      <div class="controls">
        <?php 
	  $tw = array ( '0' => $this->lang->line("disable"), '1' => $this->lang->line("enable"));
		echo form_dropdown('display_words', $tw, $settings->display_words, 'class="form-control tip chzn-select" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("display_to_words").'" required="required" data-error="'.$this->lang->line("display_to_words").' '.$this->lang->line("is_required").'"'); ?>
      </div>
    </div>
        
    </div>

    <div class="col-md-5 col-md-offset-1">
    <div class="form-group">
  <label for="date_format"><?php echo $this->lang->line("date_format"); ?></label>
  <div class="controls">
    <?php 
	  foreach($date_formats as $date_format){
    		$dt[$date_format->id] = $date_format->js;
		}
		echo form_dropdown('date_format', $dt, $settings->dateformat, 'class="form-control tip chzn-select" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("date_format").'" required="required" data-error="'.$this->lang->line("date_format").' '.$this->lang->line("is_required").'"'); ?>
  </div>
</div>

<div class="form-group">
  <label for="product_serial"><?php echo $this->lang->line("print_payment_on_invoice"); ?></label>
  <div class="controls">
    <?php 
	  $ps = array ( '0' => $this->lang->line("disable"), '1' => $this->lang->line("enable"));
		echo form_dropdown('print_payment', $ps, $settings->print_payment, 'class="form-control tip chzn-select" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("print_payment_on_invoice").'" required="required" data-error="'.$this->lang->line("print_payment_on_invoice").' '.$this->lang->line("is_required").'"'); ?>
  </div>
</div>

<div class="form-group">
  <label for="product_serial"><?php echo $this->lang->line("calendar"); ?></label>
  <div class="controls">
    <?php 
	  $cl = array ( '0' => $this->lang->line("shared"), '1' => $this->lang->line("private"));
		echo form_dropdown('calendar', $cl, $settings->calendar, 'class="form-control tip chzn-select" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("calendar").'"'); ?>
  </div>
</div>
<div class="form-group">
  <label for="restrict_sales"><?php echo $this->lang->line("restrict_sales"); ?></label>
  <div class="controls">
    <?php 
	  $rs = array ( '0' => $this->lang->line("disable"), '1' => $this->lang->line("enable"));
		echo form_dropdown('restrict_sales', $rs, $settings->restrict_sales, 'class="form-control tip chzn-select" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("restrict_sales").'"'); ?>
  </div>
</div>
<div class="form-group">
      <label for="rows_per_page"><?php echo $this->lang->line("rows_per_page"); ?></label>
      <div class="controls">
        <?php 
	  	$options = array (
						'10' => '10', 
						'25' => '25',
						'50' => '50',
						'100' => '100',
						'-1' => 'All (not recommended)');
		echo form_dropdown('rows_per_page', $options, $settings->rows_per_page, 'class="form-control" id="rows_per_page"'); ?>
      </div>
    </div>
    <div class="form-group">
      <label for="total_rows"><?php echo $this->lang->line("total_rows"); ?></label>
      <div class="controls"> <?php echo form_input('total_rows', $settings->total_rows, 'class="form-control" id="total_rows"');?> </div>
    </div>
    </div>
    </div>
    
    <div class="form-group">
      <div class="controls"> <?php echo form_submit('submit', $this->lang->line("update_settings"), 'class="btn btn-primary"');?> </div>
    </div>
    <?php echo form_close();?>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
