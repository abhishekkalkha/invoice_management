<?php $v = ''; 
if($customer_id) { $v .= '&customer_id='.$customer_id; }
?>
<script src="<?php echo $this->config->base_url(); ?>assets/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<style type="text/css">
.text_filter {
	width: 100% !important;
	border: 0 !important;
	box-shadow: none !important;
	border-radius: 0 !important;
	padding:0 !important;
	margin:0 !important;
}
.select_filter {
	width: 100% !important;
	padding:0 !important;
	height: auto !important;
	margin:0 !important;
}
.table tfoot th:nth-child(5), .table td:nth-child(5), .table tfoot th:nth-child(6), .table td:nth-child(6), .table tfoot th:nth-child(7), .table td:nth-child(7) {
text-align: right;
}
.table td:nth-child(6) {
text-transform: capitalize;
}
.table td {
	width:10%;
}
.table td:first-child, .table td:nth-child(8) {
width: 6%;
}
.table td:nth-child(8) {
text-align:center;
}
.table td:nth-child(8) span { display:block; }
.table td:nth-child(3), .table td:nth-child(5), .table td:nth-child(6), .table td:nth-child(7) {
width:5%;
}
</style>
<script>
     $(document).ready(function() {
		function status(x) {
			var st = x.split('-');
			switch (st[0]) {
				case '<?php echo $this->lang->line('paid'); ?>':
					return '<a id="'+st[1]+'" href="#myModal" role="button" data-toggle="modal" class="st"><span class="label'+st[1]+' label label-success">'+st[0]+'</span></a>';
		  			break;
					
				case '<?php echo $this->lang->line('partially_paid'); ?>':
					return '<a id="'+st[1]+'" href="#myModal" role="button" data-toggle="modal" class="st"><span class="label'+st[1]+' label label-info">'+st[0]+'</span></a>';
		  			break;
					
				case '<?php echo $this->lang->line('pending'); ?>':
					return '<a id="'+st[1]+'" href="#myModal" role="button" data-toggle="modal" class="st"><span class="label'+st[1]+' label label-warning">'+st[0]+'</span></a>';
		  			break;
					
				case '<?php echo $this->lang->line('overdue'); ?>':
					return '<a id="'+st[1]+'" href="#myModal" role="button" data-toggle="modal" class="st"><span class="label'+st[1]+' label label-danger">'+st[0]+'</span></a>';
		  			break;	
					
				case '<?php echo $this->lang->line('cancelled'); ?>':
					return '<a id="'+st[1]+'" href="#myModal" role="button" data-toggle="modal" class="st"><span class="label'+st[1]+' label label-danger">'+st[0]+'</span></a>';
		  			break;		
		  
		  
				default:
		  			return '<a id="'+st[1]+'" href="#myModal" role="button" data-toggle="modal" class="st"><span class="label'+st[1]+' label label-default">'+st[0]+'</span></a>';
		  
			}
		}
		
			function format_date(oObj) {
					//var sValue = oObj.aData[oObj.iDataColumn]; 
					var aDate = oObj.split('-');
					<?php if(JS_DATE == 'dd-mm-yy') { ?>
					return aDate[2] + "-" + aDate[1] + "-" + aDate[0];
					<?php } elseif(JS_DATE == 'dd/mm/yy') { ?>
					return aDate[2] + "/" + aDate[1] + "/" + aDate[0];
					<?php } elseif(JS_DATE == 'dd.mm.yy') { ?>
					return aDate[2] + "." + aDate[1] + "." + aDate[0];
					<?php } elseif(JS_DATE == 'mm/dd/yy') { ?>
					return aDate[1] + "/" + aDate[2] + "/" + aDate[0];
					<?php } elseif(JS_DATE == 'mm-dd-yy') { ?>
					return aDate[1] + "-" + aDate[2] + "-" + aDate[0];
					<?php } elseif(JS_DATE == 'mm.dd.yy') { ?>
					return aDate[1] + "." + aDate[2] + "." + aDate[0];
					<?php } else { ?>
					return sValue;
					<?php } ?>
				}
				
							 
	 	var inv_id;
   
              $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 0, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=sales&view=getdatatableajax<?php echo $v; ?>',
					'fnServerData': function(sSource, aoData, fnCallback)
					{
						aoData.push( { "name": "<?php echo $this->security->get_csrf_token_name(); ?>", "value": "<?php echo $this->security->get_csrf_hash() ?>" } );
					  $.ajax
					  ({
						'dataType': 'json',
						'type'    : 'POST',
						'url'     : sSource,
						'data'    : aoData,
						'success' : fnCallback
					  });
					},
					"oTableTools": {
						"sSwfPath": "assets/media/swf/copy_csv_xls_pdf.swf",
						"aButtons": [
								"csv",
								"xls",
								{
									"sExtends": "pdf",
									"sPdfOrientation": "landscape",
									"sPdfMessage": ""
								},
								"print"
						]
					},
					
					"aoColumns": [ 
					  { "mRender": format_date },
					  null,
					  null,
					  null,
					  { "bSearchable": false },
					  { "bSearchable": false },
					  { "bSearchable": false },
					  { "mRender": status },
					  { "bSortable": false }
					],
					
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			var rTotal = 0, pTotal = 0, bTotal = 0;
			for ( var i=0 ; i<aaData.length ; i++ )
			{
				rTotal += aaData[ aiDisplay[i] ][4]*1;
				pTotal += aaData[ aiDisplay[i] ][5]*1;
				bTotal += aaData[ aiDisplay[i] ][6]*1;
			}
			
			var nCells = nRow.getElementsByTagName('th');
			nCells[4].innerHTML = parseFloat(rTotal).toFixed(2);
			nCells[5].innerHTML = parseFloat(pTotal).toFixed(2);
			nCells[6].innerHTML = parseFloat(bTotal).toFixed(2);
		}
					
                } ).columnFilter({ aoColumns: [
                                                            //{ type: "text", bRegex:true },
															//null, null, null, null, null, null, null, null,
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true },
															null, null,
															{ type: "select", values: [ '<?php echo $this->lang->line('paid'); ?>','<?php echo $this->lang->line('partially_paid'); ?>','<?php echo $this->lang->line('pending'); ?>', '<?php echo $this->lang->line('overdue'); ?>', '<?php echo $this->lang->line('cancelled'); ?>'] },
															null
                                                            
                                                        ]});
				
          
	   
	$('#fileData').on("click", ".st", function(){
	  inv_id = $(this).attr('id');
   });
	
	var inv_st;
	$('#myModal').on('show.bs.modal', function () {
		inv_st = $('.label'+inv_id).text();
		if(inv_st == '<?php echo $this->lang->line('paid'); ?>') {
			var r = confirm("<?php echo $this->lang->line('paid_status_change'); ?>");
			if (r == false) {
				return false;
			} 
		}
		$('#new_status').val(inv_st); 
	})

	
	$('#myModal').on("click", "#update_status", function(){
		$('#update_status').text('Loading...');
		var new_status = $('#new_status').val();
		if(new_status != inv_st) {
			$.ajax({
					  type: "post",
					  url: "index.php?module=sales&view=update_status",
					  data: { id: inv_id, status: new_status, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash() ?>' },
					  success: function(data) {
						location.reload();
					  },
					  error: function(){
       					alert('<?php echo $this->lang->line('ajax_error'); ?>');
						$('#update_status').text('<?php echo $this->lang->line('update'); ?>');
				
    				  }
					  
			});
		} else { alert('<?php echo $this->lang->line('same_status'); ?>'); $(this).text('<?php echo $this->lang->line('update'); ?>'); //$('#myModal').modal('hide'); 
		return false; }
	});
	
	$('#fileData').on('click', '.add_payment', function() {
			var vid = $(this).attr('id');
			var cid = $(this).attr('data-customer');
			$('#vid').val(vid);
			$('#cid').val(cid);
			$('#payModal').modal();
			return false;
		});
		
		$('#payModal').on('click', '#add-payment', function() {
			$(this).text('Loading...');
			var vid = $('#vid').val();
			var cid = $('#cid').val();
			var note = $('#note').val();
			var amount = $('#amount').val();
			if(amount != '') {
				$.ajax({
					  type: "post",
					  url: "index.php?module=sales&view=add_payment",
					  data: { invoice_id: vid, customer_id: cid, amount: amount, note: note, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash() ?>' },
					  success: function(data) {
						location.reload();
					  },
					  error: function(){
       					alert('<?php echo $this->lang->line('ajax_error'); ?>');
				
    				  }
					  
				});
			} else { alert('<?php echo $this->lang->line('no_amount'); ?>'); $(this).text('<?php echo $this->lang->line('add_payment'); ?>'); //$('#payModal').modal('hide'); 
			return false; }
			
		});
		
		
		$('#fileData').on('click', '.email_inv', function() {
			var vid = $(this).attr('id');
			var cid = $(this).attr('data-customer');
			$.getJSON( "index.php?module=sales&view=getCE", { id: cid, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash() ?>' }).done(function( json ) {
				$('#customer_email').val(json.ce);
			});
			
			$('#emailModalLabel').text('<?php echo $this->lang->line("email")." ".$this->lang->line("invoice")." ".$this->lang->line("no"); ?> '+vid);
			$('#subject').val('<?php echo $this->lang->line("invoice")." from ".SITE_NAME; ?>');
			$('#inv_id').val(vid);
			$('#emailModal').modal();
			return false;
		});
		
		$('#emailModal').on('click', '#email_now', function() {
			$(this).text('Sending...');
			var vid = $('#inv_id').val();
			var to = $('#customer_email').val();
			var subject = $('#subject').val();
			var note = $('#message').val();

			if(to != '') {
				$.ajax({
					  type: "post",
					  url: "index.php?module=sales&view=send_email",
					  data: { id: vid, to: to, subject: subject, note: note, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash() ?>' },
					  success: function(data) {
						alert(data);
					  },
					  error: function(){
       					alert('<?php echo $this->lang->line('ajax_error'); ?>');
    				  }
					  
				});
			} else { alert('<?php echo $this->lang->line('to'); ?>'); }
			$('#emailModal').modal('hide');
			$(this).text('<?php echo $this->lang->line('send_email'); ?>');
			return false;
			
		});
		
	});
</script>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>
<?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("list_results"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
      <div class="table-responsive">
    <table id="fileData" cellpadding=0 cellspacing=10 class="table table-bordered table-condensed table-hover table-striped" style="margin-bottom: 5px;">
      <thead>
        <tr class="active">
          <th><?php echo $this->lang->line("date"); ?></th>
          <th><?php echo $this->lang->line("reference_no"); ?></th>
          <th><?php echo $this->lang->line("created_by"); ?></th>
          <th><?php echo $this->lang->line("customer"); ?></th>
          <th><?php echo $this->lang->line("total"); ?></th>
          <th><?php echo $this->lang->line("paid"); ?></th>
          <th><?php echo $this->lang->line("balance"); ?></th>
          <th><?php echo $this->lang->line("status"); ?></th>
          <th style="width:125px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="9" class="dataTables_empty">Loading data from server</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th><?php echo $this->lang->line("date"); ?> [yyyy-mm-dd]</th>
          <th><?php echo $this->lang->line("reference_no"); ?></th>
          <th><?php echo $this->lang->line("created_by"); ?></th>
          <th><?php echo $this->lang->line("customer"); ?></th>
          <th><?php echo $this->lang->line("total"); ?></th>
          <th><?php echo $this->lang->line("paid"); ?></th>
          <th><?php echo $this->lang->line("balance"); ?></th>
          <th><?php echo $this->lang->line("status"); ?></th>
          <th style="width:125px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th>
        </tr>
      </tfoot>
    </table>
      </div>
    <p><a href="<?php echo site_url('module=sales&view=add');?>" class="btn btn-primary"><?php echo $this->lang->line("add_invoice"); ?></a></p>
    
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('update_invoice_status'); ?></h4>
      </div>
      <div class="modal-body">
      <p class="red"><?php echo $this->lang->line("status_change_x_payment"); ?></p>
       <div class="control-group">
          <label class="control-label" for="new_status"><?php echo $this->lang->line("new_status"); ?></label>
          <div class="controls" id="change_status">
            <?php 
	
			$st = array(
				'' 		=> $this->lang->line("select")." ".$this->lang->line("status"),
				$this->lang->line('cancelled') => $this->lang->line('cancelled'),
				$this->lang->line('overdue') 	=> $this->lang->line('overdue'),
				$this->lang->line('paid')		=> $this->lang->line('paid'),
				$this->lang->line('pending')	=> $this->lang->line('pending')
			);

			echo form_dropdown('new_status', $st, '', 'class="new-status span4" id="new_status"');  ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('close'); ?></button>
        <button class="btn btn-primary" id="update_status"><?php echo $this->lang->line('update'); ?></button>
      </div>
    </div>
    </div>
    </div>
  <div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('add_payment'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="control-group">
          <label class="control-label" for="amount"><?php echo $this->lang->line("amount_paid"); ?></label>
          <div class="controls"> <?php echo form_input('amount', '', 'class="input-block-level" id="amount"');?> </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="note"><?php echo $this->lang->line("note"); ?></label>
          <div class="controls"> <?php echo form_textarea('note', '', 'class="input-block-level" id="note" style="height:100px;"');?> </div>
        </div>
        <input type="hidden" name="cid" value="" id="cid" />
        <input type="hidden" name="vid" value="" id="vid" />
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('close'); ?></button>
        <button class="btn btn-primary" id="add-payment"><?php echo $this->lang->line('add_payment'); ?></button>
      </div>
    </div>
    
    <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="emailModalLabel"></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
  <label for="from"><?php echo $this->lang->line("from"); ?></label>
  <div class="controls"> <strong><?php echo $from_name; echo " &lt;".$from_email."&gt;"; /*form_input($from_name, '', 'class="text"'); */ ?></strong></div>
</div>
<div class="form-group">
  <label for="customer_email"><?php echo $this->lang->line("to"); ?></label>
  <div class="controls"> <?php echo form_input('to', '', 'class="form-control" id="customer_email"');?></div>
</div>
<div class="form-group">
  <label for="subject"><?php echo $this->lang->line("subject"); ?></label>
  <div class="controls">
  <?php echo form_input('subject', '', 'class="form-control" id="subject"');?> </div>
</div>
<div class="form-group">
  <label for="message"><?php echo $this->lang->line("message"); ?></label>
  <div class="controls"> <?php echo form_textarea('note', $this->lang->line("find_attachment"), 'id ="message" class="form-control" placeholder="'.$this->lang->line("add_note").'" rows="3" style="margin-top: 10px; height: 100px;"');?> </div>
</div>
      <input type="hidden" id="inv_id" value="" />  
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('close'); ?></button>
        <button class="btn btn-primary" id="email_now"><?php echo $this->lang->line('send_email'); ?></button>
      </div>
    </div>
    
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
