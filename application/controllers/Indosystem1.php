<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indosystem1 extends CI_Controller {

	function __construct(){ 
		parent::__construct();
    }

    private $c1input;
    private $result;

    public function index(){
    	$this->load->view('templates/template_pageTop');
		$this->load->view('pages/indosystem1');
		$this->load->view('templates/template_pageBottom');
	}

	public function processc1(){
		$this->load->model('model_indosystem1');
		$this->c1input= $this->input->post('c1input');

		if($this->model_indosystem1->checkInput($this->c1input)){
			$this->result= $this->model_indosystem1->getResult($this->c1input);
			echo $this->result;
		} else {
			echo "Input value must be 1&le;input value&le;25";
		}
	
	}
}
?>