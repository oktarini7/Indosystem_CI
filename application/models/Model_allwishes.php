<?php

class Model_allwishes extends CI_Model{

	private $wishes;

	public function __construct(){
		parent::__construct();
	}

	public function index(){
	}

	public function setAllWishes(){
		$wishes= "";
		$this->db->order_by("id", "desc");
		$query = $this->db->get('guests');
		foreach ($query->result_array() as $row){
			$wishes.= '<div class="wishes" id="wish_'.$row['id'].'">';
			$wishes.= '<div id="name_'.$row['id'].'">Name: '.$row['name'].'</div>';
			$wishes.= '<div id="address_'.$row['id'].'">Address: '.$row['address'].'</div>';
			$wishes.= '<div id="phone_'.$row['id'].'">Phone: '.$row['phone'].'</div>';
			$wishes.= '<div id="note_'.$row['id'].'">Note: '.$row['note'].'</div>';
			$wishes.= '<div id="db_'.$row['id'].'"><a href="#" onclick="return false;" onmousedown="deleteNote(\''.$row['id'].'\',\'wish_'.$row['id'].'\');" title="DELETE NOTE">delete note</a></div>';
			$wishes.= '</div>';
		}
		$this->wishes= $wishes;
	}

	public function setAllWishes2(){
		$wishes= "";
		$this->db->order_by("id", "desc");
		$query = $this->db->get('guests');
		foreach ($query->result_array() as $row){
			$wishes.= '<div class="wishes" id="wish_'.$row['id'].'">';
			$wishes.= '<div id="name_'.$row['id'].'">Name: '.$row['name'].'</div>';
			$wishes.= '<div id="note_'.$row['id'].'">Note: '.$row['note'].'</div>';
			$wishes.= '</div>';
		}
		$this->wishes= $wishes;
	}

	public function getAllWishes(){
		return $this->wishes;
	}

}
?>