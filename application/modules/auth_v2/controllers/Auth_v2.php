<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_v2 extends MX_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Auth_v2_Mdl');
		$this->load->module('template_v2');
	}

	 function index()
	{
		$this->login();
	}
	function load_auth_page($title,$subtitle='',$next_form='',$forgot_password,$module,$view_file,$page,$userdata=''){

		$data['table'] 	   = $this->Auth_v2_Mdl->getTable('user');
		$data['title'] 	   = $title;
		$data['subtitle']  = $subtitle;
		$data['next_form']     = $next_form;
		$data['forgot_password'] = $forgot_password;
		$data['module']    =  $module;
		$data['view_file'] = $view_file;
		$data['user_data'] = $userdata;
		
        echo $this->template_v2->$page($data);
	}
    function getUseriIp(){
    	return $this->input->ip_address();
	}
	 function login()
	{
		if ($this->session->userdata('locked')) {
			$diff = time() - $this->session->userdata('locked');
			if ($diff > 30) {
				$this->session->unset_userdata('login_attempted');
				$this->session->unset_userdata('locked');
			}
		}
		$this->load_auth_page('Login','Please Enter Your Information','register',true,'auth_v2','login','tpl_auth');
	}
	function validation(){ 
		$this->load_auth_page('Valid Account','Validation','login',false,'auth_v2','otp','tpl_auth');	
	}
	function register()
	{
		$this->load_auth_page('Register','New User Registration','login',false,'auth_v2','register','tpl_auth');
	}
	function reset_password(){
        $this->load_auth_page('Reset password','Retrieve Password','login',false,'auth_v2','reset_password','tpl_auth');
	}
	function reset_password_update(){
        $this->load_auth_page('Reset password','Update Password','login',false,'auth_v2','changepassword_form','tpl_auth');
	}
	function account()
	{
		$userdta=$this->Auth_v2_Mdl->getUser($this->session->userdata('username'))->result();
		$this->load_auth_page('My account','My account','',false,'auth_v2','account','tpl_default',$userdta);
	}
	function home()
	{
		$this->load_auth_page('AUXICALL : CRM','','',false,'auth_v2','home','tpl_default');
	}

    function submit_login($value='')
    {
    	$post = $this->input->post();
    	$attemps = 0;
    	if (isset($post['login'])) {			
			$this->session->unset_userdata('reset_password_email');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username','Username','required');
            $this->form_validation->set_rules('password','Password','required');
			if ($this->form_validation->run()) {
				$this->connexion($post['username'],$post['password']);
			}else{
				$this->login();
			}
		}else{
			$this->login();
		}
    }
    function connexion($username,$pwd){
		$query = $this->Auth_v2_Mdl->getUser($username);
		$count_attempt = $this->Auth_v2_Mdl->verify_login_attempt(time() -10,$this->getUseriIp());
		if ($count_attempt == 2) {
			$this->session->set_userdata(array('login_attempted' => 'Please wait 30 seconds to try again!'));
			redirect(base_url().'auth_v2/login','refresh');
		}else{
			if($query->num_rows() > 0){
		   		$pwdUser= $query->result()[0]->password;        
				if(password_verify($pwd, $pwdUser))
				{
					$this->session->unset_userdata('login_attempted');
					$this->login_success($query,$username,$pwd,false);
			   	}
				else{
					$this->login_is_attempted();
					$this->session->set_flashdata('error', 'Mot de passe invalid!');
					redirect(base_url().'auth_v2/login','refresh');
				}
			}
			else{
				$this->login_is_attempted();
				$this->session->set_flashdata('error', 'Pseudo invalid!');
				redirect(base_url().'auth_v2/login','refresh');
			}
   		}
    }
    function login_success($query,$username,$password,$remember=false){
		$this->Auth_v2_Mdl->delete_login_attempt($this->getUseriIp());
		$emailuser= $query->result()[0]->email;
		$session_data = array('username' => $username);
		$this->session->set_userdata($session_data);
		
		if(isset($remember) && $remember == true)
		{
			setcookie('username',$username,time()+(86400*30),"/");
			setcookie('password',$password,time()+(86400*30),"/");
		} 		
		$time_to_login= time() - $this->session->userdata('time_to_login');
		if ($this->session->userdata('last_user') == $username && $time_to_login < 300) {
			redirect(base_url().'auth_v2/home','refresh');
		}
	    $this->initialize_otp($emailuser,'','','login','emaillogin',$emailuser);
    }
    function submit_register($value=''){
    	$post = $this->input->post();
      	if(isset($post['register']))
	 	{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[user.email]');
			$this->form_validation->set_rules('username','Username','required|is_unique[user.pseudo]');
			$this->form_validation->set_rules('lastname','Lastname','required');
			$this->form_validation->set_rules('firstname','Firstname','required');
			$this->form_validation->set_rules('activityDomain','Activity Domain','required');
			$this->form_validation->set_rules('mobilePhone','Mobile Phone','required|min_length[8]');
			$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_rules('repeatPassword','RepeatPassword','required|matches[password]');
			if ($this->form_validation->run()) {
                $this->save_user($post['fonction'],$post['email'],$post['username'],$post['lastname'],$post['firstname'],$post['activityDomain'],$post['mobilePhone'],$post['password']);
            } 
			else {
				$this->register();
			}			
		}
		else{
			$this->login();
		}
    }
    function save_user($fonction,$email,$username,$lastname,$firstname,$activityDomain,$mobilePhone,$password){
    	$token = random_string('alnum', 20);
		$data = array(
			    'fonction' => $fonction,
                'email' => $email,
                'pseudo' => $username,
                'nom' => $lastname,
                'prenom' => $firstname,
                'domaine_activite' => $activityDomain,
                'tel_mobile' => $mobilePhone,
                'password' => password_hash($password,PASSWORD_BCRYPT),
                'last_ip'  => $this->getUseriIp(),
                'token' => $token
                 );
        if ($this->Auth_v2_Mdl->insert_user($data)) {
        	$session_data = array('username' => $username,'email'=> $email);
	   		$this->session->set_userdata($session_data);
	   		$query = $this->Auth_v2_Mdl->getUser($username);
	   		$id=$query->result()[0]->id;
       		$this->initialize_otp($email,$token,$id,'register','emailregister',$email);
		}
		else{
			$this->session->set_flashdata('error', 'Veuillez verifier vos données!');
			$this->register();
		}
    }
    function submit_update_password($value=''){
    	$post = $this->input->post();
    	if(isset($post['resetpwd_update'])){
    		$this->load->library('form_validation');
    		$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_rules('repeatPassword','RepeatPassword','required|matches[password]');
            if ($this->form_validation->run()) {
            	$this->changed_password($post['password']);
            }
            else{
            	$this->reset_password_update();
            }
		}
		else{
			$this->login();
		}
    }
    function changed_password($password){
    	$data = array(
            'password' => password_hash($password,PASSWORD_BCRYPT),
            'status'=> 1,
            'updated_at'=> date("Y-m-d H:i:s")
    	);
    	$email = $this->session->userdata('reset_password_email');
    	$result=$this->Auth_v2_Mdl->update_password($email,$data);
    	$iduser = $this->Auth_v2_Mdl->getUser('',$email)->result()[0]->id;
    	if($result){
    	   $this->Auth_v2_Mdl->insert_into_passwordReset($iduser,random_string('alnum', 20));
           $this->session->set_flashdata('update_password', 'Your password has been updated!');

           redirect(base_url().'auth_v2/login','refresh');
    	}else{
    		$this->session->set_flashdata('update_error', 'You have encountered an error!');
           redirect(base_url().'auth_v2/reset_password_update','refresh');
    	}
    }
	function submit_resetpwd($value='')
	{   
		$post = $this->input->post();
	   	if(isset($post['resetpwd'])) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email','Email','required|valid_email');
			if($this->form_validation->run())
			{
                 $email = $post['email'];
                 if($this->Auth_v2_Mdl->verify_user_email($email))
                 {
                 	$this->initialize_otp($email,'','','reset_password','reset_password_email',$email);
                 }
                 else{
                 	$this->session->set_flashdata('email_sent', 'Email invalide!');
				    redirect(base_url().'auth_v2/reset_password','refresh');
                }       
			}else{
				$this->reset_password();
			}
		}
		else{
			$this->login();
		}
	}
	function initialize_otp($emailuser='',$token='',$userid='',$page_back,$flash_data='',$flash_value=''){
		$otp = rand(100000,999999);           
        $sendmail = $this->send_email($emailuser,$otp,$token,$userid);
   		 	if($sendmail->send())
            {
            	$this->session->set_flashdata("email_sent","Congragulation Email Send Successfully.");
            	$data_otp = array('code' => $otp,'time' => time());	
            	if($this->Auth_v2_Mdl->insert_otp($data_otp))
            	{
            		$session_data = array($flash_data => $flash_value);
			   		$this->session->set_userdata($session_data);
					redirect(base_url().'auth_v2/validation');
            	}
            	else{
                    $this->$page_back();
            	}    	
            }
       		 else
            {
            	$this->session->set_flashdata("email_sent","You have encountered an error");
                $this->$page_back();
            }
	}
	function submit_validate($value=''){
		$post = $this->input->post();
    	 if(isset($post['validate']))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('code_otp','Code','required');
			if($this->form_validation->run())
			{
				$code = $post['code_otp'];
				$data_otp = array('is_expired' => 1);
				if($this->Auth_v2_Mdl->verify_otp($code))
				{
					$this->is_logged($data_otp,$code);
				}
                else{
                	$this->session->set_flashdata('error', 'Code invalid!');
				    redirect(base_url().'auth_v2/validation','refresh');
                }		
			}
			else{
               $this->validation();
			}
		}
		elseif (isset($post['resend'])) {
			$this->resend_otp_code();
		}
		else{
			$this->login();
		}
    }
    function is_logged($data,$code){
    	$this->Auth_v2_Mdl->update_otp($data,$code);
		if($this->session->userdata('emailregister')){
			$this->Auth_v2_Mdl->active_account($this->session->userdata('emailregister'));
		}
		if($this->session->userdata('reset_password_email')){
			redirect(base_url().'auth_v2/reset_password_update');
		}
		if ($this->session->userdata('emaillogin')) {
			if ($this->Auth_v2_Mdl->verify_active_account($this->session->userdata('emaillogin'))) {
				$this->Auth_v2_Mdl->active_account($this->session->userdata('emaillogin'));
			}
		}
		redirect(base_url().'auth_v2/home','refresh');
    }
    function login_is_attempted(){
    	$data = array(
            'time' => time(),
            'ip_attempt' => $this->getUseriIp()
    	);
    	$this->Auth_v2_Mdl->insert_login_attempt($data);
    }
    function update_user_info(){
    	$post = $this->input->post();
    	$config['upload_path']          = './modules/uploads/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($post['image-profile']))
        {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            $this->account();
        }
        else
        {
            $this->session->set_flashdata('upload_data', $this->upload->data());
            $this->home();
        }
    }
	function switch_email($otp){	
 		$sending = '';
		if($this->session->userdata('emaillogin')){
			$sending = $this->send_email($this->session->userdata('emaillogin'),$otp);
		}
		if($this->session->userdata('emailregister')){
			$sending=$this->send_email($this->session->userdata('emailregister'),$otp);
		}
		if($this->session->userdata('reset_password_email')){
            $sending=$this->send_email($this->session->userdata('reset_password_email'),$otp);
		}
		return $sending;
    }
	function resend_otp_code(){
		$otp = rand(100000,999999);
		if ($this->switch_email($otp)->send()) {
			$data_otp = array('code' => $otp,'time' => time());
        	if($this->Auth_v2_Mdl->insert_otp($data_otp))
            {
				$this->session->set_flashdata('email_sent', 'Un nouveau code vous a été envoyé!');
				redirect(base_url().'auth_v2/validation','refresh');
			}
			else {
				$this->session->set_flashdata('error', 'Veuillez Patienter une erreur est survenue!');
				redirect(base_url().'auth_v2/validation','refresh');
			}
		} else {
			$this->session->set_flashdata('email_sent', 'Veuillez ressayer!');
			redirect(base_url().'auth_v2/validation','refresh');
		}
	}
    function send_email($email,$otp,$token='',$user_id='')
    {
    	$from_email = "thetysmulgan25@gmail.com";
        $to_email = $email;
        $this->load->library('email');
        $this->email->from($from_email, 'AUXICALL');
        $this->email->to($to_email);
        $this->email->subject('Validation');
        if ($token!= '') {
        	$message = "Here the Otp code to validate your account ".$otp." </br> <a href=".base_url()."auth_v2/validation?id=".$user_id."&token=".$token.">Validate</a>";
        }else{
        $message = "Here the Otp code to validate your account ".$otp." </br> <a href=".base_url()."auth_v2/validation>Validate</a>";
    	}
        $this->email->message($message);
        $this->email->set_mailtype("html");
        return $this->email;
    }
    function logout(){
    	$session_data = array(
			'time_to_login' => time(),
			'last_user' => $this->session->userdata('username')
		);
    	$this->session->unset_userdata('username');
		$this->session->unset_userdata('emaillogin');
		$this->session->unset_userdata('emailregister');
		$this->session->unset_userdata('reset_password_email');
		setcookie('username','',0,"/");
		setcookie('password','',0,"/");
		$this->session->set_userdata( $session_data );
		redirect(base_url().'auth_v2/login');
	}
}
/* End of file Auth_v2.php */
/* Location: ./application/modules/auth_v2/controllers/Auth_v2.php */