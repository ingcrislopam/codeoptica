<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datos_pacientes_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
    }
    
    public function insertarDatosPaciente($data){
        $this->db->insert("datos_pacientes", $data);
        $id = $this->input->post('id_pacientes');
        $data_paciente = array(
            'estadoPaci' => 1
        );
        $this->db->set($data_paciente);
        $this->db->where("id_pacientes", $id);
        $this->db->update("pacientes", $data_paciente);
    }
    
    public function editarDatosPaciente($data, $old_id){
        $this->db->set($data);
        $this->db->where("id_datos_pacientes", $old_id);
        $this->db->update("datos_pacientes", $data);
    }
    
    public function eliminarDatosPaciente($id){
        $this->db->query("update pacientes inner join datos_pacientes on pacientes.id_pacientes=datos_pacientes.id_pacientes set estadoPaci=0 where id_datos_pacientes=".$id);
        $this->db->delete("datos_pacientes", "id_datos_pacientes = ".$id);
    }
    
    public function existeCedula($cedula){
        $this->db->select("cedula");
        $this->db->from('datos_pacientes');
        $this->db->where('cedula', $cedula);
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
        $this->db->from('datos_pacientes');
        $this->db->where('correo', $correo);
        $resultado = $this->db->get();
        if($resultado->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function obtenerPacientes(){
        $query = $this->db->query("select id_pacientes, CONCAT(nombresPaci, ' ', apellidosPaci) as nombresPacien from pacientes where estadoPaci=0 order by nombresPacien asc");
        $data=array();
        foreach ($query->result() as $fila){
            $data[$fila->id_pacientes] = $fila->nombresPacien;
        }
        return ($data);
    }
    
    public function obtenerPacientesID($id){
        $query = $this->db->query("select (pacientes.id_pacientes) as idPaci, CONCAT(nombresPaci, ' ', apellidosPaci) as nombresPacien FROM pacientes inner join datos_pacientes on pacientes.id_pacientes=datos_pacientes.id_pacientes where id_datos_pacientes=".$id);
        $data=array();
        foreach ($query->result() as $fila){
            $data[$fila->idPaci] = $fila->nombresPacien;
        }
        return ($data);
    }
    
    public function numeroDatosPacientes(){
        return $this->db->count_all('datos_pacientes');
    }
    
    public function numeroDatosPacientesBusqueda($busqueda,$parametro)
    {
        $this->db->select("*");
        $this->db->from('datos_pacientes');
        $this->db->where($busqueda, $parametro);
        $resultado = $this->db->get();
        return $resultado->num_rows();
    }
    
    public function mostrarResultados($limit,$start)
    {
        $this->db->limit($limit,$start);
        $this->db->select("id_datos_pacientes, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPaci, cedula, (datos_pacientes.fecha_nacimiento) as fechaPaci, (datos_pacientes.sexo) as sexoPaci, ciudad, direccion, (datos_pacientes.correo) as correoPaci");
        $this->db->from('datos_pacientes');
        $this->db->join('pacientes', 'pacientes.id_pacientes=datos_pacientes.id_pacientes');
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function mostrarResultadosBusqueda($limit,$start,$busqueda,$parametro)
    {
        $this->db->limit($limit,$start);
        $this->db->select("id_datos_pacientes, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPaci, cedula, (datos_pacientes.fecha_nacimiento) as fechaPaci, (datos_pacientes.sexo) as sexoPaci, ciudad, direccion, (datos_pacientes.correo) as correoPaci");
        $this->db->from('datos_pacientes');
        $this->db->join('pacientes', 'pacientes.id_pacientes=datos_pacientes.id_pacientes');
        $this->db->where($busqueda, $parametro);
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarPDF()
    {
        $this->db->select("id_datos_pacientes, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPaci, cedula, (datos_pacientes.fecha_nacimiento) as fechaPaci, (datos_pacientes.sexo) as sexoPaci, ciudad, direccion, (datos_pacientes.correo) as correoPaci");
        $this->db->from('datos_pacientes');
        $this->db->join('pacientes', 'pacientes.id_pacientes=datos_pacientes.id_pacientes');
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarPDF_ID($id)
    {
        $this->db->select("id_datos_pacientes, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPaci, cedula, (datos_pacientes.fecha_nacimiento) as fechaPaci, (datos_pacientes.sexo) as sexoPaci, ciudad, direccion, (datos_pacientes.correo) as correoPaci");
        $this->db->from('datos_pacientes');
        $this->db->join('pacientes', 'pacientes.id_pacientes=datos_pacientes.id_pacientes');
        $this->db->where('id_datos_pacientes', $id);
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarExcel()
    {
        $this->db->select("id_datos_pacientes, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPaci, cedula, (datos_pacientes.fecha_nacimiento) as fechaPaci, (datos_pacientes.sexo) as sexoPaci, ciudad, direccion, (datos_pacientes.correo) as correoPaci");
        $this->db->from('datos_pacientes');
        $this->db->join('pacientes', 'pacientes.id_pacientes=datos_pacientes.id_pacientes');
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarExcel_ID($id)
    {
        $this->db->select("id_datos_pacientes, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPaci, cedula, (datos_pacientes.fecha_nacimiento) as fechaPaci, (datos_pacientes.sexo) as sexoPaci, ciudad, direccion, (datos_pacientes.correo) as correoPaci");
        $this->db->from('datos_pacientes');
        $this->db->join('pacientes', 'pacientes.id_pacientes=datos_pacientes.id_pacientes');
        $this->db->where('id_datos_pacientes', $id);
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarWord()
    {
        $this->db->select("id_datos_pacientes, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPaci, cedula, (datos_pacientes.fecha_nacimiento) as fechaPaci, (datos_pacientes.sexo) as sexoPaci, ciudad, direccion, (datos_pacientes.correo) as correoPaci");
        $this->db->from('datos_pacientes');
        $this->db->join('pacientes', 'pacientes.id_pacientes=datos_pacientes.id_pacientes');
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarWord_ID($id)
    {
        $this->db->select("id_datos_pacientes, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPaci, cedula, (datos_pacientes.fecha_nacimiento) as fechaPaci, (datos_pacientes.sexo) as sexoPaci, ciudad, direccion, (datos_pacientes.correo) as correoPaci");
        $this->db->from('datos_pacientes');
        $this->db->join('pacientes', 'pacientes.id_pacientes=datos_pacientes.id_pacientes');
        $this->db->where('id_datos_pacientes', $id);
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
}