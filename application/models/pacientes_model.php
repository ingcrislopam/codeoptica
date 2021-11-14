<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pacientes_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function insertarPaciente($data){
        $this->db->insert("pacientes", $data);
    }
    
    public function existeCelularUsu($celular){
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
    
    public function existeCelularPaci($celular){
        $this->db->select("celularPaci");
        $this->db->from('pacientes');
        $this->db->where('celularPaci', $celular);
        $resultado = $this->db->get();
        if($resultado->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function existeConvencionalPaci($convencional){
        $this->db->select("convencionalPaci");
        $this->db->from('pacientes');
        $this->db->where('convencionalPaci', $convencional);
        $resultado = $this->db->get();
        if($resultado->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function editarPaciente($data, $old_id){
        $this->db->set($data);
        $this->db->where("id_pacientes", $old_id);
        $this->db->update("pacientes", $data);
    }
    
    public function eliminarPaciente($id){
        $this->db->delete("pacientes", "id_pacientes = ".$id);
    }
    
    public function obtenerRecepcionistas(){
        $query = $this->db->query("select id_recepcionistas, CONCAT(nombres, ' ', apellidos) as nombresCom from usuarios inner join recepcionistas on usuarios.id_usuarios=recepcionistas.id_usuarios");
        $data=array();
        foreach ($query->result() as $fila){
            $data[$fila->id_recepcionistas] = $fila->nombresCom;
        }
        return ($data);
    }
    
    public function numeroPacientes(){
        return $this->db->count_all('pacientes');
    }
    
    public function numeroPacientesBusqueda($busqueda,$parametro)
    {
        if($parametro==""){
            $parametro="";
        }
        else{
            if($parametro=="Desconocido"){
                $parametro="";
            }
            if($parametro=="Completo"){
                $parametro=1;
            }
            if($parametro=="Incompleto"){
                $parametro=0;
            }
        }
        $this->db->select("*");
        $this->db->from('pacientes');
        $this->db->where($busqueda, $parametro);
        $resultado = $this->db->get();
        return $resultado->num_rows();
    }
    
    public function mostrarResultados($limit,$start)
    {
        $this->db->limit($limit,$start);
        $this->db->select("id_pacientes, CONCAT(usuarios.nombres, ' ', usuarios.apellidos) as nombresRecep, nombresPaci, apellidosPaci, celularPaci, convencionalPaci, estadoPaci");
        $this->db->from('pacientes');
        $this->db->join('recepcionistas', 'recepcionistas.id_recepcionistas=pacientes.id_recepcionistas');
        $this->db->join('usuarios', 'usuarios.id_usuarios=recepcionistas.id_usuarios');
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function mostrarResultadosBusqueda($limit,$start,$busqueda,$parametro)
    {
        if($parametro==""){
            $parametro="";
        }
        else{
            if($parametro=="Desconocido"){
                $parametro="";
            }
            if($parametro=="Completo"){
                $parametro=1;
            }
            if($parametro=="Incompleto"){
                $parametro=0;
            }
        }
        $this->db->limit($limit,$start);
        $this->db->select("id_pacientes, CONCAT(usuarios.nombres, ' ', usuarios.apellidos) as nombresRecep, nombresPaci, apellidosPaci, celularPaci, convencionalPaci, estadoPaci");
        $this->db->from('pacientes');
        $this->db->join('recepcionistas', 'recepcionistas.id_recepcionistas=pacientes.id_recepcionistas');
        $this->db->join('usuarios', 'usuarios.id_usuarios=recepcionistas.id_usuarios');
        $this->db->where($busqueda, $parametro);
        $this->db->order_by($busqueda,"asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarPDF()
    {
        $this->db->select("id_pacientes, CONCAT(usuarios.nombres, ' ', usuarios.apellidos) as nombresRecep, nombresPaci, apellidosPaci, if (celularPaci='','Desconocido',celularPaci) as celular, if (convencionalPaci='','Desconocido',convencionalPaci) as convencional, if (estadoPaci=0,'Incompleto','Completo') as perfil");
        $this->db->from('pacientes');
        $this->db->join('recepcionistas', 'recepcionistas.id_recepcionistas=pacientes.id_recepcionistas');
        $this->db->join('usuarios', 'usuarios.id_usuarios=recepcionistas.id_usuarios');
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarPDF_ID($id)
    {
        $this->db->select("id_pacientes, CONCAT(usuarios.nombres, ' ', usuarios.apellidos) as nombresRecep, nombresPaci, apellidosPaci, if (celularPaci='','Desconocido',celularPaci) as celular, if (convencionalPaci='','Desconocido',convencionalPaci) as convencional, if (estadoPaci=0,'Incompleto','Completo') as perfil");
        $this->db->from('pacientes');
        $this->db->join('recepcionistas', 'recepcionistas.id_recepcionistas=pacientes.id_recepcionistas');
        $this->db->join('usuarios', 'usuarios.id_usuarios=recepcionistas.id_usuarios');
        $this->db->where('id_pacientes', $id);
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarExcel()
    {
        $this->db->select("id_pacientes, CONCAT(usuarios.nombres, ' ', usuarios.apellidos) as nombresRecep, nombresPaci, apellidosPaci, if (celularPaci='','Desconocido',celularPaci), if (convencionalPaci='','Desconocido',convencionalPaci), if (estadoPaci=0,'Incompleto','Completo')");
        $this->db->from('pacientes');
        $this->db->join('recepcionistas', 'recepcionistas.id_recepcionistas=pacientes.id_recepcionistas');
        $this->db->join('usuarios', 'usuarios.id_usuarios=recepcionistas.id_usuarios');
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarExcel_ID($id)
    {
        $this->db->select("id_pacientes, CONCAT(usuarios.nombres, ' ', usuarios.apellidos) as nombresRecep, nombresPaci, apellidosPaci, if (celularPaci='','Desconocido',celularPaci) as celular, if (convencionalPaci='','Desconocido',convencionalPaci) as convencional, if (estadoPaci=0,'Incompleto','Completo') as estado");
        $this->db->from('pacientes');
        $this->db->join('recepcionistas', 'recepcionistas.id_recepcionistas=pacientes.id_recepcionistas');
        $this->db->join('usuarios', 'usuarios.id_usuarios=recepcionistas.id_usuarios');
        $this->db->where('id_pacientes', $id);
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarWord()
    {
        $this->db->select("id_pacientes, CONCAT(usuarios.nombres, ' ', usuarios.apellidos) as nombresRecep, nombresPaci, apellidosPaci, if (celularPaci='','Desconocido',celularPaci) as celular, if (convencionalPaci='','Desconocido',convencionalPaci) as convencional, if (estadoPaci=0,'Incompleto','Completo') as perfil");
        $this->db->from('pacientes');
        $this->db->join('recepcionistas', 'recepcionistas.id_recepcionistas=pacientes.id_recepcionistas');
        $this->db->join('usuarios', 'usuarios.id_usuarios=recepcionistas.id_usuarios');
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarWord_ID($id)
    {
        $this->db->select("id_pacientes, CONCAT(usuarios.nombres, ' ', usuarios.apellidos) as nombresRecep, nombresPaci, apellidosPaci, if (celularPaci='','Desconocido',celularPaci) as celular, if (convencionalPaci='','Desconocido',convencionalPaci) as convencional, if (estadoPaci=0,'Incompleto','Completo') as perfil");
        $this->db->from('pacientes');
        $this->db->join('recepcionistas', 'recepcionistas.id_recepcionistas=pacientes.id_recepcionistas');
        $this->db->join('usuarios', 'usuarios.id_usuarios=recepcionistas.id_usuarios');
        $this->db->where('id_pacientes', $id);
        $this->db->order_by("nombresPaci","asc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
}