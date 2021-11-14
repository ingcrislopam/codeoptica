<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Desarrollador_medicos extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        date_default_timezone_set("America/Lima");
    }
    
    public function index(){
        $this->load->view('folder_medicos_desarrollador/cabecera_medicos_desarrollador_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_medicos_desarrollador/medicos_desarrollador');
        $this->load->view('footer_view');
    }
}