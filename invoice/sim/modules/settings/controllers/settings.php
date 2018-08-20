<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MX_Controller {



	 
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('module=auth&view=login');
	  	}
		
		$groups = array('sales', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line('access_denied'));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=home', 'refresh');
		}
		
		$this->load->library('form_validation');
		$this->load->model('settings_model');


	}
	
	function index()
   {
	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   $data['success_message'] = $this->session->flashdata('success_message');
      $meta['page_title'] = $this->lang->line('setting');
	  $data['page_title'] = $this->lang->line('setting');
      $this->load->view('commons/header', $meta);
      $this->load->view('content', $data);
      $this->load->view('commons/footer');
	  
   }
   function system_setting()
   {
	   
		//validate form input
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('no_zero_required'));
		$this->form_validation->set_rules('site_name', $this->lang->line('site_name'), 'required|xss_clean');
		$this->form_validation->set_rules('language', $this->lang->line('language'), 'required|xss_clean');
		$this->form_validation->set_rules('currency_prefix', $this->lang->line('currency_code'), 'required|max_length[3]|xss_clean');
		$this->form_validation->set_rules('tax_rate', $this->lang->line('default_tax_rate'), 'required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('rows_per_page', $this->lang->line('rows_per_page'), 'required|greater_than[9]|less_than[501]|xss_clean');
		$this->form_validation->set_rules('total_rows', $this->lang->line('total_rows'), 'required|greater_than[9]|less_than[100]|xss_clean');
		$this->form_validation->set_rules('date_format', $this->lang->line('date_format'), 'required|xss_clean');
		$this->form_validation->set_rules('print_payment', $this->lang->line('print_payment_on_invoice'), 'required|xss_clean');
                $this->form_validation->set_rules('display_words', $this->lang->line('display_to_words'), 'required|xss_clean');
		$this->form_validation->set_rules('calendar', $this->lang->line('calendar'), 'required|xss_clean');
		$this->form_validation->set_rules('restrict_sales', $this->lang->line('restrict_sales'), 'required|xss_clean');
		
		
		if ($this->form_validation->run() == true)
		{
			
			$data = array('site_name' => $this->input->post('site_name'),
				'language' => $this->input->post('language'),
				'currency_prefix' => $this->input->post('currency_prefix'),
				'default_tax_rate' => $this->input->post('tax_rate'),
				'rows_per_page' => $this->input->post('rows_per_page'),
				'total_rows' => $this->input->post('total_rows'),
				'dateformat' => $this->input->post('date_format'),
				'print_payment' => $this->input->post('print_payment'),
				'calendar' => $this->input->post('calendar'),
				'restrict_sales' => $this->input->post('restrict_sales'),
				'major' => $this->input->post('major'),
				'minor' => $this->input->post('minor'),
                                'display_words' => $this->input->post('display_words'),
			);
		}
		
		if ( $this->form_validation->run() == true && $this->settings_model->updateSetting($data))
		{ //check to see if we are updating
			//redirect them back to the setting page
			$this->session->set_flashdata('success_message', $this->lang->line('setting_updated'));
			redirect("module=settings&view=system_setting", 'refresh');
		}
		else
		{
			
	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   $data['success_message'] = $this->session->flashdata('success_message');
	   
	   $data['settings'] = $this->settings_model->getSettings();
	   $data['date_formats'] = $this->settings_model->getDateFormats(); 
	   $data['tax_rates'] = $this->settings_model->getAllTaxRates();
	   
      $meta['page_title'] = $this->lang->line('system_setting');
	  $data['page_title'] = $this->lang->line('system_setting');
      $this->load->view('commons/header', $meta);
      $this->load->view('setting', $data);
      $this->load->view('commons/footer');
	}
   }
   
   function company_details()
   {
		
		//validate form input
		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required|xss_clean');
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required|valid_email');
		$this->form_validation->set_rules('company', $this->lang->line("company"), 'required|xss_clean');
		$this->form_validation->set_rules('cf1', $this->lang->line("cf1"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("cf2"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("cf3"), 'xss_clean');
		$this->form_validation->set_rules('cf4', $this->lang->line("cf4"), 'xss_clean');
		$this->form_validation->set_rules('cf5', $this->lang->line("cf5"), 'xss_clean');
		$this->form_validation->set_rules('cf6', $this->lang->line("cf6"), 'xss_clean');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'required|xss_clean');
		$this->form_validation->set_rules('city', $this->lang->line("city"), 'required|xss_clean');
		$this->form_validation->set_rules('state', $this->lang->line("state"), 'required|xss_clean');
		$this->form_validation->set_rules('postal_code', $this->lang->line("postal_code"), 'required|xss_clean');
		$this->form_validation->set_rules('country', $this->lang->line("country"), 'required|xss_clean');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|xss_clean|min_length[9]|max_length[16]');
		
		if ($this->form_validation->run() == true)
		{

		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
			$data = array('name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'company' => $this->input->post('company'),
				'cf1' => $this->input->post('cf1'),
				'cf2' => $this->input->post('cf2'),
				'cf3' => $this->input->post('cf3'),
				'cf4' => $this->input->post('cf4'),
				'cf5' => $this->input->post('cf5'),
				'cf6' => $this->input->post('cf6'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'postal_code' => $this->input->post('postal_code'),
				'country' => $this->input->post('country'),
				'phone' => $this->input->post('phone')
			);
		}
		
		if ( $this->form_validation->run() == true && $this->settings_model->updateCompany($data))
		{ //check to see if we are updateing the customer
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("details_updated"));
			redirect("module=settings&view=company_details", 'refresh');
		}
		else
		{ //display the update form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$data['success_message'] = $this->session->flashdata('success_message');
					
			
		$data['details'] = $this->settings_model->getCompanyDetails();
	   
      $meta['page_title'] = $this->lang->line('company_details');
	  $data['page_title'] = $this->lang->line('company_details');
      $this->load->view('commons/header', $meta);
      $this->load->view('company', $data);
      $this->load->view('commons/footer');
	}
   }
   
   function tax_rates()
   {
	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   $data['success_message'] = $this->session->flashdata('success_message');
	   $data['tax_rates'] = $this->settings_model->getAllTaxRates(); 
	   
      $meta['page_title'] = $this->lang->line('tax_rates');
	  $data['page_title'] = $this->lang->line('tax_rates');
      $this->load->view('commons/header', $meta);
      $this->load->view('tax_rates', $data);
      $this->load->view('commons/footer');
	  
   }
   
   function add_tax_rate()
   {
	 

		//validate form input
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('no_zero_required'));
		$this->form_validation->set_rules('name', $this->lang->line('title'), 'required|xss_clean');
		$this->form_validation->set_rules('rate', $this->lang->line('rate'), 'required|xss_clean');
		$this->form_validation->set_rules('type', $this->lang->line('type'), 'required|is_natural_no_zero|xss_clean');
		
		
		if ($this->form_validation->run() == true)
		{
			
			$data = array('name' => $this->input->post('name'),
				'rate' => $this->input->post('rate'),
				'type' => $this->input->post('type')
			);
		}
		
		if ( $this->form_validation->run() == true && $this->settings_model->addTaxRate($data))
		{ //check to see if we are updating
			//redirect them back to the setting page
			$this->session->set_flashdata('success_message', $this->lang->line('tax_rate_added'));
			redirect("module=settings&view=tax_rates", 'refresh');
		}
		else
		{
			
	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   
      $meta['page_title'] = $this->lang->line('new_tax_rate');
	  $data['page_title'] = $this->lang->line('new_tax_rate');
      $this->load->view('commons/header', $meta);
      $this->load->view('add_tax_rate', $data);
      $this->load->view('commons/footer');
	}
   }
   
   function edit_tax_rate($id = NULL)
   {
	   if($this->input->get('id')){ $id = $this->input->get('id'); }

		//validate form input
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('no_zero_required'));
		$this->form_validation->set_rules('name', $this->lang->line('title'), 'required|xss_clean');
		$this->form_validation->set_rules('rate', $this->lang->line('rate'), 'required|xss_clean');
		$this->form_validation->set_rules('type', $this->lang->line('type'), 'required|is_natural_no_zero|xss_clean');
		
		
		if ($this->form_validation->run() == true)
		{
			
			$data = array('name' => $this->input->post('name'),
				'rate' => $this->input->post('rate'),
				'type' => $this->input->post('type')
			);
		}
		
		if ( $this->form_validation->run() == true && $this->settings_model->updateTaxRate($id, $data))
		{ //check to see if we are updating
			//redirect them back to the setting page
			$this->session->set_flashdata('success_message', $this->lang->line('tax_rate_updated'));
			redirect("module=settings&view=tax_rates", 'refresh');
		}
		else
		{
			
	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   
	   $data['tax_rate'] = $this->settings_model->getTaxRateByID($id);
	   $data['id'] = $id;
	   
      $meta['page_title'] = $this->lang->line('update_tax_rate');
	  $data['page_title'] = $this->lang->line('update_tax_rate');
      $this->load->view('commons/header', $meta);
      $this->load->view('edit_tax_rate', $data);
      $this->load->view('commons/footer');
	}
   }
   
   
	
   function change_logo()
   {
   
		
	   //validate form input
	   $this->form_validation->set_rules('logo', 'Logo Image', 'xss_clean');
		
		if ($this->form_validation->run() == true)
		{
		
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
			
		if($_FILES['logo']['size'] > 0){
				
		$this->load->library('upload_photo');
		
		//Set the config
		$config['upload_path'] = 'assets/img/'; 
		$config['allowed_types'] = 'gif|jpg|png'; 
		$config['max_size'] = '300';
		$config['max_width'] = '300';
		$config['max_height'] = '80';
		$config['overwrite'] = FALSE; 
		
			//Initialize
			$this->upload_photo->initialize($config);
			
			if( ! $this->upload_photo->do_upload('logo')){
			
				//echo the errors
				$error = $this->upload_photo->display_errors();
				$this->session->set_flashdata('message', $error);
				redirect("module=settings&view=change_logo", 'refresh');
			} 
		
		//If the upload success
		$photo = $this->upload_photo->file_name;
		
		} else {
			$this->session->set_flashdata('message', $this->lang->line('not_uploaded'));
			redirect("module=settings&view=change_logo", 'refresh');	
		}
			
		
		}
		
		if ( $this->form_validation->run() == true && $this->settings_model->updateLogo($photo))
		{ //check to see if we are updateing the product
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line('logo_changed'));
			redirect("module=settings&view=change_logo", 'refresh');
		}
		else
		{
			
	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   $data['success_message'] = $this->session->flashdata('success_message');
	   
      $meta['page_title'] = $this->lang->line('change_logo');
	  $data['page_title'] = $this->lang->line('change_logo');
      $this->load->view('commons/header', $meta);
      $this->load->view('logo', $data);
      $this->load->view('commons/footer');
	  
   	  }
   }
   
   function change_invoice_logo()
   {
	   
	   if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
	   
	   //validate form input
	   $this->form_validation->set_rules('logo', 'Logo Image', 'xss_clean');
		
		if ($this->form_validation->run() == true)
		{
		
			
		if($_FILES['logo']['size'] > 0){
				
		$this->load->library('upload_photo');
		
		//Set the config
		$config['upload_path'] = 'assets/img/'; 
		$config['allowed_types'] = 'gif|jpg|png'; 
		$config['max_size'] = '300';
		$config['max_width'] = '300';
		$config['max_height'] = '80';
		$config['overwrite'] = FALSE; 
		
			//Initialize
			$this->upload_photo->initialize($config);
			
			if( ! $this->upload_photo->do_upload('logo')){
			
				//echo the errors
				$error = $this->upload_photo->display_errors();
				$this->session->set_flashdata('message', $error);
				redirect("module=settings&view=change_logo", 'refresh');
			} 
		
		//If the upload success
		$photo = $this->upload_photo->file_name;
		
		} else {
			$this->session->set_flashdata('message', $this->lang->line('not_uploaded'));
			redirect("module=settings&view=change_logo", 'refresh');	
		}
			
		
		}
		
		if ( $this->form_validation->run() == true && $this->settings_model->updateInvoiceLogo($photo))
		{ //check to see if we are updateing the product
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line('logo_changed'));
			redirect("module=settings&view=change_invoice_logo", 'refresh');
		}
		else
		{
			
	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   $data['success_message'] = $this->session->flashdata('success_message');
	   
      $meta['page_title'] = $this->lang->line('change_invoice_logo');
	  $data['page_title'] = $this->lang->line('change_invoice_logo');
      $this->load->view('commons/header', $meta);
      $this->load->view('invoice_logo', $data);
      $this->load->view('commons/footer');
	  
   	  }
   }
   
   function backup_database()
   {
	   if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
	  
		$this->load->dbutil();
		
		$prefs = array(     
                'format'      => 'zip',             
                'filename'    => 'sim_db_backup.sql'
              );


		$backup =& $this->dbutil->backup($prefs); 
		
		$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
		$save = 'assets/DB_BACKUPS/'.$db_name;
		
		$this->load->helper('file');
		write_file($save, $backup); 
		
		
		$this->load->helper('download');
		force_download($db_name, $backup);   
   }
   
     
   
   function delete_tax_rate($id = NULL)
	{
		
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		if($this->input->get('id')){ $id = $this->input->get('id'); }
		
		if ( $this->settings_model->deleteTaxRate($id) )
		{ 
			$this->session->set_flashdata('success_message', $this->lang->line("tax_rate_deleted"));
			redirect('module=settings&view=tax_rates', 'refresh');
		}
		
	}
	
	function delete_invoice_type($id = NULL)
	{
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		if($this->input->get('id')){ $id = $this->input->get('id'); }
		
		if ( $this->settings_model->deleteInvoiceType($id) )
		{ 
			$this->session->set_flashdata('success_message', $this->lang->line("invoice_type_deleted"));
			redirect('module=settings&view=invoice_types', 'refresh');
		}
		
	}
	
	
   
}