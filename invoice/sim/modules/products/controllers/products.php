<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends MX_Controller {


	 
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
		
		$this->load->library('form_validation');
		$this->load->model('products_model');


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
	  
	  		
      $meta['page_title'] = $this->lang->line("products");
	  $data['page_title'] = $this->lang->line("products");
      $this->load->view('commons/header', $meta);
      $this->load->view('content', $data);
      $this->load->view('commons/footer');
   }
   
   function getdatatableajax()
   {
 
	   $this->load->library('datatables');
	   $this->datatables
			->select("products.id as id, products.name as pname, price, tax_rates.name")
			->from("products")
			->join('tax_rates', 'tax_rates.id=products.tax_rate', 'left')
			->group_by('products.id')
			
			->add_column("Actions", 
			"<center><div class='btn-group'><a class=\"tip btn btn-primary btn-xs\" title='".$this->lang->line("edit_product")."' href='index.php?module=products&amp;view=edit&amp;id=$1'><i class=\"fa fa-edit\"></i></a> <a class=\"tip btn btn-danger btn-xs\" title='".$this->lang->line("delete_product")."' href='index.php?module=products&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_product') ."')\"><i class=\"fa fa-trash-o\"></i></a></div></center>", "id")
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
		$this->form_validation->set_rules('price', $this->lang->line("price"), 'required|xss_clean');
		$this->form_validation->set_rules('tax_rate', $this->lang->line("tax_rate"), 'required|xss_clean');
		
		if ($this->form_validation->run() == true)
		{

			$data = array('name' => $this->input->post('name'),
				'price' => $this->input->post('price'),
				'tax_rate' => $this->input->post('tax_rate'),
			);
		}
		
		if ( $this->form_validation->run() == true && $this->products_model->addProduct($data))
		{ //check to see if we are creating the product
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("product_added"));
			redirect("module=products", 'refresh');
		}
		else
		{ //display the create product form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

			$data['tax_rates'] = $this->products_model->getAllTaxRates();
			
		
		$meta['page_title'] = $this->lang->line("new_product");
		$data['page_title'] = $this->lang->line("new_product");
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
		$this->form_validation->set_rules('price', $this->lang->line("price"), 'required|xss_clean');
		$this->form_validation->set_rules('tax_rate', $this->lang->line("tax_rate"), 'required|xss_clean');
		
		if ($this->form_validation->run() == true)
		{

			$data = array('name' => $this->input->post('name'),
				'price' => $this->input->post('price'),
				'tax_rate' => $this->input->post('tax_rate'),
			);
		}
		
		if ( $this->form_validation->run() == true && $this->products_model->updateProduct($id, $data))
		{ //check to see if we are updateing the product
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("product_updated"));
			redirect("module=products", 'refresh');
		}
		else
		{ //display the update form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

					
			
		$data['product'] = $this->products_model->getProductByID($id);
		$data['tax_rates'] = $this->products_model->getAllTaxRates();
		
		$meta['page_title'] = $this->lang->line("update_product");
		$data['id'] = $id;
		$data['page_title'] = $this->lang->line("update_product");
		$this->load->view('commons/header', $meta);
		$this->load->view('edit', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function import()
	{
		if (!$this->ion_auth->in_group('admin'))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=products', 'refresh');
		}
			
		$this->form_validation->set_rules('userfile', $this->lang->line("upload_file"), 'xss_clean');
		 
		if ($this->form_validation->run() == true)
		{
			
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		
		$category = $this->input->post('category');			
		if ( isset($_FILES["userfile"])) /*if($_FILES['userfile']['size'] > 0)*/
		{
				
		$this->load->library('upload_photo');
		
		$config['upload_path'] = 'assets/uploads/'; 
		$config['allowed_types'] = 'csv'; 
		$config['max_size'] = '200';
		$config['overwrite'] = TRUE; 
		
			$this->upload_photo->initialize($config);
			
			if( ! $this->upload_photo->do_upload()){
			
				$error = $this->upload_photo->display_errors();
				$this->session->set_flashdata('message', $error);
				redirect("module=products&view=import", 'refresh');
			} 
		
		$csv = $this->upload_photo->file_name;
		
		$arrResult = array();
			$handle = fopen("assets/uploads/".$csv, "r");
			if( $handle ) {
			while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$arrResult[] = $row;
			}
			fclose($handle);
			}
			$titles = array_shift($arrResult);
			
			$keys = array('name', 'price', 'tax');
			
			$final = array();
					
					foreach ( $arrResult as $key => $value ) {
								$final[] = array_combine($keys, $value);
					}
			$rw=2;
			foreach($final as $csv_pr) {
				if($this->products_model->getProductByName($csv_pr['name'])) {
						$this->session->set_flashdata('message', $this->lang->line("check_product_name")." (".$csv_pr['name']."). ".$this->lang->line("product_name_already_exist")." ".$this->lang->line("line_no")." ".$rw);
						redirect("module=products&view=import", 'refresh');
				}
				if( $taxd = $this->products_model->getTaxRateByName($csv_pr['tax'])) {
					$pr_name[] = $csv_pr['name'];
					$pr_tax[] = $taxd->id;
					$pr_price[] = $csv_pr['price'];
				} else {
						$this->session->set_flashdata('message', $this->lang->line("check_tax_rate")." (".$csv_pr['tax']."). ".$this->lang->line("tax_x_exist")." ".$this->lang->line("line_no")." ".$rw);
						redirect("module=products&view=import", 'refresh');
				}
				
			$rw++;	
			}
		} 

		$ikeys = array('name', 'price', 'tax_rate');
		
					$items = array();
				foreach ( array_map(null, $pr_name, $pr_price, $pr_tax) as $ikey => $value ) {
					$items[] = array_combine($ikeys, $value);
				}
				
		$final = $this->mres($items);
		//$data['final'] = $final;
		}
	
		if ( $this->form_validation->run() == true && $this->products_model->add_products($final))
		{ 
			$this->session->set_flashdata('success_message', $this->lang->line("products_added"));
			redirect('module=products', 'refresh');
		}
		else
		{  
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			
			$data['userfile'] = array('name' => 'userfile',
				'id' => 'userfile',
				'type' => 'text',
				'value' => $this->form_validation->set_value('userfile')
			);

		$meta['page_title'] = $this->lang->line("csv_add_products");
		$data['page_title'] = $this->lang->line("csv_add_products");
		$this->load->view('commons/header', $meta);
		$this->load->view('upload_csv', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function mres($q) {
		if(is_array($q))
			foreach($q as $k => $v)
				$q[$k] = $this->mres($v); //recursive
		elseif(is_string($q))
			$q = mysql_real_escape_string($q);
		return $q;
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
		
		if ( $this->products_model->deleteProduct($id) )
		{ //check to see if we are deleting the product
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("product_deleted"));
			redirect("module=products", 'refresh');
		}
		
	}
	
	
}