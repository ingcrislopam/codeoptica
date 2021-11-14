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
//    $this->pdf->ezText("\n",12,array('justification'=>'center'));
//    $this->pdf->ezText("Reporte realizado por: ".$nombresUsu."",11,array('justification'=>'lefth'));
//    $this->pdf->ezText("Tipo de usuario: Medico",11,array('justification'=>'lefth'));
    date_default_timezone_set("America/Lima");
    $this->pdf->ezText("Reporte realizado el ". date("d/m/Y")." a las ".  date("H:i:s")." por ".$nombresUsu."",8,array('justification'=>'right'));
    $this->pdf->ezText("\n",12,array('justification'=>'center'));
    $this->pdf->ezText($title."\n",16,array('justification'=>'center'));
    
    foreach ($content as $results) {
        $contenido[]=array
        (
            $this->pdf->ezText("<u>ID:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("". $results->id_horarios."",10,array('justification'=>'lefth')),
//            $this->pdf->ezText("<u>Medico:</u>",12,array('justification'=>'lefth')),
//            $this->pdf->ezText("". $results->nombresMedi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Fecha:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("". $results->fecha_horarios."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Total de turnos:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("". $results->total_turnos."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Turnos disponibles:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("". $results->disponibles."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Turnos reservados:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("". $results->reservados."",10,array('justification'=>'lefth'))
        );
    }
    
//    $this->pdf->ezTable($contenido);
    
    //sirve para poner la imagen
    ob_end_clean();
    //sirve para poner la imagen
    
    $this->pdf->ezStream();
?>