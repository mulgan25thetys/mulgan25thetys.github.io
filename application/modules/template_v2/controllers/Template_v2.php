<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template_v2 extends MX_Controller {

    function __construct()
    {
    	parent::__construct();
    	//Do your magic here
    }
    function tpl_default($data=null)
    {
    	$this->load->view('theme_default/public_html',$data,FALSE);
    }
	function tpl_auth($data=null)
	{
		$this->load->view('theme_auth/public_html',$data,FALSE);
	}
	function tpl_authRegister($data=null)
	{
		$this->load->view('theme_auth/signup_dflt',$data,FALSE);
	}

}

/* End of file Template_v2.php */
/* Location: ./application/modules/template_v2/controllers/Template_v2.php */