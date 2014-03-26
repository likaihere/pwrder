<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model
{
	private static $default_menu_type = '1';
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_menu()
	{
		$this->db->order_by('id', 'asc');
		$query = $this->db->get_where(CH_TABLE_MENU, array('tid' => self::$default_menu_type));
		return $query->result();
	}

}
