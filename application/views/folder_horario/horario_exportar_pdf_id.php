<?php
    if (isset($this->session->userdata['logged_in'])) {
        $idUsuario = ($this->session->userdata['logged_in']['idUsuario']);
        $nombresUsu = ($this->session->userdata['logged_in']['nombresUsu']);
    }
    else {
        redirect('index.php/login/index');
    }
?>
<?php 
    $this->pdf->Cezpdf($paper='a4',$orientation='portrait');
    $this->pdf->selectFont(APPPATH.'/third_party/ezpdf/fonts/Helvetica-Oblique.afm'); // Tipo de letra

    $pdf_info = array ('Title'=>$title,'Author'=>$nombresUsu,'Subject'=>$subject,);
    $this->pdf->addInfo($pdf_info);    
    
    $options = array(
        'shadeCol'=>array(0.10,0.10,0.10),                                        
        'width'=>400   //Ancho de la Tabla.
    );
    $this->pdf->ezImage("".base_url()."/imagenes/logo.jpg", 0, 350, 'none', 'center');
//    $this->pdf->ezText("Ocean Optical\n",30,array('justification'=>'center'));
    
//    $this->pdf->ezText("Usuario: ".$nombresUsu."\n",20,array('justification'=>'center'));
    $this->pdf->ezText("\n",12,array('justification'=>'center'));
    $this->pdf->ezText("Reporte realizado por: ".$nombresUsu."",11,array('justification'=>'lefth'));
    $this->pdf->ezText("Tipo de usuario: Medico",11,array('justification'=>'lefth'));
    date_default_timezone_set("America/Lima");
    $this->pdf->ezText("Fecha del reporte: ". date("d/m/Y")."",11,array('justification'=>'lefth'));
    $this->pdf->ezText("Hora del reporte: ". date("H:i:s")."",11,array('justification'=>'lefth'));
    $this->pdf->ezText("\n",12,array('justification'=>'center'));
    $this->pdf->ezText("\n",12,array('justification'=>'center'));
    $this->pdf->ezText($title."\n",18,array('justification'=>'center'));
    
    foreach ($content as $results) {
        $contenido[]=array
        (
            $this->pdf->ezText("ID: ". $results->id_horarios."",11,array('justification'=>'lefth')),
            $this->pdf->ezText("Medico: ".$results->nombresMedi."",11,array('justification'=>'lefth')),
            $this->pdf->ezText("Fecha: ".$results->fecha_horarios."",11,array('justification'=>'lefth')),
            $this->pdf->ezText("Total de turnos: ".$results->total_turnos."",11,array('justification'=>'lefth')),
            $this->pdf->ezText("Turnos disponibles: ".$results->disponibles."",11,array('justification'=>'lefth')),
            $this->pdf->ezText("Turnos reservados: ".$results->reservados."",11,array('justification'=>'lefth'))
        );
    }
    
//    $this->pdf->ezTable($contenido);
    
    //sirve para poner la imagen
    ob_end_clean();
    //sirve para poner la imagen
    
    $this->pdf->ezStream();
?>