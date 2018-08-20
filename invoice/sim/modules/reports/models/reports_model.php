<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Reports_model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

	}
	
	
		
	public function getAllProducts() 
	{
		$q = $this->db->get('products');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	
	public function getDailySales($year, $month) 
	{
		
		/*$myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( total, 0 ) ) AS total
			FROM sales
			WHERE DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}' AND status != 'cancelled'
			GROUP BY DATE_FORMAT( date,  '%e' )";*/
			$myQuery = "SELECT DATE_FORMAT( sales.date,  '%e' ) AS date, COALESCE(sum(sales.total), 0) as total, COALESCE(sum(payment.amount), 0) as paid FROM (sales) 
						LEFT JOIN payment ON payment.invoice_id=sales.id 
						WHERE DATE_FORMAT( sales.date,  '%Y-%m' ) =  '{$year}-{$month}' AND status != 'cancelled'
						GROUP BY DATE_FORMAT( sales.date,  '%e' )";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	
	public function getMonthlySales($year) 
	{
		
		$myQuery = "SELECT DATE_FORMAT( sales.date,  '%c' ) AS date, SUM( COALESCE( total, 0 ) ) AS total, COALESCE(sum(payment.amount), 0) as paid
			FROM sales
			LEFT JOIN payment ON payment.invoice_id=sales.id 
			WHERE DATE_FORMAT( sales.date,  '%Y' ) =  '{$year}'  AND status != 'cancelled'
			GROUP BY date_format( sales.date, '%c' ) ORDER BY date_format( sales.date, '%c' ) ASC";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
		
	public function getAllCustomers() 
	{
		$q = $this->db->get('customers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getAllSuppliers() 
	{
		$q = $this->db->get('suppliers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	
	public function getTotal($customer_id) 
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
		 $q=$this->db->get_where('sales', array('customer_id' => $customer_id));
		 return $q->num_rows();
		
	}
	
	public function getPaid($customer_id) 
	{
		 if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $this->db->where('user', LI_USER); } 
		 $q = $this->db->get_where('sales', array('status' => $this->lang->line('paid'), 'customer_id' => $customer_id));
		 return $q->num_rows();

	}
	
	public function getPending($customer_id) 
	{
		if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $this->db->where('user', LI_USER); } 
		$q = $this->db->get_where('sales', array('status' => $this->lang->line('pending'), 'customer_id' => $customer_id));
		 return $q->num_rows();
	}
	
	public function getCancelled($customer_id) 
	{
		if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $this->db->where('user', LI_USER); } 
		$q = $this->db->get_where('sales', array('status' => $this->lang->line('cancelled'), 'customer_id' => $customer_id));
		 return $q->num_rows();
	}
	
	public function getOverdue($customer_id) 
	{
		if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $this->db->where('user', LI_USER); } 
		$q = $this->db->get_where('sales', array('status' => $this->lang->line('overdue'), 'customer_id' => $customer_id));
		 return $q->num_rows();
	}
		
	public function getPP($customer_id) 
	{
		if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $this->db->where('user', LI_USER); } 
		$q = $this->db->get_where('sales', array('status' => $this->lang->line('partially_paid'), 'customer_id' => $customer_id));
		 return $q->num_rows();
	}	
	
	public function TPP($customer_id) 
	{
		if(RESTRICT_SALES && !$this->ion_auth->in_group('admin')) { $this->db->where('user', LI_USER); } 
		$this->db->select('COALESCE(sum(sales.total), 0) as total, COALESCE(sum(payment.amount), 0) as paid', FALSE)->join('payment', 'payment.invoice_id=sales.id', 'left')
		->group_by('sales.customer_id');
		$q = $this->db->get_where('sales', array('sales.customer_id' => $customer_id));
		/*$qu = "SELECT COALESCE(sum(sales.total), 0) as total, COALESCE(sum(payment.amount), 0) as paid FROM (sales) LEFT JOIN payment ON payment.invoice_id=sales.id WHERE sales.customer_id = '{$customer_id}' GROUP BY sales.customer_id;";
		$q = $this->db->query($qu);*/
		 return $q->row();
	}
	
	public function getCustomerByID($id) 
	{

		$q = $this->db->get_where('customers', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}


}
