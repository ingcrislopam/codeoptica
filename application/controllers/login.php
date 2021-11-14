<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->database();
    }
    
    public function index(){
        $this->load->view('Login_view');
    }
    
    public function iniciar(){
        $this->load->model('Login_model');
        $this->reglas_validacion();
        if($this->form_validation->run()==FALSE){
            $this->index();
        }
        else{
            $username = $this->input->post('username');
        $password = $this->input->post('password');
        $cantidad = $this->Login_model->obtenerUsuario($username, $password);
        if($cantidad == TRUE){
        $result= $this->Login_model->obtenerDatosUsuario($username, $password);
        $sess_array = array();
        foreach ($result as $row){
            $sess_array = array(
                'idUsuario' => $row->idUsuario,
                'nombresUsu' => $row->nombresUsu,
                'agregar' => $row->agregar,
                'buscar' => $row->buscar,
                'editar' => $row->editar,
                'eliminar' => $row->eliminar,
                'word' => $row->word,
                'excel' => $row->excel,
                'pdf' => $row->pdf
            );
        }
        $this->session->set_userdata('logged_in',$sess_array);
        $veri =  $this->Login_model->verificarTipoUsuario($username, $password);
            if($veri['estado'] == 1){
                
                redirect('index.php/home_administradores/index');
            }
            if($veri['estado'] == 2){
                
                redirect('index.php/home_medicos/index');
            }
            if($veri['estado'] == 3){
                
                redirect('index.php/home_recepcionistas/index');
            }
        }
        else{
            $this->load->view('Login_view');
        }
        }
    }
    
    public function validar_username_password(){
        $this->load->model('Login_model');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if($this->Login_model->existeUsernamePassword($username, $password)){
            $this->form_validation->set_message('validar_username_password', 'El usuario o contraseña son incorrectos');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function reglas_validacion(){
        $config = array(
            array(
                'field'=>'username',
                'label'=>'username',
                'rules'=>'required'
            ),
            array(
                'field'=>'password',
                'label'=>'password',
                'rules'=>'required'
            ),
            array(
                'field'=>'validar',
                'label'=>'validar',
                'rules'=>'callback_validar_username_password'
            )
        );
        $this->form_validation->set_rules($config);
    }
    
    public function logout(){
        $sess_array = array(
            'idUsuario' => '',
            'nombresUsu' => '',
            'agregar' => '',
            'editar' => '',
            'eliminar' => '',
            'excel' => '',
            'word' => '',
            'pdf' => ''
        );
        $this->session->unset_userdata('logged_in', $sess_array);
        $this->session->sess_destroy();
        $this->removerCache();
        redirect('index.php/login/index');
    }
    
    public function removerCache(){
        $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
	$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
	$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
	$this->output->set_header('Pragma: no-cache');
    }
    
}