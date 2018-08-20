<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title><?php echo $page_title." &middot; ".SITE_NAME; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="assets/img/favicon.png">
<link href="assets/style/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="assets/style/font-awesome.css">
<link rel="stylesheet" href="assets/style/jquery-ui.css">
<link rel="stylesheet" href="assets/style/fullcalendar.css">
<link rel="stylesheet" href="assets/style/prettyPhoto.css">
<link rel="stylesheet" href="assets/style/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="assets/css/datatables.css">
<link href="assets/style/style.css" rel="stylesheet">
<script src="assets/js/jquery.js"></script>
<!--[if lt IE 9]>
  <script src="assets/js/html5shim.js"></script>
  <![endif]-->
</head>

<body>
<div class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a href="<?php echo base_url(); ?>" class="navbar-brand" style="padding:15px; font-size:20px; text-transform:uppercase;"><i class="fa fa-file-text"></i> <?php echo SITE_NAME; ?><!--<img src="<?php echo $this->config->base_url(); ?>assets/img/<?php echo LOGO; ?>" alt="<?php echo SITE_NAME; ?>" />--></a> </div>
    <ul class="nav navbar-nav visible-lg visible-md">
      <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="<?php echo base_url(); ?>assets/img/<?php echo LANGUAGE; ?>.png" style="margin-top:-1px" align="middle"></a>
        <ul class="dropdown-menu" style="min-width: 60px;" role="menu" aria-labelledby="dLabel">
          <?php if ($handle = opendir('sim/language/')) {
			 while (false !== ($entry = readdir($handle))) {
           	 if ($entry != "." && $entry != ".." && $entry != "index.html") {
     		?>
          <li><a href="<?php echo site_url('module=home&view=language&lang='.$entry); ?>"><img src="<?php echo base_url(); ?>assets/img/<?php echo $entry; ?>.png" class="language-img"> &nbsp;&nbsp;
            <?php if($entry == 'bportuguese') { echo "Brazilian Portuguese"; } elseif($entry == 'eportuguese') { echo "European Portuguese"; } else { echo ucwords($entry); } ?>
            </a></li>
          <?php }
            }
            closedir($handle);
            } 
           ?>
        </ul>
      </li>
    </ul>
    <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="fa fa-user"></i> Hi, <?php echo LI_USER; ?> <b class="caret"></b> </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=auth&amp;view=change_password"><i class="fa fa-key"></i> <?php echo $this->lang->line('change_password'); ?></a></li>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=auth&amp;view=logout"><i class="fa fa-sign-out"></i> <?php echo $this->lang->line('logout'); ?></a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right" style="margin-right:0px;">
     <?php  if (DEMO) {
			echo '<li class="blightblue"><a href="http://codecanyon.net/item/simple-invoice-manager-invoicing-made-easy/4259689?ref=tecdiary" target="_blank"><i class="fa fa-shopping-cart"></i> Buy Now</a></li>';
		} ?>
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('home'); ?></a></li>
        <li><a href="<?php echo base_url(); ?>index.php?module=calendar"><i class="fa fa-calendar"></i> <?php echo $this->lang->line('calendar'); ?></a></li>
        <li class="dropdown dropdown-big"> <a class="dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-list"></i> <?php echo $this->lang->line('events'); ?> </a>
          <ul class="dropdown-menu">
            <?php if(UP_EVENTS) { ?>
            <li>
              <h5><i class="fa fa-list"></i> <?php echo $this->lang->line('upcoming_events'); ?></h5>
              <hr />
            </li>
            <?php echo UP_EVENTS; ?>
            <li>
              <div class="drop-foot"> <a href="index.php?module=calendar"><?php echo $this->lang->line('view_all'); ?></a> </div>
            </li>
            <?php } else {?>
            	<li>
              <h5><i class="fa fa-list"></i> <?php echo $this->lang->line('no_upcoming_events'); ?></h5>
            </li>
            <?php } ?>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>
<div class="content">
<div class="sidebar">
  <div class="sidebar-dropdown"><a href="#">Navigation</a></div>
  <div class="sidebar-inner">
    <ul class="navi">
      <li class="nred current"><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="has_submenu nlightblue"> <a href="#"> <i class="fa fa-file-text"></i> <?php echo $this->lang->line('sales'); ?> <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
        <ul>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=sales"><?php echo $this->lang->line('list_invoices'); ?></a></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=sales&amp;view=add"><?php echo $this->lang->line('add_invoice'); ?></a></li>
          <li class="divider"></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=sales&amp;view=quotes"><?php echo $this->lang->line('list_quotes'); ?></a></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=sales&amp;view=add_quote"><?php echo $this->lang->line('add_quote'); ?></a></li>
        </ul>
      </li>
      <li class="has_submenu nblue"> <a href="#"> <i class="fa fa-list"></i> <?php echo $this->lang->line('products'); ?> <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
        <ul>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=products"><?php echo $this->lang->line('list_products'); ?></a></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=products&amp;view=add"><?php echo $this->lang->line('add_product'); ?></a></li>
          <?php if ($this->ion_auth->in_group('admin')) { ?>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=products&amp;view=import"><?php echo $this->lang->line('import_products'); ?></a></li>
          <?php } ?>
        </ul>
      </li>
      <li class="has_submenu nviolet"> <a href="#"> <i class="fa fa-users"></i> <?php echo $this->lang->line('customers'); ?> <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
        <ul>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=customers"><?php echo $this->lang->line('list_customers'); ?></a></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=customers&amp;view=add"><?php echo $this->lang->line('add_customer'); ?></a></li>
        </ul>
      </li>
      <?php if ($this->ion_auth->in_group('admin')) { ?>
      <li class="has_submenu ngreen"> <a href="#"> <i class="fa fa-users"></i> <?php echo $this->lang->line('users'); ?> <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
        <ul>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=auth&view=users"><?php echo $this->lang->line('list_users'); ?></a></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=auth&amp;view=create_user"><?php echo $this->lang->line('new_user'); ?></a></li>
        </ul>
      </li>
      <li class="has_submenu norange"> <a href="#"> <i class="fa fa-cog"></i> <?php echo $this->lang->line('settings'); ?> <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
        <ul>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=settings&amp;view=system_setting"><?php echo $this->lang->line('system_setting'); ?></a></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=settings&amp;view=company_details"><?php echo $this->lang->line('company_details'); ?></a></li>
          <!--<li><a href="<?php echo $this->config->base_url(); ?>index.php?module=settings&amp;view=change_logo"><?php echo $this->lang->line('change_logo'); ?></a></li>-->
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=settings&amp;view=change_invoice_logo"><?php echo $this->lang->line('change_invoice_logo'); ?></a></li>
          <li class="divider"></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=settings&amp;view=tax_rates"><?php echo $this->lang->line('tax_rates'); ?></a></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=settings&amp;view=add_tax_rate"><?php echo $this->lang->line('add_tax_rate'); ?></a></li>
          <li class="divider"></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=settings&amp;view=backup_database"><?php echo $this->lang->line('backup_database'); ?></a></li>
        </ul>
      </li>
      <?php } ?>
      <li class="has_submenu nblue"> <a href="#"> <i class="fa fa-bar-chart-o"></i> <?php echo $this->lang->line('reports'); ?> <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
        <ul>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=reports&view=daily_sales"><?php echo $this->lang->line('daily_sales'); ?></a></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=reports&view=monthly_sales"><?php echo $this->lang->line('monthly_sales'); ?></a></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=reports&view=sales"><?php echo $this->lang->line('sales_report'); ?></a></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=reports&view=payments"><?php echo $this->lang->line('payment_reports'); ?></a></li>
        </ul>
      </li>
      <li class="has_submenu nred"> <a href="#"> <i class="fa fa-user"></i> Hi, <?php echo LI_USER; ?>! <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
        <ul>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=auth&amp;view=change_password"><?php echo $this->lang->line('change_password'); ?></a></li>
          <li class="divider"></li>
          <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=auth&amp;view=logout"><?php echo $this->lang->line('logout'); ?></a></li>
        </ul>
      </li>
    </ul>
    <div class="sidebar-widget">
      <div id="todaydate"></div>
    </div>
    <div class="sidebar-widget" style="text-align:center; letter-spacing:2px; color:#666; text-transform:uppercase;"> <?php echo SITE_NAME.' v'.VERSION; ?> </div>
  </div>
</div>
<div class="mainbar">
