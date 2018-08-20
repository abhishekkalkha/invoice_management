<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {


	 
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
		
		$this->load->model('home_model');	
		
	}
	
   function index()
   {
	  $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
	
		$user = $this->ion_auth->user()->row();	
	    $data['name'] = $user->first_name." (".$user->email.") ";

	   $data['total'] = $this->home_model->getTotal(); 
	   $data['paid'] = $this->home_model->getPaid(); 
	   $data['cancelled'] = $this->home_model->getCancelled(); 
	   $data['overdue'] = $this->home_model->getOverdue(); 
	   $data['pending'] = $this->home_model->getPending();
	   $data['pp'] = $this->home_model->getPP();
		
      $meta['page_title'] = $this->lang->line("welcome")." ".SITE_NAME."!";
	  $data['page_title'] = $this->lang->line("welcome")." ".SITE_NAME."!";
      $this->load->view('commons/header', $meta);
      $this->load->view('content', $data);
      $this->load->view('commons/footer');
   }
   
   function language($lang = false){
	    if($this->input->get('lang')){ $lang = $this->input->get('lang'); }
		$this->load->helper('cookie');
		$folder = 'sim/language/';
		$languagefiles = scandir($folder);
		if(in_array($lang, $languagefiles)){
		//setcookie("inv_language", $lang, '31536000');
		$cookie = array(
                   'name'   => 'language',
                   'value'  => $lang,
                   'expire' => '31536000',
				   'prefix' => 'inv_',
				   'secure' => false
               );
 
		$this->input->set_cookie($cookie);
		}
		redirect($_SERVER["HTTP_REFERER"]); 
	}

}

