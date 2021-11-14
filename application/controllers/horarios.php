<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Horarios extends CI_Controller{
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("America/Lima");
        $this->load->helper('url');
        $this->load->database();
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->load->library(array('table','pdf'));
        $this->load->library("excel");
    }
    
    public function index(){
        $this->load->model('Horarios_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/horarios/index';
        $opciones['total_rows'] = $this->Horarios_model->numeroHorarios();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Horarios_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_horarios/cabecera_horarios_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_horarios/horarios_view',$data);
        $this->load->view('footer_view');
    }
    
    public function insertar_horarios_view(){
        $this->load->helper('form');
        $this->load->model('Horarios_model');
        $data['medicos'] = $this->Horarios_model->obtenerMedicos();
        $this->load->view('folder_horarios/cabecera_horarios_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_horarios/horarios_insertar',$data);
        $this->load->view('footer_view');
    }
    
    public function insertar_horarios(){
        $this->load->model('Horarios_model');
        $this->reglas_validacion();
        if($this->form_validation->run()==FALSE){
            $this->insertar_horarios_view();
        }
        else{
            $data = array(
                'id_medicos' => $this->input->post('id_medicos'),
                'fecha_horarios' => $this->input->post('fecha_horarios')
            );
            $this->Horarios_model->insertarHorario($data);
            redirect('index.php/horarios/paginar');
        }
    }
    
    public function buscar_horarios_view(){
        $this->load->model('Horarios_model');
        $this->load->library('pagination');
        $busqueda = $this->input->post('busqueda');
        $parametro = $this->input->post('parametro');
        $parametroH = $this->input->post('parametroH');
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/horarios/index';
        $opciones['total_rows'] = $this->Horarios_model->numeroHorariosBusqueda($busqueda,$parametro,$parametroH);
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Horarios_model->mostrarResultadosBusqueda($opciones['per_page'],$desde,$busqueda,$parametro,$parametroH);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_horarios/cabecera_horarios_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_horarios/horarios_view',$data);
        $this->load->view('footer_view');
    }
    
    public function editar_horarios_view(){
        $this->load->helper('form');
        $id = $this->uri->segment('3');
        $this->load->model('Horarios_model');
        $query = $this->db->get_where("horarios",array("id_horarios"=>$id));
        $query1am = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"08:30", "hora_fin"=>"09:00"));
        $query2am = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"09:00", "hora_fin"=>"09:30"));
        $query3am = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"09:30", "hora_fin"=>"10:00"));
        $query4am = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"10:00", "hora_fin"=>"10:30"));
        $query5am = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"10:30", "hora_fin"=>"11:00"));
        $query6am = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"11:00", "hora_fin"=>"11:30"));
        $query7am = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"11:30", "hora_fin"=>"12:00"));
        $query8am = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"12:00", "hora_fin"=>"12:30"));
        $query1pm = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"14:30", "hora_fin"=>"15:00"));
        $query2pm = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"15:00", "hora_fin"=>"15:30"));
        $query3pm = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"15:30", "hora_fin"=>"16:00"));
        $query4pm = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"16:00", "hora_fin"=>"16:30"));
        $query5pm = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"16:30", "hora_fin"=>"17:00"));
        $query6pm = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"17:00", "hora_fin"=>"17:30"));
        $query7pm = $this->db->get_where("turnos",array("id_horarios"=>$id, "hora_inicio"=>"17:30", "hora_fin"=>"18:00"));
        $data['medicos'] = $this->Horarios_model->obtenerMedicos();
        $data['datos'] = $query->result(); 
        $data['datos1am'] = $query1am->result();
        $data['datos2am'] = $query2am->result();
        $data['datos3am'] = $query3am->result();
        $data['datos4am'] = $query4am->result();
        $data['datos5am'] = $query5am->result();
        $data['datos6am'] = $query6am->result();
        $data['datos7am'] = $query7am->result();
        $data['datos8am'] = $query8am->result();
        $data['datos1pm'] = $query1pm->result();
        $data['datos2pm'] = $query2pm->result();
        $data['datos3pm'] = $query3pm->result();
        $data['datos4pm'] = $query4pm->result();
        $data['datos5pm'] = $query5pm->result();
        $data['datos6pm'] = $query6pm->result();
        $data['datos7pm'] = $query7pm->result();
        $data['old_id'] = $id; 
        $this->load->view('folder_horarios/cabecera_horarios_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_horarios/horarios_editar',$data);
        $this->load->view('footer_view');
    }
    
    public function editar_horarios(){
        $this->load->model('Horarios_model');	
        $data = array(
            'id_medicos' => $this->input->post('id_medicos'),
            'fecha_horarios' => $this->input->post('fecha_horarios')
        );		
        $old_id = $this->input->post('old_id'); 
        $this->Horarios_model->editarHorario($data,$old_id);
        redirect('index.php/horarios/paginar');
    }
    
    public function eliminar_horarios(){
        $this->load->model('Horarios_model'); 
        $id = $this->uri->segment('3'); 
        $this->Horarios_model->eliminarHorario($id);
        redirect('index.php/horarios/paginar');
    }

        public function reglas_validacion(){
        $config = array(
            array(
                'field'=>'fecha_horarios',
                'label'=>'fecha',
                'rules'=>'required|callback_validar_fecha_horarios'
            ),
            array(
                'field'=>'turno1am',
                'label'=>'turno 1 de la mañana',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno2am',
                'label'=>'turno 2 de la mañana',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno3am',
                'label'=>'turno 3 de la mañana',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno4am',
                'label'=>'turno 4 de la mañana',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno5am',
                'label'=>'turno 5 de la mañana',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno6am',
                'label'=>'turno 6 de la mañana',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno7am',
                'label'=>'turno 7 de la mañana',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno8am',
                'label'=>'turno 8 de la mañana',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno1pm',
                'label'=>'turno 1 de la tarde',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno2pm',
                'label'=>'turno 2 de la tarde',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno3pm',
                'label'=>'turno 3 de la tarde',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno4pm',
                'label'=>'turno 4 de la tarde',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno5pm',
                'label'=>'turno 5 de la tarde',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno6pm',
                'label'=>'turno 6 de la tarde',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'turno7pm',
                'label'=>'turno 7 de la tarde',
                'rules'=>'trim|required'
            )
        );
        $this->form_validation->set_rules($config);
    }
    
    public function validar_fecha_horarios($fecha_horarios){
        $this->load->model('Horarios_model');
        if($this->Horarios_model->existeFechaHorarios($fecha_horarios)){
            $this->form_validation->set_message('validar_fecha_horarios', 'La fecha ' .$fecha_horarios. ' ya está registrada');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function paginar(){
        $this->load->model('Horarios_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/horarios/index';
        $opciones['total_rows'] = $this->Horarios_model->numeroHorarios();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Horarios_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        //$this->load->view('Datos_pacientes_view',$data);
        $this->load->view('folder_horarios/cabecera_horarios_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_horarios/horarios_view',$data);
        $this->load->view('footer_view');
    }
    
    public function exportar_word(){
        $this->load->library('word');
        $this->load->model('Horarios_model');
        //our docx will have 'landscape' paper orientation
        //our docx will have 'portrait' paper orientation
        $section = $this->word->createSection(array('orientation'=>'portrait'));
//        $section->addImage('http://localhost/codeoptica/imagenes/logo.jpg',array('width'=>210, 'height'=>210, 'align'=>'center'));
//        $section->addTextBreak(2);
        
        //Titulo Ocean Optical
//        $estiloFuenteTitulo = array('bold'=>true, 'italic'=>true, 'size'=>34);
//        $estiloParrafoTitulo = array('align'=>'center', 'spaceAfter'=>100);
//        $section->addText('Ocean Optical', $estiloFuenteTitulo, $estiloParrafoTitulo);
        $section->addImage(
            'C:\wamp\www\codeoptica\imagenes\logo.jpg',
            array(
                'width' => 500,
                'height' => 70,
                'wrappingStyle' => 'behind',
                'align' => 'center'
            )
        );
        //Titulo Ocean Optical
        
        //Tipo, fecha y hora
        $estiloFuenteTipoFechaHora = array('bold'=>true, 'italic'=>true, 'size'=>10);
        $estiloParrafoTipoFechaHora = array('align'=>'right');
        $section->addText('Reporte realizado el '.date("d-m-Y"). ' a las '.  date("H:i:s"), $estiloFuenteTipoFechaHora, $estiloParrafoTipoFechaHora);
        $section->addText(' ');
//        $section->addText(' ');
//        $section->addText('Tipo de usuario: Medico', $estiloFuenteTipoFechaHora);
//        $section->addText('Fecha: '.date("d-m-Y"), $estiloFuenteTipoFechaHora);
//        $section->addText('Hora: '.date("H:i:s"), $estiloFuenteTipoFechaHora);
//        $section->addText(' ');
        //Tipo, fecha y hora

        //Lista de pacientes
        $estiloFuenteLista = array('bold'=>true, 'italic'=>true, 'size'=>18);
        $estiloParrafoLista = array('align'=>'center');
        $section->addText('Lista de horarios y turnos', $estiloFuenteLista, $estiloParrafoLista);
        //Lista de pacientes

        // Define table style arrays
        $styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
        $styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');
		
        // Define cell style arrays
        $styleCell = array('valign'=>'center');
        $styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);
		
        // Define font style for first row
        $fontStyle = array('bold'=>true, 'align'=>'center');
		
        // Add table style
        $this->word->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);
		
        // Add table
        $table = $section->addTable('myOwnTableStyle');
		
        // Add row
        $table->addRow(900);
		
        // Add cells
        $table->addCell(500, $styleCell)->addText('ID', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Fecha', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Total de turnos', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Disponibles', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Reservados', $fontStyle);
        
        //Obtenemos el numero de filas de la tabla seleccionada
        $contenido = $this->Horarios_model->obtenerResultadosExportarWord();
        //Obtenemos el numero de filas de la tabla seleccionada
        
        
        //Recorremos la tabla
        for ($row = 0; $row < count($this->Horarios_model->numeroHorarios()); $row++){
            //Agregamos una fila por cada recorrido 
            
            //Recorremos el array y asignamos sus valores correspondientes
            foreach ($contenido as $result){
                $table->addRow();
                $table->addCell(500)->addText(htmlspecialchars($result['id_horarios']));
                $table->addCell(2000)->addText(htmlspecialchars($result['fecha_horarios']));
                $table->addCell(2000)->addText(htmlspecialchars($result['total_turnos']));
                $table->addCell(2000)->addText(htmlspecialchars($result['disponibles']));
                $table->addCell(2000)->addText(htmlspecialchars($result['reservados']));
            }
            //Recorremos el array y asignamos sus valores correspondientes
        }
        //Recorremos la tabla
        
        //Creamos y guardamos el documento
        //$filename='Lista_Horarios_Turnos.docx'; //save our document as this file name
        $filename="Lista_Horarios_Turnos_".date("d-m-Y").".docx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPWord_IOFactory::createWriter($this->word, 'Word2007');
        $objWriter->save('php://output');
        //Creamos y guardamos el documento
    }
    
    public function exportar_word_id(){
        $this->load->library('word');
        $id = $this->uri->segment('3');
        $this->load->model('Horarios_model');
        //our docx will have 'landscape' paper orientation
        //our docx will have 'portrait' paper orientation
        $section = $this->word->createSection(array('orientation'=>'portrait'));
//        $section->addImage('http://localhost/codeoptica/imagenes/logo.jpg',array('width'=>210, 'height'=>210, 'align'=>'center'));
//        $section->addTextBreak(2);
        
        //Titulo Ocean Optical
//        $estiloFuenteTitulo = array('bold'=>true, 'italic'=>true, 'size'=>34);
//        $estiloParrafoTitulo = array('align'=>'center', 'spaceAfter'=>100);
//        $section->addText('Ocean Optical', $estiloFuenteTitulo, $estiloParrafoTitulo);
        $section->addImage(
            'C:\wamp\www\codeoptica\imagenes\logo.jpg',
            array(
                'width' => 500,
                'height' => 70,
                'wrappingStyle' => 'behind',
                'align' => 'center'
            )
        );
        //Titulo Ocean Optical
        
        //Tipo, fecha y hora
//        $estiloFuenteTipoFechaHora = array('bold'=>true, 'italic'=>true, 'size'=>12);
//        $section->addText(' ');
//        $section->addText('Tipo de usuario: Medico', $estiloFuenteTipoFechaHora);
//        $section->addText('Fecha: '.date("d-m-Y"), $estiloFuenteTipoFechaHora);
//        $section->addText('Hora: '.date("H:i:s"), $estiloFuenteTipoFechaHora);
//        $section->addText(' ');
        $estiloFuenteTipoFechaHora = array('bold'=>true, 'italic'=>true, 'size'=>10);
        $estiloParrafoTipoFechaHora = array('align'=>'right');
        $section->addText('Reporte realizado el '.date("d-m-Y"). ' a las '.  date("H:i:s"), $estiloFuenteTipoFechaHora, $estiloParrafoTipoFechaHora);
        $section->addText(' ');
        //Tipo, fecha y hora

        //Horario y turnos de fecha
        $estiloFuentePerfil = array('bold'=>true, 'italic'=>true, 'size'=>18);
        $estiloParrafoPerfil = array('align'=>'center');
        $section->addText(' ', $estiloFuentePerfil);
        $section->addText('Horario y turnos de fecha seleccionada', $estiloFuentePerfil, $estiloParrafoPerfil);
        //Horario y turnos de fecha

        //Obtenemos el numero de filas de la tabla seleccionada
        $contenido = $this->Horarios_model->obtenerResultadosExportarWord_ID($id);
        //Obtenemos el numero de filas de la tabla seleccionada
        $estiloFuenteContenidoTitulo = array('bold'=>true, 'italic'=>true, 'size'=>12);
        $estiloFuenteContenido = array('bold'=>false, 'italic'=>true, 'size'=>12);
        
        //Recorremos los datos
        $section->addText(' ', $estiloFuenteContenidoTitulo);
        foreach ($contenido as $result){
            $section->addText('ID: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['id_horarios'], $estiloFuenteContenido);
            $section->addText('Medico: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['nombresMedi'], $estiloFuenteContenido);
            $section->addText('Fecha: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['fecha_horarios'], $estiloFuenteContenido);
            $section->addText('Total de turnos: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['total_turnos'], $estiloFuenteContenido);
            $section->addText('Turnos disponibles: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['disponibles'], $estiloFuenteContenido);
            $section->addText('Turnos reservados: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['reservados'], $estiloFuenteContenido);
            $fecha=$result['fecha_horarios'];
        }
        //Recorremos los datos
        
        //Creamos y guardamos el documento
        //$filename='Horario_Turnos_Fecha.docx'; //save our document as this file name
        $filename="Horario_Turnos_Fecha_".$fecha.".docx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPWord_IOFactory::createWriter($this->word, 'Word2007');
        $objWriter->save('php://output');
        //Creamos y guardamos el documento
    }
    
    public function exportar_excel(){    
        $this->load->library('excel');
//        $nombresUsu = ($this->session->userdata['logged_in']['nombresUsu']);
        $gdImage = imagecreatefromjpeg(base_url()."imagenes/logo.jpg");
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('logo');$objDrawing->setDescription('logo');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(48);
        $objDrawing->setCoordinates('B1');
        $objDrawing->setWorksheet($this->excel->getActiveSheet());
        
        //Cabecera del reporte
        //Se establece un valor dentro de la o las celdas especificadas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('B3','Reporte realizado el '.date("d-m-Y").' a las '.date("H:i:s").'');
        //Negrita
        $this->excel->getActiveSheet()->getStyle("B3")->getFont()->setBold(true)
                //Tamaño
                ->setSize(8);
        //Combinar celdas
        $this->excel->setActiveSheetIndex(0)
                ->mergeCells('B3:F3');
        //Alineación izquierda, derecha o centro
        $this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        //Cabecera del reporte
        
        //Titulo Lista de horarios y turnos
        $this->excel->setActiveSheetIndex(0)->setCellValue('B5','Lista de horarios y turnos');
        $this->excel->getActiveSheet()->getStyle("B5")->getFont()->setBold(true)
                ->setSize(18);
        $this->excel->setActiveSheetIndex(0)->mergeCells('B5:F5');
        $this->excel->getActiveSheet()->getStyle('B5')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        //Titulo Lista de horarios y turnos
                    
        //Datos array
        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('B7','ID')
            ->setCellValue('C7','Fecha')
            ->setCellValue('D7','Total de turnos')
            ->setCellValue('E7','Disponibles')
            ->setCellValue('F7','Reservados');
        $this->excel->getActiveSheet()->getStyle("B7:F7")->getFont()->setBold(true);
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->excel->getActiveSheet()->getStyle('B7:F7')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setTitle('Lista de horarios y turnos')
            ->getColumnDimension('B')
                ->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('C')
                ->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('D')
                ->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('E')
                ->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('F')
                ->setAutoSize(TRUE);
        $this->load->database();
        $this->load->model('Horarios_model');
        $horarios = $this->Horarios_model->obtenerResultadosExportarExcel();
        $this->excel->getActiveSheet()->fromArray($horarios, null, 'B8');
        
        //Datos array
        
        //Archivo descargado
        //$filename='Lista_Horarios_Turnos.xls';
        $filename="Lista_Horarios_Turnos_".date("d-m-Y").".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
        //Archivo descargado
    }
    
    public function exportar_excel_id(){
        $this->load->library('excel');
        $id = $this->uri->segment('3');
        $gdImage = imagecreatefromjpeg(base_url()."imagenes/logo.jpg");
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('logo');$objDrawing->setDescription('logo');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(49);
        $objDrawing->setCoordinates('B1');
        $objDrawing->setWorksheet($this->excel->getActiveSheet());
        
        //Cabecera del reporte
        //Se establece un valor dentro de la o las celdas especificadas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('B4','Reporte realizado el '.date("d-m-Y").' a las '.date("H:i:s").'');
        //Negrita
        $this->excel->getActiveSheet()->getStyle("B4")->getFont()->setBold(true)
                //Tamaño
                ->setSize(8);
        //Combinar celdas
        $this->excel->setActiveSheetIndex(0)
                ->mergeCells('B4:F4');
        //Alineación izquierda, derecha o centro
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        //Cabecera del reporte
        
        //Titulo Horario y turnos de fecha seleccionada
        $this->excel->setActiveSheetIndex(0)->setCellValue('B6','Horario y turnos de fecha seleccionada');
        $this->excel->getActiveSheet()->getStyle("B6")->getFont()->setBold(true)
                ->setSize(18);
        $this->excel->setActiveSheetIndex(0)->mergeCells('B6:F6');
        $this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        //Titulo Horario y turnos de fecha seleccionada
                    
        //Datos array
        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('B8','ID:')
                ->mergeCells('C8:F8')
            ->setCellValue('B9','Medico:')
                ->mergeCells('C9:F9')
            ->setCellValue('B10','Fecha:')
                ->mergeCells('C10:F10')
            ->setCellValue('B11','Total de turnos:')
                ->mergeCells('C11:F11')
            ->setCellValue('B12','Turnos disponibles:')
                ->mergeCells('C12:F12')
            ->setCellValue('B13','Turnos reservados:')
                ->mergeCells('C13:F13');
        
        $this->excel->getActiveSheet()->getStyle("B8:B13")->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->setTitle('Hor. y tur. fec. seleccionada')
            ->getColumnDimension('B')
                ->setAutoSize(TRUE);
        $this->load->database();
        $this->load->model('Horarios_model');
        $horarios = $this->Horarios_model->obtenerResultadosExportarExcel_ID($id);
        foreach ($horarios as $result){
            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('C8',$result['id_horarios'])
            ->setCellValue('C9',$result['nombresMedi'])
            ->setCellValue('C10',$result['fecha_horarios'])
            ->setCellValue('C11',$result['total_turnos'])
            ->setCellValue('C12',$result['disponibles'])
            ->setCellValue('C13',$result['reservados']);
            $fecha=$result['fecha_horarios'];
        }
        $this->excel->getActiveSheet()->getStyle('C8:C13')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        //Datos array
        
        //Archivo descargado
        //$filename="horario_turnos_fecha_id.xls";
        $filename="Horario_Turnos_Fecha_".$fecha.".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
        //Archivo descargado
    }
    
    public function exportar_pdf(){
        $this->load->model('Horarios_model');
        $data['title']='Lista de horarios y turnos'; 
        $data['author']='Medico';
	$data['subject']='Lista_horarios_turno'; 	 
	$data['content']= $this->Horarios_model->obtenerResultadosExportarPDF();
	$this->load->view('folder_horarios/horarios_exportar_pdf',$data);
    }
    
    public function exportar_pdf_id(){
        $this->load->model('Horarios_model');
        $id = $this->uri->segment('3');
        $data['title']='Horario y turnos de fecha seleccionada';
        $data['author']='Medico';
	$data['subject']='Horario_turnos_fecha_seleccionada';
	$data['content']= $this->Horarios_model->obtenerResultadosExportarPDF_ID($id);
	$this->load->view('folder_horarios/horarios_exportar_pdf_id',$data);
    }
    
}