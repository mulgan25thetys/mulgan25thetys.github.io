<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custompage extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	function index()
	{
		$this->view();
	}

	function view($value='')
	{
		$data = array(
			'url' => uri_string()
		);
		echo Modules::run('template/tpl_default', $data);
	}

}

/* End of file Custompage.php */
/* Location: ./application/modules/custompage/controllers/Custompage.php */