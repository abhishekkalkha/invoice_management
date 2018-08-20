<link href="<?php echo $this->config->base_url(); ?>assets/css/chosen.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url(); ?>assets/css/chosen-bootstrap.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/chosen.jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui.js"></script>

<script type="text/javascript">
 
$(document).ready(function(){
	
	var availableProducts = [<?php foreach($products as $product) { echo '"'.addslashes($product->name).'",'; } ?>];
 
	$("form select").chosen({no_results_text: "No results matched", disable_search_threshold: 5, allow_single_deselect:true});
		  
    var counter = <?php echo NO_OF_ROWS+1; ?>;
 
    $("#addButton").click(function () {
 
	if(counter><?php echo TOTAL_ROWS; ?>){
            alert("<?php echo $this->lang->line("not_allowed"); ?>");
            return false;
	}   
 
	/*var newTr = $(document.createElement('tr'))
	     .attr("id", 'line' + counter);*/
		 
	var newTr = $('<tr></tr>').attr("id", 'line' + counter);

	newTr.html('<td style="width: 20px; text-align: center; padding-right: 10px;">'+ counter +'</td><td><input type="text" class="form-control input-sm" name="quantity' + counter + 
	      '" id="quantity' + counter + '" value="" style="min-width: 70px; text-align: center;" /></td><td><input type="text" name="product' + counter + 
	      '" id="product' + counter + '" value="" class="form-control input-sm" /></td><td><select class="form-control input-sm" style="min-width: 100px;" name="tax_rate' + counter + '" id="tax_rate' + counter + '"><?php
				foreach($tax_rates as $tax) {
					echo "<option value=" . $tax->id;
					if($tax->id == DEFAULT_TAX) { echo ' selected="selected"'; }
					echo ">" . $tax->name . "</option>";
				}
			?></select></td><td><input type="text" name="unit_price' + counter + 
	      '" id="price-' + counter + '" value="" class="form-control input-sm text-right" style="min-width: 100px;"></td>');

	newTr.appendTo("#dyTable");
 	
	counter++;
	$("form select").chosen({no_results_text: "No results matched", disable_search_threshold: 5, allow_single_deselect:true});

		$('input[id^="product"]').blur(function(event, data, formatted) {
			
			var len=$(this).attr('id').length;
			var v = $(this).val();
			
			var q='#quantity'+$(this).attr('id').substr(len-2);
			if($(q).val().length == 0 && v.length != 0 ){
				$(q).val(1);
			}
	
		});
		$( 'input[id^="product"]' ).autocomplete({
			source: availableProducts,
			 select: function( event, ui ) {
				var pr = ui.item ? ui.item.value : this.value;
				var pid = $(this).attr('id');
				rw = pid.substr(pid.length-2);
				$.ajax({
					  type: "get",
					  async: false,
					  url: "index.php?module=sales&view=pr_details",
					  data: { name: pr, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash() ?>' },
					  dataType: "json",
					  success: function(data) {
						price = data.price;
						tax_rate = data.tax_rate;
					  },
					  error: function(){
       					alert('<?php echo $this->lang->line('ajax_error'); ?>');
						return false;
    				  }				  
				});
				$('#price-'+rw).val(price);
				$('#tax_rate'+rw).val(tax_rate).trigger("liszt:updated");
				if($('#quantity'+rw).val().length == 0){
					$('#quantity'+rw).val(1);
				}
			}
		});
				
     });
 
     $("#removeButton").click(function () {
		if(counter==<?php echo NO_OF_ROWS+1; ?>){
          alert("<?php echo $this->lang->line("not_allowed"); ?>");
          return false;
       	}   
 
	counter--;
 
        $("#line" + counter).remove();
 
     });
	 
	 $('input[id^="product"]').blur(function(event, data, formatted) {
			
			var len=$(this).attr('id').length;
			var v = $(this).val();
			
			var q='#quantity'+$(this).attr('id').substr(len-2);
			if($(q).val().length == 0 && v.length != 0 ){
				$(q).val(1);
			}
	
		});
		
	 $( "#date" ).datepicker({
        	dateFormat: "<?php echo JS_DATE; ?>",
			autoclose: true
    	});
		$( "#date" ).datepicker("setDate", new Date());
		
		$( "#customer" ).change(function () {
        	if($(this).val() == 'new') {
				$('#customerForm').slideDown('100');
			} else {
				$('#customerForm').slideUp('100');
			}
    	});
		
		$( 'input[id^="product"]' ).autocomplete({
			source: availableProducts,
			 select: function( event, ui ) {
				var pr = ui.item ? ui.item.value : this.value;
				var pid = $(this).attr('id');
				rw = pid.substr(pid.length-2);
				$.ajax({
					  type: "get",
					  async: false,
					  url: "index.php?module=sales&view=pr_details",
					  data: { name: pr, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash() ?>' },
					  dataType: "json",
					  success: function(data) {
						price = data.price;
						tax_rate = data.tax_rate;
					  },
					  error: function(){
       					alert('<?php echo $this->lang->line('ajax_error'); ?>');
						return false;
    				  }				  
				});
				$('#price-'+rw).val(price);
				$('#tax_rate'+rw).val(tax_rate).trigger("liszt:updated");
				if($('#quantity'+rw).val().length == 0){
					$('#quantity'+rw).val(1);
				}
			}
		});

  });

</script>

<style>
.ui-autocomplete { width:20%; list-style: none; padding:0px; border: 1px solid #ccc; background:#FFF; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset; /*z-index:500; */}
.ui-autocomplete a, .ui-autocomplete li {display: block; border-radius: 0; padding: 2px 5px;} 
.ui-autocomplete a:hover, .ui-autocomplete a:active, .ui-autocomplete li:hover, .ui-autocomplete a:focus, .ui-autocomplete .ui-corner-all:focus { background: #444; color:#ccc; text-decoration: none; }
.ui-helper-hidden-accessible {padding-left: 10px; }
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { text-decoration: none; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { background: #444; border:0; color:#ccc; text-decoration: none; }
span.ui-helper-hidden-accessible { display: none; }
.ui-autocomplete-loading { background:url('<?php echo $this->config->base_url(); ?>assets/img/loading.gif') no-repeat right center }
</style>
<?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=sales&view=add");?>
    <div class="row">
    <div class="col-md-5">
    <!--<div class="form-group">
  <label for="invoice_type"><?php echo $this->lang->line("type"); ?></label>
  <div class="controls"> <?php 
	   		//$in[0] = $this->lang->line("select")." ".$this->lang->line("invoice_type");
	   		foreach($invoice_types as $in_type){
				$in[$in_type->id] = $in_type->name;
			}
			echo form_dropdown('invoice_type', $in, DEFAULT_INVOICE, 'class="form-control" id="invoice_type"');  ?> </div>
</div>  -->
    
    <div class="form-group">
      <label for="reference_no"><?php echo $this->lang->line("reference_no"); ?></label>
      <div class="controls"> <?php echo form_input($reference_no, (isset($_POST['reference_no']) ? $_POST['reference_no'] : ""), 'class="form-control" id="reference_no"');?> </div>
    </div>
    <div class="form-group">
      <label for="date"><?php echo $this->lang->line("date"); ?></label>
      <div class="controls"> <?php echo form_input($date, (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control" id="date"');?> </div>
    </div>
    <div class="form-group">
      <label for="customer"><?php echo $this->lang->line("customer"); ?></label>
      <div class="controls">
        <?php 
	   		$cu[""] = $this->lang->line("select")." ".$this->lang->line("customer");
			$cu["new"] = $this->lang->line("new_customer");
	   		foreach($customers as $customer){
				$cu[$customer->id] = $customer->name;
			}
			echo form_dropdown('customer', $cu, (isset($_POST['customer']) ? $_POST['customer'] : ""), 'class="customer form-control" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("customer").'" id="customer"');  ?>
      </div>
    </div>
    <div id="customerForm" style="display:none;">
      <div class="form-group">
            <label for="name"><?php echo $this->lang->line("name"); ?></label>
            <div class="controls"> <?php echo form_input('name', (isset($_POST['name']) ? $_POST['name'] : ""), 'class="form-control" id="name"');?> </div>
          </div>
          <div class="form-group">
            <label for="phone"><?php echo $this->lang->line("phone"); ?></label>
            <div class="controls"> <?php echo form_input('phone', (isset($_POST['phone']) ? $_POST['phone'] : ""), 'class="form-control" id="phone"');?> </div>
          </div>
          <div class="form-group">
            <label for="email_address"><?php echo $this->lang->line("email_address"); ?></label>
            <div class="controls"> <?php echo form_input('email', (isset($_POST['email']) ? $_POST['email'] : ""), 'class="form-control" id="email_address"');?> </div>
          </div>
          <div class="form-group">
            <label for="company"><?php echo $this->lang->line("company"); ?></label>
            <div class="controls"> <?php echo form_input('company', (isset($_POST['company']) ? $_POST['company'] : ""), 'class="form-control" id="company" ');?> </div>
          </div>
          <div class="form-group">
            <label for="address"><?php echo $this->lang->line("address"); ?></label>
            <div class="controls"> <?php echo form_input('address', (isset($_POST['address']) ? $_POST['address'] : ""), 'class="form-control" id="address" ');?> </div>
          </div>
          <div class="form-group">
            <label for="city"><?php echo $this->lang->line("city"); ?></label>
            <div class="controls"> <?php echo form_input('city', (isset($_POST['city']) ? $_POST['city'] : ""), 'class="form-control" id="city" ');?> </div>
          </div>
          <div class="form-group">
            <label for="state"><?php echo $this->lang->line("state"); ?></label>
            <div class="controls"> <?php echo form_input('state', (isset($_POST['state']) ? $_POST['state'] : ""), 'class="form-control" id="state" ');?> </div>
          </div>
          <div class="form-group">
            <label for="postal_code"><?php echo $this->lang->line("postal_code"); ?></label>
            <div class="controls"> <?php echo form_input('postal_code', (isset($_POST['postal_code']) ? $_POST['postal_code'] : ""), 'class="form-control" id="postal_code" ');?> </div>
          </div>
          <div class="form-group">
            <label for="country"><?php echo $this->lang->line("country"); ?></label>
            <div class="controls"> <?php echo form_input('country', (isset($_POST['country']) ? $_POST['country'] : ""), 'class="form-control" id="country" ');?> </div>
          </div>
        </div>
    
    </div>
    
    <div class="col-md-5 col-md-offset-1">
    
    <div class="form-group">
      <label for="discount"><?php echo $this->lang->line("discount_lable"); ?></label>
      <div class="controls"> <?php echo form_input('discount', (isset($_POST['discount']) ? $_POST['discount'] : ""), 'class="form-control" id="discount"');?> </div>
    </div>
        
    <div class="form-group">
      <label for="shipping"><?php echo $this->lang->line("shipping"); ?></label>
      <div class="controls"> <?php echo form_input('shipping', (isset($_POST['shipping']) ? $_POST['shipping'] : ""), 'class="form-control" id="shipping"');?> </div>
    </div>
    
    <div class="form-group">
      <label for="customer"><?php echo $this->lang->line("status"); ?></label>
      <div class="controls">
        <?php 
			$st = array(
				'' 		=> $this->lang->line("select")." ".$this->lang->line("status"),
				$this->lang->line('cancelled') => $this->lang->line('cancelled'),
				$this->lang->line('overdue') 	=> $this->lang->line('overdue'),
				$this->lang->line('paid')		=> $this->lang->line('paid'),
				$this->lang->line('pending')	=> $this->lang->line('pending')
			);

			echo form_dropdown('status', $st, (isset($_POST['status']) ? $_POST['status'] : ""), 'class="status form-control" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("status").'" id="status"');  ?>
      </div>
    </div>
    
    </div>
    </div>
    <table id="dyTable" class="table table-striped" style="margin-bottom:5px;">
      <thead>
      <tr class="active">
      <th class="text-center"><?php echo $this->lang->line("no"); ?></th>
        <th class="col-sm-2 text-center"><?php echo $this->lang->line("quantity"); ?></th>
        <th class="col-sm-5 text-center"><?php echo $this->lang->line("product_code"); ?></th>
        <th class="col-sm-2 text-center"><?php echo $this->lang->line("tax_rate"); ?></th>
        <th class="col-sm-2 text-center"><?php echo $this->lang->line("unit_price"); ?></th>
         </tr></thead>
      <tbody>
        <?php
	  $quantity = "quantity0";
	  $product = "product0";
	  $tax_rate = "tax_rate0";
	  $unit_price = "unit_price0";
	  /*$sp[0] = "";
	   		foreach($products as $product){
				$sp[$product->id] = $product->code;
			}*/
	  
	   		foreach($tax_rates as $tax){
				$tr[$tax->id] = $tax->name;
			}
			
	  for($r=1; $r<=NO_OF_ROWS; $r++) { 
	  
		  if(isset($_POST['submit'])) { 
				if(isset($_POST['quantity'.$r])) { $qt_value = $_POST['quantity'.$r]; } else { $qt_value = ""; }
				if(isset($_POST['product'.$r])) { $pr_value = $_POST['product'.$r]; } else { $pr_value = "";  }
				if(isset($_POST['tax_rate'.$r])) { $tr_value = $_POST['tax_rate'.$r]; } else { $tr_value = DEFAULT_TAX;  }
				if(isset($_POST['unit_price'.$r])) { $price_value = $_POST['unit_price'.$r]; } else { $price_value = "";  }	
				
		  } else { 
				$qt_value = ""; 
				$pr_value = ""; 
				$tr_value = DEFAULT_TAX; 
				$price_value = ""; 
		  }

	  ?>
        <tr id="line<?php echo $r; ?>">
          <td style="width: 20px; text-align: center; padding-right: 10px; padding-right: 10px;"><?php echo $r; ?></td>
          <td><?php echo form_input('quantity'.$r, $qt_value, 'id="quantity0'.$r.'" class="form-control text-center input-sm" style="min-width: 70px;"');?></td>
          <td><?php echo form_input('product'.$r, $pr_value, 'id="product0'.$r.'" class="form-control input-sm" tyle="min-width:270px;"');
			/*echo form_dropdown('product'.$r, $sp, '', 'id="product0'.$r.'" class="chzn-select" data-placeholder="Choose a Product" style="width:270px;"'); */ ?></td>
          <td><?php 
			echo form_dropdown('tax_rate'.$r, $tr, $tr_value, 'id="tax_rate0'.$r.'" class="form-control input-sm" style="min-width: 100px;"');  ?></td>
          <td><?php echo form_input('unit_price'.$r, $price_value, 'id="price-0'.$r.'" class="form-control text-right input-sm" style="min-width: 100px;"'); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <button type="button" class="btn btn-primary" id='addButton'><i class="fa fa-plus"></i></button>
    <button type="button" class="btn btn-danger" id='removeButton'><i class="fa fa-minus"></i></button>
    <p class="clearfix">&nbsp;</p>
    
    <div class="form-group"> <?php echo form_textarea($note, (isset($_POST['note']) ? $_POST['note'] : ""), 'class="input-block-level" placeholder="'.$this->lang->line("add_note").'" rows="3" style="margin-top: 10px; height: 100px;"');?> </div>
    <div class="form-group"> <?php echo form_submit('submit', $this->lang->line("add_sale"), 'class="btn btn-primary btn-large"');?> </div>
    <?php echo form_close();?>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
