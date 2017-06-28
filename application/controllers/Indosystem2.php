<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indosystem2 extends CI_Controller {

	function __construct(){ 
		parent::__construct();
        $this->load->model('model_indosystem2');
    }

    public function index(){
    	$this->load->view('templates/template_pageTop');
    	$data['answer4']= $this->answer4();
    	$data['answer5a']= $this->answer5a();
    	$data['answer5b']= $this->answer5b();
    	$data['answer6']= $this->answer6();
    	$data['answer7a']= $this->answer7a();
    	$data['answer7b']= $this->answer7b();
		$this->load->view('pages/indosystem2', $data);
		$this->load->view('templates/template_pageBottom');
    }

    public function answer4(){
    	return $this->model_indosystem2->answer4();
    }

    public function answer5a(){
    	return $this->model_indosystem2->answer5a();
    }

    public function answer5b(){
    	return $this->model_indosystem2->answer5b();
    }

    public function answer6(){
    	return $this->model_indosystem2->answer6();
    }

    public function answer7a(){
    	return $this->model_indosystem2->answer7a();
    }

    public function answer7b(){
    	return $this->model_indosystem2->answer7b();
    }

}
?>