<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datos_pacientes extends CI_Controller{
    
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
        $this->load->model('Datos_pacientes_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/datos_pacientes/index';
        $opciones['total_rows'] = $this->Datos_pacientes_model->numeroDatosPacientes();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Datos_pacientes_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_datos_pacientes/cabecera_datos_pacientes_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_datos_pacientes/datos_pacientes_view',$data);
        $this->load->view('footer_view');
    }
    
    public function insertar_datos_paciente_view(){
        $this->load->helper('form');
        $this->load->model('Datos_pacientes_model');
        $data['pacientes'] = $this->Datos_pacientes_model->obtenerPacientes();
        $this->load->view('folder_datos_pacientes/cabecera_datos_pacientes_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_datos_pacientes/datos_pacientes_insertar',$data);
        $this->load->view('footer_view');
    }
    
    public function insertar_datos_paciente(){
        $this->load->model('Datos_pacientes_model');
        $this->reglas_validacion();
        if($this->form_validation->run()==FALSE){
            $this->insertar_datos_paciente_view();
        }
        else{
            $data = array(
                'id_pacientes' => $this->input->post('id_pacientes'),
                'cedula' => $this->input->post('cedula'),
                'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
                'sexo' => $this->input->post('sexo'),
                'ciudad' => $this->input->post('ciudad'),
                'direccion' => $this->input->post('direccion'),
                'correo' => $this->input->post('correo')    
            );
            $this->Datos_pacientes_model->insertarDatosPaciente($data);
            redirect('index.php/datos_pacientes/paginar');
        }
    }
    
    public function buscar_datos_paciente_view(){
        $this->load->model('Datos_pacientes_model');
        $this->load->library('pagination');
        $busqueda = $this->input->post('busqueda');
        $parametro = $this->input->post('parametro');
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/datos_pacientes/index';
        $opciones['total_rows'] = $this->Datos_pacientes_model->numeroDatosPacientesBusqueda($busqueda,$parametro);
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Datos_pacientes_model->mostrarResultadosBusqueda($opciones['per_page'],$desde,$busqueda,$parametro);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_datos_pacientes/cabecera_datos_pacientes_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_datos_pacientes/datos_pacientes_view',$data);
        $this->load->view('footer_view');
    }
    
    public function editar_datos_paciente_view(){
        $this->load->helper('form');
        $id = $this->uri->segment('3');
        $this->load->model('Datos_pacientes_model');
        $query = $this->db->get_where("datos_pacientes",array("id_datos_pacientes"=>$id));
        $data['pacientes'] = $this->Datos_pacientes_model->obtenerPacientesID($id);
        $data['datos'] = $query->result(); 
        $data['old_id'] = $id; 
        $this->load->view('folder_datos_pacientes/cabecera_datos_pacientes_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_datos_pacientes/datos_pacientes_editar',$data);
        $this->load->view('footer_view');
    }
    
    public function editar_datos_paciente(){
        $this->load->model('Datos_pacientes_model');	
        $data = array(
            'id_pacientes' => $this->input->post('id_pacientes'),
            'cedula' => $this->input->post('cedula'),
            'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
            'sexo' => $this->input->post('sexo'),
            'ciudad' => $this->input->post('ciudad'),
            'direccion' => $this->input->post('direccion'),
            'correo' => $this->input->post('correo')
        );		
        $old_id = $this->input->post('old_id'); 
        $this->Datos_pacientes_model->editarDatosPaciente($data,$old_id);
        redirect('index.php/datos_pacientes/paginar');
    }
    
    public function eliminar_datos_paciente(){
        $this->load->model('Datos_pacientes_model'); 
        $id = $this->uri->segment('3'); 
        $this->Datos_pacientes_model->eliminarDatosPaciente($id);
        redirect('index.php/datos_pacientes/paginar');
    }
    
    public function reglas_validacion(){
        $config = array(
            array(
                'field'=>'cedula',
                'label'=>'cedula',
                'rules'=>'trim|required|numeric|min_length[10]|max_length[10]|callback_validar_cedula'
            ),
            array(
                'field'=>'fecha_nacimiento',
                'label'=>'fecha de nacimiento',
                'rules'=>'required'
            ),
            array(
                'field'=>'sexo',
                'label'=>'sexo',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'ciudad',
                'label'=>'ciudad',
                'rules'=>'required'
            ),
            array(
                'field'=>'direccion',
                'label'=>'direccion',
                'rules'=>'required'
            ),
            array(
                'field'=>'correo',
                'label'=>'correo',
                'rules'=>'trim|valid_email|callback_validar_correo'
            ),
        );
        $this->form_validation->set_rules($config);
    }
    
    public function validar_cedula($cedula){
        $this->load->model('Datos_pacientes_model');
        if($this->Datos_pacientes_model->existeCedula($cedula)){
            $this->form_validation->set_message('validar_cedula', 'La cedula ' .$cedula. ' ya está registrada');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function validar_correo($correo){
        $this->load->model('Datos_pacientes_model');
        if($this->Datos_pacientes_model->existeCorreo($correo)){
            $this->form_validation->set_message('validar_correo', 'El correo ' .$correo. ' ya está registrado');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function paginar(){
        $this->load->model('Datos_pacientes_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/datos_pacientes/index';
        $opciones['total_rows'] = $this->Datos_pacientes_model->numeroDatosPacientes();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Datos_pacientes_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_datos_pacientes/cabecera_datos_pacientes_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_datos_pacientes/datos_pacientes_view',$data);
        $this->load->view('footer_view');
    }
    
    public function exportar_word(){
        $this->load->library('word');
        $this->load->model('Datos_pacientes_model');
        //our docx will have 'landscape' paper orientation
        //our docx will have 'portrait' paper orientation
        $section = $this->word->createSection(array('orientation'=>'landscape'));
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
//        $section->addText('Tipo de usuario: Medico', $estiloFuenteTipoFechaHora);
//        $section->addText('Fecha: '.date("d-m-Y"), $estiloFuenteTipoFechaHora);
//        $section->addText('Hora: '.date("H:i:s"), $estiloFuenteTipoFechaHora);
//        $section->addText(' ');
        $section->addText('Reporte realizado el '.date("d-m-Y"). ' a las '.  date("H:i:s"), $estiloFuenteTipoFechaHora, $estiloParrafoTipoFechaHora);
        $section->addText(' ');
        //Tipo, fecha y hora

        //Lista de perfiles de pacientes
        $estiloFuenteLista = array('bold'=>true, 'italic'=>true, 'size'=>18);
        $estiloParrafoLista = array('align'=>'center');
        $section->addText('Lista de perfiles de pacientes', $estiloFuenteLista, $estiloParrafoLista);
        //Lista de perfiles de pacientes

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
//        $table->addCell(2000, $styleCell)->addText('Medico', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Paciente', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Cedula', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Fecha de nacimiento', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Sexo', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Ciudad', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Direccion', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Correo', $fontStyle);
        
        //Obtenemos el numero de filas de la tabla seleccionada
        $contenido = $this->Datos_pacientes_model->obtenerResultadosExportarWord();
        //Obtenemos el numero de filas de la tabla seleccionada
        
        
        //Recorremos la tabla
        for ($row = 0; $row < count($this->Datos_pacientes_model->numeroDatosPacientes()); $row++){
            //Agregamos una fila por cada recorrido 
            
            //Recorremos el array y asignamos sus valores correspondientes
            foreach ($contenido as $result){
                $table->addRow();
                $table->addCell(500)->addText(htmlspecialchars($result['id_datos_pacientes']));
//                $table->addCell(2000)->addText(htmlspecialchars($result['nombresMedi']));
                $table->addCell(2000)->addText(htmlspecialchars($result['nombresPaci']));
                $table->addCell(2000)->addText(htmlspecialchars($result['cedula']));
                $table->addCell(2000)->addText(htmlspecialchars($result['fechaPaci']));
                $table->addCell(2000)->addText(htmlspecialchars($result['sexoPaci']));
                $table->addCell(2000)->addText(htmlspecialchars($result['ciudad']));
                $table->addCell(2000)->addText(htmlspecialchars($result['direccion']));
                $table->addCell(2000)->addText(htmlspecialchars($result['correoPaci']));
            }
            //Recorremos el array y asignamos sus valores correspondientes
        }
        //Recorremos la tabla
        
        //Creamos y guardamos el documento
        //$filename='Lista_Perfiles_Pacientes.docx'; //save our document as this file name
        $filename="Lista_Perfiles_Pacientes_".date("d-m-Y").".docx";
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
        $this->load->model('Datos_pacientes_model');
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
//        $section->addText('Tipo de usuario: Medico', $estiloFuenteTipoFechaHora);
//        $section->addText('Fecha: '.date("d-m-Y"), $estiloFuenteTipoFechaHora);
//        $section->addText('Hora: '.date("H:i:s"), $estiloFuenteTipoFechaHora);
//        $section->addText(' ');
        $section->addText('Reporte realizado el '.date("d-m-Y"). ' a las '.  date("H:i:s"), $estiloFuenteTipoFechaHora, $estiloParrafoTipoFechaHora);
        $section->addText(' ');
        //Tipo, fecha y hora

        //Perfil de administrador
        $estiloFuentePerfil = array('bold'=>true, 'italic'=>true, 'size'=>18);
        $estiloParrafoPerfil = array('align'=>'center');
        $section->addText(' ', $estiloFuentePerfil);
        $section->addText('Perfil del paciente', $estiloFuentePerfil, $estiloParrafoPerfil);
        //Perfil de administrador

        //Obtenemos el numero de filas de la tabla seleccionada
        $contenido = $this->Datos_pacientes_model->obtenerResultadosExportarWord_ID($id);
        //Obtenemos el numero de filas de la tabla seleccionada
        $estiloFuenteContenidoTitulo = array('bold'=>true, 'italic'=>true, 'size'=>12);
        $estiloFuenteContenido = array('bold'=>false, 'italic'=>true, 'size'=>12);
        
        //Recorremos los datos
        $section->addText(' ', $estiloFuenteContenidoTitulo);
        foreach ($contenido as $result){
            $section->addText('ID: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['id_datos_pacientes'], $estiloFuenteContenido);
//            $section->addText('Medico: ', $estiloFuenteContenidoTitulo);
//            $section->addText($result['nombresMedi'], $estiloFuenteContenido);
            $section->addText('Paciente: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['nombresPaci'], $estiloFuenteContenido);
            $section->addText('Cedula: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['cedula'], $estiloFuenteContenido);
            $section->addText('Fecha de nacimiento: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['fechaPaci'], $estiloFuenteContenido);
            $section->addText('Sexo: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['sexoPaci'], $estiloFuenteContenido);
            $section->addText('Ciudad: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['ciudad'], $estiloFuenteContenido);
            $section->addText('Direccion: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['direccion'], $estiloFuenteContenido);
            $section->addText('Correo: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['correoPaci'], $estiloFuenteContenido);
            $nomPacien=$result['nombresPaci'];
        }
        //Recorremos los datos
        
        //Creamos y guardamos el documento
        //$filename='Perfil_de_administrador.docx'; //save our document as this file name
        $filename="Perfil_Paciente_".$nomPacien.".docx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPWord_IOFactory::createWriter($this->word, 'Word2007');
        $objWriter->save('php://output');
        //Creamos y guardamos el documento
    }
    
    public function exportar_excel(){
        $this->load->library('excel');
        //$nombresUsu = ($this->session->userdata['logged_in']['nombresUsu']);
        $gdImage = imagecreatefromjpeg(base_url()."imagenes/logo.jpg");
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('logo');$objDrawing->setDescription('logo');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(70);
        $objDrawing->setCoordinates('B2');
        $objDrawing->setWorksheet($this->excel->getActiveSheet());
        //Datos autor y fecha
//        $this->excel->setActiveSheetIndex(0)
////            ->setCellValue('A5','Reporte realizado por:')
////            ->setCellValue('C5',$nombresUsu)
////            ->setCellValue('A6','Tipo de usuario:')
////            ->setCellValue('C6','Administrador')
//            ->setCellValue('A5','Fecha de reporte:')
//            ->setCellValue('C5',date("d-m-Y"))
//            ->setCellValue('A6','Hora de reporte:')
//            ->setCellValue('C6',date("H:i:s"));
//        $this->excel->getActiveSheet()->getStyle("A5:A6")->getFont()->setBold(true)
//                ->setSize(11);
//        $this->excel->setActiveSheetIndex(0)->mergeCells('A5:B5');
//        $this->excel->setActiveSheetIndex(0)->mergeCells('A6:B6');
//        $this->excel->setActiveSheetIndex(0)->mergeCells('A7:B7');
//        $this->excel->setActiveSheetIndex(0)->mergeCells('A8:B8');
        //Datos autor y fecha
        
        //Cabecera del reporte
        //Se establece un valor dentro de la o las celdas especificadas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A6','Reporte realizado el '.date("d-m-Y").' a las '.date("H:i:s").'');
        //Negrita
        $this->excel->getActiveSheet()->getStyle("A6")->getFont()->setBold(true)
                //Tamaño
                ->setSize(8);
        //Combinar celdas
        $this->excel->setActiveSheetIndex(0)
                ->mergeCells('A6:H6');
        //Alineación izquierda, derecha o centro
        $this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        //Cabecera del reporte
        
        //Titulo Lista de perfiles de pacientes
        $this->excel->setActiveSheetIndex(0)->setCellValue('A8','Lista de perfiles de pacientes');
        $this->excel->getActiveSheet()->getStyle("A8")->getFont()->setBold(true)
                ->setSize(18);
        $this->excel->setActiveSheetIndex(0)->mergeCells('A8:H8');
        $this->excel->getActiveSheet()->getStyle('A8')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        //Titulo Lista de perfiles de pacientes
                    
        //Datos array
        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A10','ID')
            ->setCellValue('B10','Paciente')
            ->setCellValue('C10','Cedula')
            ->setCellValue('D10','Fecha de nacimiento')
            ->setCellValue('E10','Sexo')
            ->setCellValue('F10','Ciudad')
            ->setCellValue('G10','Direccion')
            ->setCellValue('H10','Correo');
//            ->setCellValue('I10','Correo');
        $this->excel->getActiveSheet()->getStyle("A10:H10")->getFont()->setBold(true);
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->excel->getActiveSheet()->getStyle('A10:H10')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setTitle('Lista de perfiles de pacientes')
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
        $this->excel->getActiveSheet()->getColumnDimension('F')
                ->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('G')
                ->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('H')
                ->setAutoSize(TRUE);
//        $this->excel->getActiveSheet()->getColumnDimension('I')
//                ->setAutoSize(TRUE);
        $this->load->database();
        $this->load->model('Datos_pacientes_model');
        $datos_pacientes = $this->Datos_pacientes_model->obtenerResultadosExportarExcel();
        $this->excel->getActiveSheet()->fromArray($datos_pacientes, null, 'A11');
        
        //Datos array
        
        //Archivo descargado
        //$filename='Lista_Perfiles_Pacientes.xls';
        $filename="Lista_Perfiles_Pacientes_".date("d-m-Y").".xls";
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
        
        //Datos autor y fecha
//        $this->excel->setActiveSheetIndex(0)
//            ->setCellValue('B5','Fecha de reporte:')
//            ->setCellValue('C5',date("d-m-Y"))
//            ->setCellValue('B6','Hora de reporte:')
//            ->setCellValue('C6',date("H:i:s"));
//        $this->excel->getActiveSheet()->getStyle("B5:B6")->getFont()->setBold(true)
//                ->setSize(11);
        //Datos autor y fecha
        
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
        
        //Titulo Perfil completo del paciente
        $this->excel->setActiveSheetIndex(0)->setCellValue('B6','Perfil completo del paciente');
        $this->excel->getActiveSheet()->getStyle("B6")->getFont()->setBold(true)
                ->setSize(18);
        $this->excel->setActiveSheetIndex(0)->mergeCells('B6:F6');
        $this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        //Titulo Perfil completo del paciente
                    
        //Datos array
        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('B8','ID:')
                ->mergeCells('C8:F8')
            ->setCellValue('B9','Paciente:')
                ->mergeCells('C9:F9')
            ->setCellValue('B10','Cedula:')
                ->mergeCells('C10:F10')
            ->setCellValue('B11','Fecha de nacimiento:')
                ->mergeCells('C11:F11')
            ->setCellValue('B12','Sexo:')
                ->mergeCells('C12:F12')
            ->setCellValue('B13','Ciudad:')
                ->mergeCells('C13:F13')
            ->setCellValue('B14','Direccion:')
                ->mergeCells('C14:F14')
            ->setCellValue('B15','Correo:')
                ->mergeCells('C15:F15');
        
        $this->excel->getActiveSheet()->getStyle("B8:B15")->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->setTitle('Perfil completo del paciente')
            ->getColumnDimension('B')
                ->setAutoSize(TRUE);
        $this->load->database();
        $this->load->model('Datos_pacientes_model');
        $datos_pacientes = $this->Datos_pacientes_model->obtenerResultadosExportarExcel_ID($id);
        foreach ($datos_pacientes as $result){
            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('C8',$result['id_datos_pacientes'])
//            ->setCellValue('C11',$result['nombresMedi'])
            ->setCellValue('C9',$result['nombresPaci'])
            ->setCellValue('C10',$result['cedula'])
            ->setCellValue('C11',$result['fechaPaci'])
            ->setCellValue('C12',$result['sexoPaci'])
            ->setCellValue('C13',$result['ciudad'])
            ->setCellValue('C14',$result['direccion'])
            ->setCellValue('C15',$result['correoPaci']);
            $nomPacien=$result['nombresPaci'];
        }
        $this->excel->getActiveSheet()->getStyle('C8:C15')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        //Datos array
        
        //Archivo descargado
        //$filename="perfil_completo_paciente_id.xls";
        $filename="Perfil_Paciente_".$nomPacien.".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
        //Archivo descargado
    }
    
    public function exportar_pdf(){
        $this->load->model('Datos_pacientes_model');
        $data['title']='Lista de perfiles de pacientes'; 
        $data['author']='Medico';
	$data['subject']='Lista de perfiles de pacientes'; 	 
	$data['content']= $this->Datos_pacientes_model->obtenerResultadosExportarPDF();
	$this->load->view('folder_datos_pacientes/datos_pacientes_exportar_pdf',$data);
    }
    
    public function exportar_pdf_id(){
        $this->load->model('Datos_pacientes_model');
        $id = $this->uri->segment('3');
        $data['title']='Perfil completo del paciente'; 
        $data['author']='Administrador';
	$data['subject']='Perfil completo del paciente';	 
	$data['content']= $this->Datos_pacientes_model->obtenerResultadosExportarPDF_ID($id);
	$this->load->view('folder_datos_pacientes/datos_pacientes_exportar_pdf_id',$data);
    }
    
}