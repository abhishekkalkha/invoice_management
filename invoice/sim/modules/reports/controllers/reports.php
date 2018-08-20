<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MX_Controller {



	 
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('module=auth&view=login');
	  	}
		
		$this->load->model('reports_model');

	}
	
   function index()
   {
	 	 redirect('module=reports&view=daily_sales');
   }
   
   function daily_sales()
   {
	   if($this->input->get('year')){ $year = $this->input->get('year'); } else { $year = date('Y'); }
	   if($this->input->get('month')){ $month = $this->input->get('month'); } else { $month = date('m'); }
	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   	
		
		$config['template'] = '

   {table_open}<table border="0" cellpadding="0" cellspacing="0" class="table table-bordered" style="min-width:522px;">{/table_open}

   {heading_row_start}<tr>{/heading_row_start}

   {heading_previous_cell}<th><div class="text-center"><a href="{previous_url}">&lt;&lt;</div></a></th>{/heading_previous_cell}
   {heading_title_cell}<th colspan="{colspan}"><div class="text-center">{heading}</div></th>{/heading_title_cell}
   {heading_next_cell}<th><div class="text-center"><a href="{next_url}">&gt;&gt;</a></div></th>{/heading_next_cell}

   {heading_row_end}</tr>{/heading_row_end}

   {week_row_start}<tr>{/week_row_start}
   {week_day_cell}<td class="cl_equal"><div class="cl_wday">{week_day}</div></td>{/week_day_cell}
   {week_row_end}</tr>{/week_row_end}

   {cal_row_start}<tr>{/cal_row_start}
   {cal_cell_start}<td>{/cal_cell_start}

   {cal_cell_content}<div class="cl_left">{day}</div><div class="cl_right">{content}</div>{/cal_cell_content}
   {cal_cell_content_today}<div class="cl_left highlight">{day}</div><div class="cl_right">{content}</div>{/cal_cell_content_today}

   {cal_cell_no_content}{day}{/cal_cell_no_content}
   {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

   {cal_cell_blank}&nbsp;{/cal_cell_blank}

   {cal_cell_end}</td>{/cal_cell_end}
   {cal_row_end}</tr>{/cal_row_end}

   {table_close}</table>{/table_close}
';

		
		$this->load->library('calendar', $config);
		
		 
		$sales = $this->reports_model->getDailySales($year, $month);
		
		if(!empty($sales)) {
			foreach($sales as $sale){
				$daily_sale[$sale->date] = "<span class='violet'>". $sale->total."</span><br><span class='green'>".$sale->paid."</span><br><span class='orange'>".number_format(($sale->total - $sale->paid), 2, '.', '')."</span>";	
			}
		} else {
			$daily_sale = array();
		}
		
	   $data['calender'] = $this->calendar->generate($year, $month, $daily_sale);
	   
      $meta['page_title'] = $this->lang->line("daily_sales");
	  $data['page_title'] = $this->lang->line("daily_sales");
      $this->load->view('commons/header', $meta);
      $this->load->view('daily', $data);
      $this->load->view('commons/footer');
   }
   
  
   function monthly_sales()
   {
	   if($this->input->get('year')){ $year = $this->input->get('year'); } else { $year = date('Y'); }

	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   
		$data['year'] = $year;
		
	   $data['sales'] = $this->reports_model->getMonthlySales($year);
	   
      $meta['page_title'] = $this->lang->line("monthly_sales");
	  $data['page_title'] = $this->lang->line("monthly_sales");
      $this->load->view('commons/header', $meta);
      $this->load->view('monthly', $data);
      $this->load->view('commons/footer');
   }
   
    
   
   function sales()
   {
	 	$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');	   
	    $data['customers'] = $this->reports_model->getAllCustomers();
	   if($this->input->post('submit') && $this->input->post('customer')) {
		   $data['cus'] = $this->reports_model->getCustomerByID($this->input->post('customer')); 
		   $data['tpp'] = $this->reports_model->TPP($this->input->post('customer')); 
		   $data['total'] = $this->reports_model->getTotal($this->input->post('customer')); 
		   $data['paid'] = $this->reports_model->getPaid($this->input->post('customer')); 
		   $data['cancelled'] = $this->reports_model->getCancelled($this->input->post('customer')); 
		   $data['overdue'] = $this->reports_model->getOverdue($this->input->post('customer')); 
		   $data['pending'] = $this->reports_model->getPending($this->input->post('customer'));
		   $data['pp'] = $this->reports_model->getPP($this->input->post('customer'));
	   }
      $meta['page_title'] = $this->lang->line("sale_reports");
	  $data['page_title'] = $this->lang->line("sale_reports");
      $this->load->view('commons/header', $meta);
      $this->load->view('sales', $data);
      $this->load->view('commons/footer');
   }
   
   function getsales()
   {
 		if($this->input->get('product')){ $product = $this->input->get('product'); } else { $product = NULL; }
		if($this->input->get('status')){ $status = $this->input->get('status'); } else { $status = NULL; }
		if($this->input->get('customer')){ $customer = $this->input->get('customer'); } else { $customer = NULL; }
		if($this->input->get('start_date')){ $start_date = $this->input->get('start_date'); 
			$inv_date = $start_date;
			if(JS_DATE == 'dd-mm-yy' || JS_DATE == 'dd/mm/yy' || JS_DATE == 'dd.mm.yy') {
				$start_date = substr($inv_date, -4)."-".substr($inv_date, 3, 2)."-".substr($inv_date, 0, 2); 
			} else {
				$start_date = substr($inv_date, -4)."-".substr($inv_date, 0, 2)."-".substr($inv_date, 3, 2);
			}
		} else { $start_date = NULL; }
		if($this->input->get('end_date')){ $end_date = $this->input->get('end_date');
			$inv_date = $end_date;
			if(JS_DATE == 'dd-mm-yy' || JS_DATE == 'dd/mm/yy' || JS_DATE == 'dd.mm.yy') {
				$end_date = substr($inv_date, -4)."-".substr($inv_date, 3, 2)."-".substr($inv_date, 0, 2); 
			} else {
				$end_date = substr($inv_date, -4)."-".substr($inv_date, 0, 2)."-".substr($inv_date, 3, 2);
			}
		} else { $end_date = NULL; }
		
		if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $check = TRUE; } else { $check = NULL; }
		
	    $this->load->library('datatables');
	    $this->datatables
			//->select("sales.id as sid, date, reference_no, user, customer_name, total, status, sale_items.product_name as product_name")
			->select("sales.id as id, sales.date as date, reference_no, sales.user, customer_name, total, COALESCE(sum(payment.amount), 0) as amount, total-COALESCE(sum(payment.amount), 0) as balance, status, sales.customer_id as cid, sale_items.product_name as product_name", FALSE)
			->from('sales')
			->join('payment', 'payment.invoice_id=sales.id', 'left');
			if($check) { $this->datatables->where('sales.user', LI_USER); }
		if($product) { $this->datatables->like('sale_items.product_name', $product, 'both'); }
		if($customer) { $this->datatables->where('sales.customer_id', $customer); }	
		if($status) { $this->datatables->where('status', $status); }
		if($start_date) { $this->datatables->where('sales.date >=', $start_date); }
		if($end_date) { $this->datatables->where('sales.date <=', $end_date); }
		$this->datatables->join('sale_items', 'sale_items.sale_id=sales.id', 'left')->group_by('sales.id');
		/*$this->datatables->add_column("Actions", "<center><a class=\"tip\" title='".$this->lang->line("view_invoice")."' href='#' onClick=\"MyWindow=window.open('index.php?module=sales&view=view_invoice&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1000,height=600'); return false;\"><i class=\"icon-list\"></i></a> 
								<a class=\"tip\" title='".$this->lang->line("download_pdf")."' href='index.php?module=sales&view=pdf&id=$1'><i class=\"icon-file\"></i></a> 
								<a class=\"tip\" title='".$this->lang->line("email_invoice")."' href='index.php?module=sales&view=email_invoice&id=$1'><i class=\"icon-envelope\"></i></a>
								<a class=\"tip\" title='".$this->lang->line("edit_invoice")."' href='index.php?module=sales&amp;view=edit&amp;id=$1'><i class=\"icon-edit\"></i></a>
							    <a class=\"tip\" title='".$this->lang->line("delete_invoice")."' href='index.php?module=sales&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_invoice') ."')\"><i class=\"icon-remove\"></i></a></center>", "sid")*/
		
		$this->datatables->unset_column('id')
		->unset_column('cid')
		->unset_column('product_name');
		
		
	   echo $this->datatables->generate();
   }
   
   function payments()
   {
	 	$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');	 
		$data['customers'] = $this->reports_model->getAllCustomers(); 
	   if($this->input->post('submit') && $this->input->post('customer')) {
		   $data['cus'] = $this->reports_model->getCustomerByID($this->input->post('customer')); 
		   $data['tpp'] = $this->reports_model->TPP($this->input->post('customer')); 
		   $data['total'] = $this->reports_model->getTotal($this->input->post('customer')); 
		   $data['paid'] = $this->reports_model->getPaid($this->input->post('customer')); 
		   $data['cancelled'] = $this->reports_model->getCancelled($this->input->post('customer')); 
		   $data['overdue'] = $this->reports_model->getOverdue($this->input->post('customer')); 
		   $data['pending'] = $this->reports_model->getPending($this->input->post('customer'));
		   $data['pp'] = $this->reports_model->getPP($this->input->post('customer'));
	   }
      $meta['page_title'] = $this->lang->line("payment_reports");
	  $data['page_title'] = $this->lang->line("payment_reports");
      $this->load->view('commons/header', $meta);
      $this->load->view('payment', $data);
      $this->load->view('commons/footer');
   }
   
   function getpayments()
   {
		if($this->input->get('customer')){ $customer = $this->input->get('customer'); } else { $customer = NULL; }
		if($this->input->get('note')){ $note = $this->input->get('note'); } else { $note = NULL; }
		if($this->input->get('start_date')){ $start_date = $this->input->get('start_date'); 
			$inv_date = $start_date;
			if(JS_DATE == 'dd-mm-yy' || JS_DATE == 'dd/mm/yy' || JS_DATE == 'dd.mm.yy') {
				$start_date = substr($inv_date, -4)."-".substr($inv_date, 3, 2)."-".substr($inv_date, 0, 2); 
			} else {
				$start_date = substr($inv_date, -4)."-".substr($inv_date, 0, 2)."-".substr($inv_date, 3, 2);
			}
		} else { $start_date = NULL; }
		if($this->input->get('end_date')){ $end_date = $this->input->get('end_date');
			$inv_date = $end_date;
			if(JS_DATE == 'dd-mm-yy' || JS_DATE == 'dd/mm/yy' || JS_DATE == 'dd.mm.yy') {
				$end_date = substr($inv_date, -4)."-".substr($inv_date, 3, 2)."-".substr($inv_date, 0, 2); 
			} else {
				$end_date = substr($inv_date, -4)."-".substr($inv_date, 0, 2)."-".substr($inv_date, 3, 2);
			}
		} else { $end_date = NULL; }
		
		if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $check = TRUE; } else { $check = NULL; }
		
	    $this->load->library('datatables');
	    $this->datatables
			//->select("sales.id as sid, date, reference_no, user, customer_name, total, status, sale_items.product_name as product_name")
			->select("payment.id as id, payment.date as date, payment.invoice_id, customers.name, payment.user, amount", FALSE)
			->from('payment');
		if($check) { $this->datatables->where('payment.user', LI_USER); }
		if($note) { $this->datatables->like('payment.note', $note, 'both'); }
		if($customer) { $this->datatables->where('payment.customer_id', $customer); }	
		if($start_date) { $this->datatables->where('payment.date >=', $start_date); }
		if($end_date) { $this->datatables->where('payment.date <=', $end_date); }
		$this->datatables->join('customers', 'customers.id=payment.customer_id', 'left')->group_by('payment.id');
		
		$this->datatables->unset_column('id');
		
		
	   echo $this->datatables->generate();
   }

}