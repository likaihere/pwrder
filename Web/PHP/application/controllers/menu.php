<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
	private static $default_menu_type = '1';
	private static $menu = array();

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('Menu_model');

		$this->load->view('add_menu', array(
				'menu_data' => $this->Menu_model->get_menu(),
			));
	}

	public function add()
	{
		$post = $this->input->post();
		$names = $post['names'];
		$prices = $post['prices'];

		if(empty($names) || empty($prices))
		{
			echo json_encode(array(
					'code' => -1,
					'msg' => '参数不正确'
				));
			exit();
		}

		$ret = $this->db->insert(CH_TABLE_MENU, array(
				   'name' => $names[0],
				   'price' => ((float) $prices[0] * 100),
				   'tid' => self::$default_menu_type,
			   ));

		if($ret > 0)
		{
			echo json_encode(array(
					'code' => 0,
					'msg' => '添加成功'
				));
		}
		else
		{
			echo json_encode(array(
					'code' => -1,
					'msg' => '参数不正确'
				));			
		}
	}
}

?>
