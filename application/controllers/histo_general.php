<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Histo_general extends CI_Controller{
    
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
        $this->load->model('Histo_general_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/histo_general/index';
        $opciones['total_rows'] = $this->Histo_general_model->numeroHistoGeneral();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Histo_general_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_histo_generales/cabecera_histo_generales_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_histo_generales/histo_general_view',$data);
        $this->load->view('footer_view');
    }
    
    public function insertar_histo_general_view(){
        $this->load->helper('form');
        $this->load->model('Histo_general_model');
        $data['medicos'] = $this->Histo_general_model->obtenerMedicos();
        $data['reservaciones'] = $this->Histo_general_model->obtenerReservaciones();
        $this->load->view('folder_histo_generales/cabecera_histo_generales_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_histo_generales/histo_general_insertar',$data);
        $this->load->view('footer_view');
    }
    
    public function insertar_histo_general(){
        $this->load->model('Histo_general_model');
        $this->reglas_validacion();
        if($this->form_validation->run()==FALSE){
            $this->insertar_histo_general_view();
        }
        else {
            $data = array(
                'id_medicos' => $this->input->post('id_medicos'),
                'id_reservaciones' => $this->input->post('id_reservaciones')
            );
            $id=$this->input->post('id_reservaciones');
            $this->Histo_general_model->insertarHistoGeneral($data,$id);
            redirect('index.php/histo_general/paginar');
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
    
    public function validar_fecha($id_pacientes, $fecha){
        $this->load->model('Histo_general_model');
        if($this->Histo_general_model->existeFecha($id_pacientes, $fecha)){
            $this->form_validation->set_message('validar_fecha', 'La fecha ' .$fecha. ' ya tiene un registro con el mismo paciente');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }

    public function buscar_histo_general_view(){
        $this->load->model('Histo_general_model');
        $this->load->library('pagination');
        $busqueda = $this->input->post('busqueda');
        $parametro = $this->input->post('parametro');
        $parametroH = $this->input->post('parametroH');
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/histo_general/index';
        $opciones['total_rows'] = $this->Histo_general_model->numeroHistoGeneralBusqueda($busqueda,$parametro,$parametroH);
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Histo_general_model->mostrarResultadosBusqueda($opciones['per_page'],$desde,$busqueda,$parametro,$parametroH);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_histo_generales/cabecera_histo_generales_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_histo_generales/histo_general_view',$data);
        $this->load->view('footer_view');
    }

    public function ver_histo_general_view(){
        $this->load->helper('form');
        $id = $this->uri->segment('3');
        $this->load->model('Histo_general_model');
        $queryH = $this->db->get_where("historias_clinicas",array("id_historias_clinicas"=>$id));
        $query = $this->db->get_where("general",array("id_histo_clinicas"=>$id));
        $data['medicos'] = $this->Histo_general_model->obtenerMedicos();
        $data['reservaciones'] = $this->Histo_general_model->obtenerReservacionesEdi();
        $data['datosH'] = $queryH->result();
        $data['datos'] = $query->result(); 
        $data['old_id'] = $id;
        $this->load->view('folder_histo_generales/cabecera_histo_generales_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_histo_generales/histo_general_ver',$data);
        $this->load->view('footer_view');
    }

    public function editar_histo_general_view(){
        $this->load->helper('form');
        $id = $this->uri->segment('3');
        $this->load->model('Histo_general_model');
        $queryH = $this->db->get_where("historias_clinicas",array("id_historias_clinicas"=>$id));
        $query = $this->db->get_where("general",array("id_histo_clinicas"=>$id));
        $data['medicos'] = $this->Histo_general_model->obtenerMedicos();
        $data['reservaciones'] = $this->Histo_general_model->obtenerReservacionesEdi();
        $data['datosH'] = $queryH->result();
        $data['datos'] = $query->result(); 
        $data['old_id'] = $id;
        $this->load->view('folder_histo_generales/cabecera_histo_generales_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_histo_generales/histo_general_editar',$data);
        $this->load->view('footer_view');
    }
    
    public function editar_histo_general(){
        $this->load->model('Histo_general_model');	
        $data = array(
            'id_medicos' => $this->input->post('id_medicos'),
            'id_reservaciones' => $this->input->post('id_reservaciones')
        );		
        $old_id = $this->input->post('old_id'); 
        $this->Histo_general_model->editarHistoGeneral($data,$old_id);
        redirect('index.php/histo_general/paginar');
    }
    
    public function eliminar_histo_general(){
        $this->load->model('Histo_general_model'); 
        $id = $this->uri->segment('3'); 
        $this->Histo_general_model->eliminarHistoGeneral($id);
        redirect('index.php/histo_general/paginar');
    }
    
    public function paginar(){
        $this->load->model('Histo_general_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/histo_general/index';
        $opciones['total_rows'] = $this->Histo_general_model->numeroHistoGeneral();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Histo_general_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_histo_generales/cabecera_histo_generales_view');
        $this->load->view('menu_medicos_view');
        $this->load->view('folder_histo_generales/histo_general_view',$data);
        $this->load->view('footer_view');
    }
    
    public function exportar_word_id(){
        $this->load->library('word');
        $id = $this->uri->segment('3');
        $this->load->model('Histo_general_model');
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
        
        //Historia clinica general del paciente
        $estiloFuentePerfil = array('bold'=>true, 'italic'=>true, 'size'=>18);
        $estiloParrafoPerfil = array('align'=>'center');
        $section->addText(' ', $estiloFuentePerfil);
        $section->addText('Historia clinica general del paciente', $estiloFuentePerfil, $estiloParrafoPerfil);
        //Historia clinica general del paciente

        //Obtenemos el numero de filas de la tabla seleccionada
        $contenido = $this->Histo_general_model->obtenerResultadosExportarWord_ID($id);
        //Obtenemos el numero de filas de la tabla seleccionada
        $estiloFuenteContenidoTitulo = array('bold'=>true, 'italic'=>true, 'size'=>12);
        $estiloFuenteContenido = array('bold'=>false, 'italic'=>true, 'size'=>12);
//        ->setCellValue('D7',$result['nombresMedi'])
//            ->setCellValue('D8',$result['nombresPacien'])
//            ->setCellValue('D9',$result['fecha'])
        //Recorremos los datos
        $section->addText(' ', $estiloFuenteContenidoTitulo);
        foreach ($contenido as $result){
            $section->addText('Medico', $estiloFuenteContenidoTitulo);
            $section->addText(''.$result['nombresMedi'].'', $estiloFuenteContenido);
            $section->addText('Paciente', $estiloFuenteContenidoTitulo);
            $section->addText(''.$result['nombresPacien'].'', $estiloFuenteContenido);
            $section->addText('Fecha de atencion', $estiloFuenteContenidoTitulo);
            $section->addText(''.$result['fecha_horarios'].'', $estiloFuenteContenido);
            $section->addText(' ', $estiloFuenteContenidoTitulo);
            $section->addText('AGUDEZA VISUAL ', $estiloFuenteContenidoTitulo);
            $section->addText('VL', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['vl_od'].'     O. IZQUIERDO: '.$result['vl_oi'], $estiloFuenteContenido);
            $section->addText('CC', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['cc_od'].'     O. IZQUIERDO: '.$result['cc_oi'], $estiloFuenteContenido);
            $section->addText('VP', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['vp_od'].'     O. IZQUIERDO: '.$result['vp_oi'], $estiloFuenteContenido);
            $section->addText('CC', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['cc2_od'].'     O. IZQUIERDO: '.$result['cc2_oi'], $estiloFuenteContenido);
            $section->addText('PH', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['ph_od'].'     O. IZQUIERDO: '.$result['ph_oi'], $estiloFuenteContenido);
            $section->addText(' ', $estiloFuenteContenidoTitulo);
            $section->addText('DP', $estiloFuenteContenidoTitulo);
            $section->addText($result['dp'], $estiloFuenteContenido);
            $section->addText('PPC', $estiloFuenteContenidoTitulo);
            $section->addText($result['ppc'], $estiloFuenteContenido);
            $section->addText('FORIA', $estiloFuenteContenidoTitulo);
            $section->addText($result['foria'], $estiloFuenteContenido);
            $section->addText(' ', $estiloFuenteContenidoTitulo);
            $section->addText('MOTIVO DE CONSULTA', $estiloFuenteContenidoTitulo);
            $section->addText($result['motivo_consulta'], $estiloFuenteContenido);
            $section->addText(' ', $estiloFuenteContenidoTitulo);
            $section->addText('SIGNOS Y SINTOMAS', $estiloFuenteContenidoTitulo);
            $section->addText($result['signos_sintomas'], $estiloFuenteContenido);
            $section->addText(' ', $estiloFuenteContenidoTitulo);
            $section->addText('EXAMEN EXTERNO', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['examen_externo_od'].'     O. IZQUIERDO: '.$result['examen_externo_oi'], $estiloFuenteContenido);
            $section->addText('ANTECEDENTES', $estiloFuenteContenidoTitulo);
            $section->addText($result['antecedentes'], $estiloFuenteContenido);
            $section->addText('ANTECEDENTES P', $estiloFuenteContenidoTitulo);
            $section->addText($result['antecedentes_p'], $estiloFuenteContenido);
            $section->addText(' ', $estiloFuenteContenidoTitulo);
            $section->addText('FONDO OJO', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['fondo_ojo_od'].'     O. IZQUIERDO: '.$result['fondo_ojo_oi'], $estiloFuenteContenido);
            $section->addText('QUERATONERIA', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['queratoneria_od'].'     O. IZQUIERDO: '.$result['queratoneria_oi'], $estiloFuenteContenido);
            $section->addText('RETINOSCOPIA', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['retinoscopia_od'].'     O. IZQUIERDO: '.$result['retinoscopia_oi'], $estiloFuenteContenido);
            $section->addText('SUBJETIVO', $estiloFuenteContenidoTitulo);
            $section->addText('O. DERECHO: '.$result['subjetivo_od'].'     O. IZQUIERDO: '.$result['subjetivo_oi'], $estiloFuenteContenido);
            $fec = $result['fecha_horarios'];
            $nomPac = $result['nombresPacien'];
        }
        //Recorremos los datos
        
        //Creamos y guardamos el documento
        $filename="Hist_General_".$fec."_".$nomPac.".docx";
        //$filename='Historia_clinica_general_del_paciente.docx'; //save our document as this file name
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
                ->setCellValue('B11','Historia clínica general del paciente')
                ->setCellValue('B13','AGUDEZA VISUAL')
                ->setCellValue('B15','VL')
                    ->setCellValue('D15','OD:')
                    ->setCellValue('G15','OI:')
                ->setCellValue('B16','CC')
                    ->setCellValue('D16','OD:')
                    ->setCellValue('G16','OI:')
                ->setCellValue('B17','VP')
                    ->setCellValue('D17','OD:')
                    ->setCellValue('G17','OI:')
                ->setCellValue('B18','CC')
                    ->setCellValue('D18','OD:')
                    ->setCellValue('G18','OI:')
                ->setCellValue('B19','PH')
                    ->setCellValue('D19','OD:')
                    ->setCellValue('G19','OI:')
                ->setCellValue('B21','DP')
                ->setCellValue('B22','PPC')
                ->setCellValue('B23','FORIA')
                ->setCellValue('B25','Motivo de consulta:')
                ->setCellValue('B28','Signos y síntomas:')
                ->setCellValue('B31','Examen externo')
                    ->setCellValue('D31','OD:')
                    ->setCellValue('G31','OI:')
                ->setCellValue('B33','Antecedentes:')
                ->setCellValue('B36','Antecedentes P. :')
                ->setCellValue('B39','Fondo de ojo')
                    ->setCellValue('D39','OD:')
                    ->setCellValue('G39','OI:')
                ->setCellValue('B40','Queratoneria')
                    ->setCellValue('D40','OD:')
                    ->setCellValue('G40','OI:')
                ->setCellValue('B41','Retinoscopia')
                    ->setCellValue('D41','OD:')
                    ->setCellValue('G41','OI:')
                ->setCellValue('B42','Subjetivo')
                    ->setCellValue('D42','OD:')
                    ->setCellValue('G42','OI:');
        //Negrita
        $this->excel->getActiveSheet()->getStyle("B11")->getFont()->setBold(true)
                //Tamaño
                ->setSize(16);
        $this->excel->getActiveSheet()->getStyle("B13")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("B15:B23")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("B25")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("B28")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("B31")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("B33")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("B36")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("B39:B42")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("D15:D19")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("D31:D42")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("G15:G19")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        $this->excel->getActiveSheet()->getStyle("G31:G42")->getFont()->setBold(true)
                //Tamaño
                ->setSize(11);
        //Combinar celdas
        $this->excel->setActiveSheetIndex(0)
                ->mergeCells('B11:H11')
                ->mergeCells('B13:H13')
                ->mergeCells('B15:C15')
                ->mergeCells('B16:C16')
                ->mergeCells('B17:C17')
                ->mergeCells('B18:C18')
                ->mergeCells('B19:C19')
                ->mergeCells('B21:C21')
                    ->mergeCells('D21:H21')
                ->mergeCells('B22:C22')
                    ->mergeCells('D22:H22')
                ->mergeCells('B23:C23')
                    ->mergeCells('D23:H23')
                ->mergeCells('B25:C25')
                ->mergeCells('B26:H26')
                ->mergeCells('B28:C28')
                ->mergeCells('B29:H29')
                ->mergeCells('B31:C31')
                ->mergeCells('B33:C33')
                ->mergeCells('B34:H34')
                ->mergeCells('B36:C36')
                ->mergeCells('B37:H37')
                ->mergeCells('B39:C39')
                ->mergeCells('B40:C40')
                ->mergeCells('B41:C41')
                ->mergeCells('B42:C42');
        //Alineación izquierda, derecha o centro
        $this->excel->getActiveSheet()->getStyle('B11')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $this->excel->getActiveSheet()->getStyle('B13')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $this->excel->getActiveSheet()->getStyle('B15:B23')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,)
        );
        $this->excel->getActiveSheet()->getStyle('D21:D23')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,)
        );
        $this->excel->getActiveSheet()->getStyle('B25:B42')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,)
        );
        //Estructura del reporte
        
        //Pasar datos a la estructura
        //Definimos un nombre al libro del excel
        $this->excel->getActiveSheet(0)->setTitle('Hist. general del paciente');
        //Cargamos la base de datos
        $this->load->database();
        //Cargams el modelo a utilizar
        $this->load->model('Histo_general_model');
        //Declaramos una variable la cual tendra los datos del método utilizado
        $histo_general = $this->Histo_general_model->obtenerResultadosExportarExcel_ID($id);
        //Recorremos la variable creada con un foreach
        foreach ($histo_general as $result){
            //Cargamos el libro al cual le vamos a pasar los datos a cada una de las celdas que se especifiquen
            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('D7',$result['nombresMedi'])
            ->setCellValue('D8',$result['nombresPacien'])
            ->setCellValue('D9',$result['fecha_horarios'])
            ->setCellValue('E15',$result['vl_od'])
            ->setCellValue('H15',$result['vl_oi'])
            ->setCellValue('E16',$result['cc_od'])
            ->setCellValue('H16',$result['cc_oi'])
            ->setCellValue('E17',$result['vp_od'])
            ->setCellValue('H17',$result['vp_oi'])
            ->setCellValue('E18',$result['cc2_od'])
            ->setCellValue('H18',$result['cc2_oi'])        
            ->setCellValue('E19',$result['ph_od'])
            ->setCellValue('H19',$result['ph_oi'])        
            ->setCellValue('D21',$result['dp'])        
            ->setCellValue('D22',$result['ppc'])        
            ->setCellValue('D23',$result['foria'])        
            ->setCellValue('B26',$result['motivo_consulta'])
            ->setCellValue('B29',$result['signos_sintomas'])        
            ->setCellValue('E31',$result['examen_externo_od'])
            ->setCellValue('H31',$result['examen_externo_oi'])        
            ->setCellValue('B34',$result['antecedentes'])        
            ->setCellValue('B37',$result['antecedentes_p'])        
            ->setCellValue('E39',$result['fondo_ojo_od'])
            ->setCellValue('H39',$result['fondo_ojo_oi'])
            ->setCellValue('E40',$result['queratoneria_od'])
            ->setCellValue('H40',$result['queratoneria_oi'])
            ->setCellValue('E41',$result['retinoscopia_od'])
            ->setCellValue('H41',$result['retinoscopia_oi'])        
            ->setCellValue('E42',$result['subjetivo_od'])
            ->setCellValue('H42',$result['subjetivo_oi']);
            $fec = $result['fecha_horarios'];
            $nomPac = $result['nombresPacien'];
        }
        //Pasar datos a la estructura
        
        //Archivo descargado
        $filename="Hist_General_".$fec."_".$nomPac.".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
        //Archivo descargado
    }

    public function exportar_pdf_id(){
        $this->load->model('Histo_general_model');
        $id = $this->uri->segment('3');
        $data['title']='Historia clinica general del paciente'; 
        $data['author']='Medico';
	$data['subject']='Historia clinica general del paciente';	 
	$data['content']= $this->Histo_general_model->obtenerResultadosExportarPDF_ID($id);
	$this->load->view('folder_histo_generales/histo_general_exportar_pdf_id',$data);
    }
    
}