<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recepcionistas_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
    }
    
    public function insertarRecepcionista($data){
        $this->db->insert("usuarios", $data);
        $data_recepcionista = array(
            'id_usuarios' => $this->db->insert_id()
        );
        $data_permisos = array(
            'id_usuarios' => $this->db->insert_id(),
            'agregar' => $this->input->post('agregar'),
            'buscar' => $this->input->post('buscar'),
            'editar' => $this->input->post('editar'),
            'eliminar' => $this->input->post('eliminar'),
            'word' => $this->input->post('word'),
            'excel' => $this->input->post('excel'),
            'pdf' => $this->input->post('pdf')
        );
        $this->db->insert("recepcionistas", $data_recepcionista);
        $this->db->insert("permisos", $data_permisos);
    }
    
    public function existeRecepcionista($nombres, $apellidos, $username){
        $this->db->select("id_usuarios");
        $this->db->from('usuarios');
        $this->db->where('nombres', $nombres, 'apellidos', $apellidos);
        $this->db->or_where('username', $username);
        $resultado = $this->db->get();
        return $resultado->num_rows();   
    }
    
    public function existeUsername($username){
        $this->db->select("username");
        $this->db->from('usuarios');
        $this->db->where('username', $username);
        $resultado = $this->db->get();
        if($resultado->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function existeCelular($celular){
        $this->db->select("celular");
        $this->db->from('usuarios');
        $this->db->where('celular', $celular);
        $resultado = $this->db->get();
        if($resultado->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function existeCorreo($correo){
        $this->db->select("correo");
        $this->db->from('usuarios');
        $this->db->where('correo', $correo);
        $resultado = $this->db->get();
        if($resultado->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function editarRecepcionista($data, $old_id){
        $this->db->set($data);
        $this->db->where("id_usuarios", $old_id);
        $this->db->update("usuarios", $data);
        $data_per = array(
            'id_usuarios' => $this->input->post('id_usuarios'),
            'agregar' => $this->input->post('agregar'),
            'buscar' => $this->input->post('buscar'),
            'editar' => $this->input->post('editar'),
            'eliminar' => $this->input->post('eliminar'),
            'word' => $this->input->post('word'),
            'excel' => $this->input->post('excel'),
            'pdf' => $this->input->post('pdf')
        );
        $this->db->set($data_per);
        $this->db->where("id_usuarios", $old_id);
        $this->db->update("permisos", $data_per);
    }
    
    public function editarRecepcionistaPermisos($data_per, $old_id){
        $this->db->set($data_per);
        $this->db->where("id_usuarios", $old_id);
        $this->db->update("permisos", $data_per);
    }
    
    public function eliminarRecepcionista($id){
        $this->db->delete("recepcionistas", "id_usuarios = ".$id);
        $this->db->delete("permisos", "id_usuarios = ".$id);
        $this->db->delete("usuarios", "id_usuarios = ".$id);
    }
    
    public function numeroRecepcionistas()
    {
        $estado = 3;
        $this->db->where('estado', $estado);
        return $this->db->count_all('usuarios');
    }
    
    public function numeroRecepcionistasBusqueda($busqueda,$parametro)
    {
        $estado = 3;
        $this->db->select("*");
        $this->db->from('usuarios');
        $this->db->where('estado', $estado);
        $this->db->where($busqueda, $parametro);
        $resultado = $this->db->get();
        return $resultado->num_rows();
    }
    
    public function mostrarResultados($limit,$start)
    {
        $estado = 3;
        $this->db->limit($limit,$start);
        $this->db->select("(usuarios.id_usuarios) as id_usua, nombres, apellidos, username, fecha_nacimiento, sexo, celular, correo, agregar, buscar, editar, eliminar, word, excel, pdf");
        $this->db->from('usuarios');
        $this->db->join('permisos', 'permisos.id_usuarios=usuarios.id_usuarios');
        $this->db->where('estado', $estado);
        $this->db->order_by("nombres","asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function mostrarResultadosBusqueda($limit,$start,$busqueda,$parametro)
    {
        $estado = 3;
        $this->db->limit($limit,$start);
        $this->db->select("(usuarios.id_usuarios) as id_usua, nombres, apellidos, username, fecha_nacimiento, sexo, celular, correo, agregar, buscar, editar, eliminar, word, excel, pdf");
        $this->db->from('usuarios');
        $this->db->join('permisos', 'permisos.id_usuarios=usuarios.id_usuarios');
        $this->db->where('estado', $estado);
        $this->db->where($busqueda, $parametro);
        $this->db->order_by($busqueda,"asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarPDF()
    {
        $estado = 3;
        $this->db->select("id_usuarios, nombres, apellidos, username, fecha_nacimiento, sexo, celular, correo");
        $this->db->from('usuarios');
        $this->db->where('estado', $estado);
        $this->db->order_by("nombres","asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarPDF_ID($id)
    {
        $estado = 3;
        $this->db->select("id_usuarios, nombres, apellidos, username, fecha_nacimiento, sexo, celular, correo");
        $this->db->from('usuarios');
        $this->db->where('estado', $estado);
        $this->db->where('id_usuarios', $id);
        $this->db->order_by("nombres","asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarWord()
    {
        $estado = 3;
        $this->db->select("id_usuarios, nombres, apellidos, username, fecha_nacimiento, sexo, celular, correo");
        $this->db->from('usuarios');
        $this->db->where('estado', $estado);
        $this->db->order_by("nombres","asc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarWord_ID($id)
    {
        $estado = 3;
        $this->db->select("id_usuarios, nombres, apellidos, username, fecha_nacimiento, sexo, celular, correo");
        $this->db->from('usuarios');
        $this->db->where('estado', $estado);
        $this->db->where('id_usuarios', $id);
        $this->db->order_by("nombres","asc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarExcel()
    {
        $estado = 3;
        $this->db->select("id_usuarios, nombres, apellidos, username, fecha_nacimiento, sexo, celular, correo");
        $this->db->from('usuarios');
        $this->db->where('estado', $estado);
        $this->db->order_by("nombres","asc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarExcel_ID($id)
    {
        $estado = 3;
        $this->db->select("id_usuarios, nombres, apellidos, username, fecha_nacimiento, sexo, celular, correo");
        $this->db->from('usuarios');
        $this->db->where('estado', $estado);
        $this->db->where('id_usuarios', $id);
        $this->db->order_by("nombres","asc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
}