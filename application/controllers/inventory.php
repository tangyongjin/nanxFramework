<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class inventory extends CI_Controller {

	public function index()
	{ 
                $this->load->model('minventory');
                $this->minventory->calc_inventory();
	}
} 

