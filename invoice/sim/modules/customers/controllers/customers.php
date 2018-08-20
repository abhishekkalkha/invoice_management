<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends MX_Controller {



	 
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
		
		$this->load->library('form_validation');
		$this->load->model('customers_model');


	}
	
   function index()
   {
	   $groups = array('purchaser', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('home', 'refresh');
		}
		
	  $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	  $data['success_message'] = $this->session->flashdata('success_message');
	  
	  		
      $meta['page_title'] = $this->lang->line("customers");
	  $data['page_title'] = $this->lang->line("customers");
      $this->load->view('commons/header', $meta);
      $this->load->view('content', $data);
      $this->load->view('commons/footer');
   }
   
   function getdatatableajax()
   {
 
	   $this->load->library('datatables');
	   $this->datatables
			->select("id, name, company, phone, email, city, country")
			->from("customers")
			
			->add_column("Actions", 
			"<center><div class='btn-group'><a class=\"tip btn btn-primary btn-xs\" title='".$this->lang->line("edit_customer")."' href='index.php?module=customers&amp;view=edit&amp;id=$1'><i class=\"fa fa-edit\"></i></a> <a class=\"tip btn btn-danger btn-xs\" title='".$this->lang->line("delete_customer")."' href='index.php?module=customers&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_customer') ."')\"><i class=\"fa fa-trash-o\"></i></a></div></center>", "id")
			->unset_column('id');
		
		
	   echo $this->datatables->generate();

   }
	
	function add()
	{
		$groups = array('admin', 'sales');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=home', 'refresh');
		}	
		

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
			$name = strtolower($this->input->post('name'));
			$email = $this->input->post('email');
			$company = $this->input->post('company');

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
		
		if ( $this->form_validation->run() == true && $this->customers_model->addCustomer($data))
		{ //check to see if we are creating the customer
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("customer_added"));
			redirect("module=customers", 'refresh');
		}
		else
		{ //display the create customer form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

			$data['name'] = array('name' => 'name',
				'id' => 'name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('name'),
			);
			$data['email'] = array('name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$data['company'] = array('name' => 'company',
				'id' => 'company',
				'type' => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			$data['cui'] = array('name' => 'cui',
				'id' => 'cui',
				'type' => 'text',
				'value' => $this->form_validation->set_value('cui', '-'),
			);
			$data['reg'] = array('name' => 'reg',
				'id' => 'reg',
				'type' => 'text',
				'value' => $this->form_validation->set_value('reg', '-'),
			);
			$data['cnp'] = array('name' => 'cnp',
				'id' => 'cnp',
				'type' => 'text',
				'value' => $this->form_validation->set_value('cnp', '-'),
			);
			$data['serie'] = array('name' => 'serie',
				'id' => 'serie',
				'type' => 'text',
				'value' => $this->form_validation->set_value('serie', '-'),
			);
			$data['account_no'] = array('name' => 'account_no',
				'id' => 'account_no',
				'type' => 'text',
				'value' => $this->form_validation->set_value('account_no', '-'),
			);
			$data['bank'] = array('name' => 'bank',
				'id' => 'bank',
				'type' => 'text',
				'value' => $this->form_validation->set_value('bank', '-'),
			);
			$data['address'] = array('name' => 'address',
				'id' => 'address',
				'type' => 'text',
				'value' => $this->form_validation->set_value('address'),
			);
			$data['city'] = array('name' => 'city',
				'id' => 'city',
				'type' => 'text',
				'value' => $this->form_validation->set_value('city'),
			);
			$data['state'] = array('name' => 'state',
				'id' => 'state',
				'type' => 'text',
				'value' => $this->form_validation->set_value('state'),
			);
			$data['postal_code'] = array('name' => 'postal_code',
				'id' => 'postal_code',
				'type' => 'text',
				'value' => $this->form_validation->set_value('postal_code'),
			);
			$data['country'] = array('name' => 'country',
				'id' => 'country',
				'type' => 'text',
				'value' => $this->form_validation->set_value('country'),
			);
			$data['phone'] = array('name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$data['cf1'] = array('name' => 'cf1',
				'id' => 'cf1',
				'type' => 'text',
				'value' => $this->form_validation->set_value('cf1', '-'),
			);
			$data['cf2'] = array('name' => 'cf2',
				'id' => 'cf2',
				'type' => 'text',
				'value' => $this->form_validation->set_value('cf2', '-'),
			);
			$data['cf3'] = array('name' => 'cf3',
				'id' => 'cf3',
				'type' => 'text',
				'value' => $this->form_validation->set_value('cf3', '-'),
			);
			$data['cf4'] = array('name' => 'cf4',
				'id' => 'cf4',
				'type' => 'text',
				'value' => $this->form_validation->set_value('cf4', '-'),
			);
			$data['cf5'] = array('name' => 'cf5',
				'id' => 'cf5',
				'type' => 'text',
				'value' => $this->form_validation->set_value('cf5', '-'),
			);
			$data['cf6'] = array('name' => 'cf6',
				'id' => 'cf6',
				'type' => 'text',
				'value' => $this->form_validation->set_value('cf6', '-'),
			);
			
		
		$meta['page_title'] = $this->lang->line("new_customer");
		$data['page_title'] = $this->lang->line("new_customer");
		$this->load->view('commons/header', $meta);
		$this->load->view('add', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function edit($id = NULL)
	{
		if($this->input->get('id')) { $id = $this->input->get('id'); }
		$groups = array('admin', 'sales');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=home', 'refresh');
		}
		

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
		
		if ( $this->form_validation->run() == true && $this->customers_model->updateCustomer($id, $data))
		{ //check to see if we are updateing the customer
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("customer_updated"));
			redirect("module=customers", 'refresh');
		}
		else
		{ //display the update form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

					
			
		$data['customer'] = $this->customers_model->getCustomerByID($id);
		
		$meta['page_title'] = $this->lang->line("update_customer");
		$data['id'] = $id;
		$data['page_title'] = $this->lang->line("update_customer");
		$this->load->view('commons/header', $meta);
		$this->load->view('edit', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function delete($id = NULL)
	{
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		
		if($this->input->get('id')) { $id = $this->input->get('id'); }
		if (!$this->ion_auth->in_group('admin'))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=home', 'refresh');
		}
		
		if ( $this->customers_model->deleteCustomer($id) )
		{ //check to see if we are deleting the customer
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("customer_deleted"));
			redirect("module=customers", 'refresh');
		}
		
	}
	
	
}