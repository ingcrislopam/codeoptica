<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_medicos extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        date_default_timezone_set("America/Lima");
    }
    
    public function index(){
        $this->load->view('folder_medicos_home/cabecera_medicos_home_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_medicos_home/medicos_home');
        $this->load->view('footer_view');
    }
}