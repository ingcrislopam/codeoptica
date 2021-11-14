<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Horarios_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function insertarHorario($data){
        $this->db->insert("horarios", $data);
        $datat1am = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "08:30",
            'hora_fin' => "09:00",
            'laborar' => $this->input->post('turno1am'),
            'estado_turnos' => 0
            );
        $datat2am = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "09:00",
            'hora_fin' => "09:30",
            'laborar' => $this->input->post('turno2am'),
            'estado_turnos' => 0
            );
        $datat3am = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "09:30",
            'hora_fin' => "10:00",
            'laborar' => $this->input->post('turno3am'),
            'estado_turnos' => 0
            );
        $datat4am = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "10:00",
            'hora_fin' => "10:30",
            'laborar' => $this->input->post('turno4am'),
            'estado_turnos' => 0
            );
        $datat5am = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "10:30",
            'hora_fin' => "11:00",
            'laborar' => $this->input->post('turno5am'),
            'estado_turnos' => 0
            );
        $datat6am = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "11:00",
            'hora_fin' => "11:30",
            'laborar' => $this->input->post('turno6am'),
            'estado_turnos' => 0
            );
        $datat7am = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "11:30",
            'hora_fin' => "12:00",
            'laborar' => $this->input->post('turno7am'),
            'estado_turnos' => 0
            );
        $datat8am = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "12:00",
            'hora_fin' => "12:30",
            'laborar' => $this->input->post('turno8am'),
            'estado_turnos' => 0
            );
        $datat1pm = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "14:30",
            'hora_fin' => "15:00",
            'laborar' => $this->input->post('turno1pm'),
            'estado_turnos' => 0
            );
        $datat2pm = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "15:00",
            'hora_fin' => "15:30",
            'laborar' => $this->input->post('turno2pm'),
            'estado_turnos' => 0
            );
        $datat3pm = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "15:30",
            'hora_fin' => "16:00",
            'laborar' => $this->input->post('turno3pm'),
            'estado_turnos' => 0
            );
        $datat4pm = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "16:00",
            'hora_fin' => "16:30",
            'laborar' => $this->input->post('turno4pm'),
            'estado_turnos' => 0
            );
        $datat5pm = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "16:30",
            'hora_fin' => "17:00",
            'laborar' => $this->input->post('turno5pm'),
            'estado_turnos' => 0
            );
        $datat6pm = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "17:00",
            'hora_fin' => "17:30",
            'laborar' => $this->input->post('turno6pm'),
            'estado_turnos' => 0
            );
        $datat7pm = array(
            'id_horarios' => $this->db->insert_id(),
            'hora_inicio' => "17:30",
            'hora_fin' => "18:00",
            'laborar' => $this->input->post('turno7pm'),
            'estado_turnos' => 0
            );
        $this->db->insert("turnos", $datat1am);
        $this->db->insert("turnos", $datat2am);
        $this->db->insert("turnos", $datat3am);
        $this->db->insert("turnos", $datat4am);
        $this->db->insert("turnos", $datat5am);
        $this->db->insert("turnos", $datat6am);
        $this->db->insert("turnos", $datat7am);
        $this->db->insert("turnos", $datat8am);
        $this->db->insert("turnos", $datat1pm);
        $this->db->insert("turnos", $datat2pm);
        $this->db->insert("turnos", $datat3pm);
        $this->db->insert("turnos", $datat4pm);
        $this->db->insert("turnos", $datat5pm);
        $this->db->insert("turnos", $datat6pm);
        $this->db->insert("turnos", $datat7pm);
    }
    
    public function editarHorario($data, $old_id){
        $this->db->set($data);
        $this->db->where("id_horarios", $old_id);
        $this->db->update("horarios", $data);
        $data_1am = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno1am')
        );
        $this->db->set($data_1am);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "08:30");
        $this->db->where("hora_fin", "09:00");
        $this->db->update("turnos", $data_1am);
        $data_2am = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno2am')
        );
        $this->db->set($data_2am);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "09:00");
        $this->db->where("hora_fin", "09:30");
        $this->db->update("turnos", $data_2am);
        $data_3am = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno3am')
        );
        $this->db->set($data_3am);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "09:30");
        $this->db->where("hora_fin", "10:00");
        $this->db->update("turnos", $data_3am);
        $data_4am = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno4am')
        );
        $this->db->set($data_4am);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "10:00");
        $this->db->where("hora_fin", "10:30");
        $this->db->update("turnos", $data_4am);
        $data_5am = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno5am')
        );
        $this->db->set($data_5am);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "10:30");
        $this->db->where("hora_fin", "11:00");
        $this->db->update("turnos", $data_5am);
        $data_6am = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno6am')
        );
        $this->db->set($data_6am);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "11:00");
        $this->db->where("hora_fin", "11:30");
        $this->db->update("turnos", $data_6am);
        $data_7am = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno7am')
        );
        $this->db->set($data_7am);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "11:30");
        $this->db->where("hora_fin", "12:00");
        $this->db->update("turnos", $data_7am);
        $data_8am = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno8am')
        );
        $this->db->set($data_8am);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "12:00");
        $this->db->where("hora_fin", "12:30");
        $this->db->update("turnos", $data_8am);
        $data_1pm = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno1pm')
        );
        $this->db->set($data_1pm);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "14:30");
        $this->db->where("hora_fin", "15:00");
        $this->db->update("turnos", $data_1pm);
        $data_2pm = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno2pm')
        );
        $this->db->set($data_2pm);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "15:00");
        $this->db->where("hora_fin", "15:30");
        $this->db->update("turnos", $data_2pm);
        $data_3pm = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno3pm')
        );
        $this->db->set($data_3pm);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "15:30");
        $this->db->where("hora_fin", "16:00");
        $this->db->update("turnos", $data_3pm);
        $data_4pm = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno4pm')
        );
        $this->db->set($data_4pm);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "16:00");
        $this->db->where("hora_fin", "16:30");
        $this->db->update("turnos", $data_4pm);
        $data_5pm = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno5pm')
        );
        $this->db->set($data_5pm);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "16:30");
        $this->db->where("hora_fin", "17:00");
        $this->db->update("turnos", $data_5pm);
        $data_6pm = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno6pm')
        );
        $this->db->set($data_6pm);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "17:00");
        $this->db->where("hora_fin", "17:30");
        $this->db->update("turnos", $data_6pm);
        $data_7pm = array(
            'id_horarios' => $this->input->post('id_horarios'),
            'laborar' => $this->input->post('turno7pm')
        );
        $this->db->set($data_7pm);
        $this->db->where("id_horarios", $old_id);
        $this->db->where("hora_inicio", "17:30");
        $this->db->where("hora_fin", "18:00");
        $this->db->update("turnos", $data_7pm);
    }
    
    public function eliminarHorario($id){
        $this->db->delete("turnos", "id_horarios = ".$id);
        $this->db->delete("horarios", "id_horarios = ".$id);
    }
    
    public function existeFechaHorarios($fecha_horarios){
        $this->db->select("fecha_horarios");
        $this->db->from('horarios');
        $this->db->where('fecha_horarios', $fecha_horarios);
        $resultado = $this->db->get();
        if($resultado->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function obtenerMedicos(){
        $query = $this->db->query("select id_medicos, CONCAT(nombres, ' ', apellidos) as nombresMedi from usuarios inner join medicos on usuarios.id_usuarios=medicos.id_usuarios");
        $data=array();
        foreach ($query->result() as $fila){
            $data[$fila->id_medicos] = $fila->nombresMedi;
        }
        return ($data);
    }
    
    public function numeroHorarios(){
        return $this->db->count_all('horarios');
    }
    
    public function numeroHorariosBusqueda($busqueda, $parametro, $parametroH){
        $this->db->select("*");
        $this->db->from('horarios');
        $this->db->where($busqueda.'>=', $parametro);
        $this->db->where($busqueda.'<=', $parametroH);
        $resultado = $this->db->get();
        return $resultado->num_rows();
    }
    
    public function mostrarResultados($limit,$start)
    {
        $this->db->limit($limit,$start);
        $this->db->select("id_horarios, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, fecha_horarios, (select COUNT(*) from turnos where laborar='Si' and id_horarios=horarios.id_horarios) as total_turnos, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=0 and id_horarios=horarios.id_horarios) as disponibles, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=1 and id_horarios=horarios.id_horarios) as reservados");
        $this->db->from('horarios');
        $this->db->join('medicos', 'medicos.id_medicos=horarios.id_medicos');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function mostrarResultadosBusqueda($limit,$start,$busqueda,$parametro,$parametroH){
        $this->db->limit($limit,$start);
        $this->db->select("id_horarios, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, fecha_horarios, (select COUNT(*) from turnos where laborar='Si' and id_horarios=horarios.id_horarios) as total_turnos, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=0 and id_horarios=horarios.id_horarios) as disponibles, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=1 and id_horarios=horarios.id_horarios) as reservados");
        $this->db->from('horarios');
        $this->db->join('medicos', 'medicos.id_medicos=horarios.id_medicos');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->where($busqueda.'>=', $parametro);
        $this->db->where($busqueda.'<=', $parametroH);
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarWord()
    {
        $this->db->select("id_horarios, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, fecha_horarios, (select COUNT(*) from turnos where laborar='Si' and id_horarios=horarios.id_horarios) as total_turnos, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=0 and id_horarios=horarios.id_horarios) as disponibles, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=1 and id_horarios=horarios.id_horarios) as reservados");
        $this->db->from('horarios');
        $this->db->join('medicos', 'medicos.id_medicos=horarios.id_medicos');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarWord_ID($id)
    {
        $this->db->select("id_horarios, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, fecha_horarios, (select COUNT(*) from turnos where laborar='Si' and id_horarios=horarios.id_horarios) as total_turnos, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=0 and id_horarios=horarios.id_horarios) as disponibles, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=1 and id_horarios=horarios.id_horarios) as reservados");
        $this->db->from('horarios');
        $this->db->join('medicos', 'medicos.id_medicos=horarios.id_medicos');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->where('id_horarios', $id);
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarExcel()
    {
        $this->db->select("id_horarios, fecha_horarios, (select COUNT(*) from turnos where laborar='Si' and id_horarios=horarios.id_horarios) as total_turnos, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=0 and id_horarios=horarios.id_horarios) as disponibles, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=1 and id_horarios=horarios.id_horarios) as reservados");
        $this->db->from('horarios');
        $this->db->join('medicos', 'medicos.id_medicos=horarios.id_medicos');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarExcel_ID($id)
    {
        $this->db->select("id_horarios, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, fecha_horarios, (select COUNT(*) from turnos where laborar='Si' and id_horarios=horarios.id_horarios) as total_turnos, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=0 and id_horarios=horarios.id_horarios) as disponibles, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=1 and id_horarios=horarios.id_horarios) as reservados");
        $this->db->from('horarios');
        $this->db->join('medicos', 'medicos.id_medicos=horarios.id_medicos');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->where('id_horarios', $id);
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarPDF()
    {
        $this->db->select("id_horarios, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, fecha_horarios, (select COUNT(*) from turnos where laborar='Si' and id_horarios=horarios.id_horarios) as total_turnos, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=0 and id_horarios=horarios.id_horarios) as disponibles, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=1 and id_horarios=horarios.id_horarios) as reservados");
        $this->db->from('horarios');
        $this->db->join('medicos', 'medicos.id_medicos=horarios.id_medicos');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarPDF_ID($id)
    {
        $this->db->select("id_horarios, CONCAT(usuarios.nombres, ' ',usuarios.apellidos) as nombresMedi, fecha_horarios, (select COUNT(*) from turnos where laborar='Si' and id_horarios=horarios.id_horarios) as total_turnos, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=0 and id_horarios=horarios.id_horarios) as disponibles, (select COUNT(*) from turnos where laborar='Si' and estado_turnos=1 and id_horarios=horarios.id_horarios) as reservados");
        $this->db->from('horarios');
        $this->db->join('medicos', 'medicos.id_medicos=horarios.id_medicos');
        $this->db->join('usuarios', 'usuarios.id_usuarios=medicos.id_usuarios');
        $this->db->where('id_horarios', $id);
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
}