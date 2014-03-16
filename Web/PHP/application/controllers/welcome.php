<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	 private static $menu_type = '1';
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
		$this->load->view('welcome_message', array(
				'menuData' => $this->get_menu(self::$menu_type),
			));
	}

	/**
	 * @Function: ;
	 * @Param: param;
	 * @Return datatype;
	 */
	private function get_menu ($type)
	{
		return $this->db->get_where(CH_TABLE_MENU, array('tid' => $type))->result();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */