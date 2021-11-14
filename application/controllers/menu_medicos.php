<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_medicos extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
    }
    
    public function index(){
        $this->load->view('cabecera_medicos_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('footer_view');
    }
    
}