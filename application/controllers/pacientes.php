<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pacientes extends CI_Controller{
    
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
        $this->load->model('Pacientes_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/pacientes/index';
        $opciones['total_rows'] = $this->Pacientes_model->numeroPacientes();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Pacientes_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_pacientes/cabecera_pacientes_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_pacientes/pacientes_view',$data);
        $this->load->view('footer_view');
    }
    
    public function insertar_paciente_view(){
        $this->load->helper('form');
        $this->load->model('Pacientes_model');
        $data['recepcionista'] = $this->Pacientes_model->obtenerRecepcionistas();
        $this->load->view('folder_pacientes/cabecera_pacientes_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_pacientes/pacientes_insertar', $data);
        $this->load->view('footer_view');
    }
    
    public function insertar_paciente(){
        $this->load->model('Pacientes_model');
        $this->reglas_validacion();
        if($this->form_validation->run()==FALSE){
            $this->insertar_paciente_view();
        }
        else{
            $data = array(
                'id_recepcionistas' => $this->input->post('id_recepcionistas'),
                'nombresPaci' => $this->input->post('nombresPaci'),
                'apellidosPaci' => $this->input->post('apellidosPaci'),
                'celularPaci' => $this->input->post('celularPaci'),
                'convencionalPaci' => $this->input->post('convencionalPaci'),
                'estadoPaci' => 0
            );
            $this->Pacientes_model->insertarPaciente($data);
            redirect('index.php/pacientes/paginar');
        }
    }
    
    public function buscar_paciente_view(){
        $this->load->model('Pacientes_model');
        $this->load->library('pagination');
        $busqueda = $this->input->post('busqueda');
        $parametro = $this->input->post('parametro');
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/pacientes/index';
        $opciones['total_rows'] = $this->Pacientes_model->numeroPacientesBusqueda($busqueda,$parametro);
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Pacientes_model->mostrarResultadosBusqueda($opciones['per_page'],$desde,$busqueda,$parametro);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_pacientes/cabecera_pacientes_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_pacientes/pacientes_view',$data);
        $this->load->view('footer_view');
    }
    
    public function editar_paciente_view(){
        $this->load->helper('form');
        $id = $this->uri->segment('3');
        $this->load->model('Pacientes_model');
        $query = $this->db->get_where("pacientes",array("id_pacientes"=>$id));
        $data['recepcionista'] = $this->Pacientes_model->obtenerRecepcionistas();
        $data['datos'] = $query->result(); 
        $data['old_id'] = $id; 
        $this->load->view('folder_pacientes/cabecera_pacientes_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_pacientes/pacientes_editar',$data);
        $this->load->view('footer_view');
    }
    
    public function editar_paciente(){
        $this->load->model('Pacientes_model');	
        $data = array( 
            'id_pacientes' => $this->input->post('id_pacientes'), 
            'id_recepcionistas' => $this->input->post('id_recepcionistas'),
            'nombresPaci' => $this->input->post('nombresPaci'),
            'apellidosPaci' => $this->input->post('apellidosPaci'),
            'celularPaci' => $this->input->post('celularPaci'),
            'convencionalPaci' => $this->input->post('convencionalPaci')
        );		
        $old_id = $this->input->post('old_id'); 
        $this->Pacientes_model->editarPaciente($data,$old_id);
        redirect('index.php/pacientes/paginar');
    }
    
    public function eliminar_paciente(){
        $this->load->model('Pacientes_model'); 
        $id = $this->uri->segment('3'); 
        $this->Pacientes_model->eliminarPaciente($id);
        redirect('index.php/pacientes/paginar');
    }
    
    public function reglas_validacion(){
        $config = array(
            array(
                'field'=>'id_recepcionistas',
                'label'=>'recepcionista',
                'rules'=>'required'
            ),
            array(
                'field'=>'nombresPaci',
                'label'=>'nombres',
                'rules'=>'required'
            ),
            array(
                'field'=>'apellidosPaci',
                'label'=>'apellidos',
                'rules'=>'required'
            ),
            array(
                'field'=>'celularPaci',
                'label'=>'celular',
                'rules'=>'trim|numeric|min_length[10]|max_length[10]|callback_validar_celular'
            ),
            array(
                'field'=>'convencionalPaci',
                'label'=>'convencional',
                'rules'=>'trim|numeric|min_length[6]|max_length[6]|callback_validar_celular'
            )
        );
        $this->form_validation->set_rules($config);
    }
    
    public function validar_celular($celular){
        $this->load->model('Pacientes_model');
        if($this->Pacientes_model->existeCelularUsu($celular)||$this->Pacientes_model->existeCelularPaci($celular)){
            $this->form_validation->set_message('validar_celular', 'El celular ' .$celular. ' ya está registrado');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function validar_convencional($convencional){
        $this->load->model('Pacientes_model');
        if($this->Pacientes_model->existeConvencionalPaci($convencional)){
            $this->form_validation->set_message('validar_convencional', 'El convencional ' .$convencional. ' ya está registrado');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function paginar(){
        $this->load->model('Pacientes_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/pacientes/index';
        $opciones['total_rows'] = $this->Pacientes_model->numeroPacientes();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Pacientes_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_pacientes/cabecera_pacientes_view');
        $this->load->view('menu_recepcionistas_view');
        $this->load->view('folder_pacientes/pacientes_view',$data);
        $this->load->view('footer_view');
    }
    
    public function exportar_word(){
        $this->load->library('word');
        $this->load->model('Pacientes_model');
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
        $section->addText('Reporte realizado el '.date("d-m-Y"). ' a las '.  date("H:i:s"), $estiloFuenteTipoFechaHora, $estiloParrafoTipoFechaHora);
        $section->addText(' ');
        //Tipo, fecha y hora

        //Lista de pacientes
        $estiloFuenteLista = array('bold'=>true, 'italic'=>true, 'size'=>18);
        $estiloParrafoLista = array('align'=>'center');
        $section->addText('Lista de pacientes', $estiloFuenteLista, $estiloParrafoLista);
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
        $table->addCell(2000, $styleCell)->addText('Recepcionista', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Nombres', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Apellidos', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Celular', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Convencional', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Perfil', $fontStyle);
        
        //Obtenemos el numero de filas de la tabla seleccionada
        $contenido = $this->Pacientes_model->obtenerResultadosExportarWord();
        //Obtenemos el numero de filas de la tabla seleccionada
        
        
        //Recorremos la tabla
        for ($row = 0; $row < count($this->Pacientes_model->numeroPacientes()); $row++){
            //Agregamos una fila por cada recorrido 
            
            //Recorremos el array y asignamos sus valores correspondientes
            foreach ($contenido as $result){
                $table->addRow();
                $table->addCell(500)->addText(htmlspecialchars($result['id_pacientes']));
                $table->addCell(2000)->addText(htmlspecialchars($result['nombresRecep']));
                $table->addCell(2000)->addText(htmlspecialchars($result['nombresPaci']));
                $table->addCell(2000)->addText(htmlspecialchars($result['apellidosPaci']));
                $table->addCell(2000)->addText(htmlspecialchars($result['celular']));
                $table->addCell(2000)->addText(htmlspecialchars($result['convencional']));
                $table->addCell(2000)->addText(htmlspecialchars($result['perfil']));
            }
            //Recorremos el array y asignamos sus valores correspondientes
        }
        //Recorremos la tabla
        
        //Creamos y guardamos el documento
        //$filename='Lista_Pacientes.docx'; //save our document as this file name
        $filename="Lista_Pacientes_Fecha_".date("d-m-Y").".docx";
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
        $this->load->model('Pacientes_model');
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

        //Paciente
        $estiloFuentePerfil = array('bold'=>true, 'italic'=>true, 'size'=>18);
        $estiloParrafoPerfil = array('align'=>'center');
        $section->addText(' ', $estiloFuentePerfil);
        $section->addText('Paciente', $estiloFuentePerfil, $estiloParrafoPerfil);
        //Paciente

        //Obtenemos el numero de filas de la tabla seleccionada
        $contenido = $this->Pacientes_model->obtenerResultadosExportarWord_ID($id);
        //Obtenemos el numero de filas de la tabla seleccionada
        $estiloFuenteContenidoTitulo = array('bold'=>true, 'italic'=>true, 'size'=>12);
        $estiloFuenteContenido = array('bold'=>false, 'italic'=>true, 'size'=>12);
        
        //Recorremos los datos
        $section->addText(' ', $estiloFuenteContenidoTitulo);
        foreach ($contenido as $result){
            $section->addText('ID: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['id_pacientes'], $estiloFuenteContenido);
            $section->addText('Recepcionista: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['nombresRecep'], $estiloFuenteContenido);
            $section->addText('Nombres: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['nombresPaci'], $estiloFuenteContenido);
            $section->addText('Apellidos: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['apellidosPaci'], $estiloFuenteContenido);
            $section->addText('Celular: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['celular'], $estiloFuenteContenido);
            $section->addText('Convencional: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['convencional'], $estiloFuenteContenido);
            $section->addText('Perfil: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['perfil'], $estiloFuenteContenido);
            $nomPac="".$result['nombresPaci']." ".$result['apellidosPaci']."";
        }
        //Recorremos los datos
        
        //Creamos y guardamos el documento
        //$filename='Perfil_del_paciente.docx'; //save our document as this file name
        $filename="Paciente_".$nomPac.".docx";
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
                ->setCellValue('A3','Reporte realizado el '.date("d-m-Y").' a las '.date("H:i:s").'');
        //Negrita
        $this->excel->getActiveSheet()->getStyle("A3")->getFont()->setBold(true)
                //Tamaño
                ->setSize(8);
        //Combinar celdas
        $this->excel->setActiveSheetIndex(0)
                ->mergeCells('A3:G3');
        //Alineación izquierda, derecha o centro
        $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        //Cabecera del reporte
        
        //Titulo Lista de pacientes
        $this->excel->setActiveSheetIndex(0)->setCellValue('A5','Lista de pacientes');
        $this->excel->getActiveSheet()->getStyle("A5")->getFont()->setBold(true)
                ->setSize(18);
        $this->excel->setActiveSheetIndex(0)->mergeCells('A5:G5');
        $this->excel->getActiveSheet()->getStyle('A5')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        //Titulo Lista de pacientes
                    
        //Datos array
        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A7','ID')
            ->setCellValue('B7','Recepcionista')
            ->setCellValue('C7','Nombres')
            ->setCellValue('D7','Apellidos')
            ->setCellValue('E7','Celular')
            ->setCellValue('F7','Convencional')
            ->setCellValue('G7','Perfil');
        
        $this->excel->getActiveSheet()->getStyle("A7:G7")->getFont()->setBold(true);
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->excel->getActiveSheet()->getStyle('A7:G7')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setTitle('Lista de pacientes')
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
        $this->load->database();
        $this->load->model('Pacientes_model');
        $pacientes = $this->Pacientes_model->obtenerResultadosExportarExcel();
        $this->excel->getActiveSheet()->fromArray($pacientes, null, 'A8');
        
        //Datos array
        
        //Archivo descargado
        //$filename='Lista_de_pacientes.xls';
        $filename="Lista_Pacientes_Fecha_".date("d-m-Y").".xls";
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
        
        //Estructura del reporte
        //Se establece un valor dentro de la o las celdas especificadas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('B6','Paciente')
                ->setCellValue('B8','ID:')
                ->setCellValue('B9','Nombres:')
                ->setCellValue('B10','Apellidos:')
                ->setCellValue('B11','Celular:')
                ->setCellValue('B12','Convencional:')
                ->setCellValue('B13','Perfil:');
        //Negrita
        $this->excel->getActiveSheet()->getStyle("B6")->getFont()->setBold(true)
                //Tamaño
                ->setSize(16);
        $this->excel->getActiveSheet()->getStyle("B8:B13")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        //Combinar celdas
        $this->excel->setActiveSheetIndex(0)
                ->mergeCells('B6:F6')
                ->mergeCells('B8:C8')
                ->mergeCells('D8:F8')
                ->mergeCells('B9:C9')
                ->mergeCells('D9:F9')
                ->mergeCells('B10:C10')
                ->mergeCells('D10:F10')
                ->mergeCells('B11:C11')
                ->mergeCells('D11:F11')
                ->mergeCells('B12:C12')
                ->mergeCells('D12:F12')
                ->mergeCells('B13:C13')
                ->mergeCells('D13:F13');
        //Alineación izquierda, derecha o centro
        $this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $this->excel->getActiveSheet()->getStyle('B8:C13')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,)
        );
        $this->excel->getActiveSheet()->getStyle('D8:F13')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        //Estructura del reporte
        
        //Pasar datos a la estructura
        //Definimos un nombre al libro del excel
        $this->excel->getActiveSheet(0)->setTitle('Paciente');
        //Cargamos la base de datos
        $this->load->database();
        //Cargams el modelo a utilizar
        $this->load->model('Pacientes_model');
        //Declaramos una variable la cual tendra los datos del método utilizado
        $pacientes = $this->Pacientes_model->obtenerResultadosExportarExcel_ID($id);
        //Recorremos la variable creada con un foreach
        foreach ($pacientes as $result){
            //Cargamos el libro al cual le vamos a pasar los datos a cada una de las celdas que se especifiquen
            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('D8',$result['nombresRecep'])
            ->setCellValue('D9',$result['nombresPaci'])
            ->setCellValue('D10',$result['apellidosPaci'])
            ->setCellValue('D11',$result['celular'])
            ->setCellValue('D12',$result['convencional'])
            ->setCellValue('D13',$result['estado']);
            $nomPac = "".$result['nombresPaci']." ".$result['apellidosPaci']."";
        }
        //Pasar datos a la estructura
        
        //Archivo descargado
        $filename="Paciente_".$nomPac.".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
        //Archivo descargado
    }

    public function exportar_pdf(){
        $this->load->model('Pacientes_model');
        $data['title']='Lista de pacientes'; 
        $data['author']='Recepcionista';
	$data['subject']='Lista de pacientes'; 	 
	$data['content']= $this->Pacientes_model->obtenerResultadosExportarPDF();
	$this->load->view('folder_pacientes/pacientes_exportar_pdf',$data);
    }
    
    public function exportar_pdf_id(){
        $this->load->model('Pacientes_model');
        $id = $this->uri->segment('3');
        $data['title']='Perfil del paciente'; 
        $data['author']='Recepcionista';
	$data['subject']='Perfil del paciente';	 
	$data['content']= $this->Pacientes_model->obtenerResultadosExportarPDF_ID($id);
	$this->load->view('folder_pacientes/pacientes_exportar_pdf_id',$data);
    }
    
}