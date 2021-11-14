<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Histo_ocupacional_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function insertarHistoOcupacional($data,$id){
        $this->db->insert("historias_clinicas", $data);
        $data_ocupacional = array(
            'id_histo_clinicas' => $this->db->insert_id(),
            'lentes' => $this->input->post('lentes'),
            'agudeza_vision_lejana_od' => $this->input->post('agudeza_vision_lejana_od'),
            'agudeza_vision_lejana_oi' => $this->input->post('agudeza_vision_lejana_oi') ,
            'agudeza_vision_cercana_od' => $this->input->post('agudeza_vision_cercana_od'),
            'agudeza_vision_cercana_oi' => $this->input->post('agudeza_vision_cercana_oi'),
            'agudeza_perimetria_od' => $this->input->post('agudeza_perimetria_od'),
            'agudeza_perimetria_oi' => $this->input->post('agudeza_perimetria_oi'),
            'agudeza_tonometria_od' => $this->input->post('agudeza_tonometria_od'),
            'agudeza_tonometria_oi' => $this->input->post('agudeza_tonometria_oi'),
            'agudeza_fondo_ojo_od' => $this->input->post('agudeza_fondo_ojo_od'),
            'agudeza_fondo_ojo_oi' => $this->input->post('agudeza_fondo_ojo_oi'),
            'agudeza_examen_externo_od' => $this->input->post('agudeza_examen_externo_od'),
            'agudeza_examen_externo_oi' => $this->input->post('agudeza_examen_externo_oi'),
            'forias_vision_lejana' => $this->input->post('forias_vision_lejana'),
            'forias_vision_proxima' => $this->input->post('forias_vision_proxima'),
            'forias_test_color' => $this->input->post('forias_test_color'),
            'forias_test_esteriopsis' => $this->input->post('forias_test_esteriopsis'),
            'forias_diagnostico' => $this->input->post('forias_diagnostico')
        );
        $this->db->insert("ocupacional", $data_ocupacional);
        $this->db->query("update reservaciones set estadoReser=1 where id_reservaciones=".$id);
    }
    
    public function existeFecha($id_pacientes, $fecha){
        $this->db->select("id_historias_clinicas");
        $this->db->from('historias_clinicas');
        $this->db->where('id_pacientes', $id_pacientes);
        $this->db->where('fecha', $fecha);
        $resultado = $this->db->get();
        if($resultado->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function editarHistoOcupacional($data, $old_id){
        $this->db->set($data);
        $this->db->where("id_historias_clinicas", $old_id);
        $this->db->update("historias_clinicas", $data);
        $dataO = array(
            'lentes' => $this->input->post('lentes'),
            'agudeza_vision_lejana_od' => $this->input->post('agudeza_vision_lejana_od'),
            'agudeza_vision_lejana_oi' => $this->input->post('agudeza_vision_lejana_oi') ,
            'agudeza_vision_cercana_od' => $this->input->post('agudeza_vision_cercana_od'),
            'agudeza_vision_cercana_oi' => $this->input->post('agudeza_vision_cercana_oi'),
            'agudeza_perimetria_od' => $this->input->post('agudeza_perimetria_od'),
            'agudeza_perimetria_oi' => $this->input->post('agudeza_perimetria_oi'),
            'agudeza_tonometria_od' => $this->input->post('agudeza_tonometria_od'),
            'agudeza_tonometria_oi' => $this->input->post('agudeza_tonometria_oi'),
            'agudeza_fondo_ojo_od' => $this->input->post('agudeza_fondo_ojo_od'),
            'agudeza_fondo_ojo_oi' => $this->input->post('agudeza_fondo_ojo_oi'),
            'agudeza_examen_externo_od' => $this->input->post('agudeza_examen_externo_od'),
            'agudeza_examen_externo_oi' => $this->input->post('agudeza_examen_externo_oi'),
            'forias_vision_lejana' => $this->input->post('forias_vision_lejana'),
            'forias_vision_proxima' => $this->input->post('forias_vision_proxima'),
            'forias_test_color' => $this->input->post('forias_test_color'),
            'forias_test_esteriopsis' => $this->input->post('forias_test_esteriopsis'),
            'forias_diagnostico' => $this->input->post('forias_diagnostico')
        );
        $this->db->set($dataO);
        $this->db->where("id_histo_clinicas", $old_id);
        $this->db->update("ocupacional", $dataO);
    }
    
    public function eliminarHistoOcupacional($id){
        $this->db->delete("ocupacional", "id_histo_clinicas = ".$id);
        $this->db->delete("historias_clinicas", "id_historias_clinicas = ".$id);
    }
    
    public function obtenerMedicos(){
        $query = $this->db->query("select id_medicos, CONCAT(nombres, ' ', apellidos) as nombresMedi from usuarios inner join medicos on usuarios.id_usuarios=medicos.id_usuarios");
        $data=array();
        foreach ($query->result() as $fila){
            $data[$fila->id_medicos] = $fila->nombresMedi;
        }
        return ($data);
    }
    
    public function obtenerPacientes(){
        $query = $this->db->query("select id_pacientes, CONCAT(nombresPaci, ' ', apellidosPaci) as nombresPacien from pacientes where estadoPaci = 1");
        $data=array();
        foreach ($query->result() as $fila){
            $data[$fila->id_pacientes] = $fila->nombresPacien;
        }
        return ($data);
    }
    
    public function obtenerReservaciones() {
        $reservaciones = $this->db->query("select id_reservaciones, CONCAT(fecha_horarios, ' - ',nombresPaci, ' ',apellidosPaci) as fecha_paciente from reservaciones inner join horarios on reservaciones.id_horarios=horarios.id_horarios inner join pacientes on reservaciones.id_pacientes=pacientes.id_pacientes where estadoReser=2");
        if($reservaciones->num_rows() > 0){
            return $reservaciones->result();
        }
    }
    
    public function obtenerReservacionesEdi() {
        $query = $this->db->query("select id_reservaciones, CONCAT(fecha_horarios, ' - ',nombresPaci, ' ',apellidosPaci) as fecha_paciente from reservaciones inner join horarios on reservaciones.id_horarios=horarios.id_horarios inner join pacientes on reservaciones.id_pacientes=pacientes.id_pacientes");
        $data=array();
        foreach ($query->result() as $fila){
            $data[$fila->id_reservaciones] = $fila->fecha_paciente;
        }
        return ($data);
    }
    
    public function numeroHistoOcupacional(){
        return $this->db->count_all('ocupacional');
    }
    
    public function numeroHistoOcupacionalBusqueda($busqueda, $parametro, $parametroH){
        $this->db->select("id_historias_clinicas, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, CONCAT(pacientes.nombresPaci, ' ',pacientes.apellidosPaci) as nombresPacien, fecha_horarios, lentes, agudeza_vision_lejana_od, agudeza_vision_lejana_oi, agudeza_vision_cercana_od, agudeza_vision_cercana_oi, agudeza_perimetria_od, agudeza_perimetria_oi, agudeza_tonometria_od, agudeza_tonometria_oi, agudeza_fondo_ojo_od, agudeza_fondo_ojo_oi, agudeza_examen_externo_od, agudeza_examen_externo_oi, forias_vision_lejana, forias_vision_proxima, forias_test_color, forias_test_esteriopsis, forias_diagnostico");
        $this->db->from('historias_clinicas');
        $this->db->join('ocupacional', 'historias_clinicas.id_historias_clinicas=ocupacional.id_histo_clinicas');
        $this->db->join('medicos', 'medicos.id_medicos=historias_clinicas.id_medicos');
        $this->db->join('reservaciones', 'reservaciones.id_reservaciones=historias_clinicas.id_reservaciones');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->where($busqueda.'>=', $parametro);
        $this->db->where($busqueda.'<=', $parametroH);
        $resultado = $this->db->get();
        return $resultado->num_rows();
    }
    
    public function mostrarResultados($limit,$start){
        $this->db->limit($limit,$start);
        $this->db->select("id_historias_clinicas, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, CONCAT(pacientes.nombresPaci, ' ',pacientes.apellidosPaci) as nombresPacien, fecha_horarios, lentes, agudeza_vision_lejana_od, agudeza_vision_lejana_oi, agudeza_vision_cercana_od, agudeza_vision_cercana_oi, agudeza_perimetria_od, agudeza_perimetria_oi, agudeza_tonometria_od, agudeza_tonometria_oi, agudeza_fondo_ojo_od, agudeza_fondo_ojo_oi, agudeza_examen_externo_od, agudeza_examen_externo_oi, forias_vision_lejana, forias_vision_proxima, forias_test_color, forias_test_esteriopsis, forias_diagnostico");
        $this->db->from('historias_clinicas');
        $this->db->join('ocupacional', 'ocupacional.id_histo_clinicas=historias_clinicas.id_historias_clinicas');
        $this->db->join('medicos', 'medicos.id_medicos=historias_clinicas.id_medicos');
        $this->db->join('reservaciones', 'reservaciones.id_reservaciones=historias_clinicas.id_reservaciones');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->order_by("id_historias_clinicas","asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function mostrarResultadosBusqueda($limit,$start,$busqueda,$parametro,$parametroH){
        $this->db->limit($limit,$start);
        $this->db->select("id_historias_clinicas, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, CONCAT(pacientes.nombresPaci, ' ',pacientes.apellidosPaci) as nombresPacien, fecha_horarios, lentes, agudeza_vision_lejana_od, agudeza_vision_lejana_oi, agudeza_vision_cercana_od, agudeza_vision_cercana_oi, agudeza_perimetria_od, agudeza_perimetria_oi, agudeza_tonometria_od, agudeza_tonometria_oi, agudeza_fondo_ojo_od, agudeza_fondo_ojo_oi, agudeza_examen_externo_od, agudeza_examen_externo_oi, forias_vision_lejana, forias_vision_proxima, forias_test_color, forias_test_esteriopsis, forias_diagnostico");
        $this->db->from('historias_clinicas');
        $this->db->join('ocupacional', 'ocupacional.id_histo_clinicas=historias_clinicas.id_historias_clinicas');
        $this->db->join('medicos', 'medicos.id_medicos=historias_clinicas.id_medicos');
        $this->db->join('reservaciones', 'reservaciones.id_reservaciones=historias_clinicas.id_reservaciones');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->where($busqueda.'>=', $parametro);
        $this->db->where($busqueda.'<=', $parametroH);
        $this->db->order_by("id_historias_clinicas","asc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarWord_ID($id)
    {
        $this->db->select("id_historias_clinicas, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, CONCAT(pacientes.nombresPaci, ' ',pacientes.apellidosPaci) as nombresPacien, fecha_horarios, lentes, agudeza_vision_lejana_od, agudeza_vision_lejana_oi, agudeza_vision_cercana_od, agudeza_vision_cercana_oi, agudeza_perimetria_od, agudeza_perimetria_oi, agudeza_tonometria_od, agudeza_tonometria_oi, agudeza_fondo_ojo_od, agudeza_fondo_ojo_oi, agudeza_examen_externo_od, agudeza_examen_externo_oi, forias_vision_lejana, forias_vision_proxima, forias_test_color, forias_test_esteriopsis, forias_diagnostico");
        $this->db->from('historias_clinicas');
        $this->db->join('ocupacional', 'ocupacional.id_histo_clinicas=historias_clinicas.id_historias_clinicas');
        $this->db->join('medicos', 'medicos.id_medicos=historias_clinicas.id_medicos');
        $this->db->join('reservaciones', 'reservaciones.id_reservaciones=historias_clinicas.id_reservaciones');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->where('id_historias_clinicas', $id);
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarExcel_ID($id)
    {
        $this->db->select("id_historias_clinicas, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, CONCAT(pacientes.nombresPaci, ' ',pacientes.apellidosPaci) as nombresPacien, fecha_horarios, lentes, agudeza_vision_lejana_od, agudeza_vision_lejana_oi, agudeza_vision_cercana_od, agudeza_vision_cercana_oi, agudeza_perimetria_od, agudeza_perimetria_oi, agudeza_tonometria_od, agudeza_tonometria_oi, agudeza_fondo_ojo_od, agudeza_fondo_ojo_oi, agudeza_examen_externo_od, agudeza_examen_externo_oi, forias_vision_lejana, forias_vision_proxima, forias_test_color, forias_test_esteriopsis, forias_diagnostico");
        $this->db->from('historias_clinicas');
        $this->db->join('ocupacional', 'ocupacional.id_histo_clinicas=historias_clinicas.id_historias_clinicas');
        $this->db->join('medicos', 'medicos.id_medicos=historias_clinicas.id_medicos');
        $this->db->join('reservaciones', 'reservaciones.id_reservaciones=historias_clinicas.id_reservaciones');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->where('id_historias_clinicas', $id);
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarPDF_ID($id)
    {
        $this->db->select("id_historias_clinicas, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, CONCAT(pacientes.nombresPaci, ' ',pacientes.apellidosPaci) as nombresPacien, fecha_horarios, lentes, agudeza_vision_lejana_od, agudeza_vision_lejana_oi, agudeza_vision_cercana_od, agudeza_vision_cercana_oi, agudeza_perimetria_od, agudeza_perimetria_oi, agudeza_tonometria_od, agudeza_tonometria_oi, agudeza_fondo_ojo_od, agudeza_fondo_ojo_oi, agudeza_examen_externo_od, agudeza_examen_externo_oi, forias_vision_lejana, forias_vision_proxima, forias_test_color, forias_test_esteriopsis, forias_diagnostico");
        $this->db->from('historias_clinicas');
        $this->db->join('ocupacional', 'ocupacional.id_histo_clinicas=historias_clinicas.id_historias_clinicas');
        $this->db->join('medicos', 'medicos.id_medicos=historias_clinicas.id_medicos');
        $this->db->join('reservaciones', 'reservaciones.id_reservaciones=historias_clinicas.id_reservaciones');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->where('id_historias_clinicas', $id);
        $resultado = $this->db->get();
        return $resultado->result();
    }
}