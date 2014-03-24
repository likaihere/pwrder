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
				'order_id' => $id,
				'order_data' => $this->get_order($id),
				'record_data' => $this->get_record($id),
				'menu' => self::$menu,
			));
	}

	public function del_record()
	{
		$post = $this->input->post();
		$oid = $post['oid'];
		$mids = $post['mids'];
		
		if(empty($oid) || empty($mids))
		{
			echo json_encode(array(
					'code' => -1,
					'msg' => '参数不正确'
				));
			exit();
		}

		$flag = FALSE;
		foreach($mids as $mid)
		{
			$ret = $this->db->delete(CH_TABLE_RECORD, array(
						 'oid' => $oid,
						 'mid' => $mid
					 ));
			if($ret && !$flag)
			{
				$flag = TRUE;
			}
		}

		if($flag)
		{
			$message = array(
				'code' => 0,
				'msg' => '删除成功',
			);			
		}
		else
		{
			$message = array(
				'code' => -1,
				'msg' => '删除失败',
			);
		}
		
		echo json_encode($message);
		exit();
	}

	private function get_menu()
	{
		$query = $this->db->get_where(CH_TABLE_MENU);
		$menu = array();
		foreach($query->result() as $key => $val)
		{
			$menu[$val->id] = $val;
		}
		return $menu;
		
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
