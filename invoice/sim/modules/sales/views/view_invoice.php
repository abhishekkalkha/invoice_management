<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $page_title." ".$this->lang->line("no")." ".$inv->id; ?></title>
<link rel="shortcut icon" href="<?php echo $this->config->base_url(); ?>assets/img/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url(); ?>assets/style/style.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url(); ?>assets/css/rwd-table.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<style type="text/css">
html, body { height: 100%; padding:0; }
#wrap { padding: 20px; }
</style>
</head>

<body>
<img src="<?php echo $this->config->base_url(); ?>assets/img/<?php echo $inv->status; ?>.png" alt="<?php echo $inv->status; ?>" style="float: right; position: absolute; top:0; right: 0;"/>
<div id="wrap">
<img src="<?php echo $this->config->base_url(); ?>assets/img/<?php echo INVOICE_LOGO; ?>" alt="<?php echo SITE_NAME ?>" />
<div class="row-fluid">    
<div class="span6">
	
	<h3><?php echo $biller->company; ?></h3>
	<?php echo $biller->address.",<br />".$biller->city.", ".$biller->postal_code.", ".$biller->state.",<br />".$biller->country;

	echo "<br />".$this->lang->line("tel").": ".$biller->phone."<br />".$this->lang->line("email").": ".$biller->email; 
	
	if($biller->cf1 && $biller->cf1 != "-") { echo "<br />".$this->lang->line("cf1").": ".$biller->cf1; }
	if($biller->cf2 && $biller->cf2 != "-") { echo "<br />".$this->lang->line("cf2").": ".$biller->cf2; }
	if($biller->cf3 && $biller->cf3 != "-") { echo "<br />".$this->lang->line("cf3").": ".$biller->cf3; }
	if($biller->cf4 && $biller->cf4 != "-") { echo "<br />".$this->lang->line("cf4").": ".$biller->cf4; }
	if($biller->cf5 && $biller->cf5 != "-") { echo "<br />".$this->lang->line("cf5").": ".$biller->cf5; }
	if($biller->cf6 && $biller->cf6 != "-") { echo "<br />".$this->lang->line("cf6").": ".$biller->cf6; }
	
	?>
    
	</div>
  
    <div class="span6">
    
   <?php echo $this->lang->line("billed_to"); ?>:
   <h3><?php if($customer->company != "-") { echo $customer->company; } else { echo $customer->name; } ?></h3>
   <?php if($customer->company != "-") { echo "<p>Attn: ".$customer->name."</p>"; } ?>
   
   <?php if($customer->address != "-") { echo  $this->lang->line("address").": ".$customer->address.", ".$customer->city.", ".$customer->postal_code.", ".$customer->state.", ".$customer->country; } ?><br>
   <?php echo $this->lang->line("tel").": ".$customer->phone; ?><br>
   <?php echo $this->lang->line("email").": ".$customer->email; ?><br>
   <?php
   if($customer->cf1 && $customer->cf1 != "-") { echo "<br />".$this->lang->line("cf1").": ".$customer->cf1; }
	if($customer->cf2 && $customer->cf2 != "-") { echo "<br />".$this->lang->line("cf2").": ".$customer->cf2; }
	if($customer->cf3 && $customer->cf3 != "-") { echo "<br />".$this->lang->line("cf3").": ".$customer->cf3; }
	if($customer->cf4 && $customer->cf4 != "-") { echo "<br />".$this->lang->line("cf4").": ".$customer->cf4; }
	if($customer->cf5 && $customer->cf5 != "-") { echo "<br />".$this->lang->line("cf5").": ".$customer->cf5; }
	if($customer->cf6 && $customer->cf6 != "-") { echo "<br />".$this->lang->line("cf6").": ".$customer->cf6; }
   ?>

	</div> 
</div>
<div style="clear: both;"></div>
<p>&nbsp;</p>
<div class="row-fluid"> 
<div class="span6">    	
<h3 class="inv"><?php echo $this->lang->line("invoice")." ". $this->lang->line("no") ." ".$inv->id; ?></h3>
</div>
<div class="span6">

<p style="font-weight:bold;"><?php echo $this->lang->line("reference_no"); ?>: <?php echo $inv->reference_no; ?></p>

<p style="font-weight:bold;"><?php echo $this->lang->line("date"); ?>: <?php echo date(PHP_DATE, strtotime($inv->date)); ?></p>
    
   </div>
   <p>&nbsp;</p>
 <div style="clear: both;"></div>	

	<table class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

	<thead> 

	<tr> 

	    <th style="text-align:center; vertical-align:middle;"><?php echo $this->lang->line("no"); ?></th> 
	    <th style="vertical-align:middle;"><?php echo $this->lang->line("description"); ?></th> 
        <th style="text-align:center; vertical-align:middle;"><?php echo $this->lang->line("tax"); ?></th>    
        <th style="text-align:center; vertical-align:middle;"><?php echo $this->lang->line("quantity"); ?></th>
	    <th style="padding-right:20px; text-align:center; vertical-align:middle;"><?php echo $this->lang->line("unit_price"); ?></th> 
        <th style="padding-right:20px; text-align:center; vertical-align:middle;"><?php echo $this->lang->line("tax_value"); ?></th>
	    <th style="padding-right:20px; text-align:center; vertical-align:middle;"><?php echo $this->lang->line("subtotal"); ?></th> 
	</tr> 

	</thead> 

	<tbody> 
	
	<?php $r = 1; foreach ($rows as $row):?>
			<tr>
            	<td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $r; ?></td>
                <td style="vertical-align:middle;"><?php echo $row->product_name; ?></td>
                <td style="width: 100px; text-align:center; vertical-align:middle;"><?php echo $row->tax; ?></td>
                <td style="width: 100px; text-align:center; vertical-align:middle;"><?php echo $row->quantity; ?></td>
                <td style="width: 100px; text-align:right; padding-right:20px; vertical-align:middle;"><?php echo $row->unit_price; ?></td>
                <td style="width: 100px; text-align:right; padding-right:20px; vertical-align:middle;"><?php echo $row->val_tax; ?></td>
                <td style="width: 100px; text-align:right; padding-right:20px; vertical-align:middle;"><?php echo $row->gross_total; ?></td> 
			</tr> 
    <?php 
		$r++; 
		endforeach;
	?>
    
<tr><td colspan="7">&nbsp;</td></tr>     

<?php if(TOWORDS) { ?>

<tr>
<td colspan="4"><?php if ($inv->inv_total != 0) { list($no, $fr) = explode(".", $inv->inv_total); echo ucfirst(Numbers_Words::toWords($no))." ".CMAJOR; if($fr!=0) { echo " & ". Numbers_Words::toWords($fr) ." ".CMINOR; } } ?></td>
<td colspan="2" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("total"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $inv->inv_total; ?></td>
</tr>
<tr>
<td colspan="4"><?php if ($inv->total_tax != 0) { list($no, $fr) = explode(".", $inv->total_tax); echo ucfirst(Numbers_Words::toWords($no))." ".CMAJOR; if($fr!=0) { echo " & ". Numbers_Words::toWords($fr) ." ".CMINOR; } } ?></td>
<td colspan="2" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("tax"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $inv->total_tax; ?></td></tr>

<?php if ($inv->shipping != 0) { ?>
<tr>
<td colspan="4"><?php if ($inv->shipping != 0) { list($no, $fr) = explode(".", $inv->shipping); echo ucfirst(Numbers_Words::toWords($no))." ".CMAJOR; if($fr!=0) { echo " & ". Numbers_Words::toWords($fr) ." ".CMINOR; } } ?></td>
<td colspan="2" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("shipping"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $inv->shipping; ?></td></tr>
<?php } ?>

<?php if ($inv->total_discount != 0) { ?>
<tr>
<td colspan="4"><?php if (($inv->total+$inv->shipping) != 0) { list($no, $fr) = explode(".", number_format(($inv->total+$inv->shipping+$inv->total_discount), 2, '.', '')); echo ucfirst(Numbers_Words::toWords($no))." ".CMAJOR; if($fr!=0) { echo " & ". Numbers_Words::toWords($fr) ." ".CMINOR; } } ?></td>
<td colspan="2" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("invoice_total"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td>
<td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo number_format(($inv->total+$inv->shipping+$inv->total_discount), 2, '.', ''); ?></td></tr>

<tr>
<td colspan="4"><?php if ($inv->total_discount != 0) { list($no, $fr) = explode(".", $inv->total_discount); echo ucfirst(Numbers_Words::toWords($no))." ".CMAJOR; if($fr!=0) { echo " & ". Numbers_Words::toWords($fr) ." ".CMINOR; } } ?></td>
<td colspan="2" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("discount").' ('.$inv->discount.')'; ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $inv->total_discount; ?></td></tr>

<tr class="info">
<td colspan="4"><?php if (($inv->total_discount) != 0) { list($no, $fr) = explode(".", number_format(($inv->total+$inv->shipping), 2, '.', '')); echo ucfirst(Numbers_Words::toWords($no))." ".CMAJOR; if($fr!=0) { echo " & ". Numbers_Words::toWords($fr) ." ".CMINOR; } } ?></td>
<td colspan="2" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("grand_total"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td>
<td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo number_format(($inv->total+$inv->shipping), 2, '.', ''); ?></td></tr>

<?php } else { ?>
<tr class="info">
<td colspan="4"><?php if (($inv->total+$inv->shipping) != 0) { list($no, $fr) = explode(".", number_format(($inv->total+$inv->shipping), 2, '.', '')); echo ucfirst(Numbers_Words::toWords($no))." ".CMAJOR; if($fr!=0) { echo " & ". Numbers_Words::toWords($fr) ." ".CMINOR; } } ?></td>
<td colspan="2" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("grand_total"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td>
<td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo number_format(($inv->total+$inv->shipping), 2, '.', ''); ?></td></tr>
<?php } ?>
<tr class="success">
<td colspan="4"><?php if ($paid != 0) { list($no, $fr) = explode(".", $paid); echo ucfirst(Numbers_Words::toWords($no))." ".CMAJOR; if($fr!=0) { echo " & ". Numbers_Words::toWords($fr) ." ".CMINOR; } } ?></td>
<td colspan="2" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("paid"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $paid; ?></td></tr>

<tr class="warning">
<td colspan="4"><?php if ((($inv->total - $paid)+$inv->shipping) != 0) { list($no, $fr) = explode(".", number_format(($inv->total - $paid), 2, '.', '')); echo ucfirst(Numbers_Words::toWords($no))." ".CMAJOR; if($fr!=0) { echo " & ". Numbers_Words::toWords($fr) ." ".CMINOR; } } ?></td>
<td colspan="2" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("balance"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo number_format((($inv->total - $paid) + $inv->shipping), 2, '.', ''); ?></td></tr>

<?php } else { ?>

<tr>
<td colspan="6" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("total"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $inv->inv_total; ?></td>
</tr>
<tr>
<td colspan="6" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("tax"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $inv->total_tax; ?></td></tr>

<?php if ($inv->shipping != 0) { ?>
<tr>
<td colspan="6" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("shipping"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $inv->shipping; ?></td></tr>
<?php } ?>

<?php if ($inv->total_discount != 0) { ?>
<tr>
<td colspan="6" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("invoice_total"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td>
<td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo number_format(($inv->total+$inv->shipping+$inv->total_discount), 2, '.', ''); ?></td></tr>

<tr>
<td colspan="6" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("discount").' ('.$inv->discount.')'; ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $inv->total_discount; ?></td></tr>

<tr class="info">
<td colspan="6" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("grand_total"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td>
<td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo number_format(($inv->total+$inv->shipping), 2, '.', ''); ?></td></tr>

<?php } else { ?>
<tr class="info">
<td colspan="6" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("grand_total"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td>
<td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo number_format(($inv->total+$inv->shipping), 2, '.', ''); ?></td></tr>
<?php } ?>
<tr class="success">
<td colspan="6" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("paid"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $paid; ?></td></tr>

<tr class="warning">
<td colspan="6" style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo $this->lang->line("balance"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:20px; font-weight:bold;"><?php echo number_format((($inv->total - $paid) + $inv->shipping), 2, '.', ''); ?></td></tr>

<?php } ?>
	</tbody> 

	</table> 
<div style="clear: both;"></div>
<div class="row-fluid"> 
<div class="span12">    	
    <?php if($inv->note != "<br>" || $inv->note != " ") { ?>
	<p>&nbsp;</p>
	<p><span style="font-weight:bold; font-size:14px; margin-bottom:5px;"><?php echo $this->lang->line("note"); ?>:</span></p>
	<p><?php echo $inv->note; ?></p>
	
    <?php } ?>
</div>
</div>
<div style="clear: both;"></div>
<div class="span4"> 
<p>&nbsp;</p>
<p><?php echo $this->lang->line("buyer"); ?>: <?php if($customer->company != "-") { echo $customer->company; } else { echo $customer->name; } ?> </p>
<p>&nbsp;</p>
<p style="border-bottom: 1px solid #666;">&nbsp;</p>
<p><?php echo $this->lang->line("signature")." &amp; ".$this->lang->line("stamp"); ; ?></p>
</div>
<div class="flearfix"></div>
</div>
<?php if(PRINT_PAYMENT) { if(!empty($payment)) { ?>
<hr><h4><?php echo $this->lang->line("payment_details"); ?></h4>
<table class="table table-bordered table-condensed table-hover table-striped" style="margin-bottom: 5px;">

	<thead> 
	<tr> 
	    <th><?php echo $this->lang->line("date"); ?></th> 
	    <th><?php echo $this->lang->line("amount"); ?></th> 
	</tr> 
	</thead> 
    <tbody>
    <?php foreach ($payment as $p) { ?>
    <tr> 
	    <td><?php echo strftime("%d/%m/%Y", strtotime($p->date)); ?></td> 
	    <td><?php echo $p->amount; ?></td> 
	</tr> 
    <?php } ?>
    </tbody>
</table>    
   <?php } else { //echo "<p>".$this->lang->line("no_payment")."</p>"; 
   } }?> 
   
</body>
</html>