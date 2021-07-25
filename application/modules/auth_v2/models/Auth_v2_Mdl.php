<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_v2_Mdl extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	//get function
	function getTable($table)
	{
		if($this->db->table_exists($table))
		{
			return $table;
		}
		else{
			$this->session->set_flashdata('error','Table '.$table.' does not exists!');
			return false;
		}
	}
	function getUser($username='',$email='')
    {
    	$query=$this->db
    				->where('pseudo',$username)
    				->or_where('email',$email)
    				->get($this->getTable('user'));
    	return $query;
    }
    function active_account($email){
    	
    	$data =array('status'=> 1,'updated_at'=> date("Y-m-d H:i:s"));
    	$this->db->where('email',$email)->update($this->getTable('user'),$data);
    }

    //insert function
    function insert_user($data=''){
        
    	return $this->db->insert($this->getTable('user'),$data);

    }
    function insert_login_attempt($data){
    	$this->db->insert($this->getTable('login_Attempt'),$data);
    }
    function insert_otp($data=''){
    	return $this->db->insert($this->getTable('otp'),$data);
    }
    function insert_into_passwordReset($iduser,$token){
        $data = array(
                'user_id' => $iduser,
                'token' => $token
        );
        $this->db->insert($this->getTable('password_Reset'),$data);
    }

    // delete function
    function delete_login_attempt($ip){
    	$this->db->where('ip_attempt',$ip)->delete($this->getTable('login_Attempt'));
    }

    // Update function
    function update_otp($data,$code){

    	$this->db->where('code',$code)->update($this->getTable('otp'),$data);
    }
    function update_password($email='',$data){
    	if($this->db->where('email',$email)->update($this->getTable('user'),$data)){
    		return true;
    	}
    	return false;
    }

    //getter
    function get_user_ipadresse($email){
        $query = $this->db->where('email',$email)->get($this->getTable('user'));
        if($query->num_rows() === 1)
            {
                foreach ($query->result_array() as $value) {
                    // code...
                    return $value['last_ip'];
                }
            }
        return false;
    }

    // verify function
    function verify_active_account($email){
        $query = $this->db->where('email',$email)->get($this->getTable('user'));
        if($query->num_rows() === 1)
        {
            foreach ($query->result_array() as $value) {
                    if ($value['status'] != 1) {
                        return true;
                    }
            }
        }
        return false;
    }
    function verify_user_email($email)
    {
    	$query= $this->db->where('email',$email)->get($this->getTable('user'));
    	if ($query->num_rows() === 1) {
    		return true;
    	}
    	return false;
    }
    function verify_login_attempt($time,$ip){
    	$array = array(
                'time >'=> $time,
                'ip_attempt '=> $ip
    	);
        $query= $this->db->where($array)->get($this->getTable('login_Attempt'));
    	return $query->num_rows();
    	
    }
    function verify_otp($code){
    	$query = $this->db->where('code',$code)->where('is_expired',0)->get($this->getTable('otp'));
    	if ($query->num_rows() === 1) {
            $diff = time() - $query->result()[0]->time;
            if($diff < 120){
    		    return true;
            }else{
                $data_otp = array(
                              'is_expired' => 1
                );
                $this->update_otp($data_otp,$code);
            }
    	}
    	return false;
    }
   
}

/* End of file Aurh_v2_Mdl.php */
/* Location: ./application/modules/auth_v2/models/Aurh_v2_Mdl.php */