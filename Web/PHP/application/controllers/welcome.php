<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	 private static $menu_type = '1';
	 private static $now = 0;
	 private static $meal_time = array(
		 'lunch' => array('00:00', '12:30'),
		 'dinner' => array('17:00', '23:59'),
	 );
	 
	 public function __construct()
	 {
		 parent::__construct();
		 self::$now = time();
	 }
	 
	public function index()
	{
		$oid = $this->get_order_id();
		
		$this->load->view('welcome_message', array(
				'menu_data' => $this->get_menu(self::$menu_type),
				'order_id' => $oid,
				'meal_time' => self::$meal_time,
			));
	}

	/**
	 * @Function: add_record;
	 * @Param: $id;
	 * @Return void;
	 */
	public function add_record()
	{
		$oid = $this->get_order_id();
		if($oid == 0)
		{
			$message = $this->get_message(FAILED_ERROR_NO_ORDER, '别着急!订餐时间还没到');
			echo json_encode($message);
			exit();
		}
		
		$post = $this->input->post();

		if (empty($post))
		{
			$message = $this->get_message();
			echo json_encode($message);
			exit();
		}
		
		$datas_order = array();
		$mids = $post['ids'];
		$has_one = FALSE;
		$menu_duplicate_id = 0;
			
		foreach($mids as $mid)
		{
			$has_one = $this->check_order_menu($oid, $mid);
			if($has_one)
			{
				$menu_duplicate_id = $mid;
				break;
			}
				
			$price = 0;
			$query = $this->db->get_where(CH_TABLE_MENU, array('id' => $mid));
			$ret = $query->result();

			if(count($ret) > 0)
			{
				$price = $ret[0]->price;
			}
				
			$datas_order[] = array(
				'tid' => self::$menu_type,
				'oid' => $oid,
				'mid' => $mid,
				'price' => $price,
				'usertoken' => $this->get_user_unique(),
				'lastupdate' => self::$now,
			);
		}
		
		
		if($has_one)
		{
			$query = $this->db->get_where(CH_TABLE_MENU, array('id' => $menu_duplicate_id));
			$menu = $query->result();
			$message = $this->get_message(FAILED_ERROR_DUPLICATE_ORDER, '已经订过' . $menu[0]->name . ',请重新选择.');
		}
		else
		{
			$r = $this->db->insert_batch(CH_TABLE_RECORD, $datas_order);
			if($r)
			{
				$message = $this->get_message(SUCCES_CODE, '下单成功');
			}
			else
			{
				$message = $this->get_message(FAILED_ERROR_ADD_RECORD, '下单失败 X_X');
			}
		}
		
		echo json_encode($message);
		exit();
	}

	private function check_order_menu($oid, $mid)
	{
		if(empty($oid) || empty($mid)){
			return TRUE;
		}
		
		$query = $this->db->get_where(CH_TABLE_RECORD, array('oid' => $oid, 'mid' => $mid));
		$ret = $query->result();
		return count($ret) > 0;
	}
	
	private function add_order()
	{
		$order_id = 0;

		foreach(self::$meal_time as $val)
		{
			if(self::$now >= strtotime($val[0])
				&& self::$now <= strtotime($val[1]))
			{
				$addtime = strtotime($val[0]);
				$deadline = strtotime($val[1]);

//			echo date('Y-m-d H:i:s', self::$now), "<br/>\n";
//			echo date('Y-m-d H:i:s', $ret[0]->addtime), "<br/>\n";
//			echo date('Y-m-d H:i:s', $ret[0]->deadline), "<br/>\n";
				
				$data = array(
					'tid' => self::$menu_type,
					'addtime' => $addtime,
					'deadline' => $deadline,
				);
				$this->db->insert(CH_TABLE_ORDER, $data);
				$order_id = $this->db->insert_id();
				break;
			}
		}

		return $order_id;
	}

	private function get_user_unique()
	{
		$session = $this->session->all_userdata();
		return $session['session_id'];
	}
	
	private function get_message($code = FAILED_ERROR_NO_SELECT, $message = '请选择想吃的菜')
	{
		return array(
			'code' => $code,
			'msg' => $message,
		);
	}

    /**
	 * @Function: get_menu;
	 * @Param: $type;
	 * @Return array;
	 */
	private function get_menu ($type)
	{
		return $this->db->get_where(CH_TABLE_MENU, array('tid' => $type))->result();
	}


	private function get_order_id()
	{
		$order_id = 0;

		$this->db->select('id, addtime, deadline')->order_by('id', 'desc');
		$order = $this->db->get(CH_TABLE_ORDER, 1, 0);
		
		if($order->num_rows > 0)
		{
			$ret = $order->result();
/*			
			echo 'now : ', date('Y-m-d H:i:s', self::$now), "<br/>\n";
			echo 'addtime : ', date('Y-m-d H:i:s', $ret[0]->addtime), "<br/>\n";
			echo 'deadline : ', date('Y-m-d H:i:s', $ret[0]->deadline), "<br/>\n";
*/
			
			if($ret[0]->addtime <= self::$now && $ret[0]->deadline >= self::$now)
			{
				$order_id = $ret[0]->id;
				return $order_id;
			}
		}
		
		$order_id = $this->add_order();
		return $order_id;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */