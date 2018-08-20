<script>
             $(document).ready(function() {
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 1, "desc" ]],
                    "iDisplayLength": 10,
					"oTableTools": {
						"sSwfPath": "assets/media/swf/copy_csv_xls_pdf.swf",
						"aButtons": [
								// "copy",
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
					  { "bSortable": false },
					  null,
					  null,
					  null,
	
					  { "bSortable": false }
					]
					
                } );
				
            } );
                    
</script>

<!-- Errors -->
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("list_results"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <table id="fileData" cellpadding=0 cellspacing=10 class="table table-bordered table-condensed table-hover table-striped" style="margin-bottom: 5px;">
      <thead>
        <tr>
          <th style="width:35px;"><?php echo $this->lang->line('no'); ?></th>
          <th><?php echo $this->lang->line('title'); ?></th>
          <th><?php echo $this->lang->line('tax_rate'); ?></th>
          <th><?php echo $this->lang->line('type'); ?></th>
          <th style="width:100px;"><?php echo $this->lang->line('actions'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
		$r = 1;
		foreach ($tax_rates as $row):?>
        <tr>
          <td><?php echo $r; ?></td>
          <td><?php echo $row->name; ?></td>
          <td><?php echo $row->rate; ?></td>
          <td><?php switch ($row->type) {
								case 1:
									echo "Percentage (%)";
									break;
								case 2:
									echo "Fixed ($)";
									break;
						}
					?></td>
          <td><?php echo '<center><div class="btn-group"> <a class="tip btn btn-primary btn-xs" title="'. $this->lang->line('edit_tax_rate').'"  href="index.php?module=settings&view=edit_tax_rate&id=' . $row->id . '"> <i class="fa fa-edit"></i> </a> <a class="tip btn btn-danger btn-xs" title="'.$this->lang->line('delete_tax_rate').'" href="index.php?module=settings&view=delete_tax_rate&id=' . $row->id . '" onClick="return confirm(\''. $this->lang->line('alert_x_tax_rate') .'\')"> <i class="fa fa-trash-o"></i> </a></div></center> 
								
							
                '; ?></td>
        </tr>
        <?php $r++; endforeach;?>
      </tbody>
    </table>
    <p><a href="<?php echo site_url('module=settings&view=add_tax_rate');?>" class="btn btn-primary"><?php echo $this->lang->line('new_tax_rate'); ?></a></p>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
