<link href="<?php echo $this->config->base_url(); ?>assets/css/calender.css" rel="stylesheet">
<div class="page-head">
  <h2 class="pull-left"><?php echo $page_title; ?> <span class="page-meta">Total = <span class='violet'>Violet</span>, Paid = <span class='green'>Green</span> and Pending = <span class='orange'>Orange</span></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
<p>&nbsp;</p>
<style>
.table td { width: 8.333%; }
.table tr:first-child td { text-align:center; }
.table tr:last-child td { text-align:right; }
</style>

    <table class="table table-bordered" style="min-width:522px;">
    <thead>
    <tr>
    <th><div class="text-center"> <a href="index.php?module=reports&view=monthly_sales&year=<?php echo $year-1; ?>">&lt;&lt;</a> </div></th>
    <th colspan="10"><div class="text-center"> <?php echo $year; ?> </div></td>
    <th><div class="text-center"> <a href="index.php?module=reports&view=monthly_sales&year=<?php echo $year+1; ?>">&gt;&gt;</a> </div></th>
    </th>
    </tr>
    </thead> 
    <tr>
    <td>January</td>
    <td>Feburary</td>
    <td>March</td>
    <td>April</td>
    <td>May</td>
    <td>June</td>
    <td>July</td>
    <td>August</td>
    <td>September</td>
    <td>October</td>
    <td>November</td>
    <td>December</td>
    </tr>
    <tr>
	<?php
	if(!empty($sales)) {
		
		foreach($sales as $value) {
			$array[$value->date] = "<span class='violet'>". $value->total."</span><br><span class='green'>".$value->paid."</span><br><span class='orange'>".number_format(($value->total - $value->paid), 2, '.', '')."</span>";
		}

		for ($i = 1; $i <= 12; $i++){
       		echo "<td>";
       			if(isset($array[$i])) {
        			echo $array[$i]; 
				} else { echo "<span class='violet'>0.00</span><br><span class='green'>0.00</span><br><span class='orange'>0.00</span>"; }
        	echo "</td>";
    	}
		
	} else {
		for($i=1; $i<=12; $i++) {
			echo "<td><span class='violet'>0.00</span><br><span class='green'>0.00</span><br><span class='orange'>0.00</span></td>";
		}
	}
	?>
    </tr>
    </table>
<div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>