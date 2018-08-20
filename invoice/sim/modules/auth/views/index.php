<script>
             $(document).ready(function() {
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 0, "asc" ]],
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
					
					  null,
					  null,
					  null,
					  null,
					  null,
					  { "bSortable": false }
					]
					
                } );
				
            } );
                    
</script>

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta"><?php echo $this->lang->line("list_results"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <table id="fileData" class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
      <thead>
        <tr>
          <th><?php echo $this->lang->line("first_name"); ?></th>
          <th><?php echo $this->lang->line("last_name"); ?></th>
          <th><?php echo $this->lang->line("email_address") ?></th>
          <th><?php echo $this->lang->line("phone"); ?></th>
          <th><?php echo $this->lang->line("user_role"); ?></th>
          <th style="width:100px;"><?php echo $this->lang->line("actions"); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user):?>
        <tr>
          <td><?php echo $user->first_name;?></td>
          <td><?php echo $user->last_name;?></td>
          <td><?php echo $user->email;?></td>
          <td><?php echo $user->phone;?></td>
          <td><?php foreach ($user->groups as $group):?>
            <?php echo $group->description;?>
            <?php endforeach?></td>
          <td style="text-align:center;"><?php /* echo ($user->active) ? anchor("auth/deactivate/".$user->id, 'Active') : anchor("auth/activate/". $user->id, 'Inactive'); */ ?>
            <?php echo '<center><div class="btn-group">
                <a class="tip btn btn-primary btn-xs" title="'.$this->lang->line("edit_user").'" href="index.php?module=auth&view=edit_user&id=' . $user->id . '"> <i class="fa fa-edit"></i> </a>';
								if ($this->ion_auth->in_group('admin')) {
								echo '<a class="tip btn btn-danger btn-xs" title="'.$this->lang->line("delete_user").'" href="index.php?module=auth&view=delete_user&id=' . $user->id . '" onClick="return confirm(\''. $this->lang->line('alert_x_user') .'\');">
								<i class="fa fa-trash-o"></i>
								</a></div></center>
                '; }  ?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <p><a href="<?php echo site_url('module=auth&view=create_user');?>" class="btn btn-primary"><?php echo $this->lang->line("add_user"); ?></a></p>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
