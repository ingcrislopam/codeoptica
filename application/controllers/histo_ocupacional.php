<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Histo_ocupacional extends CI_Controller{
    
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
        $this->load->model('Histo_ocupacional_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/histo_ocupacional/index';
        $opciones['total_rows'] = $this->Histo_ocupacional_model->numeroHistoOcupacional();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Histo_ocupacional_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_histo_ocupacionales/cabecera_histo_ocupacional_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_histo_ocupacionales/histo_ocupacional_view',$data);
        $this->load->view('footer_view');
    }
    
    public function insertar_histo_ocupacional_view(){
        $this->load->helper('form');
        $this->load->model('Histo_ocupacional_model');
        $data['medicos'] = $this->Histo_ocupacional_model->obtenerMedicos();
        $data['reservaciones'] = $this->Histo_ocupacional_model->obtenerReservaciones();
        $this->load->view('folder_histo_ocupacionales/cabecera_histo_ocupacional_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_histo_ocupacionales/histo_ocupacional_insertar',$data);
        $this->load->view('footer_view');
    }
    
    public function insertar_histo_ocupacional(){
        $this->load->model('Histo_ocupacional_model');
        $this->reglas_validacion();
        if($this->form_validation->run()==FALSE){
            $this->insertar_histo_ocupacional_view();
        }
        else {
            $data = array(
                'id_medicos' => $this->input->post('id_medicos'),
                'id_reservaciones' => $this->input->post('id_reservaciones')
            );
            $id=$this->input->post('id_reservaciones');
            $this->Histo_ocupacional_model->insertarHistoOcupacional($data,$id);
            redirect('index.php/histo_ocupacional/paginar');
        }
    }
    
    public function reglas_validacion(){
        $config = array(
            array(
                'field'=>'id_medicos',
                'label'=>'medico',
                'rules'=>'trim|required'
            ),
            array(
                'field'=>'id_reservaciones',
                'label'=>'fecha y paciente',
                'rules'=>'trim|required'
            )
        );
        $this->form_validation->set_rules($config);
    }
    
    public function buscar_histo_ocupacional_view(){
        $this->load->model('Histo_ocupacional_model');
        $this->load->library('pagination');
        $busqueda = $this->input->post('busqueda');
        $parametro = $this->input->post('parametro');
        $parametroH = $this->input->post('parametroH');
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/histo_ocupacional/index';
        $opciones['total_rows'] = $this->Histo_ocupacional_model->numeroHistoOcupacionalBusqueda($busqueda,$parametro,$parametroH);
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Histo_ocupacional_model->mostrarResultadosBusqueda($opciones['per_page'],$desde,$busqueda,$parametro,$parametroH);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_histo_ocupacionales/cabecera_histo_ocupacional_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_histo_ocupacionales/histo_ocupacional_view',$data);
        $this->load->view('footer_view');
    }
    
    public function ver_histo_ocupacional_view(){
        $this->load->helper('form');
        $id = $this->uri->segment('3');
        $this->load->model('Histo_ocupacional_model');
        $queryH = $this->db->get_where("historias_clinicas",array("id_historias_clinicas"=>$id));
        $query = $this->db->get_where("ocupacional",array("id_histo_clinicas"=>$id));
        $data['medicos'] = $this->Histo_ocupacional_model->obtenerMedicos();
        $data['reservaciones'] = $this->Histo_ocupacional_model->obtenerReservacionesEdi();
        $data['datosH'] = $queryH->result();
        $data['datos'] = $query->result(); 
        $data['old_id'] = $id;
        $this->load->view('folder_histo_ocupacionales/cabecera_histo_ocupacional_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_histo_ocupacionales/histo_ocupacional_ver',$data);
        $this->load->view('footer_view');
    }
    
    public function editar_histo_ocupacional_view(){
        $this->load->helper('form');
        $id = $this->uri->segment('3');
        $this->load->model('Histo_ocupacional_model');
        $queryH = $this->db->get_where("historias_clinicas",array("id_historias_clinicas"=>$id));
        $query = $this->db->get_where("ocupacional",array("id_histo_clinicas"=>$id));
        $data['medicos'] = $this->Histo_ocupacional_model->obtenerMedicos();
        $data['reservaciones'] = $this->Histo_ocupacional_model->obtenerReservacionesEdi();
        $data['datosH'] = $queryH->result();
        $data['datos'] = $query->result(); 
        $data['old_id'] = $id;
        $this->load->view('folder_histo_ocupacionales/cabecera_histo_ocupacional_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_histo_ocupacionales/histo_ocupacional_editar',$data);
        $this->load->view('footer_view');
    }
    
    public function editar_histo_ocupacional(){
        $this->load->model('Histo_ocupacional_model');	
        $data = array(
            'id_medicos' => $this->input->post('id_medicos'),
            'id_reservaciones' => $this->input->post('id_reservaciones')
        );		
        $old_id = $this->input->post('old_id'); 
        $this->Histo_ocupacional_model->editarHistoOcupacional($data,$old_id);
        redirect('index.php/histo_ocupacional/paginar');
    }
    
    public function eliminar_histo_ocupacional(){
        $this->load->model('Histo_ocupacional_model'); 
        $id = $this->uri->segment('3'); 
        $this->Histo_ocupacional_model->eliminarHistoOcupacional($id);
        redirect('index.php/histo_ocupacional/paginar');
    }
    
    public function paginar(){
        $this->load->model('Histo_ocupacional_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/histo_ocupacional/index';
        $opciones['total_rows'] = $this->Histo_ocupacional_model->numeroHistoOcupacional();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Histo_ocupacional_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_histo_ocupacionales/cabecera_histo_ocupacional_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_histo_ocupacionales/histo_ocupacional_view',$data);
        $this->load->view('footer_view');
    }
    
    public function exportar_word_id(){
        $this->load->library('word');
        $id = $this->uri->segment('3');
        $this->load->model('Histo_ocupacional_model');
        $section = $this->word->createSection(array('orientation'=>'portrait'));
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

        //Historia clinica ocupacional del paciente
        $estiloFuentePerfil = array('bold'=>true, 'italic'=>true, 'size'=>18);
        $estiloParrafoPerfil = array('align'=>'center');
        $section->addText(' ', $estiloFuentePerfil);
        $section->addText('Historia clinica ocupacional del paciente', $estiloFuentePerfil, $estiloParrafoPerfil);
        //Historia clinica ocupacional del paciente

        //Obtenemos el numero de filas de la tabla seleccionada
        $contenido = $this->Histo_ocupacional_model->obtenerResultadosExportarWord_ID($id);
        //Obtenemos el numero de filas de la tabla seleccionada
        $estiloFuenteContenidoTitulo = array('bold'=>true, 'italic'=>true, 'size'=>12);
        $estiloFuenteContenido = array('bold'=>false, 'italic'=>true, 'size'=>12);
        
        //Recorremos los datos
        $section->addText(' ', $estiloFuenteContenidoTitulo);
        foreach ($contenido as $result){
            $section->addText('Medico', $estiloFuenteContenidoTitulo);
            $section->addText(''.$result['nombresMedi'].'', $estiloFuenteContenido);
            $section->addText('Paciente', $estiloFuenteContenidoTitulo);
            $section->addText(''.$result['nombresPacien'].'', $estiloFuenteContenido);
            $section->addText('Fecha de atencion', $estiloFuenteContenidoTitulo);
            $section->addText(''.$result['fecha_horarios'].'', $estiloFuenteContenido);
            $section->addText('Lentes', $estiloFuenteContenidoTitulo);
            $section->addText(''.$result['lentes'].'', $estiloFuenteContenido);
            $section->addText(' ', $estiloFuenteContenidoTitulo);
            $section->addText('AGUDEZA VISUAL', $estiloFuenteContenidoTitulo);
            $section->addText('VISION LEJANA', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['agudeza_vision_lejana_od'].'     O. IZQUIERDO: '.$result['agudeza_vision_lejana_oi'], $estiloFuenteContenido);
            $section->addText('VISION CERCANA', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['agudeza_vision_cercana_od'].'     O. IZQUIERDO: '.$result['agudeza_vision_cercana_oi'], $estiloFuenteContenido);
            $section->addText('PERIMETRIA', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['agudeza_perimetria_od'].'     O. IZQUIERDO: '.$result['agudeza_perimetria_oi'], $estiloFuenteContenido);
            $section->addText('TONOMETRIA', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['agudeza_tonometria_od'].'     O. IZQUIERDO: '.$result['agudeza_tonometria_oi'], $estiloFuenteContenido);
            $section->addText('FONDO DE OJO', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['agudeza_fondo_ojo_od'].'     O. IZQUIERDO: '.$result['agudeza_fondo_ojo_oi'], $estiloFuenteContenido);
            $section->addText('EXAMEN EXTERNO', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['agudeza_examen_externo_od'].'     O. IZQUIERDO: '.$result['agudeza_examen_externo_oi'], $estiloFuenteContenido);
            $section->addText(' ', $estiloFuenteContenidoTitulo);
            $section->addText('FORIAS', $estiloFuenteContenidoTitulo);
            $section->addText('VISION LEJANA', $estiloFuenteContenidoTitulo);
            $section->addText($result['forias_vision_lejana'], $estiloFuenteContenido);
            $section->addText('VISION PROXIMA', $estiloFuenteContenidoTitulo);
            $section->addText($result['forias_vision_proxima'], $estiloFuenteContenido);
            $section->addText('TEST DE COLOR', $estiloFuenteContenidoTitulo);
            $section->addText($result['forias_test_color'], $estiloFuenteContenido);
            $section->addText('TEST DE ESTERIOPSIS', $estiloFuenteContenidoTitulo);
            $section->addText($result['forias_test_esteriopsis'], $estiloFuenteContenido);
            $section->addText('DIAGNOSTICO', $estiloFuenteContenidoTitulo);
            $section->addText($result['forias_diagnostico'], $estiloFuenteContenido);
            $fec = $result['fecha_horarios'];
            $nomPac = $result['nombresPacien'];
        }
        //Recorremos los datos
        
        //Creamos y guardamos el documento
        $filename="Hist_Ocupacional_".$fec."_".$nomPac.".docx";
        //$filename='Historia_clinica_ocupacional_del_paciente.docx'; //save our document as this file name
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPWord_IOFactory::createWriter($this->word, 'Word2007');
        $objWriter->save('php://output');
        //Creamos y guardamos el documento
    }
    
    public function exportar_excel_id(){
        //Cargamos la libreria
        $this->load->library('excel');
        //Obtenemos el id por medio de a url
        $id = $this->uri->segment('3');
        //Creamos la imagen del directorio escogido
        $gdImage = imagecreatefromjpeg(base_url()."imagenes/logo.jpg");
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('logo');$objDrawing->setDescription('logo');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        //Definimos la dimensión de la imagen
        $objDrawing->setHeight(69);
        //Establemos en que celda se pocisionará
        $objDrawing->setCoordinates('B1');
        $objDrawing->setWorksheet($this->excel->getActiveSheet());
        
        //Cabecera del reporte
        //Se establece un valor dentro de la o las celdas especificadas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('B5','Reporte realizado el '.date("d-m-Y").' a las '.date("H:i:s").'')
                ->setCellValue('B7','Médico:')
                ->setCellValue('B8','Paciente:')
                ->setCellValue('B9','Fecha de atención:');
        //Negrita
        $this->excel->getActiveSheet()->getStyle("B5")->getFont()->setBold(true)
                //Tamaño
                ->setSize(8);
        //Negrita
        $this->excel->getActiveSheet()->getStyle("B7:B9")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        //Combinar celdas
        $this->excel->setActiveSheetIndex(0)
                ->mergeCells('B5:H5')
                ->mergeCells('B7:C7')
                ->mergeCells('D7:H7')
                ->mergeCells('B8:C8')
                ->mergeCells('D8:H8')
                ->mergeCells('B9:C9')
                ->mergeCells('D9:H9');
        //Alineación izquierda, derecha o centro
        $this->excel->getActiveSheet()->getStyle('B5')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        $this->excel->getActiveSheet()->getStyle('D7:D9')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        //Cabecera del reporte
        
        //Estructura del reporte
        //Se establece un valor dentro de la o las celdas especificadas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('B11','Historia clínica ocupacional del paciente')
                ->setCellValue('B13','Lentes:')
                ->setCellValue('B15','AGUDEZA VISUAL')
                ->setCellValue('B17','Visión lejana')
                    ->setCellValue('D17','OD:')
                    ->setCellValue('G17','OI:')
                ->setCellValue('B18','Visión cercana')
                    ->setCellValue('D18','OD:')
                    ->setCellValue('G18','OI:')
                ->setCellValue('B19','Perimetria')
                    ->setCellValue('D19','OD:')
                    ->setCellValue('G19','OI:')
                ->setCellValue('B20','Tonometria')
                    ->setCellValue('D20','OD:')
                    ->setCellValue('G20','OI:')
                ->setCellValue('B21','Fondo de ojo')
                    ->setCellValue('D21','OD:')
                    ->setCellValue('G21','OI:')
                ->setCellValue('B22','Examen externo')
                    ->setCellValue('D22','OD:')
                    ->setCellValue('G22','OI:')
                ->setCellValue('B24','FORIAS')
                ->setCellValue('B26','Visión lejana:')
                ->setCellValue('B27','Visión próxima:')
                ->setCellValue('B28','Test de color')
                ->setCellValue('B29','Test de esteriopsis')
                ->setCellValue('B30','Diagnóstico');
        //Negrita
        $this->excel->getActiveSheet()->getStyle("B11")->getFont()->setBold(true)
                //Tamaño
                ->setSize(16);
        $this->excel->getActiveSheet()->getStyle("B13:B30")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("B17:B22")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("D17:D22")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("G17:G22")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        //Combinar celdas
        $this->excel->setActiveSheetIndex(0)
                ->mergeCells('B11:H11')
                ->mergeCells('B13:C13')
                ->mergeCells('D13:H13')
                ->mergeCells('B15:H15')
                ->mergeCells('B17:C17')
                ->mergeCells('B18:C18')
                ->mergeCells('B19:C19')
                ->mergeCells('B20:C20')
                ->mergeCells('B21:C21')
                ->mergeCells('B22:C22')
                ->mergeCells('B24:H24')
                ->mergeCells('B26:C26')
                    ->mergeCells('D26:H26')
                ->mergeCells('B27:C27')
                    ->mergeCells('D27:H27')
                ->mergeCells('B28:C28')
                    ->mergeCells('D28:H28')
                ->mergeCells('B29:C29')
                    ->mergeCells('D29:H29')
                ->mergeCells('B30:C30')
                    ->mergeCells('D30:H30')
                ->mergeCells('B31:H31');
        //Alineación izquierda, derecha o centro
        $this->excel->getActiveSheet()->getStyle('B11')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $this->excel->getActiveSheet()->getStyle('D13')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        $this->excel->getActiveSheet()->getStyle('B15')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $this->excel->getActiveSheet()->getStyle('B24')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $this->excel->getActiveSheet()->getStyle('D26:D30')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        $this->excel->getActiveSheet()->getStyle('D31')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,)
        );
        //Estructura del reporte
        
        //Pasar datos a la estructura
        //Definimos un nombre al libro del excel
        $this->excel->getActiveSheet(0)->setTitle('Hist. ocupacional del paciente');
        //Cargamos la base de datos
        $this->load->database();
        //Cargams el modelo a utilizar
        $this->load->model('Histo_ocupacional_model');
        //Declaramos una variable la cual tendra los datos del método utilizado
        $histo_ocupacional = $this->Histo_ocupacional_model->obtenerResultadosExportarExcel_ID($id);
        //Recorremos la variable creada con un foreach
        foreach ($histo_ocupacional as $result){
            //Cargamos el libro al cual le vamos a pasar los datos a cada una de las celdas que se especifiquen
            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('D7',$result['nombresMedi'])
            ->setCellValue('D8',$result['nombresPacien'])
            ->setCellValue('D9',$result['fecha_horarios'])
            ->setCellValue('D13',$result['lentes'])
            ->setCellValue('E17',$result['agudeza_vision_lejana_od'])
            ->setCellValue('H17',$result['agudeza_vision_lejana_oi'])
            ->setCellValue('E18',$result['agudeza_vision_cercana_od'])
            ->setCellValue('H18',$result['agudeza_vision_cercana_oi'])
            ->setCellValue('E19',$result['agudeza_perimetria_od'])
            ->setCellValue('H19',$result['agudeza_perimetria_oi'])
            ->setCellValue('E20',$result['agudeza_tonometria_od'])
            ->setCellValue('H20',$result['agudeza_tonometria_oi'])
            ->setCellValue('E21',$result['agudeza_fondo_ojo_od'])
            ->setCellValue('H21',$result['agudeza_fondo_ojo_oi'])
            ->setCellValue('E22',$result['agudeza_examen_externo_od'])
            ->setCellValue('H22',$result['agudeza_examen_externo_oi'])
            ->setCellValue('D26',$result['forias_vision_lejana'])
            ->setCellValue('D27',$result['forias_vision_proxima'])        
            ->setCellValue('D28',$result['forias_test_color'])
            ->setCellValue('D29',$result['forias_test_esteriopsis'])        
            ->setCellValue('B31',$result['forias_diagnostico']);
            $fec = $result['fecha_horarios'];
            $nomPac = $result['nombresPacien'];
        }
        //Pasar datos a la estructura
        
        //Archivo descargado
        $filename="Hist_Ocupacional_".$fec."_".$nomPac.".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
        //Archivo descargado
    }
    
    public function exportar_pdf_id(){
        $this->load->model('Histo_ocupacional_model');
        $id = $this->uri->segment('3');
        $data['title']='Historia clinica ocupacional del paciente'; 
        $data['author']='Medico';
	$data['subject']='Historia clinica ocupacional del paciente';	 
	$data['content']= $this->Histo_ocupacional_model->obtenerResultadosExportarPDF_ID($id);
	$this->load->view('folder_histo_ocupacionales/histo_ocupacional_exportar_pdf_id',$data);
    }
    
}