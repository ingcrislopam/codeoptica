<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservaciones extends CI_Controller{
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
        $this->load->model('Reservaciones_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/reservaciones/index';
        $opciones['total_rows'] = $this->Reservaciones_model->numeroReservaciones();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Reservaciones_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_reservaciones/cabecera_reservaciones_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_reservaciones/reservaciones_view',$data);
        $this->load->view('footer_view');
    }
    
    public function insertar_reservacion_view(){
        $this->load->helper('form');
        $this->load->model('Reservaciones_model');
        $data['pacientes'] = $this->Reservaciones_model->obtenerPacientes();
        $data['horarios'] = $this->Reservaciones_model->obtenerHorarios();
        $this->load->view('folder_reservaciones/cabecera_reservaciones_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_reservaciones/reservaciones_insertar',$data);
        $this->load->view('footer_view');
    }
    
    public function insertar_reservacion(){
        $this->load->model('Reservaciones_model');
        $this->reglas_validacion();
        if($this->form_validation->run()==FALSE){
            $this->insertar_reservacion_view();
        }
        else{
            $data = array(
                'id_pacientes' => $this->input->post('id_pacientes'),
                'id_horarios' => $this->input->post('id_horarios'),
                'id_turnos' => $this->input->post('id_turnos'),
                'estadoReser' => 2
            );
            $this->Reservaciones_model->insertarReservacion($data);
            redirect('index.php/reservaciones/paginar');
        }
    }
    
    public function reglas_validacion(){
        $config = array(
            array(
                'field'=>'id_pacientes',
                'label'=>'paciente',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'id_horarios',
                'label'=>'horario',
                'rules'=>'trim|required|callback_validar_reservacion'
            ),
            array(
                'field'=>'id_turnos',
                'label'=>'turno',
                'rules'=>'required'
            )
        );
        $this->form_validation->set_rules($config);
    }
    
    public function validar_reservacion($id_horarios){
        $this->load->model('Reservaciones_model');
        if($this->Reservaciones_model->reservacionValida($id_horarios)){
            $this->form_validation->set_message('validar_reservacion', 'El horario es invalido porque expiró');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function buscar_reservacion_view(){
        $this->load->model('Reservaciones_model');
        $this->load->library('pagination');
        $busqueda = $this->input->post('busqueda');
        $parametro = $this->input->post('parametro');
        $parametroH = $this->input->post('parametroH');
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/reservaciones/index';
        $opciones['total_rows'] = $this->Reservaciones_model->numeroReservacionesBusqueda($busqueda,$parametro,$parametroH);
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Reservaciones_model->mostrarResultadosBusqueda($opciones['per_page'],$desde,$busqueda,$parametro,$parametroH);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_reservaciones/cabecera_reservaciones_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_reservaciones/reservaciones_view',$data);
        $this->load->view('footer_view');
    }

    public function eliminar_reservacion(){
        $this->load->model('Reservaciones_model'); 
        $id = $this->uri->segment('3');	
        $this->Reservaciones_model->eliminarReservacion($id);
        redirect('index.php/reservaciones/paginar');
    }
    
    public function fillTurnos() {
        $id_horarios = $this->input->post('id_horarios');
        if($id_horarios){
            $this->load->model('Reservaciones_model');
            $turnos = $this->Reservaciones_model->obtenerTurnos($id_horarios);
            echo '<option value="">Seleccione</option>';
            foreach($turnos as $fila){
                echo '<option value="'. $fila->id_turnos .'">'. $fila->hora_inicio .' - '. $fila->hora_fin .'</option>';
            }
        }  
        else {
            echo '<option value="">No hay turnos disponibles</option>';
        }
    }
    
    public function paginar(){
        $this->load->model('Reservaciones_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/reservaciones/index';
        $opciones['total_rows'] = $this->Reservaciones_model->numeroReservaciones();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Reservaciones_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_reservaciones/cabecera_reservaciones_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_reservaciones/reservaciones_view',$data);
        $this->load->view('footer_view');
    }
    
    public function exportar_word(){
        $this->load->library('word');
        $this->load->model('Reservaciones_model');
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
//        $section->addText(' ');
//        $section->addText(' ');
//        $section->addText('Tipo de usuario: Recepcionista', $estiloFuenteTipoFechaHora);
//        $section->addText('Fecha: '.date("d-m-Y"), $estiloFuenteTipoFechaHora);
//        $section->addText('Hora: '.date("H:i:s"), $estiloFuenteTipoFechaHora);
//        $section->addText(' ');
        $section->addText('Reporte realizado el '.date("d-m-Y"). ' a las '.  date("H:i:s"), $estiloFuenteTipoFechaHora, $estiloParrafoTipoFechaHora);
        $section->addText(' ');
        //Tipo, fecha y hora

        //Lista de reservaciones
        $estiloFuenteLista = array('bold'=>true, 'italic'=>true, 'size'=>18);
        $estiloParrafoLista = array('align'=>'center');
        $section->addText('Lista de reservaciones', $estiloFuenteLista, $estiloParrafoLista);
        //Lista de reservaciones

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
        $table->addCell(2000, $styleCell)->addText('Paciente', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Fecha', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Turno', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Estado', $fontStyle);
        
        //Obtenemos el numero de filas de la tabla seleccionada
        $contenido = $this->Reservaciones_model->obtenerResultadosExportarWord();
        //Obtenemos el numero de filas de la tabla seleccionada
        
        
        //Recorremos la tabla
        for ($row = 0; $row < count($this->Reservaciones_model->numeroReservaciones()); $row++){
            //Agregamos una fila por cada recorrido 
            
            //Recorremos el array y asignamos sus valores correspondientes
            foreach ($contenido as $result){
                $table->addRow();
                $table->addCell(500)->addText(htmlspecialchars($result['id_reservaciones']));
                $table->addCell(2000)->addText(htmlspecialchars($result['nombresPacien']));
                $table->addCell(2000)->addText(htmlspecialchars($result['fecha_horarios']));
                $table->addCell(2000)->addText(htmlspecialchars($result['turno']));
                $table->addCell(2000)->addText(htmlspecialchars($result['estado_reser']));
            }
            //Recorremos el array y asignamos sus valores correspondientes
        }
        //Recorremos la tabla
        
        //Creamos y guardamos el documento
        //$filename='Lista_Reservaciones.docx'; //save our document as this file name
        $filename="Lista_Reservaciones_Fecha_".date("d-m-Y").".docx";
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
        $this->load->model('Reservaciones_model');
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
//        $section->addText(' ');
//        $section->addText('Tipo de usuario: Recepcionista', $estiloFuenteTipoFechaHora);
//        $section->addText('Fecha: '.date("d-m-Y"), $estiloFuenteTipoFechaHora);
//        $section->addText('Hora: '.date("H:i:s"), $estiloFuenteTipoFechaHora);
//        $section->addText(' ');
        $section->addText('Reporte realizado el '.date("d-m-Y"). ' a las '.  date("H:i:s"), $estiloFuenteTipoFechaHora, $estiloParrafoTipoFechaHora);
        $section->addText(' ');
        //Tipo, fecha y hora

        //Reservacion del paciente
        $estiloFuentePerfil = array('bold'=>true, 'italic'=>true, 'size'=>18);
        $estiloParrafoPerfil = array('align'=>'center');
        $section->addText(' ', $estiloFuentePerfil);
        $section->addText('Reservacion del paciente', $estiloFuentePerfil, $estiloParrafoPerfil);
        //Reservacion del paciente

        //Obtenemos el numero de filas de la tabla seleccionada
        $contenido = $this->Reservaciones_model->obtenerResultadosExportarWord_ID($id);
        //Obtenemos el numero de filas de la tabla seleccionada
        $estiloFuenteContenidoTitulo = array('bold'=>true, 'italic'=>true, 'size'=>12);
        $estiloFuenteContenido = array('bold'=>false, 'italic'=>true, 'size'=>10);
        
        //Recorremos los datos
        $section->addText(' ', $estiloFuenteContenidoTitulo);
        foreach ($contenido as $result){
            $section->addText('ID: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['id_reservaciones'], $estiloFuenteContenido);
            $section->addText('Paciente: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['nombresPacien'], $estiloFuenteContenido);
            $section->addText('Fecha: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['fecha_horarios'], $estiloFuenteContenido);
            $section->addText('Turno: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['turno'], $estiloFuenteContenido);
            $section->addText('Estado: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['estado_reser'], $estiloFuenteContenido);
            $nomPacien=$result['nombresPacien'];
            $fechaReser=$result['fecha_horarios'];
        }
        //Recorremos los datos
        
        //Creamos y guardamos el documento
        //$filename='Reservacion_del_paciente.docx'; //save our document as this file name
        $filename="Reservacion_Paciente_".$nomPacien."_Fecha_".$fechaReser.".docx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPWord_IOFactory::createWriter($this->word, 'Word2007');
        $objWriter->save('php://output');
        //Creamos y guardamos el documento
    }
    
    public function exportar_excel(){
        $this->load->library('excel');
        //Agregar imagen
        $gdImage = imagecreatefromjpeg(base_url()."imagenes/logo.jpg");
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('logo');$objDrawing->setDescription('logo');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(49);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($this->excel->getActiveSheet());
        //Agregar imagen
        
//        //Datos autor y fecha
//        $this->excel->setActiveSheetIndex(0)
//            ->setCellValue('A5','Fecha de reporte:')
//            ->setCellValue('C5',date("d-m-Y"))
//            ->setCellValue('A6','Hora de reporte:')
//            ->setCellValue('C6',date("H:i:s"));
//        $this->excel->getActiveSheet()->getStyle("A5:A6")->getFont()->setBold(true)
//                ->setSize(11);
//        $this->excel->setActiveSheetIndex(0)->mergeCells('A5:B5');
//        $this->excel->setActiveSheetIndex(0)->mergeCells('A6:B6');
//        //Datos autor y fecha
        
        //Cabecera del reporte
        //Se establece un valor dentro de la o las celdas especificadas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A4','Reporte realizado el '.date("d-m-Y").' a las '.date("H:i:s").'');
        //Negrita
        $this->excel->getActiveSheet()->getStyle("A4")->getFont()->setBold(true)
                //Tamaño
                ->setSize(8);
        //Combinar celdas
        $this->excel->setActiveSheetIndex(0)
                ->mergeCells('A4:E4');
        //Alineación izquierda, derecha o centro
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        //Cabecera del reporte
        
        //Titulo Lista de reservaciones
        $this->excel->setActiveSheetIndex(0)->setCellValue('A6','Lista de reservaciones');
        $this->excel->getActiveSheet()->getStyle("A6")->getFont()->setBold(true)
                ->setSize(18);
        $this->excel->setActiveSheetIndex(0)->mergeCells('A6:E6');
        $this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        //Titulo Lista de reservaciones
                    
        //Datos array
        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A8','ID')
            ->setCellValue('B8','Paciente')
            ->setCellValue('C8','Fecha')
            ->setCellValue('D8','Turno')
            ->setCellValue('E8','Estado');
        $this->excel->getActiveSheet()->getStyle("A8:E8")->getFont()->setBold(true);
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->excel->getActiveSheet()->getStyle('A8:E8')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setTitle('Lista de reservaciones')
            ->getColumnDimension('A')
                ->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('B')
                ->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('C')
                ->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('D')
                ->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('E')
                ->setAutoSize(TRUE);
        $this->load->database();
        $this->load->model('Reservaciones_model');
        $reservaciones = $this->Reservaciones_model->obtenerResultadosExportarExcel();
        $this->excel->getActiveSheet()->fromArray($reservaciones, null, 'A9');
        //Datos array
        
        //Archivo descargado
        //$filename='Lista_Reservaciones.xls';
        $filename="Lista_Reservaciones_Fecha_".date("d-m-Y").".xls";
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
        
//        //Datos autor y fecha
//        $this->excel->setActiveSheetIndex(0)
//            ->setCellValue('B5','Fecha de reporte:')
//            ->setCellValue('C5',date("d-m-Y"))
//            ->setCellValue('B6','Hora de reporte:')
//            ->setCellValue('C6',date("H:i:s"));
//        $this->excel->getActiveSheet()->getStyle("B5:B6")->getFont()->setBold(true)
//                ->setSize(11);
//        //Datos autor y fecha
        
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
        
        //Titulo Reservacion del paciente
        $this->excel->setActiveSheetIndex(0)->setCellValue('B6','Reservacion del paciente');
        $this->excel->getActiveSheet()->getStyle("B6")->getFont()->setBold(true)
                ->setSize(18);
        $this->excel->setActiveSheetIndex(0)->mergeCells('B6:F6');
        $this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        //Titulo Reservacion del paciente
                    
        //Datos array
        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('B8','ID:')
                ->mergeCells('C8:F8')
            ->setCellValue('B9','Paciente:')
                ->mergeCells('C9:F9')
            ->setCellValue('B10','Fecha:')
                ->mergeCells('C10:F10')
            ->setCellValue('B11','Turno:')
                ->mergeCells('C11:F11')
            ->setCellValue('B12','Estado:')
                ->mergeCells('C12:F12');
        
        $this->excel->getActiveSheet()->getStyle("B8:B12")->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->setTitle('Reservacion del paciente')
            ->getColumnDimension('B')
                ->setAutoSize(TRUE);
        $this->load->database();
        $this->load->model('Reservaciones_model');
        $reservaciones = $this->Reservaciones_model->obtenerResultadosExportarExcel_ID($id);
        foreach ($reservaciones as $result){
            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('C8',$result['id_reservaciones'])
            ->setCellValue('C9',$result['nombresPacien'])
            ->setCellValue('C10',$result['fecha_horarios'])
            ->setCellValue('C11',$result['turno'])
            ->setCellValue('C12',$result['estado_reser']);
            $nomPacien=$result['nombresPacien'];
            $fechaReser=$result['fecha_horarios'];
        }
        $this->excel->getActiveSheet()->getStyle('C8:C12')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        //Datos array
        
        //Archivo descargado
        //$filename="reservacion_paciente_id.xls";
        $filename="Reservacion_Paciente_".$nomPacien."_Fecha_".$fechaReser.".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
        //Archivo descargado
    }
    
    public function exportar_pdf(){
        $this->load->model('Reservaciones_model');
        $data['title']='Lista de reservaciones'; 
        $data['author']='Recepcionista';
	$data['subject']='Lista de reservaciones'; 	 
	$data['content']= $this->Reservaciones_model->obtenerResultadosExportarPDF();
	$this->load->view('folder_reservaciones/reservaciones_exportar_pdf',$data);
    }
    
    public function exportar_pdf_id(){
        $this->load->model('Reservaciones_model');
        $id = $this->uri->segment('3');
        $data['title']='Reservacion del paciente'; 
        $data['author']='Recepcionista';
	$data['subject']='Reservacion del paciente';	 
	$data['content']= $this->Reservaciones_model->obtenerResultadosExportarPDF_ID($id);
	$this->load->view('folder_reservaciones/reservaciones_exportar_pdf_id',$data);
    }
    
}