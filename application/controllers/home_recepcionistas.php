<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_recepcionistas extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }
    
    public function index(){
        $this->load->view('folder_recepcionistas_home/cabecera_recepcionistas_home_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_recepcionistas_home/recepcionistas_home');
        $this->load->view('footer_view');
    }
}