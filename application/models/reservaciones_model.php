<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservaciones_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("America/Lima");
    }
    
    public function insertarReservacion($data){
        $this->db->insert("reservaciones", $data);
//        $id = $this->input->post('id_turnos');
//        $data_turno = array(
//            'estado_turnos' => 1
//        );
//        $this->db->set($data_turno);
//        $this->db->where("id_turnos", $id);
//        $this->db->update("turnos", $data_turno);
//        
//        $id_paci = $this->input->post('id_pacientes');
//        $id_ho = $this->input->post('id_horarios');
//        $id_tur = $this->input->post('id_turnos');
//        
//        $this->load->library('nexmo');
//        $this->nexmo->set_format('json');
//        
//        $queryP = $this->db->query("select CONCAT(nombresPaci, ' ', apellidosPaci) as nombresPacien, celularPaci from pacientes  where id_pacientes=".$id_paci);
//        $queryDP = $this->db->query("select correo from datos_pacientes where id_pacientes=".$id_paci);
//        $queryH = $this->db->query("select fecha_horarios from horarios where id_horarios=".$id_ho);
//        $queryT = $this->db->query("select hora_inicio, hora_fin from turnos where id_turnos=".$id_tur);
//        
//        foreach ($queryH->result() as $filaH){
//            $fecha = $filaH->fecha_horarios;
//        }
//        foreach ($queryDP->result() as $filaDP){
//            $correo = $filaDP->correo;
//        }
//        foreach ($queryT->result() as $filaT){
//            $hora_i = $filaT->hora_inicio;
//            $hora_f = $filaT->hora_fin;
//        }
//        foreach ($queryP->result() as $filaP){
//            $prefijo = '593';
//            $nuevoCelular = substr($filaP->celularPaci, 1);
//        }
//        $from = 'OCEAN OPTICAL';
//        $to = trim(''.$prefijo.''.$nuevoCelular.'');
//        $message = array(
//                'text' => 'Su próxima cita médica es el ' .$fecha.' de '.$hora_i.' a '.$hora_f.'',
//            );
//        $this->nexmo->send_message($from, $to, $message);
        //Descomentar cuando se adquiera las claves de la API nexmo
    }
    
    public function reservacionValida($id_horarios){
        $query = $this->db->query("select fecha_horarios from horarios where id_horarios=".$id_horarios);
        foreach ($query->result() as $fila){
            if($fila->fecha_horarios < date("Y-m-d")){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
    }
    
    public function eliminarReservacion($id){
//        $this->load->library('nexmo');
//        $this->nexmo->set_format('json');
//        $queryNotificacion = $this->db->query("select id_pacientes, id_horarios, id_turnos from reservaciones where id_reservaciones=".$id);
//        foreach ($queryNotificacion->result() as $filaN){
//            $paciente = $filaN->id_pacientes;
//        }
//        $queryPaciente = $this->db->query("select CONCAT(nombresPaci, ' ', apellidosPaci) as nombresPacien, celularPaci from pacientes  where id_pacientes=".$paciente);
//        foreach ($queryPaciente->result() as $filaP){
//            $prefijo = '593';
//            $nuevoCelular = substr($filaP->celularPaci, 1);
//        }
//        $from = 'OCEAN OPTICAL';
//        $to = trim(''.$prefijo.''.$nuevoCelular.'');
//        $message = array(
//                'text' => 'Su cita médica ha sido cancelada',
//            );
//        $this->nexmo->send_message($from, $to, $message);
        //Descomentar las lineas cuando se adquiera las claves de la API nexmo
        $query = $this->db->query("select id_turnos from reservaciones where id_reservaciones=".$id);
        foreach ($query->result() as $fila){
            $this->db->query("update turnos set estado_turnos=0 where id_turnos=".$fila->id_turnos);
        }
        $this->db->query("update reservaciones set estadoReser=3 where id_reservaciones=".$id);
    }
    
    public function numeroReservaciones(){
        return $this->db->count_all('reservaciones');
    }
    
    public function numeroReservacionesBusqueda($busqueda, $parametro, $parametroH){
        $this->db->select("*");
        $this->db->from('reservaciones');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('turnos', 'turnos.id_turnos=reservaciones.id_turnos');
        $this->db->where($busqueda.'>=', $parametro);
        $this->db->where($busqueda.'<=', $parametroH);
        $resultado = $this->db->get();
        return $resultado->num_rows();
    }
    
    public function obtenerHorarios() {
        $this->db->order_by('fecha_horarios', 'desc');
        $horarios = $this->db->get('horarios');
        if($horarios->num_rows() > 0){
            return $horarios->result();
        }
    }
    
    public function obtenerPacientes() {
        $pacientes = $this->db->query("select id_pacientes, CONCAT(nombresPaci, ' ', apellidosPaci) as nombresPacien from pacientes where estadoPaci=1 order by nombresPacien asc");
        if($pacientes->num_rows() > 0){
            return $pacientes->result();
        }
    }
    
    public function obtenerTurnos($id_horarios) {
        $this->db->where('id_horarios', $id_horarios);
        $this->db->where('laborar', "Si");
        $this->db->where('estado_turnos', 0);
        $this->db->order_by('id_turnos', 'asc');
        $turnos = $this->db->get('turnos');
        if($turnos->num_rows() > 0){
            return $turnos->result();
        }
    }
    
    public function mostrarResultados($limit,$start)
    {
        $this->db->limit($limit,$start);
        $this->db->select("id_reservaciones, CONCAT(pacientes.nombresPaci, ' ', pacientes.apellidosPaci) as nombresPacien, fecha_horarios, CONCAT(hora_inicio, ' - ', hora_fin) as turno, if (estadoReser=1,'Atendido', if(estadoReser=2,'No atendido','Cancelada')) as estado_reser");
        $this->db->from('reservaciones');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('turnos', 'turnos.id_turnos=reservaciones.id_turnos');
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function mostrarResultadosBusqueda($limit,$start,$busqueda,$parametro,$parametroH){
        $this->db->limit($limit,$start);
        $this->db->select("id_reservaciones, CONCAT(pacientes.nombresPaci, ' ', pacientes.apellidosPaci) as nombresPacien, fecha_horarios, CONCAT(hora_inicio, ' - ', hora_fin) as turno, if (estadoReser=1,'Atendido', if(estadoReser=2,'No atendido','Cancelada')) as estado_reser");
        $this->db->from('reservaciones');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('turnos', 'turnos.id_turnos=reservaciones.id_turnos');
        $this->db->where($busqueda.'>=', $parametro);
        $this->db->where($busqueda.'<=', $parametroH);
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarWord()
    {
        $this->db->select("id_reservaciones, CONCAT(pacientes.nombresPaci, ' ', pacientes.apellidosPaci) as nombresPacien, fecha_horarios, CONCAT(hora_inicio, ' - ', hora_fin) as turno, if (estadoReser=1,'Atendido', if(estadoReser=2,'No atendido','Cancelada')) as estado_reser");
        $this->db->from('reservaciones');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('turnos', 'turnos.id_turnos=reservaciones.id_turnos');
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarWord_ID($id)
    {
        $this->db->select("id_reservaciones, CONCAT(pacientes.nombresPaci, ' ', pacientes.apellidosPaci) as nombresPacien, fecha_horarios, CONCAT(hora_inicio, ' - ', hora_fin) as turno, if (estadoReser=1,'Atendido', if(estadoReser=2,'No atendido','Cancelada')) as estado_reser");
        $this->db->from('reservaciones');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('turnos', 'turnos.id_turnos=reservaciones.id_turnos');
        $this->db->where('id_reservaciones', $id);
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarExcel()
    {
        $this->db->select("id_reservaciones, CONCAT(pacientes.nombresPaci, ' ', pacientes.apellidosPaci) as nombresPacien, fecha_horarios, CONCAT(hora_inicio, ' - ', hora_fin) as turno, if (estadoReser=1,'Atendido', if(estadoReser=2,'No atendido','Cancelada')) as estado_reser");
        $this->db->from('reservaciones');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('turnos', 'turnos.id_turnos=reservaciones.id_turnos');
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarExcel_ID($id)
    {
        $this->db->select("id_reservaciones, CONCAT(pacientes.nombresPaci, ' ', pacientes.apellidosPaci) as nombresPacien, fecha_horarios, CONCAT(hora_inicio, ' - ', hora_fin) as turno, if (estadoReser=1,'Atendido', if(estadoReser=2,'No atendido','Cancelada')) as estado_reser");
        $this->db->from('reservaciones');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('turnos', 'turnos.id_turnos=reservaciones.id_turnos');
        $this->db->where('id_reservaciones', $id);
        $resultado = $this->db->get();
        return $resultado->result_array();
    }
    
    public function obtenerResultadosExportarPDF()
    {
        $this->db->select("id_reservaciones, CONCAT(pacientes.nombresPaci, ' ', pacientes.apellidosPaci) as nombresPacien, fecha_horarios, CONCAT(hora_inicio, ' - ', hora_fin) as turno, if (estadoReser=1,'Atendido', if(estadoReser=2,'No atendido','Cancelada')) as estado_reser");
        $this->db->from('reservaciones');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('turnos', 'turnos.id_turnos=reservaciones.id_turnos');
        $this->db->order_by("fecha_horarios","desc");
        $resultado = $this->db->get();
        return $resultado->result();
    }
    
    public function obtenerResultadosExportarPDF_ID($id)
    {
        $this->db->select("id_reservaciones, CONCAT(pacientes.nombresPaci, ' ', pacientes.apellidosPaci) as nombresPacien, fecha_horarios, CONCAT(hora_inicio, ' - ', hora_fin) as turno, if (estadoReser=1,'Atendido', if(estadoReser=2,'No atendido','Cancelada')) as estado_reser");
        $this->db->from('reservaciones');
        $this->db->join('pacientes', 'pacientes.id_pacientes=reservaciones.id_pacientes');
        $this->db->join('horarios', 'horarios.id_horarios=reservaciones.id_horarios');
        $this->db->join('turnos', 'turnos.id_turnos=reservaciones.id_turnos');
        $this->db->where('id_reservaciones', $id);
        $resultado = $this->db->get();
        return $resultado->result();
    }
}