<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administradores extends CI_Controller{
    
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
        $this->load->model('Administradores_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/administradores/index';
        $opciones['total_rows'] = $this->Administradores_model->numeroAdministradores();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Administradores_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_administradores/cabecera_administradores_view');
        $this->load->view('menu_administradores_view');
        $this->load->view('folder_administradores/administradores_view',$data);
        $this->load->view('footer_view');
    }
    
    public function insertar_administrador_view(){
        $this->load->helper('form');
        $this->load->view('folder_administradores/cabecera_administradores_view');
        $this->load->view('menu_administradores_view');
        $this->load->view('folder_administradores/administradores_insertar');
        $this->load->view('footer_view');
    }

    public function insertar_administrador(){
        $this->load->model('Administradores_model');
        $this->reglas_validacion();
        if($this->form_validation->run()==FALSE){
            $this->insertar_administrador_view();
        }
        else{
            $data = array(
                'nombres' => $this->input->post('nombres'),
                'apellidos' => $this->input->post('apellidos'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
                'sexo' => $this->input->post('sexo'),
                'celular' => $this->input->post('celular'),
                'correo' => $this->input->post('correo'),
                'estado' => 1
            );
            $this->Administradores_model->insertarAdministrador($data);
            redirect('index.php/administradores/paginar');
        }
    }
    
    public function buscar_administrador_view(){
        $this->load->model('Administradores_model');
        $this->load->library('pagination');
        $busqueda = $this->input->post('busqueda');
        $parametro = $this->input->post('parametro');
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/administradores/index';
        $opciones['total_rows'] = $this->Administradores_model->numeroAdministradoresBusqueda($busqueda,$parametro);
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Administradores_model->mostrarResultadosBusqueda($opciones['per_page'],$desde,$busqueda,$parametro);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_administradores/cabecera_administradores_view');
        $this->load->view('menu_administradores_view');
        $this->load->view('folder_administradores/administradores_view',$data);
        $this->load->view('footer_view');
    }
    
    public function editar_administrador_view(){
        $this->load->helper('form');
        $id = $this->uri->segment('3');
        $this->load->model('Administradores_model');
        $query = $this->db->get_where("usuarios",array("id_usuarios"=>$id));
        $queryPer = $this->db->get_where("permisos",array("id_usuarios"=>$id));
        $data['datos'] = $query->result();
        $data['datosPer'] = $queryPer->result();
        $data['old_id'] = $id;
        $this->load->view('folder_administradores/cabecera_administradores_view');
        $this->load->view('menu_administradores_view');
        $this->load->view('folder_administradores/administradores_editar',$data);
        $this->load->view('footer_view');
    }
    
    public function editar_administrador(){
        $this->load->model('Administradores_model');
        $data = array( 
            'nombres' => $this->input->post('nombres'),
            'apellidos' => $this->input->post('apellidos'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
            'sexo' => $this->input->post('sexo'),
            'celular' => $this->input->post('celular'),
            'correo' => $this->input->post('correo'),
            'estado' => 1
            );
            $old_id = $this->input->post('old_id'); 
            $this->Administradores_model->editarAdministrador($data,$old_id);
            redirect('index.php/administradores/paginar');
    }
    
    public function editar_administrador_permisos_view(){
        $this->load->helper('form');
        $id = $this->uri->segment('3');
        $this->load->model('Administradores_model');
        $query = $this->db->get_where("usuarios",array("id_usuarios"=>$id));
        $queryPer = $this->db->get_where("permisos",array("id_usuarios"=>$id));
        $data['datos'] = $query->result();
        $data['datosPer'] = $queryPer->result();
        $data['old_id'] = $id; 
        $this->load->view('folder_administradores/cabecera_administradores_view');
        $this->load->view('menu_administradores_view');
        $this->load->view('folder_administradores/administradores_editar_permisos',$data);
        $this->load->view('footer_view');
    }
    
    public function editar_administrador_permisos(){
        $this->load->model('Administradores_model');
        $data_per = array( 
            'id_usuarios' => $this->input->post('id_usuarios'),
            'agregar' => $this->input->post('agregar'),
            'buscar' => $this->input->post('buscar'),
            'editar' => $this->input->post('editar'),
            'eliminar' => $this->input->post('eliminar'),
            'word' => $this->input->post('word'),
            'excel' => $this->input->post('excel'),
            'pdf' => $this->input->post('pdf')
        );
        $old_id = $this->input->post('old_id'); 
        $this->Administradores_model->editarAdministradorPermisos($data_per,$old_id);
        redirect('index.php/administradores/paginar');
    }

    public function eliminar_administrador(){
        $this->load->model('Administradores_model'); 
        $id = $this->uri->segment('3'); 
        $this->Administradores_model->eliminarAdministrador($id);
        redirect('index.php/administradores/paginar');
    }
    
    public function reglas_validacion(){
        $config = array(
            array(
                'field'=>'nombres',
                'label'=>'nombres',
                'rules'=>'required'
            ),
            array(
                'field'=>'apellidos',
                'label'=>'apellidos',
                'rules'=>'required'
            ),
            array(
                'field'=>'username',
                'label'=>'username',
                'rules'=>'trim|required|callback_validar_username'
            ),
            array(
                'field'=>'password',
                'label'=>'password',
                'rules'=>'required|min_length[8]|max_length[15]'
            ),
            array(
                'field'=>'fecha_nacimiento',
                'label'=>'fecha_nacimiento',
                'rules'=>'required'
            ),
            array(
                'field'=>'sexo',
                'label'=>'sexo',
                'rules'=>'required'
            ),
            array(
                'field'=>'celular',
                'label'=>'celular',
                'rules'=>'trim|required|numeric|min_length[10]|callback_validar_celular'
            ),
            array(
                'field'=>'correo',
                'label'=>'correo',
                'rules'=>'trim|required|valid_email|callback_validar_correo'
            ),
            array(
                'field'=>'agregar',
                'label'=>'agregar',
                'rules'=>'required'
            ),
            array(
                'field'=>'buscar',
                'label'=>'buscar',
                'rules'=>'required'
            ),
            array(
                'field'=>'editar',
                'label'=>'editar',
                'rules'=>'required'
            ),
            array(
                'field'=>'eliminar',
                'label'=>'eliminar',
                'rules'=>'required'
            ),
            array(
                'field'=>'word',
                'label'=>'word',
                'rules'=>'required'
            ),
            array(
                'field'=>'excel',
                'label'=>'excel',
                'rules'=>'required'
            ),
            array(
                'field'=>'pdf',
                'label'=>'pdf',
                'rules'=>'required'
            )
        );
        $this->form_validation->set_rules($config);
    }
    
    public function reglas_validacion_busqueda(){
        $config = array(
            array(
                'field'=>'busqueda',
                'label'=>'busqueda',
                'rules'=>'required'
            )
        );
        $this->form_validation->set_rules($config);
    }

    public function validar_username($username){
        $this->load->model('Administradores_model');
        if($this->Administradores_model->existeUsername($username)){
            $this->form_validation->set_message('validar_username', 'El usuario ' .$username. ' ya está registrado');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function validar_celular($celular){
        $this->load->model('Administradores_model');
        if($this->Administradores_model->existeCelular($celular)){
            $this->form_validation->set_message('validar_celular', 'El celular ' .$celular. ' ya está registrado');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function validar_correo($correo){
        $this->load->model('Administradores_model');
        if($this->Administradores_model->existeCorreo($correo)){
            $this->form_validation->set_message('validar_correo', 'El correo ' .$correo. ' ya está registrado');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }

    public function paginar(){
        $this->load->model('Administradores_model');
        $this->load->library('pagination');
        $opciones = array();
        $desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $opciones['per_page'] = 10;
        $opciones['num_links'] = 5;
        $opciones['base_url'] = base_url().'index.php/administradores/index';
        $opciones['total_rows'] = $this->Administradores_model->numeroAdministradores();
        $opciones['uri_segment'] = 3;
        $opciones['first_link'] = 'Primero';
        $opciones['last_link'] = 'Ultimo';
        $opciones['next_link'] = 'Siguiente';
        $opciones['prev_link'] = 'Anterior';
        $this->pagination->initialize($opciones);
        $data['lista'] = $this->Administradores_model->mostrarResultados($opciones['per_page'],$desde);
        $data['paginacion'] = $this->pagination->create_links();
        $this->load->view('folder_administradores/cabecera_administradores_view');
        $this->load->view('menu_administradores_view');
        $this->load->view('folder_administradores/administradores_view',$data);
        $this->load->view('footer_view');
    }
    
    public function exportar_word(){
        $this->load->library('word');
        $this->load->model('Administradores_model');
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
        $estiloFuenteTipoFechaHora = array('bold'=>true, 'italic'=>true, 'size'=>8);
        $estiloParrafoTipoFechaHora = array('align'=>'right');
//        $section->addText(' ');
//        $section->addText('Tipo de usuario: Administrador', $estiloFuenteTipoFechaHora);
//        $section->addText('Fecha: '.date("d-m-Y"), $estiloFuenteTipoFechaHora);
//        $section->addText('Hora: '.date("H:i:s"), $estiloFuenteTipoFechaHora);
        
        
        
        
        $section->addText('Reporte realizado el '.date("d-m-Y"). ' a las '.  date("H:i:s"), $estiloFuenteTipoFechaHora, $estiloParrafoTipoFechaHora);
        $section->addText(' ');
        //Tipo, fecha y hora

        //Lista de administradores
        $estiloFuenteLista = array('bold'=>true, 'italic'=>true, 'size'=>18);
        $estiloParrafoLista = array('align'=>'center');
        $section->addText('Lista de administradores', $estiloFuenteLista, $estiloParrafoLista);
        //Lista de administradores

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
        $table->addCell(2000, $styleCell)->addText('Nombres', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Apellidos', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Username', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Fecha de nacimiento', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Sexo', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Celular', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Correo', $fontStyle);
        
        //Obtenemos el numero de filas de la tabla seleccionada
        $contenido = $this->Administradores_model->obtenerResultadosExportarWord();
        //Obtenemos el numero de filas de la tabla seleccionada
        
        
        //Recorremos la tabla
        for ($row = 0; $row < count($this->Administradores_model->numeroAdministradores()); $row++){
            //Agregamos una fila por cada recorrido 
            
            //Recorremos el array y asignamos sus valores correspondientes
            foreach ($contenido as $result){
                $table->addRow();
                $table->addCell(500)->addText(htmlspecialchars($result['id_usuarios']));
                $table->addCell(2000)->addText(htmlspecialchars($result['nombres']));
                $table->addCell(2000)->addText(htmlspecialchars($result['apellidos']));
                $table->addCell(2000)->addText(htmlspecialchars($result['username']));
                $table->addCell(2000)->addText(htmlspecialchars($result['fecha_nacimiento']));
                $table->addCell(2000)->addText(htmlspecialchars($result['sexo']));
                $table->addCell(2000)->addText(htmlspecialchars($result['celular']));
                $table->addCell(2000)->addText(htmlspecialchars($result['correo']));
            }
            //Recorremos el array y asignamos sus valores correspondientes
        }
        //Recorremos la tabla
        
        //Creamos y guardamos el documento
        $filename='Lista_Administradores.docx'; //save our document as this file name
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
        $this->load->model('Administradores_model');
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
        $estiloFuenteTipoFechaHora = array('bold'=>true, 'italic'=>true, 'size'=>8);
        $estiloParrafoTipoFechaHora = array('align'=>'right');
//        $section->addText(' ');
//        $section->addText('Tipo de usuario: Administrador', $estiloFuenteTipoFechaHora);
//        $section->addText('Fecha: '.date("d-m-Y"), $estiloFuenteTipoFechaHora);
//        $section->addText('Hora: '.date("H:i:s"), $estiloFuenteTipoFechaHora);
        $section->addText('Reporte realizado el '.date("d-m-Y"). ' a las '.  date("H:i:s"), $estiloFuenteTipoFechaHora, $estiloParrafoTipoFechaHora);
//        $section->addText(' ');
        //Tipo, fecha y hora

        //Perfil de administrador
        $estiloFuentePerfil = array('bold'=>true, 'italic'=>true, 'size'=>18);
        $estiloParrafoPerfil = array('align'=>'center');
        $section->addText(' ', $estiloFuentePerfil);
        $section->addText('Perfil del administrador', $estiloFuentePerfil, $estiloParrafoPerfil);
        //Perfil de administrador

        //Obtenemos el numero de filas de la tabla seleccionada
        $contenido = $this->Administradores_model->obtenerResultadosExportarWord_ID($id);
        //Obtenemos el numero de filas de la tabla seleccionada
        $estiloFuenteContenidoTitulo = array('bold'=>true, 'italic'=>true, 'size'=>12);
        $estiloFuenteContenido = array('bold'=>false, 'italic'=>true, 'size'=>12);
        
        //Recorremos los datos
        $section->addText(' ', $estiloFuenteContenidoTitulo);
        foreach ($contenido as $result){
            $section->addText('ID: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['id_usuarios'], $estiloFuenteContenido);
            $section->addText('Nombres: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['nombres'], $estiloFuenteContenido);
            $section->addText('Apellidos: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['apellidos'], $estiloFuenteContenido);
            $section->addText('Username: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['username'], $estiloFuenteContenido);
            $section->addText('Fecha de nacimiento: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['fecha_nacimiento'], $estiloFuenteContenido);
            $section->addText('Sexo: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['sexo'], $estiloFuenteContenido);
            $section->addText('Celular: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['celular'], $estiloFuenteContenido);
            $section->addText('Correo: ', $estiloFuenteContenidoTitulo);
            $section->addText($result['correo'], $estiloFuenteContenido);
            $nomAdmin = "".$result['nombres']." ".$result['apellidos']."";
        }
        //Recorremos los datos
        
        //Creamos y guardamos el documento
        $filename="Administrador_".$nomAdmin.".docx";
//        $filename='Perfil_de_administrador.docx'; //save our document as this file name
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
        $objDrawing->setCoordinates('C1');
        $objDrawing->setWorksheet($this->excel->getActiveSheet());
        //Agregar imagen
        
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
                ->mergeCells('A4:H4');
        //Alineación izquierda, derecha o centro
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        //Cabecera del reporte
        
        //Titulo Lista de administradores
        $this->excel->setActiveSheetIndex(0)->setCellValue('A6','Lista de administradores');
        $this->excel->getActiveSheet()->getStyle("A6")->getFont()->setBold(true)
                ->setSize(18);
        $this->excel->setActiveSheetIndex(0)->mergeCells('A6:H6');
        $this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        //Titulo Lista de administradores
                    
        //Datos array
        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A8','ID')
            ->setCellValue('B8','Nombres')
            ->setCellValue('C8','Apellidos')
            ->setCellValue('D8','Username')
            ->setCellValue('E8','Fecha de nacimiento')
            ->setCellValue('F8','Sexo')
            ->setCellValue('G8','Celular')
            ->setCellValue('H8','Correo');
        $this->excel->getActiveSheet()->getStyle("A8:H8")->getFont()->setBold(true);
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->excel->getActiveSheet()->getStyle('A8:H8')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setTitle('Lista de administradores')
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
        $this->load->database();
        $this->load->model('Administradores_model');
        $administradores = $this->Administradores_model->obtenerResultadosExportarExcel();
        $this->excel->getActiveSheet()->fromArray($administradores, null, 'A9');
        
        //Datos array
        
        //Archivo descargado
        $filename='Lista_de_administradores.xls';
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
        
        //Titulo Lista de administradores
        $this->excel->setActiveSheetIndex(0)->setCellValue('B6','Perfil del administrador');
        $this->excel->getActiveSheet()->getStyle("B6")->getFont()->setBold(true)
                ->setSize(18);
        $this->excel->setActiveSheetIndex(0)->mergeCells('B6:F6');
        $this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        //Titulo Lista de administradores
                    
        //Datos array
        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('B8','ID:')
                ->mergeCells('C8:F8')
            ->setCellValue('B9','Nombres:')
                ->mergeCells('C9:F9')
            ->setCellValue('B10','Apellidos:')
                ->mergeCells('C10:F10')
            ->setCellValue('B11','Username:')
                ->mergeCells('C11:F11')
            ->setCellValue('B12','Fecha de nacimiento:')
                ->mergeCells('C12:F12')
            ->setCellValue('B13','Sexo:')
                ->mergeCells('C13:F13')
            ->setCellValue('B14','Celular:')
                ->mergeCells('C14:F14')
            ->setCellValue('B15','Correo:')
                ->mergeCells('C15:F15');
        
        $this->excel->getActiveSheet()->getStyle("B8:B15")->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->setTitle('Perfil del administrador')
            ->getColumnDimension('B')
                ->setAutoSize(TRUE);
        $this->load->database();
        $this->load->model('Administradores_model');
        $administradores = $this->Administradores_model->obtenerResultadosExportarExcel_ID($id);
        foreach ($administradores as $result){
            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('C8',$result['id_usuarios'])
            ->setCellValue('C9',$result['nombres'])
            ->setCellValue('C10',$result['apellidos'])
            ->setCellValue('C11',$result['username'])
            ->setCellValue('C12',$result['fecha_nacimiento'])
            ->setCellValue('C13',$result['sexo'])
            ->setCellValue('C14',$result['celular'])
            ->setCellValue('C15',$result['correo']);
            $nomAdmin = "".$result['nombres']." ".$result['apellidos']."";
        }
        $this->excel->getActiveSheet()->getStyle('C8:C15')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        //Datos array
        
        //Archivo descargado
        $filename="Administrador_".$nomAdmin.".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
        //Archivo descargado
    }

    public function exportar_pdf(){
        $this->load->model('Administradores_model');
        $data['title']='Lista de administradores'; 
        $data['author']='Administrador';
	$data['subject']='Lista de administradores'; 	 
	$data['content']= $this->Administradores_model->obtenerResultadosExportarPDF();
	$this->load->view('folder_administradores/administradores_exportar_pdf',$data);
    }
    
    public function exportar_pdf_id(){
        $this->load->model('Administradores_model');
        $id = $this->uri->segment('3');
        $data['title']='Perfil del administrador'; 
        $data['author']='Administrador';
	$data['subject']='Perfil del administrador';	 
	$data['content']= $this->Administradores_model->obtenerResultadosExportarPDF_ID($id);
	$this->load->view('folder_administradores/administradores_exportar_pdf_id',$data);
    }
    
}