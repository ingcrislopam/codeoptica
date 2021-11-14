<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Desarrollador_administradores extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        date_default_timezone_set("America/Lima");
    }
    
    public function index(){
        $this->load->view('folder_administradores_desarrollador/cabecera_administradores_desarrollador_view');
        $this->load->view('menu_administradores_view');
        $this->load->view('folder_administradores_desarrollador/administradores_desarrollador');
        $this->load->view('footer_view');
    }
}