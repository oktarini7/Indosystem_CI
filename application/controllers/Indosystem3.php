<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indosystem3 extends CI_Controller {

	private $name;
	private $address;
	private $phone;
	private $note;
    private $loggedin;

	function __construct(){ 
		parent::__construct();
        $this->load->model('model_indosystem3');
        $this->load->model('model_allwishes');
        $this->load->model('model_check_login_status');
    }
    
    public function index(){
    	$this->load->view('templates/template_pageTop');
        
        if ($this->model_check_login_status->check_login()){
            $this->loggedin= 1;
            $data['loggedin']= $this->getLoginStatus();
            $admin= $this->session->userdata('userData');
            $data['hello']= 'Hi '.$admin["first_name"].', you are logged in as admin.<br />';
            $data['loginout'] = 'Click <a href="'.$this->facebook->logout_url().'">here</a> to logout.';
            $this->model_allwishes->setAllWishes();
            $data['allWishes']= $this->model_allwishes->getAllWishes();
        } else {
            $this->loggedin= 0;
            $data['loggedin']= $this->getLoginStatus();
            $data['hello']='';
            $data['loginout'] =  'Click <a href="'.$this->facebook->login_url().'">here</a> to login as admin via facebook</a>';
            $this->model_allwishes->setAllWishes2();
            $data['allWishes']= $this->model_allwishes->getAllWishes();
        }
		$this->load->view('pages/indosystem3', $data);
		$this->load->view('templates/template_pageBottom');
    }

    public function submitNote(){
    	$name= $this->input->post('name');
    	$address= $this->input->post('address');
    	$phone= $this->input->post('phone');
    	$note= $this->input->post('note');
        if(!$this->setName($name)){
            echo "Name must contain only letters and spaces";
            exit();
        }
        if(!$this->setPhone($phone)){
            echo "Phone must contain only numbers";
            exit();
        }
        $this->setAddress($address);
        $this->setNote($note);
        $insertOK= explode('|',$this->model_indosystem3->submitToDatabase($this->getName(), $this->getAddress(), $this->getPhone(), $this->getNote()));
        if($insertOK[0]=="insert_ok"){
    		echo "insert_ok|".$insertOK[1]."|".$insertOK[2]."|".$insertOK[3]."|".$insertOK[4]."|".$insertOK[5];
            exit();
    	} else{
            echo "insert_notok|0";
            exit();
        }
    }

    public function setName($name){
        if(preg_match ("/[^a-zA-Z ]+/", $name)){
            return false;
        } else {
            $this->name= $name;
            return true;
        }
    }

    public function setAddress($address){
        $this->address= $address;
    }

    public function setPhone($phone){
        if(preg_match ("/[^0-9]+/", $phone)){
            return false;
        } else {
            $this->phone= $phone;
            return true;
        }
    }

    public function setNote($note){
        $this->note= $note;
    }

    public function getName(){
        return $this->name;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function getNote(){
        return $this->note;
    }

    public function getLoginStatus(){
        return $this->loggedin;
    }

    public function facebook_login(){
        $userData= array();
        if($this->facebook->is_authenticated()){
            // Get user facebook profile details
            $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email');

            // Preparing data for database insertion
            $userData['oauth_uid'] = $userProfile['id'];
            $userData['first_name'] = $userProfile['first_name'];
            $userData['last_name'] = $userProfile['last_name'];
            $userData['email'] = $userProfile['email'];
            $userData['created'] = date('Y-m-d H:i:s');
            $userData['webtoken'] = $this->generateRandomString();
        }
        //Insert or update user data
        $userID = $this->model_indosystem3->checkUser($userData);

        // Check user data insert or update status
        if(!empty($userID)){
            $this->session->set_userdata('userData',$userData);
            $this->setCookie($userData);
            redirect('indosystem3');
        }

    }

    public function facebook_logout() {

        // Remove user data from session and cookie
        $this->session->unset_userdata('userData');
        delete_cookie('oauth_uid');
        delete_cookie('email');
        delete_cookie('webtoken');
        // Redirect to login page
        redirect('indosystem3');
    }

    public function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public  function setCookie($userData){
        foreach($userData as $key => $value){
            $cookie= array(
                'name'   => $key,
                'value'  => $value,
                'expire' => '3600',
            );
            $this->input->set_cookie($cookie);
        }
    }

    public function deleteNote(){
        $noteid= $this->input->post('noteid');
        if($this->model_indosystem3->deleteNote($noteid)){
            echo "delete_ok";
            exit();
        }
    }

}
?>