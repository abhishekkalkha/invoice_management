<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title><?php echo $this->lang->line("login")." ".SITE_NAME; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="assets/style/bootstrap.css" rel="stylesheet">
  <link rel="assets/stylesheet" href="style/font-awesome.css">
  <link href="assets/style/style.css" rel="stylesheet">
  
  <!--[if lt IE 9]>
  <script src="js/html5shim.js"></script>
  <![endif]-->

  <link rel="shortcut icon" href="assets/img/favicon.png">
  <style> body { background:#111; } .alert { margin-bottom: 20px; padding: 10px; } </style>
</head>

<body>

<div class="admin-form">
  <div class="container">

    <div class="row">
      <div class="col-md-12">
      <div></div>
            <div class="widget worange">
              <div class="widget-head">
               <?php echo $this->lang->line("login_to"); ?> 
              </div>

              <div class="widget-content">
                <div class="padd" style="padding-bottom:0;">
                 <?php $attib = array('class' => 'form-horizontal');  echo form_open("module=auth&view=login", $attib);?> 
                  
                  <?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
       <?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>
        
                    <div class="form-group">
                      <label class="control-label col-lg-3" for="inputEmail"><?php echo $this->lang->line("email"); ?></label>
                      <div class="col-lg-9">
                        <?php echo form_input($identity, '', 'class="form-control" id="inputEmail" placeholder="'.$this->lang->line("email_address").'" autofocus="autofocus"');?>
                        
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-lg-3" for="inputPassword"><?php echo $this->lang->line("pw"); ?></label>
                      <div class="col-lg-9">
                        <?php echo form_input($password,  '', 'class="form-control" id="inputPassword" placeholder="'.$this->lang->line("pw").'"');?>
                      </div>
                    </div>

                    <!--<div class="form-group">
                    <div class="control-label col-lg-3">&nbsp;</div>
					<div class="col-lg-9">
                      <label>
						 <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?> <?php echo $this->lang->line("remember_me"); ?>
                      </label>
					</div>
					</div>-->
               
                     <div class="form-group">
                    <div class="control-label col-lg-3">&nbsp;</div>
                        <div class="col-lg-9">
							<button type="submit" class="btn btn-primary btn-block"><?php echo $this->lang->line("login"); ?></button>
							<!--<button type="reset" class="btn btn-default">Reset</button>-->
						</div>
                    </div>
                  <?php echo form_close();?>
				  
				</div>
                </div>
              
                <div class="widget-foot">
                <strong><?php echo $this->lang->line("forgot_pw"); ?></strong> <a href="index.php?module=auth&view=forgot_password"><?php echo $this->lang->line("click_to_reset"); ?></a> 
                 
                </div>
            </div>  
      </div>
    </div>
  </div> 
</div>
	
		
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.js"></script>
</body>
</html>