<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales extends MX_Controller {



	 
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('module=auth&view=login');
	  	}
		$this->load->library('form_validation');
		$this->load->model('sales_model');
		$this->locale = 'en_US';
		$this->load->library('mywords');
		$this->mywords->load('Numbers/Words');

	}
/* -------------------------------------------------------------------------------------------------------------------------------- */
//index or inventories page
	
   function index()
   {
	  
			
	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
	   $data['success_message'] = $this->session->flashdata('success_message');
	   
	    if($this->input->get('customer_id')){ $data['customer_id'] = $this->input->get('customer_id'); } else { $data['customer_id'] = NULL; }
		$user = $this->ion_auth->user()->row();	
	    $data['from_name'] = $user->first_name." ".$user->last_name;
		$data['from_email'] = $user->email;
	  
      $meta['page_title'] = $this->lang->line("invoices");
	  $data['page_title'] = $this->lang->line("invoices");
      $this->load->view('commons/header', $meta);
      $this->load->view('content', $data);
      $this->load->view('commons/footer');
   }
   
   function getdatatableajax()
   {

	   $check = NULL;
	   
	   if($this->ion_auth->in_group('admin')) { 
	   	$opt = "<center><div class='btn-group' style='margin:0;'><a class=\"tip add_payment btn btn-success btn-xs\" title='".$this->lang->line("add_payment")."' href='#' id='$1' data-customer='$2'><i class=\"fa fa-briefcase\"></i></a><a class=\"tip btn btn-primary btn-xs\" title='".$this->lang->line("view_invoice")."' href='#' onClick=\"MyWindow=window.open('index.php?module=sales&view=view_invoice&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1000,height=600'); return false;\"><i class=\"fa fa-file-text-o\"></i></a><a class=\"tip btn btn-primary btn-xs\" title='".$this->lang->line("download_pdf")."' href='index.php?module=sales&view=pdf&id=$1'><i class=\"fa fa-download\"></i></a> 
		<!--<a class=\"tip btn btn-primary btn-xs\" title='".$this->lang->line("email_invoice")."' href='index.php?module=sales&view=email_invoice&id=$1'>--> 
		<a class=\"tip email_inv btn btn-success btn-xs\" title='".$this->lang->line("email_invoice")."' href='#' id='$1' data-customer='$2'><i class=\"fa fa-envelope\"></i></a><a class=\"tip btn btn-warning btn-xs\" title='".$this->lang->line("edit_invoice")."' href='index.php?module=sales&amp;view=edit&amp;id=$1'><i class=\"fa fa-edit\"></i></a><a class=\"tip btn btn-danger btn-xs\" title='".$this->lang->line("delete_invoice")."' href='index.php?module=sales&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_invoice') ."')\"><i class=\"fa fa-trash-o\"></i></a></div></center>";  
	   } else { 
	   
	   if(RESTRICT_SALES) { $check = TRUE; }
	   
	   	$opt = "<center><div class='btn-group' style='margin:0;'><a class=\"tip add_payment btn btn-success btn-xs\" title='".$this->lang->line("add_payment")."' href='#' id='$1' data-customer='$2'><i class=\"fa fa-briefcase\"></i></a><a class=\"tip btn btn-primary btn-xs\" title='".$this->lang->line("view_invoice")."' href='#' onClick=\"MyWindow=window.open('index.php?module=sales&view=view_invoice&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1000,height=600'); return false;\"><i class=\"fa fa-file-text-o\"></i></a><a class=\"tip btn btn-primary btn-xs\" title='".$this->lang->line("download_pdf")."' href='index.php?module=sales&view=pdf&id=$1'><i class=\"fa fa-download\"></i></a><a class=\"tip btn btn-primary btn-xs\" title='".$this->lang->line("email_invoice")."' href='index.php?module=sales&view=email_invoice&id=$1'><i class=\"fa fa-envelope\"></i></a><a class=\"tip btn btn-warning btn-xs\" title='".$this->lang->line("edit_invoice")."' href='index.php?module=sales&amp;view=edit&amp;id=$1'><i class=\"fa fa-edit\"></i></a><a class=\"tip btn btn-danger btn-xs\" title='".$this->lang->line("delete_invoice")."' href='index.php?module=sales&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_invoice') ."')\"><i class=\"fa fa-trash-o\"></i></a></div></center>"; 
	   }
 	
	   if($this->input->get('customer_id')){ $customer_id = $this->input->get('customer_id'); } else { $customer_id = NULL; }
	
	   $this->load->library('datatables');
	   $this->datatables
			->select("sales.id as id, sales.date as date, reference_no, sales.user, customer_name, total+COALESCE(shipping, 0) as total, COALESCE(sum(payment.amount), 0) as amount, (total+COALESCE(shipping, 0))-COALESCE(sum(payment.amount), 0) as balance, status, sales.customer_id as cid", FALSE)
			->from('sales')
			->join('payment', 'payment.invoice_id=sales.id', 'left')
			->group_by('sales.id');
		if($customer_id) { $this->datatables->where('sales.customer_id', $customer_id); }	
		if($check) { $this->datatables->where('sales.user', LI_USER); }
		$this->datatables->edit_column('status', '$1-$2', 'status, id')
			->add_column("Actions", $opt, "id, cid")
		
		->unset_column('id')
		->unset_column('cid');;
		
		
	   echo $this->datatables->generate();

   }
   
   
   function quotes()
   {
	  
				
	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
	   $data['success_message'] = $this->session->flashdata('success_message');
	   
	   $user = $this->ion_auth->user()->row();	
	    $data['from_name'] = $user->first_name." ".$user->last_name;
		$data['from_email'] = $user->email;
		
      $meta['page_title'] = $this->lang->line("quotes");
	  $data['page_title'] = $this->lang->line("quotes");
      $this->load->view('commons/header', $meta);
      $this->load->view('quotes', $data);
      $this->load->view('commons/footer');
   }
   
   function getquotes()
   {
 
	   if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $check = TRUE; } else { $check = NULL; }
	   $this->load->library('datatables');
	   $this->datatables
			->select("id, date, reference_no, user, customer_name, inv_total, total_tax, COALESCE(shipping, 0) as shipping, COALESCE(total_discount, 0) as discount, (total+COALESCE(shipping, 0)) as total, customer_id as cid", FALSE)
			->from('quotes');
		if($check) { $this->datatables->where('user', LI_USER); }
		$this->datatables->add_column("Actions", 
			"<center><div class='btn-group'><a class=\"tip btn btn-primary btn-xs\" title='".$this->lang->line("view_quote")."' href='#' onClick=\"MyWindow=window.open('index.php?module=sales&view=view_quote&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1000,height=600'); return false;\"><i class=\"fa fa-file-text-o\"></i></a> 
			<a class=\"tip  btn btn-success btn-xs\" title='".$this->lang->line("quote_to_invoice")."' href='index.php?module=sales&view=convert&id=$1'><i class=\"fa fa-share\"></i></a> 
			<a class=\"tip  btn btn-primary btn-xs\" title='".$this->lang->line("download_pdf")."' href='index.php?module=sales&view=pdf_quote&id=$1'><i class=\"fa fa-download\"></i></a> 
			<a class=\"tip email_inv btn btn-success btn-xs\" title='".$this->lang->line("email_quote")."' href='#' id='$1' data-customer='$2'><!--<a class=\"tip  btn btn-primary btn-xs\" title='".$this->lang->line("email_quote")."' href='index.php?module=sales&view=email_quote&id=$1'>--><i class=\"fa fa-envelope\"></i></a>
			<a class=\"tip  btn btn-warning btn-xs\" title='".$this->lang->line("edit_quote")."' href='index.php?module=sales&amp;view=edit_quote&amp;id=$1'><i class=\"fa fa-edit\"></i></a>
			<a class=\"tip  btn btn-danger btn-xs\" title='".$this->lang->line("delete_quote")."' href='index.php?module=sales&amp;view=delete_quote&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_quote') ."')\"><i class=\"fa fa-trash-o\"></i></a></div></center>", "id, cid")
		
		->unset_column('id')
		->unset_column('cid');
		
	   echo $this->datatables->generate();

   }
   
   function getCE() {
	   
	   	//if($this->input->post('id')){ $id = $this->input->post('id'); } else { $id = NULL; break; }
		if($this->input->get('id')){ $id = $this->input->get('id'); } else { $id = NULL; die(); }
		
		$cus = $this->sales_model->getCustomerByID($id);
		
		echo json_encode(array('ce' => $cus->email));
			
	   
   }
   
   function send_email() {
	   if($this->input->post('id')){ $id = $this->input->post('id'); } else { $id = NULL; die(); }
	   if($this->input->post('to')){ $to = $this->input->post('to'); } else { $to = NULL; die(); }
	   if($this->input->post('subject')){ $subject = $this->input->post('subject'); } else { $subject = NULL; }
	   if($this->input->post('note')){ $message = $this->input->post('note'); } else { $message = NULL; }
	   
			
			$user = $this->ion_auth->user()->row();	
			$from_name = $user->first_name." ".$user->last_name;
			$from = $user->email;
	
		
		if ( $this->email($id, $to, $from_name, $from, $subject, $message) )
		{ 			
			echo $this->lang->line("sent");
		} else {
			echo $this->lang->line("x_sent");
		}
	   
   }
   
   function send_quote() {
	   if($this->input->post('id')){ $id = $this->input->post('id'); } else { $id = NULL; die(); }
	   if($this->input->post('to')){ $to = $this->input->post('to'); } else { $to = NULL; die(); }
	   if($this->input->post('subject')){ $subject = $this->input->post('subject'); } else { $subject = NULL; }
	   if($this->input->post('note')){ $message = $this->input->post('note'); } else { $message = NULL; }
	   
			
			$user = $this->ion_auth->user()->row();	
			$from_name = $user->first_name." ".$user->last_name;
			$from = $user->email;
	
		
		if ( $this->emailQ($id, $to, $from_name, $from, $subject, $message) )
		{ 			
			echo $this->lang->line("sent");
		} else {
			echo $this->lang->line("x_sent");
		}
	   
   }
   
/* -------------------------------------------------------------------------------------------------------------------------------- */
//view inventory as html page
   
   function view_invoice()
   {
	   if($this->input->get('id')){ $sale_id = $this->input->get('id'); } else { $sale_id = NULL; }
	   
	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		   $data['rows'] = $this->sales_model->getAllInvoiceItems($sale_id);
		   
		   $inv = $this->sales_model->getInvoiceBySaleID($sale_id);
		   $customer_id = $inv->customer_id;
		   $data['biller'] = $this->sales_model->getCompanyDetails();
		   $data['customer'] = $this->sales_model->getCustomerByID($customer_id);
		   $data['payment'] = $this->sales_model->getPaymetnBySaleID($sale_id);
		   $data['paid'] = $this->sales_model->getPaidAmount($sale_id);
		   $data['inv'] = $inv;
		   $data['sid'] = $sale_id; 

	  $data['page_title'] = $this->lang->line("invoice");
	
	  
      $this->load->view('view_invoice', $data);

   }
   
     function view_quote()
   {
	   if($this->input->get('id')){ $quote_id = $this->input->get('id'); } else { $quote_id = NULL; }
	   
	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		   $data['rows'] = $this->sales_model->getAllQuoteItems($quote_id);
		   
		   $inv = $this->sales_model->getQuoteByID($quote_id);
		   $customer_id = $inv->customer_id;
		   $data['biller'] = $this->sales_model->getCompanyDetails();
		   $data['customer'] = $this->sales_model->getCustomerByID($customer_id);
		   
		   $data['inv'] = $inv;
		   $data['sid'] = $quote_id; 

	  $data['page_title'] = $this->lang->line("invoice");
	
	  
      $this->load->view('view_quote', $data);

   }
/* -------------------------------------------------------------------------------------------------------------------------------- */

/* -------------------------------------------------------------------------------------------------------------------------------- */ 
//Add new sales

   function add()
   {
	   $groups = array('admin', 'sales');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line("no_zero_required"));
		//validate form input
		$this->form_validation->set_rules('status', $this->lang->line("status"), 'required|xss_clean');
		$this->form_validation->set_rules('reference_no', $this->lang->line("reference_no"), 'required|xss_clean');
		$this->form_validation->set_rules('date', $this->lang->line("date"), 'required|xss_clean');
		$this->form_validation->set_rules('customer', $this->lang->line("customer"), 'required|xss_clean');
		$this->form_validation->set_rules('quantity1', $this->lang->line("quantity")." 1", 'required|integer|xss_clean');
		$this->form_validation->set_rules('product1', $this->lang->line("product").' 1', 'required|xss_clean');
		$this->form_validation->set_rules('tax_rate1', $this->lang->line("tax_rate").' 1', 'required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('unit_price1', $this->lang->line("unit_price").' 1', 'required|xss_clean');
		$this->form_validation->set_rules('note', $this->lang->line("note"), 'xss_clean');
                $this->form_validation->set_rules('discount', $this->lang->line("discount"), 'xss_clean');
		if($this->input->post('customer') == 'new') {
		$this->form_validation->set_rules('name', $this->lang->line("customer")." ".$this->lang->line("name"), 'required|xss_clean');
		$this->form_validation->set_rules('email', $this->lang->line("customer")." ".$this->lang->line("email_address"), 'required|valid_email');
		$this->form_validation->set_rules('company', $this->lang->line("customer")." ".$this->lang->line("company"), 'xss_clean');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'xss_clean');
		$this->form_validation->set_rules('city', $this->lang->line("city"), 'xss_clean');
		$this->form_validation->set_rules('state', $this->lang->line("state"), 'xss_clean');
		$this->form_validation->set_rules('postal_code', $this->lang->line("postal_code"), 'xss_clean');
		$this->form_validation->set_rules('country', $this->lang->line("country"), 'xss_clean');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|xss_clean|min_length[9]|max_length[16]');	
		}
		/*
		for($i=1; $i<=TOTAL_ROWS; $i++){
			$this->form_validation->set_rules('quantity'.$i, 'Quantity', 'is_natural_no_zero');
		}
		*/
		$quantity = "quantity";
		$product = "product";
		$unit_price = "unit_price";
		$tax_rate = "tax_rate";
			
		if ($this->form_validation->run() == true)
		{
			$inv_date = trim($this->input->post('date'));
			if(JS_DATE == 'dd-mm-yy' || JS_DATE == 'dd/mm/yy' || JS_DATE == 'dd.mm.yy') {
				$date = substr($inv_date, -4)."-".substr($inv_date, 3, 2)."-".substr($inv_date, 0, 2); 
			} else {
				$date = substr($inv_date, -4)."-".substr($inv_date, 0, 2)."-".substr($inv_date, 3, 2);
			}
			$reference_no = $this->input->post('reference_no');
			$status = $this->input->post('status');
			$shipping = $this->input->post('shipping');
                        $discount = $this->input->post('discount') ? $this->input->post('discount') : 0;
			
			if($this->input->post('customer') == 'new') {
				
				$customer_name = $this->input->post('name');
				$customer_data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'company' => $this->input->post('company'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'postal_code' => $this->input->post('postal_code'),
				'state' => $this->input->post('state'),
				'country' => $this->input->post('country')
				);
				
			} else {
				$customer_id = $this->input->post('customer');
				$customer_details = $this->sales_model->getCustomerByID($customer_id);
				$customer_name = $customer_details->name;
			}
			$note = $this->input->post('note');
			
			$inv_total_no_tax = 0;

				for($i=1; $i<=TOTAL_ROWS; $i++){
					if( $this->input->post($quantity.$i) && $this->input->post($product.$i) && $this->input->post($tax_rate.$i) && $this->input->post($unit_price.$i) ) {
						
												
						$tax_id = $this->input->post($tax_rate.$i);
						$tax_details = $this->sales_model->getTaxRateByID($tax_id);
						$taxRate = $tax_details->rate;
						$taxType = $tax_details->type;	
						$tax_rate_id[] = $tax_id;				
						
						$inv_quantity[] = $this->input->post($quantity.$i);
						$inv_product_name[] = $this->input->post($product.$i);
						$inv_unit_price[] = $this->input->post($unit_price.$i);
						$inv_gross_total[] = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)));
						
						if($taxType == 1 && $taxType != 0) {
						$val_tax[] = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)) * $taxRate / 100);
						} else {
						$val_tax[] = $taxRate;
						}
						
						if($taxType == 1) { $tax[] = $taxRate."%"; } else { $tax[] = $taxRate;  }
						
						$inv_total_no_tax += (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)));
						
					}
				}

				 $total_tax = array_sum($val_tax);
				 $total = $inv_total_no_tax + $total_tax;
				 $percentage = '%';
                                 $dpos = strpos($discount, $percentage);
                                if ($dpos !== false) {
                                        $pds = explode("%", $discount);
                                        $total_discount = ($total* (Float)($pds[0]))/100;
                                } else {
                                         $total_discount = $discount;
                                }
                                $total_discount = $this->roundnum($total_discount);

				$keys = array("product_name","tax_rate_id", "tax","quantity","unit_price", "gross_total", "val_tax");
		
					$items = array();
				foreach ( array_map(null, $inv_product_name, $tax_rate_id, $tax, $inv_quantity, $inv_unit_price, $inv_gross_total, $val_tax) as $key => $value ) {
					$items[] = array_combine($keys, $value);
				}
			if($this->input->post('customer') == 'new') {
				$saleDetails = array('reference_no' => $reference_no,
					'date' => $date,
					'user' => LI_USER,
					'customer_name' => $customer_name,
					'note' => $note,
					'inv_total' => $inv_total_no_tax,
					'total_tax' => $total_tax,
					'total' => $total - $total_discount,
					'status' => $status,
					'shipping' => $shipping,
                                        'total_discount' => $total_discount,
					'discount' => $discount,
				);
			} else {
				$saleDetails = array('reference_no' => $reference_no,
					'date' => $date,
					'user' => LI_USER,
					'customer_id' => $customer_id,
					'customer_name' => $customer_name,
					'note' => $note,
					'inv_total' => $inv_total_no_tax,
					'total_tax' => $total_tax,
					'total' => $total - $total_discount,
					'status' => $status,
					'shipping' => $shipping,
                                    'total_discount' => $total_discount,
					'discount' => $discount,
				);
				$customer_data = array();
			}
                        
		}
		
		
		if ( $this->form_validation->run() == true && $this->sales_model->addSale($saleDetails, $items, $customer_data) )
		{ 
				$this->session->set_flashdata('success_message', $this->lang->line("sale_added"));
				redirect("module=sales", 'refresh');
	
		}
		else
		{ 
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		
			$data['reference_no'] = array('name' => 'reference_no',
				'id' => 'reference_no',
				'type' => 'text',
				'value' => $this->form_validation->set_value('reference_no'),
			);
			$data['date'] = array('name' => 'date',
				'id' => 'date',
				'type' => 'text',
				'value' => $this->form_validation->set_value('date'),
			);
			
			$data['customer'] = array('name' => 'customer',
				'id' => 'customer',
				'type' => 'select',
				'value' => $this->form_validation->set_select('customer'),
			);
			$data['note'] = array('name' => 'note',
				'id' => 'note',
				'type' => 'textarea',
				'value' => $this->form_validation->set_value('note'),
			);
			
		
	  
	   $data['customers'] = $this->sales_model->getAllCustomers();
	   $data['products'] = $this->sales_model->getAllProducts();
	   $data['tax_rates'] = $this->sales_model->getAllTaxRates();
	   
      $meta['page_title'] = $this->lang->line("add_sale");
	  $data['page_title'] = $this->lang->line("add_sale");
      $this->load->view('commons/header', $meta);
      $this->load->view('add', $data);
      $this->load->view('commons/footer');
	  
		}
   }

//Add new quote

   function add_quote()
   {
	   $groups = array('admin', 'sales');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line("no_zero_required"));
		//validate form input
		$this->form_validation->set_rules('reference_no', $this->lang->line("reference_no"), 'required|xss_clean');
		$this->form_validation->set_rules('date', $this->lang->line("date"), 'required|xss_clean');
		$this->form_validation->set_rules('customer', $this->lang->line("customer"), 'required|xss_clean');
		$this->form_validation->set_rules('quantity1', $this->lang->line("quantity")." 1", 'required|integer|xss_clean');
		$this->form_validation->set_rules('product1', $this->lang->line("product").' 1', 'required|xss_clean');
		$this->form_validation->set_rules('tax_rate1', $this->lang->line("tax_rate").' 1', 'required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('unit_price1', $this->lang->line("unit_price").' 1', 'required|xss_clean');
		$this->form_validation->set_rules('note', $this->lang->line("note"), 'xss_clean');
                $this->form_validation->set_rules('discount', $this->lang->line("discount"), 'xss_clean');
		if($this->input->post('customer') == 'new') {
		$this->form_validation->set_rules('name', $this->lang->line("customer")." ".$this->lang->line("name"), 'required|xss_clean');
		$this->form_validation->set_rules('email', $this->lang->line("customer")." ".$this->lang->line("email_address"), 'required|valid_email');
		$this->form_validation->set_rules('company', $this->lang->line("customer")." ".$this->lang->line("company"), 'xss_clean');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'xss_clean');
		$this->form_validation->set_rules('city', $this->lang->line("city"), 'xss_clean');
		$this->form_validation->set_rules('state', $this->lang->line("state"), 'xss_clean');
		$this->form_validation->set_rules('postal_code', $this->lang->line("postal_code"), 'xss_clean');
		$this->form_validation->set_rules('country', $this->lang->line("country"), 'xss_clean');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|xss_clean|min_length[9]|max_length[16]');	
		}
		
		/*
		for($i=1; $i<=TOTAL_ROWS; $i++){
			$this->form_validation->set_rules('quantity'.$i, 'Quantity', 'is_natural_no_zero');
		}
		*/
		
		$quantity = "quantity";
		$product = "product";
		$unit_price = "unit_price";
		$tax_rate = "tax_rate";
			
		if ($this->form_validation->run() == true)
		{
			$inv_date = trim($this->input->post('date'));
			if(JS_DATE == 'dd-mm-yy' || JS_DATE == 'dd/mm/yy' || JS_DATE == 'dd.mm.yy') {
				$date = substr($inv_date, -4)."-".substr($inv_date, 3, 2)."-".substr($inv_date, 0, 2); 
			} else {
				$date = substr($inv_date, -4)."-".substr($inv_date, 0, 2)."-".substr($inv_date, 3, 2);
			}
			$reference_no = $this->input->post('reference_no');
			
			if($this->input->post('customer') == 'new') {
				
				$customer_name = $this->input->post('name');
				$customer_data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'company' => $this->input->post('company'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'postal_code' => $this->input->post('postal_code'),
				'state' => $this->input->post('state'),
				'country' => $this->input->post('country')
				);
				
			} else {
				$customer_id = $this->input->post('customer');
				$customer_details = $this->sales_model->getCustomerByID($customer_id);
				$customer_name = $customer_details->name;
			}
			$note = $this->input->post('note');
			$shipping = $this->input->post('shipping');
			$discount = $this->input->post('discount') ? $this->input->post('discount') : 0;
			$inv_total_no_tax = 0;

				for($i=1; $i<=TOTAL_ROWS; $i++){
					if( $this->input->post($quantity.$i) && $this->input->post($product.$i) && $this->input->post($tax_rate.$i) && $this->input->post($unit_price.$i) ) {
						
												
						$tax_id = $this->input->post($tax_rate.$i);
						$tax_details = $this->sales_model->getTaxRateByID($tax_id);
						$taxRate = $tax_details->rate;
						$taxType = $tax_details->type;	
						$tax_rate_id[] = $tax_id;				
						
						$inv_quantity[] = $this->input->post($quantity.$i);
						$inv_product_name[] = $this->input->post($product.$i);
						$inv_unit_price[] = $this->input->post($unit_price.$i);
						$inv_gross_total[] = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)));
						
						if($taxType == 1 && $taxType != 0) {
						$val_tax[] = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)) * $taxRate / 100);
						} else {
						$val_tax[] = $taxRate;
						}
						
						if($taxType == 1) { $tax[] = $taxRate."%"; } else { $tax[] = $taxRate;  }
						
						$inv_total_no_tax += (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)));
						
					}
				}

				 $total_tax = array_sum($val_tax);
				 $total = $inv_total_no_tax + $total_tax;
				 $percentage = '%';
                                 $dpos = strpos($discount, $percentage);
                                if ($dpos !== false) {
                                        $pds = explode("%", $discount);
                                        $total_discount = ($total* (Float)($pds[0]))/100;
                                } else {
                                         $total_discount = $discount;
                                }
                                $total_discount = $this->roundnum($total_discount);
		
				$keys = array("product_name","tax_rate_id", "tax","quantity","unit_price", "gross_total", "val_tax");
		
					$items = array();
				foreach ( array_map(null, $inv_product_name, $tax_rate_id, $tax, $inv_quantity, $inv_unit_price, $inv_gross_total, $val_tax) as $key => $value ) {
					$items[] = array_combine($keys, $value);
				}
			
			if($this->input->post('customer') == 'new') {
				$quoteDetails = array('reference_no' => $reference_no,
					'date' => $date,
					'user' => LI_USER,
					'customer_name' => $customer_name,
					'note' => $note,
					'inv_total' => $inv_total_no_tax,
					'total_tax' => $total_tax,
					'total' => $total - $total_discount,
					'shipping' => $shipping,
                                    'total_discount' => $total_discount,
					'discount' => $discount,
				);
			} else {
				$quoteDetails = array('reference_no' => $reference_no,
					'date' => $date,
					'user' => LI_USER,
					'customer_id' => $customer_id,
					'customer_name' => $customer_name,
					'note' => $note,
					'inv_total' => $inv_total_no_tax,
					'total_tax' => $total_tax,
					'total' => $total - $total_discount,
					'shipping' => $shipping,
                                    'total_discount' => $total_discount,
					'discount' => $discount,
				);
				$customer_data = array();
			}	
		}
		
		
		if ( $this->form_validation->run() == true && $this->sales_model->addQuote($quoteDetails, $items, $customer_data) )
		{ 
				$this->session->set_flashdata('success_message', $this->lang->line("quote_added"));
				redirect("module=sales&view=quotes", 'refresh');
	
		}
		else
		{ 
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		
			$data['reference_no'] = array('name' => 'reference_no',
				'id' => 'reference_no',
				'type' => 'text',
				'value' => $this->form_validation->set_value('reference_no'),
			);
			$data['date'] = array('name' => 'date',
				'id' => 'date',
				'type' => 'text',
				'value' => $this->form_validation->set_value('date'),
			);
			
			$data['customer'] = array('name' => 'customer',
				'id' => 'customer',
				'type' => 'select',
				'value' => $this->form_validation->set_select('customer'),
			);
			$data['note'] = array('name' => 'note',
				'id' => 'note',
				'type' => 'textarea',
				'value' => $this->form_validation->set_value('note'),
			);
			
		
	  
	   $data['customers'] = $this->sales_model->getAllCustomers();
	   $data['tax_rates'] = $this->sales_model->getAllTaxRates();
	   $data['products'] = $this->sales_model->getAllProducts();
      $meta['page_title'] = $this->lang->line("new_quote");
	  $data['page_title'] = $this->lang->line("new_quote");
      $this->load->view('commons/header', $meta);
      $this->load->view('add_quote', $data);
      $this->load->view('commons/footer');
	  
		}
   }
   
   //Add new quote

   function convert()
   {
	   $groups = array('admin', 'sales');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		if(RESTRICT_SALES) {
		if($this->input->get('id')) { $id = $this->input->get('id'); } else { $id = NULL; }
		if ($this->ion_auth->in_group('sales')) { 
		$inv = $this->sales_model->getQuoteByID($id);
		if(USER_ID != $inv->user_id) {
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		}
		}
		if($this->input->get('id')) { $id = $this->input->get('id'); } else { $id = NULL; }
		
		$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				
		  $data['customers'] = $this->sales_model->getAllCustomers();
		  $data['products'] = $this->sales_model->getAllProducts();
		  $data['tax_rates'] = $this->sales_model->getAllTaxRates();
		  		
		  
		  $data['inv'] = $this->sales_model->getQuoteByID($id);
		  $data['inv_products'] =  $this->sales_model->getAllQuoteItems($id);
		  $meta['page_title'] = $this->lang->line("quote_to_invoice");
		  $data['page_title'] = $this->lang->line("quote_to_invoice");
		  
		  $data['id'] = $id;
		
      $this->load->view('commons/header', $meta);
      $this->load->view('convert', $data);
      $this->load->view('commons/footer');
	  
		
   }

/* -------------------------------------------------------------------------------------------------------------------------------- */ 
//Edit sale

   function edit()
   {
	   if($this->input->get('id')) { $id = $this->input->get('id'); } else { $id = NULL; }
	   
	   $groups = array('admin', 'sales');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		
		if(RESTRICT_SALES) {
		if ($this->ion_auth->in_group('sales')) { 
		$inv = $this->sales_model->getInvoiceByID($id);
		if(USER_ID != $inv->user_id) {
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		}
		}
		//validate form input
		$this->form_validation->set_rules('reference_no', $this->lang->line("reference_no"), 'required|xss_clean');
		$this->form_validation->set_rules('status', $this->lang->line("status"), 'required|xss_clean');
		$this->form_validation->set_rules('date', $this->lang->line("date"), 'required|xss_clean');
		$this->form_validation->set_rules('customer', $this->lang->line("customer"), 'required|xss_clean');
		$this->form_validation->set_rules('quantity1', $this->lang->line("quantity").' 1', 'required|integer|xss_clean');
		$this->form_validation->set_rules('product1', $this->lang->line("products").' 1', 'required|xss_clean');
		$this->form_validation->set_rules('unit_price1', $this->lang->line("unit_price").' 1', 'required|xss_clean');
		$this->form_validation->set_rules('note', $this->lang->line("note"), 'xss_clean');
                $this->form_validation->set_rules('discount', $this->lang->line("discount"), 'xss_clean');
		
		$quantity = "quantity";
		$product = "product";
		$unit_price = "unit_price";
		$tax_rate = "tax_rate";
			
		if ($this->form_validation->run() == true)
		{
			$inv_date = trim($this->input->post('date'));
			if(JS_DATE == 'dd-mm-yy' || JS_DATE == 'dd/mm/yy' || JS_DATE == 'dd.mm.yy') {
				$date = substr($inv_date, -4)."-".substr($inv_date, 3, 2)."-".substr($inv_date, 0, 2); 
			} else {
				$date = substr($inv_date, -4)."-".substr($inv_date, 0, 2)."-".substr($inv_date, 3, 2);
			}
			$reference_no = $this->input->post('reference_no');
			$status = $this->input->post('status');
						
			if($this->input->post('customer') == 'new') {
				
				$customer_name = $this->input->post('name');
				$customer_data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'company' => $this->input->post('company'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'postal_code' => $this->input->post('postal_code'),
				'state' => $this->input->post('state'),
				'country' => $this->input->post('country')
				);
				
			} else {
				$customer_id = $this->input->post('customer');
				$customer_details = $this->sales_model->getCustomerByID($customer_id);
				$customer_name = $customer_details->name;
			}
			$note = $this->input->post('note');
			$shipping = $this->input->post('shipping');
			$discount = $this->input->post('discount') ? $this->input->post('discount') : 0;
                        
			$inv_total_no_tax = 0;

				for($i=1; $i<=TOTAL_ROWS; $i++){
					if( $this->input->post($quantity.$i) && $this->input->post($product.$i) && $this->input->post($tax_rate.$i) && $this->input->post($unit_price.$i) ) {
						
												
						$tax_id = $this->input->post($tax_rate.$i);
						$tax_details = $this->sales_model->getTaxRateByID($tax_id);
						$taxRate = $tax_details->rate;
						$taxType = $tax_details->type;	
						$tax_rate_id[] = $tax_id;				
						$sid[] = $id;
						$inv_quantity[] = $this->input->post($quantity.$i);
						$inv_product_name[] = $this->input->post($product.$i);
						$inv_unit_price[] = $this->input->post($unit_price.$i);
						$inv_gross_total[] = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)));
						
						if($taxType == 1 && $taxType != 0) {
						$val_tax[] = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)) * $taxRate / 100);
						} else {
						$val_tax[] = $taxRate;
						}
						
						if($taxType == 1) { $tax[] = $taxRate."%"; } else { $tax[] = $taxRate;  }
						
						$inv_total_no_tax += (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)));
						
					}
				}

				 $total_tax = array_sum($val_tax);
				 $total = $inv_total_no_tax + $total_tax;
				 
                                 $percentage = '%';
                                 $dpos = strpos($discount, $percentage);
                                if ($dpos !== false) {
                                        $pds = explode("%", $discount);
                                        $total_discount = ($total* (Float)($pds[0]))/100;
                                } else {
                                         $total_discount = $discount;
                                }
                                $total_discount = $this->roundnum($total_discount);
		
				$keys = array("sale_id", "product_name","tax_rate_id", "tax","quantity","unit_price", "gross_total", "val_tax");
		
					$items = array();
				foreach ( array_map(null, $sid, $inv_product_name, $tax_rate_id, $tax, $inv_quantity, $inv_unit_price, $inv_gross_total, $val_tax) as $key => $value ) {
					$items[] = array_combine($keys, $value);
				}
			if($this->input->post('customer') == 'new') {
				$saleDetails = array('reference_no' => $reference_no,
					'date' => $date,
					'user' => LI_USER,
					'customer_name' => $customer_name,
					'note' => $note,
					'inv_total' => $inv_total_no_tax,
					'total_tax' => $total_tax,
					'total' => $total - $total_discount,
					'status' => $status,
					'shipping' => $shipping,
                                    'total_discount' => $total_discount,
					'discount' => $discount,
				);
			} else {
				$saleDetails = array('reference_no' => $reference_no,
					'date' => $date,
					'user' => LI_USER,
					'customer_id' => $customer_id,
					'customer_name' => $customer_name,
					'note' => $note,
					'inv_total' => $inv_total_no_tax,
					'total_tax' => $total_tax,
					'total' => $total - $total_discount,
					'status' => $status,
					'shipping' => $shipping,
                                    'total_discount' => $total_discount,
					'discount' => $discount,
				);
				$customer_data = array();
			}
		}
		
		if ( $this->form_validation->run() == true && $this->sales_model->updateSale($id, $saleDetails, $items) )
		{ 	
				$this->session->set_flashdata('success_message', $this->lang->line("sale_updated"));
				redirect("module=sales", 'refresh');
			
		}
		else
		{ //display the create biller form
			//set the flash data error message if there is one
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				
		  $data['customers'] = $this->sales_model->getAllCustomers();
		  
		  $data['tax_rates'] = $this->sales_model->getAllTaxRates();
		  $data['products'] = $this->sales_model->getAllProducts();		
		  
		  $data['inv'] = $this->sales_model->getInvoiceByID($id);
		  $data['inv_products'] =  $this->sales_model->getAllInvoiceItems($id);
		  $data['id'] = $id;
		  $meta['page_title'] = $this->lang->line("update_sale");
		  $data['page_title'] = $this->lang->line("update_sale");
		
      $this->load->view('commons/header', $meta);
      $this->load->view('edit', $data);
      $this->load->view('commons/footer');
	  
	  }
   } 
   
   //Edit quote

   function edit_quote()
   {
	   if($this->input->get('id')) { $id = $this->input->get('id'); } else { $id = NULL; }
	   
	   $groups = array('admin', 'sales');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		if(RESTRICT_SALES) {
		if ($this->ion_auth->in_group('sales')) { 
		$inv = $this->sales_model->getQuoteByID($id);
		if(USER_ID != $inv->user_id) {
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		}
		}
		//validate form input
		$this->form_validation->set_rules('reference_no', $this->lang->line("reference_no"), 'required|xss_clean');
		$this->form_validation->set_rules('date', $this->lang->line("date"), 'required|xss_clean');
		$this->form_validation->set_rules('customer', $this->lang->line("customer"), 'required|xss_clean');
		$this->form_validation->set_rules('quantity1', $this->lang->line("quantity").' 1', 'required|integer|xss_clean');
		$this->form_validation->set_rules('product1', $this->lang->line("products").' 1', 'required|xss_clean');
		$this->form_validation->set_rules('unit_price1', $this->lang->line("unit_price").' 1', 'required|xss_clean');
		$this->form_validation->set_rules('note', $this->lang->line("note"), 'xss_clean');
		$this->form_validation->set_rules('discount', $this->lang->line("discount"), 'xss_clean');
		$quantity = "quantity";
		$product = "product";
		$unit_price = "unit_price";
		$tax_rate = "tax_rate";
			
		if ($this->form_validation->run() == true)
		{
			$inv_date = trim($this->input->post('date'));
			if(JS_DATE == 'dd-mm-yy' || JS_DATE == 'dd/mm/yy' || JS_DATE == 'dd.mm.yy') {
				$date = substr($inv_date, -4)."-".substr($inv_date, 3, 2)."-".substr($inv_date, 0, 2); 
			} else {
				$date = substr($inv_date, -4)."-".substr($inv_date, 0, 2)."-".substr($inv_date, 3, 2);
			}
			$reference_no = $this->input->post('reference_no');
						
			if($this->input->post('customer') == 'new') {
				
				$customer_name = $this->input->post('name');
				$customer_data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'company' => $this->input->post('company'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'postal_code' => $this->input->post('postal_code'),
				'state' => $this->input->post('state'),
				'country' => $this->input->post('country')
				);
				
			} else {
				$customer_id = $this->input->post('customer');
				$customer_details = $this->sales_model->getCustomerByID($customer_id);
				$customer_name = $customer_details->name;
			}
			$note = $this->input->post('note');
			$shipping = $this->input->post('shipping');
			$discount = $this->input->post('discount') ? $this->input->post('discount') : 0;
			$inv_total_no_tax = 0;

				for($i=1; $i<=TOTAL_ROWS; $i++){
					if( $this->input->post($quantity.$i) && $this->input->post($product.$i) && $this->input->post($tax_rate.$i) && $this->input->post($unit_price.$i) ) {
						
												
						$tax_id = $this->input->post($tax_rate.$i);
						$tax_details = $this->sales_model->getTaxRateByID($tax_id);
						$taxRate = $tax_details->rate;
						$taxType = $tax_details->type;	
						$tax_rate_id[] = $tax_id;				
						$qid[] = $id;
						$inv_quantity[] = $this->input->post($quantity.$i);
						$inv_product_name[] = $this->input->post($product.$i);
						$inv_unit_price[] = $this->input->post($unit_price.$i);
						$inv_gross_total[] = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)));
						
						if($taxType == 1 && $taxType != 0) {
						$val_tax[] = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)) * $taxRate / 100);
						} else {
						$val_tax[] = $taxRate;
						}
						
						if($taxType == 1) { $tax[] = $taxRate."%"; } else { $tax[] = $taxRate;  }
						
						$inv_total_no_tax += (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)));
						
					}
				}

				 $total_tax = array_sum($val_tax);
				 $total = $inv_total_no_tax + $total_tax;
				 $percentage = '%';
                                 $dpos = strpos($discount, $percentage);
                                if ($dpos !== false) {
                                        $pds = explode("%", $discount);
                                        $total_discount = ($total* (Float)($pds[0]))/100;
                                } else {
                                         $total_discount = $discount;
                                }
                                $total_discount = $this->roundnum($total_discount);
		
				$keys = array("quote_id", "product_name","tax_rate_id", "tax","quantity","unit_price", "gross_total", "val_tax");
		
					$items = array();
				foreach ( array_map(null, $qid, $inv_product_name, $tax_rate_id, $tax, $inv_quantity, $inv_unit_price, $inv_gross_total, $val_tax) as $key => $value ) {
					$items[] = array_combine($keys, $value);
				}
			
			if($this->input->post('customer') == 'new') {
				$quoteDetails = array('reference_no' => $reference_no,
					'date' => $date,
					'user' => LI_USER,
					'customer_name' => $customer_name,
					'note' => $note,
					'inv_total' => $inv_total_no_tax,
					'total_tax' => $total_tax,
					'total' => $total - $total_discount,
					'shipping' => $shipping,
                                    'total_discount' => $total_discount,
					'discount' => $discount,
				);
			} else {
				$quoteDetails = array('reference_no' => $reference_no,
					'date' => $date,
					'user' => LI_USER,
					'customer_id' => $customer_id,
					'customer_name' => $customer_name,
					'note' => $note,
					'inv_total' => $inv_total_no_tax,
					'total_tax' => $total_tax,
					'total' => $total - $total_discount,
					'shipping' => $shipping,
                                    'total_discount' => $total_discount,
					'discount' => $discount,
				);
				$customer_data = array();
			}	
		}
		
		if ( $this->form_validation->run() == true && $this->sales_model->updateQuote($id, $quoteDetails, $items) )
		{ 	
				$this->session->set_flashdata('success_message', $this->lang->line("quote_updated"));
				redirect("module=sales&view=quotes", 'refresh');
			
		}
		else
		{ //display the create biller form
			//set the flash data error message if there is one
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				
		  $data['customers'] = $this->sales_model->getAllCustomers();
		  $data['products'] = $this->sales_model->getAllProducts();
		  $data['tax_rates'] = $this->sales_model->getAllTaxRates();
		  		
		  
		  $data['inv'] = $this->sales_model->getQuoteByID($id);
		  $data['inv_products'] =  $this->sales_model->getAllQuoteItems($id);
		  $data['id'] = $id;
		  $meta['page_title'] = $this->lang->line("update_quote");
		  $data['page_title'] = $this->lang->line("update_quote");
		
      $this->load->view('commons/header', $meta);
      $this->load->view('edit_quote', $data);
      $this->load->view('commons/footer');
	  
	  }
   }   
/*-------------------------------*/
function delete($id = NULL)
    {
       if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		
	    if($this->input->get('id')){ $id = $this->input->get('id'); } else { $id = NULL; }
       
        if (!$this->ion_auth->in_group('admin'))
        {
            $this->session->set_flashdata('message', $this->lang->line("access_denied"));
            $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            redirect('module=sales', 'refresh');
        }
       
        if ( $this->sales_model->deleteInvoice($id) )
        { //check to see if we are deleting the product
            //redirect them back to the admin page
            $this->session->set_flashdata('message', $this->lang->line("invoice_deleted"));
            redirect('module=sales', 'refresh');
        }
       
    }   
	
	function delete_quote($id = NULL)
    {
        if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		
		if($this->input->get('id')){ $id = $this->input->get('id'); } else { $id = NULL; }
       
        if (!$this->ion_auth->in_group('admin'))
        {
            $this->session->set_flashdata('message', $this->lang->line("access_denied"));
            $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            redirect('module=sales', 'refresh');
        }
       
        if ( $this->sales_model->deleteQuote($id) )
        { //check to see if we are deleting the product
            //redirect them back to the admin page
            $this->session->set_flashdata('message', $this->lang->line("invoice_deleted"));
            redirect('module=sales&view=quotes', 'refresh');
        }
       
    }   
/* -------------------------------------------------------------------------------------------------------------------------------- */
//generate pdf and force to download  
 
   function pdf()
   {
	    if($this->input->get('id')){ $sale_id = $this->input->get('id'); } else { $sale_id = NULL; }
	   
	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		   $data['rows'] = $this->sales_model->getAllInvoiceItems($sale_id);
		   
		   $inv = $this->sales_model->getInvoiceBySaleID($sale_id);
		   $customer_id = $inv->customer_id;
		   $data['biller'] = $this->sales_model->getCompanyDetails();
		   $data['customer'] = $this->sales_model->getCustomerByID($customer_id);
		   $data['payment'] = $this->sales_model->getPaymetnBySaleID($sale_id);
		   $data['paid'] = $this->sales_model->getPaidAmount($sale_id);
		   $data['inv'] = $inv;
		   $data['sid'] = $sale_id; 

	  $data['page_title'] = $this->lang->line("invoice");
		 
	  $this->load->library('MPDF53/mpdf');
			  
		$mpdf=new mPDF('win-1252','A4', '12', '', 10, 10, 10, 10, 9, 9, 'P'); 
		$mpdf->useOnlyCoreFonts = true;    // false is default
		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("Invoice");
		$mpdf->SetAuthor("Tecdiary.net");
		$mpdf->SetCreator('Invoice Manager');
		$mpdf->SetWatermarkText("Invoice Manager");
		$mpdf->showWatermarkText = false;
		$mpdf->watermark_font = 'DejaVuSansCondensed';
		$mpdf->watermarkTextAlpha = 0.025;
		$mpdf->SetDisplayMode('fullpage');
		
		$html =  $this->load->view('view_invoice', $data, TRUE);
	$name = $this->lang->line("invoice")." ".$this->lang->line("no")." ".$inv->id.".pdf";
	
	$search = array("<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span2\">", "<div class=\"span10\">");
	$replace = array("<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 18%; float: left;'>", "<div style='width: 78%; float: left;'>");
	
	$html = str_replace($search, $replace, $html);
	
	$mpdf->WriteHTML($html);
	
	$mpdf->Output($name, 'D'); 
	
	exit;
		
		
   }
   
   function pdf_quote()
   {
	    if($this->input->get('id')){ $quote_id = $this->input->get('id'); } else { $quote_id = NULL; }
	   
	   	$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		   $data['rows'] = $this->sales_model->getAllQuoteItems($quote_id);
		   
		   $inv = $this->sales_model->getQuoteByID($quote_id);
		   $customer_id = $inv->customer_id;
		   $data['biller'] = $this->sales_model->getCompanyDetails();
		   $data['customer'] = $this->sales_model->getCustomerByID($customer_id);
		   
		   $data['inv'] = $inv;

	  $data['page_title'] = $this->lang->line("quote");
	
	 
	  $this->load->library('MPDF53/mpdf');
			  
		$mpdf=new mPDF('win-1252','A4', '12', '', 10, 10, 10, 10, 9, 9, 'P'); 
		$mpdf->useOnlyCoreFonts = true;    // false is default
		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("Invoice");
		$mpdf->SetAuthor("Tecdiary.net");
		$mpdf->SetCreator('Invoice Manager');
		$mpdf->SetWatermarkText("Invoice Manager");
		$mpdf->showWatermarkText = false;
		$mpdf->watermark_font = 'DejaVuSansCondensed';
		$mpdf->watermarkTextAlpha = 0.025;
		$mpdf->SetDisplayMode('fullpage');
		
		$html =  $this->load->view('view_quote', $data, TRUE);
	$name = $this->lang->line("quote")." ".$this->lang->line("no")." ".$inv->id.".pdf";
	
	$search = array("<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span2\">", "<div class=\"span10\">");
	$replace = array("<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 18%; float: left;'>", "<div style='width: 78%; float: left;'>");
	
	$html = str_replace($search, $replace, $html);
	
	$mpdf->WriteHTML($html);
	
	$mpdf->Output($name, 'D'); 
	
	exit;
		
		
   }
/* -------------------------------------------------------------------------------------------------------------------------------- */
//email inventory as html and send pdf as attachment   

   function email($sale_id = NULL, $to, $from_name, $from, $subject, $note)
   {
	 	
	      
	   if($this->input->get('id')){ $sale_id = $this->input->get('id'); } 
	   
	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		   $data['rows'] = $this->sales_model->getAllInvoiceItems($sale_id);
		   
		   $inv = $this->sales_model->getInvoiceBySaleID($sale_id);
		   $customer_id = $inv->customer_id;
		   $data['biller'] = $this->sales_model->getCompanyDetails();
		   $data['customer'] = $this->sales_model->getCustomerByID($customer_id);
		   $data['payment'] = $this->sales_model->getPaymetnBySaleID($sale_id);
		   $data['paid'] = $this->sales_model->getPaidAmount($sale_id);
		   $data['inv'] = $inv;
		   $data['sid'] = $sale_id; 
		    

	  $data['page_title'] = $this->lang->line("invoice");
		 
	  $this->load->library('MPDF53/mpdf');
			  
		$mpdf=new mPDF('win-1252','A4', '12', '', 10, 10, 10, 10, 9, 9, 'P'); 
		$mpdf->useOnlyCoreFonts = true;    // false is default
		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("Invoice");
		$mpdf->SetAuthor("Tecdiary.net");
		$mpdf->SetCreator('Invoice Manager');
		$mpdf->SetWatermarkText("Invoice Manager");
		$mpdf->showWatermarkText = false;
		$mpdf->watermark_font = 'DejaVuSansCondensed';
		$mpdf->watermarkTextAlpha = 0.025;
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->setBasePath(base_url());
		
		$html =  $this->load->view('view_invoice', $data, TRUE);
	$name = $this->lang->line("invoice")." ".$this->lang->line("no")." ".$inv->id.".pdf";
	
	$search = array("<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span2\">", "<div class=\"span10\">");
	$replace = array("<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 18%; float: left;'>", "<div style='width: 78%; float: left;'>");
	
	$html = str_replace($search, $replace, $html);
	
	$mpdf->WriteHTML($html);
	
	//$mpdf->Output($name, 'F'); 
	$mpdf->Output($name,'F', 'assets/uploads');
	  
	  $email_data = $this->load->view('view_invoice', $data, TRUE);
	
	$search = array("<body>", "<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span2\">", "<div class=\"span10\">", "class=\"table table-bordered table-hover table-striped\"");
	$replace = array("<body style='max-width:800px;'>", "<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 18%; float: left;'>", "<div style='width: 78%; float: left;'>", "border='1' width='100%'");
	
	$email_data = str_replace($search, $replace, $email_data);
	
	if($note) { $message = $note."<br /><hr>".$email_data; } else { $message = $email_data; }
						
	$this->load->library('email');
		
	$config['mailtype'] = 'html';
	$config['wordwrap'] = TRUE;
	
	$this->email->initialize($config);
	
	$this->email->from($from, $from_name);
	$this->email->to($to); 
	
	$this->email->subject($subject);
	$this->email->message($message);
	$this->email->attach('assets/uploads/'.$name);	
	
	if($this->email->send()) {
		// email sent		
		unlink('assets/uploads/'.$name);
		//echo $this->email->print_debugger(); die();
		return true;
	} else {
		//email not sent
		unlink('assets/uploads/'.$name);
		//echo $this->email->print_debugger(); die();
		return false;
	}
	
   }
   
   function emailQ($id, $to, $from_name, $from, $subject, $note)
   {
	 	
	   
	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		   $data['rows'] = $this->sales_model->getAllQuoteItems($id);
		   
		   $inv = $this->sales_model->getQuoteByID($id);
		   $customer_id = $inv->customer_id;
   		   $data['biller'] = $this->sales_model->getCompanyDetails();
		   $data['customer'] = $this->sales_model->getCustomerByID($customer_id);
		   
		   $data['inv'] = $inv;


	  $data['page_title'] = $this->lang->line("quote");
		
		$this->load->library('MPDF53/mpdf');
			  
		$mpdf=new mPDF('win-1252','A4', '12', '', 10, 10, 10, 10, 9, 9, 'P'); 
		$mpdf->useOnlyCoreFonts = true;    // false is default
		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("Invoice");
		$mpdf->SetAuthor("Tecdiary.net");
		$mpdf->SetCreator('Invoice Manager');
		$mpdf->SetWatermarkText("Invoice Manager");
		$mpdf->showWatermarkText = false;
		$mpdf->watermark_font = 'DejaVuSansCondensed';
		$mpdf->watermarkTextAlpha = 0.025;
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->setBasePath(base_url());
		
		$html1 =  $this->load->view('view_quote', $data, TRUE);
	$name = $this->lang->line("quote")." ".$this->lang->line("no")." ".$inv->id.".pdf";
	
	$search = array("<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span2\">", "<div class=\"span10\">");
	$replace = array("<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 18%; float: left;'>", "<div style='width: 78%; float: left;'>");
	
	$html1 = str_replace($search, $replace, $html1);
	
	$mpdf->WriteHTML($html1);
	
	$mpdf->Output($name,'F', 'assets/uploads');
	
	  $html =  $this->load->view('view_quote', $data, TRUE);
	
	$search = array("<body>", "<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span2\">", "<div class=\"span10\">", "class=\"table table-bordered table-hover table-striped\"");
	$replace = array("<body style='max-width:800px;'>", "<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 18%; float: left;'>", "<div style='width: 78%; float: left;'>", "border='1' width='100%'");
	
	$html = str_replace($search, $replace, $html);
		
	if($note) { $message = $note."<br /><hr>".$html; } else { $message = $html; }
				
	$this->load->library('email');
		
	$config['mailtype'] = 'html';
	$config['wordwrap'] = TRUE;
	
	$this->email->initialize($config);
	
	$this->email->from($from, $from_name);
	$this->email->to($to); 
	
	$this->email->subject($subject);
	$this->email->message($message);
	$this->email->attach('assets/uploads/'.$name);	

	
	if($this->email->send()) {
		// email sent
		//$this->email->print_debugger(); die();
		
		unlink('assets/uploads/'.$name);
		return true;
	} else {
		//email not sent
		unlink('assets/uploads/'.$name);
		return false;
	}
	

   }

   
   function email_invoice()
   {
	   if($this->input->get('id')){ $id = $this->input->get('id'); } else { $id = NULL; }
		
		//validate form input
		$this->form_validation->set_rules('to', $this->lang->line("to")." ".$this->lang->line("email"), 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('subject', $this->lang->line("subject"), 'required|xss_clean');
		$this->form_validation->set_rules('note', $this->lang->line("message"), 'trim|xss_clean');
		
		if ($this->form_validation->run() == true)
		{
			$to = $this->input->post('to');
			$subject= $this->input->post('subject');
			$message = $this->input->post('note');
			$user = $this->ion_auth->user()->row();	
			$from_name = $user->first_name." ".$user->last_name;
			$from = $user->email;
		}
		
		if ( $this->form_validation->run() == true && $this->email($id, $to, $from_name, $from, $subject, $message) )
		{ //check to see if we are creating the biller
			//redirect them back to the admin page
			
				$this->session->set_flashdata('success_message', $this->lang->line("sent"));
				redirect("module=sales", 'refresh');
			
		}
		else
		{ //display the create biller form
			//set the flash data error message if there is one
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		
			$data['to'] = array('name' => 'to',
				'id' => 'to',
				'type' => 'text',
				'value' => $this->form_validation->set_value('to'),
			);
			$data['subject'] = array('name' => 'subject',
				'id' => 'subject',
				'type' => 'text',
				'value' => $this->form_validation->set_value('subject'),
			);
			$data['note'] = array('name' => 'note',
				'id' => 'note',
				'type' => 'text',
				'value' => $this->form_validation->set_value('note'),
			);
			
			
		$user = $this->ion_auth->user()->row();	
	    $data['from_name'] = $user->first_name." ".$user->last_name;
		$data['from_email'] = $user->email;

			//get customer by invoice
			$inv = $this->sales_model->getInvoiceByID($id);
			$customer_id = $inv->customer_id;
			//get customer details
			$data['cus'] = $this->sales_model->getCustomerByID($customer_id);
			$data['id'] = $id;
			$data['quote_id'] = NULL;
			$meta['page_title'] = $this->lang->line("email"). " " . $this->lang->line("invoice");
	  		$data['page_title'] = $this->lang->line("email"). " " . $this->lang->line("invoice");
		
      
      $this->load->view('commons/header', $meta);
      $this->load->view('email', $data);
      $this->load->view('commons/footer');
			
		}
   }
   
   function email_quote()
   {
	   if($this->input->get('id')){ $id = $this->input->get('id'); } else { $id = NULL; }
		
		//validate form input
		$this->form_validation->set_rules('to', $this->lang->line("to")." ".$this->lang->line("email"), 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('subject', $this->lang->line("subject"), 'required|xss_clean');
		$this->form_validation->set_rules('note', $this->lang->line("message"), 'trim|xss_clean');
		
		if ($this->form_validation->run() == true)
		{
			$to = $this->input->post('to');
			$subject= $this->input->post('subject');
			$message = $this->input->post('note');
			$user = $this->ion_auth->user()->row();	
			$from_name = $user->first_name." ".$user->last_name;
			$from = $user->email;
		}
		
		if ( $this->form_validation->run() == true && $this->emailQ($id, $to, $from_name, $from, $subject, $message) )
		{ //check to see if we are creating the biller
			//redirect them back to the admin page

				$this->session->set_flashdata('success_message', $this->lang->line("sent"));
				redirect("module=sales&view=quotes", 'refresh');
		
		}
		else
		{ //display the create biller form
			//set the flash data error message if there is one
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		
			$data['to'] = array('name' => 'to',
				'id' => 'to',
				'type' => 'text',
				'value' => $this->form_validation->set_value('to'),
			);
			$data['subject'] = array('name' => 'subject',
				'id' => 'subject',
				'type' => 'text',
				'value' => $this->form_validation->set_value('subject'),
			);
			$data['note'] = array('name' => 'note',
				'id' => 'note',
				'type' => 'text',
				'value' => $this->form_validation->set_value('note'),
			);
			
			
		$user = $this->ion_auth->user()->row();	
	    $data['from_name'] = $user->first_name." ".$user->last_name;
		$data['from_email'] = $user->email;

			//get customer by invoice
			$inv = $this->sales_model->getQuoteByID($id);
			$customer_id = $inv->customer_id;
			//get customer details
			$data['cus'] = $this->sales_model->getCustomerByID($customer_id);
			$data['id'] = $id;
			$data['quote_id'] = NULL;
			$meta['page_title'] = $this->lang->line("email"). " " . $this->lang->line("quote");
	  		$data['page_title'] = $this->lang->line("email"). " " . $this->lang->line("quote");
		
      
      $this->load->view('commons/header', $meta);
      $this->load->view('email_quote', $data);
      $this->load->view('commons/footer');
			
		}
   }
/*----------------------------------------------------------------------------------------------------------------------------------*/
	function update_status()
   {
	  if($this->input->post('id')){ $id = $this->input->post('id'); } else { $id = NULL; break; }
	  if($this->input->post('status')){ $status = $this->input->post('status'); } else { $status = NULL; break; }
	  if($id && $status) {
		  if($this->sales_model->updateStatus($id, $status)){
			  $this->session->set_flashdata('success_message', $this->lang->line("status_updated"));
			  redirect("module=sales", 'refresh');
		  }
	  }
	  
	return false;
   }
   
   function add_payment()
   {
	  if($this->input->post('invoice_id')){ $invoice_id = $this->input->post('invoice_id'); } else { $invoice_id = NULL; break; }
	  if($this->input->post('customer_id')){ $customer_id = $this->input->post('customer_id'); } else { $customer_id = NULL; break; }
	  if($this->input->post('note')){ $note = $this->input->post('note'); } else { $note = NULL; }
	  if($this->input->post('amount')){ $amount = $this->input->post('amount'); } else { $amount = NULL; break; }
	  if($invoice_id && $customer_id && $amount) {
		  if($this->sales_model->addPaument($invoice_id, $customer_id, $amount, $note)){
			  $this->session->set_flashdata('success_message', $this->lang->line("amount_added"));
			  redirect("module=sales", 'refresh');
		  }
	  }
	  
	return false;
   }
   
   function pr_details()
   {
	   if($this->input->get('name')) { $name = $this->input->get('name'); }
	   
	   if($item = $this->sales_model->getProductByName($name)) {
	   		
			$price = $item->price;
			$tax_rate = $item->tax_rate;
			
			$product = array('price' => $price, 'tax_rate' => $tax_rate);	
		
	   }
	   
	  echo json_encode($product);

   }
   
   function roundnum($num, $nearest = 0.05){
		return round($num / $nearest) * $nearest;
	}
   
}