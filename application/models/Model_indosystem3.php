<?php

class Model_indosystem3 extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function index(){

	}
	public function submitToDatabase($name, $address, $phone, $note){
		$data=[
			'name' => $name,
			'address' => $address,
			'phone' => $phone,
			'note' => $note
		];
		if($this->db->insert('guests', $data)){
			return "insert_ok|".$this->db->insert_id()."|".$name."|".$address."|".$phone."|".$note;
		} else {
			return "insert_notok|0";
		}
	}

	public function deleteNote($noteid){
		$this->db->where('id', $noteid);
		if($this->db->delete('guests')){
			return true;
		} else {
			return false;
		}
	}

	public function checkUser($userData= array()){
		$requirements = [
			'oauth_uid' => $userData['oauth_uid'],
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
            'email' => $userData['email']
		];
    	$query = $this->db->get_where('admin', $requirements, '1');
       	$numrow= $query->num_rows();
       	if ($numrow > 0){
       		$result= $query->row_array();
       		$userID = $result['id'];

       		$data = array(
				'webtoken' => $userData['webtoken']
			);
			$this->db->where('id', $userID);
			$this->db->update('admin', $data);
       		return $userID;
       	}else{
            if($this->db->insert('admin', $userData)){
				return $this->db->insert_id();
			} else {
				return false;
			}
        }
   	}

}
?>