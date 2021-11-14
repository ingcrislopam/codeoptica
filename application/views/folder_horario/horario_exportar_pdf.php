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

    foreach ($content as $results) {
        $contenido[]=array
        (
            'ID'=>$results->id_horarios,
//            'Medico'=>$results->nombresMedi,
            'Fecha'=>$results->fecha_horarios,
            'Total de turnos'=>$results->total_turnos,
            'Disponibles'=>$results->disponibles,
            'Reservados'=>$results->reservados
        );
    
    }
    $options = array(
        'shadeCol'=>array(0.10,0.10,0.10),                                        
        'width'=>400   //Ancho de la Tabla.
    );
    $this->pdf->ezImage("".base_url()."/imagenes/logo.jpg", 0, 300, 'none', 'center');
//    $this->pdf->ezText("Ocean Optical\n",30,array('justification'=>'center'));
    
//    $this->pdf->ezText("Usuario: ".$nombresUsu."\n",20,array('justification'=>'center'));
    $this->pdf->ezText("\n",12,array('justification'=>'center'));
    $this->pdf->ezText("Reporte realizado por: ".$nombresUsu."",10,array('justification'=>'lefth'));
    $this->pdf->ezText("Tipo de usuario: Medico",10,array('justification'=>'lefth'));
    date_default_timezone_set("America/Lima");
    $this->pdf->ezText("Fecha del reporte: ". date("d/m/Y")."",10,array('justification'=>'lefth'));
    $this->pdf->ezText("Hora del reporte: ". date("H:i:s")."",10,array('justification'=>'lefth'));
    $this->pdf->ezText("\n",12,array('justification'=>'center'));
    $this->pdf->ezText($title."\n",12,array('justification'=>'center'));
    
    
    
    
    $this->pdf->ezTable($contenido);
    
    //sirve para poner la imagen
    ob_end_clean();
    //sirve para poner la imagen
    
    $this->pdf->ezStream();
?>