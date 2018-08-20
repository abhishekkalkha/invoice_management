<style>
.today-datas li {
	width: 30%;
	min-width:150px;
	margin-left:1%;
	margin-bottom:10px;
	height:90px;
	vertical-align:middle;
	display: inline-table;
	text-align:center;
	text-transform:uppercase;
}
.shots {
	list-style-type: none;
	margin: 10px 0;
	padding: 0;
}
.shots li {
	font-size:14px;
	float: left;
	display: inline-block;
	width: 23%;
	min-width:145px;
	margin-bottom: 5px;
	height:45px;
	margin-right: 1%;
	padding:10px;
}
<?php if($this->ion_auth->in_group('admin')) { ?>
.shots li:nth-child(11) { font-size:12px; }
<?php } else { ?>
.shots li:nth-child(9) { font-size:12px; }
<?php } ?>
.shots li i {
	font-size:16px;
}
</style>
<script src="<?php echo base_url(); ?>/assets/js/sl/highcharts.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/sl/modules/exporting.js"></script>
<script type="text/javascript">
$(function () {
    var chart;
    
    $(document).ready(function () {
    	
        $('#chart').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
			colors: [ 
   '#43C83C', 
   '#1171A3', 
   '#F88529', 
   '#FA3031', 
   '#000000',
   '#932AB6',
   '#f28f43', 
   '#77a1e5', 
   '#c42525', 
   '#a6c96a'
],
			credits: {
			  	enabled: false
			},
            title: {
                text: ''
            },

			tooltip: {
				shared: true,
                valueSuffix: '<?php echo CURRENCY_PREFIX; ?>',
				headerFormat: '<span style="font-size:18px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:5px;">{series.name}: </td>' +
                    '<td style="color:{series.color};padding:5px;text-align:right;"><b>{point.percentage:.1f}%</b></td></tr>',
                footerFormat: '</table>',
                useHTML: true,
				valueDecimals: 2,
				hideDelay: 200,
				crosshairs: true,
				style: {
					fontSize: '15px',
					padding: '10px',
					fontWeight: 'bold',
					color: '#000000'
				}
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Invoices',
                data: [
                   /* ['<?php echo $this->lang->line('total'); ?>',   <?php echo $total; ?>],*/
                    ['<?php echo $this->lang->line('paid'); ?>',   <?php echo $paid; ?>],
					['<?php echo $this->lang->line('partially_paid'); ?>',   <?php echo $pp; ?>],
					['<?php echo $this->lang->line('pending'); ?>',   <?php echo $pending; ?>],
					['<?php echo $this->lang->line('overdue'); ?>',   <?php echo $overdue; ?>],
					['<?php echo $this->lang->line('cancelled'); ?>',   <?php echo $cancelled; ?>]
                ]
            }]
        });
    });
    
});
</script>
<?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head"> 
  <h2 class="pull-left"><?php echo $page_title; ?> 
    <span class="page-meta"><?php echo $name; ?> </span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="widget wlightblue"> 
          <div class="widget-head">
            <div class="pull-left"><?php echo SITE_NAME; ?> Overview</div>
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
            </div>
          </div>
        </div>
        <div class="widget wlightblue"> 
          <div class="widget-head">
            <div class="pull-left">Important Links</div>
            <div class="widget-icons pull-right"> <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a> <a class="wclose" href="#"><i class="icon-remove"></i></a> </div>
            <div class="clearfix"></div>
          </div>
          
          <div class="widget-content">
            <div class="padd">
              <ul class="shots">
                <li class="blightblue"> <a href="index.php?module=sales"> <span style="font-size: px"><i class="fa fa-file-text"></i> <?php echo $this->lang->line("sales"); ?></span> </a> </li>
                <li class="blightblue"> <a href="index.php?module=sales&view=add"> <span style="font-size: px"><i class="fa fa-file-text"></i> <?php echo $this->lang->line("new_sale"); ?></span> </a> </li>
                <li class="borange"> <a href="index.php?module=sales&view=quotes"> <span style="font-size: px"><i class="fa fa-file"></i> <?php echo $this->lang->line("quotes"); ?></span> </a> </li>
                <li class="borange"> <a href="index.php?module=sales&view=add_quote"> <span style="font-size: px"><i class="fa fa-file"></i> <?php echo $this->lang->line("add_quote"); ?></span> </a> </li>
                <li class="blightblue"> <a href="index.php?module=calendar"> <span style="font-size: px"><i class="fa fa-calendar"></i> <?php echo $this->lang->line("calendar"); ?></span> </a> </li>
                <li class="bviolet"> <a href="index.php?module=customers"> <span style="font-size: px"><i class="fa fa-users"></i> <?php echo $this->lang->line("customers"); ?></span> </a>
                <li class="bviolet"> <a href="index.php?module=customers&view=add"> <span style="font-size: px"><i class="fa fa-user"></i> <?php echo $this->lang->line("add_customer"); ?></span> </a> </li>
                <li class="bgreen"> <a href="index.php?module=reports&view=daily_sales"> <span style="font-size: px"><i class="fa fa-bar-chart-o"></i> <?php echo $this->lang->line("reports"); ?></span> </a> </li>
                <?php if($this->ion_auth->in_group('admin')) { ?>
                <li class="bblue"> <a href="index.php?module=auth&view=users"> <span style="font-size: px"><i class="fa fa-users"></i> <?php echo $this->lang->line("users"); ?></span> </a> </li>
                <li class="bblue"> <a href="index.php?module=auth&view=create_user"> <span style="font-size: px"><i class="fa fa-user"></i> <?php echo $this->lang->line("add_user"); ?></span> </a> </li>
                <?php } ?>
                <li class="bblue"> <a href="index.php?module=auth&view=change_password"> <span style="font-size: px"><i class="fa fa-key"></i> <?php echo $this->lang->line("change_password"); ?></span> </a> </li>
                <li class="bred"> <a href="index.php?module=auth&view=logout"> <span style="font-size: px"><i class="fa fa-sign-out"></i> <?php echo $this->lang->line("logout"); ?></span> </a> </li>
              </ul>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6"> 
        
        <div class="widget wlightblue"> 
          <div class="widget-head">
            <div class="pull-left">Overview Chart</div>
            <div class="widget-icons pull-right"> <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a> <a class="wclose" href="#"><i class="icon-remove"></i></a> </div>
            <div class="clearfix"></div>
          </div>
          
          <div class="widget-content">
            <div class="padd">
              <div style="width:100%;">
                <div id="chart"></div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
