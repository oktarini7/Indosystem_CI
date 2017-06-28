<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndosystemMain extends CI_Controller {

	function __construct(){ 
		parent::__construct();
    }

	public function index()
	{
		$this->load->view('templates/template_pageTop');
		$this->load->view('templates/template_pageBottom');
  	}
}
?>