<?php
if($this->input->post('submit')) {
		   
		  $v = "";
		   if($this->input->post('customer')){
			   $v .= "&customer=".$this->input->post('customer');
		   } 
		   if($this->input->post('start_date')){
			   $v .= "&start_date=".$this->input->post('start_date');
		   }
		   if($this->input->post('end_date')) {
			    $v .= "&end_date=".$this->input->post('end_date');
		   }
		   if($this->input->post('note')){
			   $v .= "&note=".$this->input->post('note');
		   }
	  
}
?>
<script src="<?php echo $this->config->base_url(); ?>assets/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<link href="<?php echo $this->config->base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url(); ?>assets/css/chosen.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url(); ?>assets/css/chosen-bootstrap.css" rel="stylesheet">
<style type="text/css">
body { background: #111; }
.mainbar { min-height:768px; }
.text_filter { width: 100% !important; border: 0 !important; box-shadow: none !important;  border-radius: 0 !important;  padding:0 !important; margin:0 !important; }
.select_filter { width: 100% !important; padding:0 !important; height: auto !important; margin:0 !important;}
.table thead th { text-align:center; font-weight:bold; }
.table tfoot th:nth-child(5), .table td:nth-child(5), .table tfoot th:nth-child(6), .table td:nth-child(6), .table tfoot th:nth-child(7), .table td:nth-child(7) { text-align: right; }
.table tfoot th:nth-child(5), .table tfoot th:nth-child(6), .table tfoot th:nth-child(7) { font-weight:bold; }
.table td:nth-child(6) { text-transform: capitalize; }

.today-datas li {
	width: 16%;
	min-width:130px;
	margin-right:0.5%;
	margin-bottom:10px;
	height:90px;
	vertical-align:middle;
	display: inline-table;
	text-align:center;
	text-transform:uppercase;
}
.today-datas li:last-child, .t li:last-child { margin-right:0; }
.t li { width:32.7%; min-width:150px; }

</style>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/chosen.jquery.js"></script>
<script type="text/javascript">
 
$(document).ready(function(){
 
	//$("form select").chosen({no_results_text: "No results matched", disable_search_threshold: 5, allow_single_deselect:true});
	
	$( "#start_date" ).datepicker({
        	dateFormat: "<?php echo JS_DATE; ?>",
			autoclose: true
    	});

		$( "#end_date" ).datepicker({
        	dateFormat: "<?php echo JS_DATE; ?>",
			autoclose: true
    	});
		$( "#end_date" ).datepicker("setDate", new Date());
		
		<?php if($this->input->post('submit')) { echo "$('.form').hide();"; } ?>
        $(".show_hide").slideDown('slow');
 
		$('.show_hide').click(function(){
			$(".form").slideToggle();
			return false;
		});
		
		function status(x) {
			var st = x.split('-');
			switch (st[0]) {
				case '<?php echo $this->lang->line('paid'); ?>':
					return '<span class="label'+st[1]+' label label-success">'+st[0]+'</span>';
		  			break;
					
				case '<?php echo $this->lang->line('partially_paid'); ?>':
					return '<span class="label'+st[1]+' label label-info">'+st[0]+'</span>';
		  			break;
					
				case '<?php echo $this->lang->line('pending'); ?>':
					return '<span class="label'+st[1]+' label label-warning">'+st[0]+'</span>';
		  			break;
					
				case '<?php echo $this->lang->line('overdue'); ?>':
					return '<span class="label'+st[1]+' label label-danger">'+st[0]+'</span>';
		  			break;	
					
				case '<?php echo $this->lang->line('cancelled'); ?>':
					return '<span class="label'+st[1]+' label label-danger">'+st[0]+'</span>';
		  			break;		
		  
				default:
		  			return '<span class="label'+st[1]+' label label-default">'+st[0]+'</span>';
		  
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

                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 0, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=reports&view=getpayments<?php if($this->input->post('submit')) { echo $v; } ?>',
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
					  null
					],
					
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			var rTotal = 0, pTotal = 0, bTotal = 0;
			for ( var i=0 ; i<aaData.length ; i++ )
			{
				rTotal += aaData[ aiDisplay[i] ][4]*1;
			}
			
			var nCells = nRow.getElementsByTagName('th');
			nCells[4].innerHTML = parseFloat(rTotal).toFixed(2);
		}
					
                } ).columnFilter({ aoColumns: [
                                                            //{ type: "text", bRegex:true },
															//null, null, null, null, null, null, null, null,
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true }
															
                                                            
                                                        ]});

				
            } );
                    
</script>

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><a href="#" class="btn btn-primary btn-xs show_hide"><?php echo $this->lang->line("show_hide"); ?></a></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
<div class="form">

<p>Please customise the report below.</p>
<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=reports&view=payments"); ?>
<div class="form-group">
  <label for="customer"><?php echo $this->lang->line("customer"); ?></label>
  <div class="controls">
    <?php 
	   		$cu[""] = $this->lang->line("select")." ".$this->lang->line("customer");
	   		foreach($customers as $customer){
				$cu[$customer->id] = $customer->name;
			}
			echo form_dropdown('customer', $cu, (isset($_POST['customer']) ? $_POST['customer'] : ""), 'class="form-control customer" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("customer").'" id="customer"');  ?>
  </div>
</div>
<div class="row">
    <div class="col-md-6">
<div class="form-group">
  <label for="start_date"><?php echo $this->lang->line("start_date"); ?></label>
  <div class="controls"> <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="form-control" id="start_date"');?> </div>
</div>

</div>

<div class="col-md-6">
<div class="form-group">
  <label for="end_date"><?php echo $this->lang->line("end_date"); ?></label>
  <div class="controls"> <?php echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="form-control" id="end_date"');?> </div>
</div>
</div>
</div>
<div class="form-group">
  <label for="start_date"><?php echo $this->lang->line("note"); ?></label>
  <div class="controls"> <?php echo form_input('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="note"');?> </div>
</div>

<div class="form-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?>

</div>
<div class="clearfix"></div>
<?php if($this->input->post('submit')) { ?>
<?php if($this->input->post('customer')){ ?>
	<div class="widget wlightblue"> 
          <div class="widget-head">
            <div class="pull-left"><?php echo $this->lang->line('name').": <strong>".$cus->name."</strong> &nbsp;&nbsp;&nbsp;&nbsp;".$this->lang->line('email').": <strong>".$cus->email."</strong> &nbsp;&nbsp;&nbsp;&nbsp;".$this->lang->line('phone').": <strong>".$cus->phone."</strong>"; ?></div>
            <div class="widget-icons pull-right"> <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a> <a class="wclose" href="#"><i class="icon-remove"></i></a> </div>
            <div class="clearfix"></div>
          </div>
          
          <div class="widget-content">
            <div class="padd">
              <ul class="today-datas">
                <li class="bviolet"> <span class="bold" style="font-size:24px;">
                  <?php /* echo CURRENCY_PREFIX." ".$total['total_amount']; */ ?>
                  <?php echo $total; ?></span><br>
                  <?php echo $this->lang->line('total'); ?> <?php echo $this->lang->line('invoices'); ?>
                  <div class="clearfix"></div>
                </li>
                <li class="bgreen"> <span class="bold" style="font-size:24px;">
                  <?php /* echo CURRENCY_PREFIX." ".$paid['total_amount'];*/ ?>
                  <?php echo $paid; ?></span><br>
                  <?php echo $this->lang->line('paid'); ?>
                  <div class="clearfix"></div>
                </li>
                <li class="bblue"> <span class="bold" style="font-size:24px;"><?php echo $pp; ?></span><br>
                  <?php echo $this->lang->line('partially_paid'); ?>
                  <div class="clearfix"></div>
                </li>
                <li class="borange"> <span class="bold" style="font-size:24px;"><?php echo $pending; ?></span><br>
                  <?php echo $this->lang->line('pending'); ?>
                  <div class="clearfix"></div>
                </li>
                <li class="bred"> <span class="bold" style="font-size:24px;"><?php echo $overdue; ?></span><br>
                  <?php echo $this->lang->line('overdue'); ?>
                  <div class="clearfix"></div>
                </li>
                <li class="bred" style="background:#000 !important;"> <span class="bold" style="font-size:24px;"><?php echo $cancelled; ?></span><br>
                  <?php echo $this->lang->line('cancelled'); ?>
                  <div class="clearfix"></div>
                </li>
              </ul>
              <hr />
              <ul class="today-datas t">
                <li class="bviolet"> <span class="bold" style="font-size:24px;">
                  <?php /* echo CURRENCY_PREFIX." ".$total['total_amount']; */ ?>
                  <?php echo $tpp->total; ?></span><br>
                  <?php echo $this->lang->line('total'); ?> <?php echo $this->lang->line('amount'); ?>
                  <div class="clearfix"></div>
                </li>
                <li class="bgreen"> <span class="bold" style="font-size:24px;">
                  <?php /* echo CURRENCY_PREFIX." ".$paid['total_amount'];*/ ?>
                  <?php echo $tpp->paid; ?></span><br>
                  <?php echo $this->lang->line('paid'); ?> <?php echo $this->lang->line('amount'); ?>
                  <div class="clearfix"></div>
                </li>
                <li class="borange"> <span class="bold" style="font-size:24px;"><?php echo number_format(($tpp->total - $tpp->paid), 2, '.', ''); ?></span><br>
                  <?php echo $this->lang->line('balance'); ?> <?php echo $this->lang->line('amount'); ?>
                  <div class="clearfix"></div>
                </li>
                </ul>
            </div>
          </div>
        </div>
<?php }	?>

<table id="fileData" cellpadding=0 cellspacing=10 class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
		<thead>
        <tr class="active">
          <th><?php echo $this->lang->line("date"); ?></th>
          <th><?php echo $this->lang->line("invoice").' '.$this->lang->line("no"); ?></th>
          <th><?php echo $this->lang->line("customer"); ?></th>
          <th><?php echo $this->lang->line("added_by"); ?></th>
          <th><?php echo $this->lang->line("amount"); ?></th>
		</tr>
        </thead>
		<tbody>
			<tr>
            	<td colspan="7" class="dataTables_empty">Loading data from server</td>
			</tr>
        </tbody>
        
        <tfoot>
        <tr>
           <th><?php echo $this->lang->line("date"); ?></th>
          <th><?php echo $this->lang->line("invoice").' '.$this->lang->line("no"); ?></th>
          <th><?php echo $this->lang->line("customer"); ?></th>
          <th><?php echo $this->lang->line("added_by"); ?></th>
          <th><?php echo $this->lang->line("amount"); ?></th>
		</tr>
        </tfoot>
	</table>
<?php 
	}
	?>
<div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
