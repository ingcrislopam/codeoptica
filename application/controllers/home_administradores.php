<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_administradores extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        date_default_timezone_set("America/Lima");
    }
    
    public function index(){
        $this->load->view('folder_administradores_home/cabecera_administradores_home_view');
        $this->load->view('menu_administradores_view');
        $this->load->view('folder_administradores_home/administradores_home');
        $this->load->view('footer_view');
    }
}