<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

	}
	
	public function getTotal() 
	{

		 /*$this->db->select('sum(total) as total');
		 $q = $this->db->get('sales');
		 if( $q->num_rows() > 0 )
		  {
			$t = $q->row();
		  } else {
			 $t = array('total' => 0); 
		  }
		  
		 $q->free_result();
		 
		 $q=$this->db->get('sales');
		 $total = $q->num_rows();
		
		  return array('total_amount' => $t->total, 'total_number' => $total);*/
		 if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $this->db->where('user', LI_USER); } 
		 $q=$this->db->get('sales');
		 return $q->num_rows();
		
	}
	
	public function getPaid() 
	{
		 if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $this->db->where('user', LI_USER); } 
		 $q = $this->db->get_where('sales', array('status' => $this->lang->line('paid')));
		 return $q->num_rows();

	}
	
	public function getPending() 
	{
		if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $this->db->where('user', LI_USER); } 
		$q = $this->db->get_where('sales', array('status' => $this->lang->line('pending')));
		 return $q->num_rows();
	}
	
	public function getCancelled() 
	{
		if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $this->db->where('user', LI_USER); } 
		$q = $this->db->get_where('sales', array('status' => $this->lang->line('cancelled')));
		 return $q->num_rows();
	}
	
	public function getOverdue() 
	{
		if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $this->db->where('user', LI_USER); } 
		$q = $this->db->get_where('sales', array('status' => $this->lang->line('overdue')));
		 return $q->num_rows();
	}
		
	public function getPP() 
	{
		if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $this->db->where('user', LI_USER); } 
		$q = $this->db->get_where('sales', array('status' => $this->lang->line('partially_paid')));
		 return $q->num_rows();
	}	
	
}
