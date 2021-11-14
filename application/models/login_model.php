<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function obtenerUsuario($username, $password){
        $this->db->select("username, password");
        $this->db->from('usuarios');
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        $resultado = $this->db->get();
        if($resultado->num_rows() == 1){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    public function obtenerDatosUsuario($username, $password){
        $this->db->select("(usuarios.id_usuarios) as idUsuario, CONCAT(nombres,' ', apellidos) as nombresUsu, agregar, buscar, editar, eliminar, word, excel, pdf");
        $this->db->from('usuarios');
        $this->db->join('permisos', 'permisos.id_usuarios=usuarios.id_usuarios');
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        $query = $this->db->get();
        if($query->num_rows() == 1){
            return $query->result();
        }
        else{
            return FALSE;
        }
    }

    public function verificarTipoUsuario($username, $password){
        $this->db->select("estado");
        $this->db->from('usuarios');
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        $resultado = $this->db->get();
        if($resultado->num_rows() == 1){
            return $resultado->row_array();
        }
        else{
            return NULL;
        } 
    }
    
     public function existeUsernamePassword($username, $password){
        $this->db->select("id_usuarios");
        $this->db->from('usuarios');
        $this->db->where('nombres', $username);
        $this->db->where('password', $password);
        $resultado = $this->db->get();
        if($resultado->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        } 
    }
     
}