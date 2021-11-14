<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Histo_general_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function insertarHistoGeneral($data,$id){
        $this->db->insert("historias_clinicas", $data);
        $data_general = array(
            'id_histo_clinicas' => $this->db->insert_id(),
            'vl_od' => $this->input->post('vl_od'),
            'vl_oi' => $this->input->post('vl_oi') ,
            'cc_od' => $this->input->post('cc_od'),
            'cc_oi' => $this->input->post('cc_oi'),
            'vp_od' => $this->input->post('vp_od'),
            'vp_oi' => $this->input->post('vp_oi'),
            'cc2_od' => $this->input->post('cc2_od'),
            'cc2_oi' => $this->input->post('cc2_oi'),
            'ph_od' => $this->input->post('ph_od'),
            'ph_oi' => $this->input->post('ph_oi'),
            'dp' => $this->input->post('dp'),
            'ppc' => $this->input->post('ppc'),
            'foria' => $this->input->post('foria'),
            'motivo_consulta' => $this->input->post('motivo_consulta'),
            'signos_sintomas' => $this->input->post('signos_sintomas'),
            'examen_externo_od' => $this->input->post('examen_externo_od'),
            'examen_externo_oi' => $this->input->post('examen_externo_oi'),
            'antecedentes' => $this->input->post('antecedentes'),
            'antecedentes_p' => $this->input->post('antecedentes_p'),
            'fondo_ojo_od' => $this->input->post('fondo_ojo_od'),
            'fondo_ojo_oi' => $this->input->post('fondo_ojo_oi'),
            'queratoneria_od' => $this->input->post('queratoneria_od'),
            'queratoneria_oi' => $this->input->post('queratoneria_oi'),
            'retinoscopia_od' => $this->input->post('retinoscopia_od'),
            'retinoscopia_oi' => $this->input->post('retinoscopia_oi'),
            'subjetivo_od' => $this->input->post('subjetivo_od'),
            'subjetivo_oi' => $this->input->post('subjetivo_oi')
        );
        $this->db->insert("general", $data_general);
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
    
    public function editarHistoGeneral($data, $old_id){
        $this->db->set($data);
        $this->db->where("id_historias_clinicas", $old_id);
        $this->db->update("historias_clinicas", $data);
        $dataG = array(
            'vl_od' => $this->input->post('vl_od'),
            'vl_oi' => $this->input->post('vl_oi') ,
            'cc_od' => $this->input->post('cc_od'),
            'cc_oi' => $this->input->post('cc_oi'),
            'vp_od' => $this->input->post('vp_od'),
            'vp_oi' => $this->input->post('vp_oi'),
            'cc2_od' => $this->input->post('cc2_od'),
            'cc2_oi' => $this->input->post('cc2_oi'),
            'ph_od' => $this->input->post('ph_od'),
            'ph_oi' => $this->input->post('ph_oi'),
            'dp' => $this->input->post('dp'),
            'ppc' => $this->input->post('ppc'),
            'foria' => $this->input->post('foria'),
            'motivo_consulta' => $this->input->post('motivo_consulta'),
            'signos_sintomas' => $this->input->post('signos_sintomas'),
            'examen_externo_od' => $this->input->post('examen_externo_od'),
            'examen_externo_oi' => $this->input->post('examen_externo_oi'),
            'antecedentes' => $this->input->post('antecedentes'),
            'antecedentes_p' => $this->input->post('antecedentes_p'),
            'fondo_ojo_od' => $this->input->post('fondo_ojo_od'),
            'fondo_ojo_oi' => $this->input->post('fondo_ojo_oi'),
            'queratoneria_od' => $this->input->post('queratoneria_od'),
            'queratoneria_oi' => $this->input->post('queratoneria_oi'),
            'retinoscopia_od' => $this->input->post('retinoscopia_od'),
            'retinoscopia_oi' => $this->input->post('retinoscopia_oi'),
            'subjetivo_od' => $this->input->post('subjetivo_od'),
            'subjetivo_oi' => $this->input->post('subjetivo_oi')
        );
        $this->db->set($dataG);
        $this->db->where("id_histo_clinicas", $old_id);
        $this->db->update("general", $dataG);
    }
    
    public function eliminarHistoGeneral($id){
        $this->db->delete("general", "id_histo_clinicas = ".$id);
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
    
    public function numeroHistoGeneral(){
        return $this->db->count_all('general');
    }
    
    public function numeroHistoGeneralBusqueda($busqueda, $parametro, $parametroH){
        $this->db->select("id_historias_clinicas, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPacien, fecha_horarios, vl_od, vl_oi, cc_od, cc_oi, vp_od, vp_oi, cc2_od, cc2_oi, ph_od, ph_oi, dp, ppc, foria, motivo_consulta, signos_sintomas, examen_externo_od, examen_externo_oi, antecedentes, antecedentes_p, fondo_ojo_od, fondo_ojo_oi, queratoneria_od, queratoneria_oi, retinoscopia_od, retinoscopia_oi, subjetivo_od, subjetivo_oi");
        $this->db->from('historias_clinicas');
        $this->db->join('general', 'historias_clinicas.id_historias_clinicas=general.id_histo_clinicas');
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
        $this->db->select("id_historias_clinicas, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPacien, fecha_horarios, vl_od, vl_oi, cc_od, cc_oi, vp_od, vp_oi, cc2_od, cc2_oi, ph_od, ph_oi, dp, ppc, foria, motivo_consulta, signos_sintomas, examen_externo_od, examen_externo_oi, antecedentes, antecedentes_p, fondo_ojo_od, fondo_ojo_oi, queratoneria_od, queratoneria_oi, retinoscopia_od, retinoscopia_oi, subjetivo_od, subjetivo_oi");
        $this->db->from('historias_clinicas');
        $this->db->join('general', 'general.id_histo_clinicas=historias_clinicas.id_historias_clinicas');
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
        $this->db->select("id_historias_clinicas, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPacien, fecha_horarios, vl_od, vl_oi, cc_od, cc_oi, vp_od, vp_oi, cc2_od, cc2_oi, ph_od, ph_oi, dp, ppc, foria, motivo_consulta, signos_sintomas, examen_externo_od, examen_externo_oi, antecedentes, antecedentes_p, fondo_ojo_od, fondo_ojo_oi, queratoneria_od, queratoneria_oi, retinoscopia_od, retinoscopia_oi, subjetivo_od, subjetivo_oi");
        $this->db->from('historias_clinicas');
        $this->db->join('general', 'general.id_histo_clinicas=historias_clinicas.id_historias_clinicas');
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
        $this->db->select("id_historias_clinicas, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPacien, fecha_horarios, vl_od, vl_oi, cc_od, cc_oi, vp_od, vp_oi, cc2_od, cc2_oi, ph_od, ph_oi, dp, ppc, foria, motivo_consulta, signos_sintomas, examen_externo_od, examen_externo_oi, antecedentes, antecedentes_p, fondo_ojo_od, fondo_ojo_oi, queratoneria_od, queratoneria_oi, retinoscopia_od, retinoscopia_oi, subjetivo_od, subjetivo_oi");
        $this->db->from('historias_clinicas');
        $this->db->join('general', 'general.id_histo_clinicas=historias_clinicas.id_historias_clinicas');
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
        $this->db->select("id_historias_clinicas, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPacien, fecha_horarios, vl_od, vl_oi, cc_od, cc_oi, vp_od, vp_oi, cc2_od, cc2_oi, ph_od, ph_oi, dp, ppc, foria, motivo_consulta, signos_sintomas, examen_externo_od, examen_externo_oi, antecedentes, antecedentes_p, fondo_ojo_od, fondo_ojo_oi, queratoneria_od, queratoneria_oi, retinoscopia_od, retinoscopia_oi, subjetivo_od, subjetivo_oi");
        $this->db->from('historias_clinicas');
        $this->db->join('general', 'general.id_histo_clinicas=historias_clinicas.id_historias_clinicas');
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
        $this->db->select("id_historias_clinicas, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, CONCAT(nombresPaci, ' ',apellidosPaci) as nombresPacien, fecha_horarios, vl_od, vl_oi, cc_od, cc_oi, vp_od, vp_oi, cc2_od, cc2_oi, ph_od, ph_oi, dp, ppc, foria, motivo_consulta, signos_sintomas, examen_externo_od, examen_externo_oi, antecedentes, antecedentes_p, fondo_ojo_od, fondo_ojo_oi, queratoneria_od, queratoneria_oi, retinoscopia_od, retinoscopia_oi, subjetivo_od, subjetivo_oi");
        $this->db->from('historias_clinicas');
        $this->db->join('general', 'general.id_histo_clinicas=historias_clinicas.id_historias_clinicas');
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