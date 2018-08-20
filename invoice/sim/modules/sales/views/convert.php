<?php $reference_no = array(
              'name'        => 'reference_no',
              'id'          => 'reference_no',
              'value'       => $inv->reference_no,
              'class'       => 'form-control',
            );
			$date = array(
              'name'        => 'date',
              'id'          => 'date',
              'value'       => date(PHP_DATE, strtotime($inv->date)),
              'class'       => 'form-control',
            );
			
			$note = array(
              'name'        => 'note',
              'id'          => 'note',
              'value'       => $inv->note,
              'class'       => 'form-control',
			  'style'		=> 'height: 100px; margin-top:10px;',
			  'placeholder' => $this->lang->line("add_note")
            );
			
			
			$pr_value = sizeof($inv_products);
			$cno = $pr_value +1;
			
?>
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
<link href="<?php echo $this->config->base_url(); ?>assets/css/chosen.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url(); ?>assets/css/chosen-bootstrap.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/chosen.jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui.js"></script>

<script type="text/javascript">
 
$(document).ready(function(){

    var counter = <?php if($cno >= 9) { echo $cno; } else { echo 10;} ?>;
 
    $("form select").chosen({no_results_text: "No results matched", disable_search_threshold: 5, allow_single_deselect:true});
	var availableProducts = [<?php foreach($products as $product) { echo '"'.$product->name.'",'; } ?>];
	
	$("#addButton").click(function () {
 
	if(counter><?php echo TOTAL_ROWS; ?>){
            alert("<?php echo $this->lang->line("not_allowed"); ?>");
            return false;
	}   
 
	/*var newTr = $(document.createElement('tr'))
	     .attr("id", 'line' + counter);*/
		 
	var newTr = $('<tr></tr>').attr("id", 'line' + counter);

	newTr.html('<td style="width: 20px; text-align: center; padding-right: 10px;">'+ counter +'</td><td><input type="text" class="form-control" name="quantity' + counter + 
	      '" id="quantity' + counter + '" value="" style="min-width: 70px; text-align: center;" /></td><td><input type="text" class="form-control" name="product' + counter + 
	      '" id="product' + counter + '" value="" /></td><td><select data-placeholder="Select..." class="form-control" style="min-width: 100px;" name="tax_rate' + counter + '" id="tax_rate' + counter + '"><?php
				foreach($tax_rates as $tax) {
					echo "<option value=" . $tax->id;
					if($tax->id == DEFAULT_TAX) { echo ' selected="selected"'; }
					echo ">" . $tax->name . "</option>";
				}
			?></select></td><td><input type="text" name="unit_price' + counter + 
	      '" id="price-' + counter + '" value="" class="form-control text-right" style="min-width: 100px;"></td>');

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
		if(counter==<?php if($cno >= 9) { echo $cno; } else { echo 10;} ?>){
          alert("<?php echo $this->lang->line("not_allowed"); ?>");
          return false;
       	}   
 
	counter--;
 
        $("#line" + counter).remove();
 
     });
 
	
		$( "#date" ).datepicker({
        	dateFormat: "<?php echo JS_DATE; ?>",
			autoclose: true
    	});
		$( "#date" ).datepicker("setDate", new Date());
		
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
	
	</script>
<?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title." ".$this->lang->line("no")." ".$id ?> <span class="page-meta"><?php echo $this->lang->line("update_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=sales&view=add");?>
    <div class="row">
      <div class="col-md-5">
        <div class="form-group">
          <label for="reference_no"><?php echo $this->lang->line("reference_no"); ?></label>
          <div class="controls"> <?php echo form_input($reference_no);?> </div>
        </div>
        <div class="form-group">
          <label for="date"><?php echo $this->lang->line("date"); ?></label>
          <div class="controls"> <?php echo form_input($date);?> </div>
        </div>
        <div class="form-group">
          <label for="customer"><?php echo $this->lang->line("customer"); ?></label>
          <div class="controls">
            <?php 
	   		$cu[""] = $this->lang->line("select")." ".$this->lang->line("customer");
	   		foreach($customers as $customer){
				$cu[$customer->id] = $customer->name;
			}
			echo form_dropdown('customer', $cu, $inv->customer_id, 'class="form-control" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("customer").'" id="customer"');  ?>
          </div>
        </div>
      </div>
      <div class="col-md-5 col-md-offset-1">
          <div class="form-group">
      <label for="discount"><?php echo $this->lang->line("discount_lable"); ?></label>
      <div class="controls"> <?php echo form_input('discount', (isset($_POST['discount']) ? $_POST['discount'] : ($inv->discount ? $inv->discount : '')), 'class="form-control" id="discount"');?> </div>
    </div>
    <div class="form-group">
      <label for="shipping"><?php echo $this->lang->line("shipping"); ?></label>
      <div class="controls"> <?php echo form_input('shipping', (isset($_POST['shipping']) ? $_POST['shipping'] : $inv->shipping), 'class="form-control" id="shipping"');?> </div>
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


			echo form_dropdown('status', $st, '', 'class="status form-control" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("status").'" id="status"');  ?>
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
        </tr>
          </thead>
      <tbody>
        <?php 
	  		
			$tr[0] = "";
	   		foreach($tax_rates as $tax){
				$tr[$tax->id] = $tax->name;
			}			
		
			$r = 1;
			foreach($inv_products as $prod){
			
			?>
        <tr id="line<?php echo $r; ?>">
          <td style="width: 20px; text-align: center; padding-right: 10px; padding-right: 10px;"><?php echo $r; ?></td>
          <td><?php echo form_input('quantity'.$r, $prod->quantity, 'id="quantity0'.$r.'" class="form-control" style="min-width: 70px; text-align: center;"');?></td>
          <td><?php echo form_input('product'.$r, $prod->product_name, 'id="product0'.$r.'" class="form-control"'); ?></td>
          <td><?php echo form_dropdown('tax_rate'.$r, $tr, $prod->tax_rate_id, 'id="tax_rate0'.$r.'" class="form-control" style="min-width: 100px;"');  ?></td>
          <td><?php echo form_input('unit_price'.$r, $prod->unit_price, 'id="price-0'.$r.'" class="form-control text-right" style="min-width: 100px;"'); ?></td>
          <?php if($prod->id) { echo form_hidden('item_id'.$r, $prod->id); }  ?>
        </tr>
        <?php
         $r++;
			
		} if($r < 9) {
			for($rw=$r; $rw<=NO_OF_ROWS; $rw++) { ?>
        <tr id="line<?php echo $rw; ?>">
          <td style="width: 20px; text-align: center; padding-right: 10px; padding-right: 10px;"><?php echo $rw; ?></td>
          <td><?php echo form_input('quantity'.$rw, '', 'id="quantity0'.$rw.'" class="form-control" style="min-width: 70px; text-align: center;"');?></td>
          <td><?php echo form_input('product'.$rw, '', 'id="product0'.$rw.'" class="form-control"'); ?></td>
          <td><?php echo form_dropdown('tax_rate'.$rw, $tr, DEFAULT_TAX, 'id="tax_rate0'.$rw.'" class="form-control" style="min-width: 100px;"');  ?></td>
          <td><?php echo form_input('unit_price'.$rw, '', 'id="price-0'.$rw.'" class="form-control text-right" style="min-width: 100px;"'); ?></td>
        </tr>
        <?php } 
			} ?>
      </tbody>
    </table>
    <button type="button" class="btn btn-primary" id='addButton'><i class="fa fa-plus"></i></button>
    <button type="button" class="btn btn-danger" id='removeButton'><i class="fa fa-minus"></i></button>
    <p class="clearfix">&nbsp;</p>
    
    <div class="form-group"> <?php echo form_textarea($note);?> </div>
    <div class="form-group"> <?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary btn-large"');?> </div>
    <?php echo form_close();?>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
