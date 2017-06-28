<?php
// Initialize some vars
class Model_check_login_status extends CI_Model{

	private $user_ok = false;
	private $oauth_uid = "";
	private $email = "";
	private $webtoken = "";

	public function __construct(){
		parent::__construct();
	}

	public function evalLoggedUser($oauth_uid,$email,$webtoken){
       	$requirements = [
			'oauth_uid' => $oauth_uid,
            'email' => $email
		];
    	$query = $this->db->get_where('admin', $requirements, '1');
    	$result= $query->row_array();
      	
		if(!$result){
			return false;
		} else {
			return true;
		}
	}

	public function check_login(){
		if(isset($_SESSION["userData"])) {
			$session_var= $this->session->userdata('userData');
			$this->oauth_uid = $session_var['oauth_uid'];
			$this->email = $session_var['email'];
			$this->webtoken = $session_var['webtoken'];
			//$this->user_ok = $this->evalLoggedUser($this->oauth_uid,$this->email,$this->webtoken);
			return $this->evalLoggedUser($this->oauth_uid,$this->email,$this->webtoken);
		} else if(isset($_COOKIE["oauth_uid"]) && isset($_COOKIE["email"]) && isset($_COOKIE["webtoken"])){
			$userData= array();
			$userData['oauth_uid'] =  $this->input->cookie('oauth_uid');
            $userData['first_name'] = $this->input->cookie('first_name');
            $userData['last_name'] = $this->input->cookie('last_name');
            $userData['email'] = $this->input->cookie('email');
            $userData['webtoken'] = $this->input->cookie('webtoken');
			$this->session->set_userdata('userData', $userData);

			$session_var= $this->session->userdata('userData');
			$this->oauth_uid = $session_var('oauth_uid');
			$this->email = $session_var('email');
			$this->webtoken = $session_var('webtoken');
			// Verify the user
			$this->user_ok = $this->evalLoggedUser($this->oauth_uid,$this->email,$this->webtoken);
		}
		return $this->user_ok;
	}
	public function get_oauth_uid(){
		return $this->oauth_uid;
	}
	public function get_email(){
		return $this->email;
	}
	public function get_webtoken(){
		return $this->webtoken;
	}
}
?>