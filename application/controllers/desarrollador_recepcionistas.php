<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Desarrollador_recepcionistas extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        date_default_timezone_set("America/Lima");
    }
    
    public function index(){
        $this->load->view('folder_recepcionistas_desarrollador/cabecera_recepcionistas_desarrollador_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_recepcionistas_desarrollador/recepcionistas_desarrollador');
        $this->load->view('footer_view');
    }
}