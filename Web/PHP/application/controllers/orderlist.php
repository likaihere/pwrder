<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orderlist extends CI_Controller {
	private static $menu = array();

	public function __construct()
	{
		parent::__construct();
		self::$menu = $this->get_menu();
	}
	
	public function index($id)
	{
		$order_data = array();
		$record_data = array();

		$this->load->view('orderlist', array(
				'order_data' => $this->get_order($id),
				'record_data' => $this->get_record($id),
				'menu' => self::$menu,
			));
	}

	public function del_record($oid, $rid)
	{
		if(empty($oid) || empty($rid))
		{
			echo json_encode(array(
					'code' => -1,
					'msg' => '参数不正确'
				));
			exit();
		}
		
		$query = $this->db->delete(CH_TABLE_RECORD, array(
					 'oid' => $oid,
					 'rid' => $rid
			));
		
		var_dump($query);exit();
	}

	private function get_menu()
	{
		$query = $this->db->get_where(CH_TABLE_MENU);
		return $query->result();
	}

	private function get_order($id)
	{
		$query = $this->db->get_where(CH_TABLE_ORDER, array('id' => $id));
		return $query->result();
	}

	private function get_record($id)
	{
		$query = $this->db->get_where(CH_TABLE_RECORD, array('oid' => $id));
		return $query->result();
	}

	
	
}
