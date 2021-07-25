<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Template extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->db->cache_delete($this->router->fetch_class(), $this->router->fetch_method());
		$this->db->simple_query('SET NAMES \'utf-8\'');
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}

	function tpl_default($data=null, $n=300)
	{	
		$this->cache->get($data['url']);
		$this->cache->save($data['url'], $data['url'], $n);

		$this->load->view('default/public_html', $data, FALSE);
	}

	function tpl_login($value='')
	{
		# code...
	}

}

/* End of file Template.php */
/* Location: ./application/modules/template/controllers/Template.php */