<?php
    if (isset($this->session->userdata['logged_in'])) {
        $nombresUsu = ($this->session->userdata['logged_in']['nombresUsu']);
    }
    else {
        redirect('index.php/login/index');
    }
?>
<?php 
    $this->pdf->Cezpdf($paper='a4',$orientation='portrait');
    $this->pdf->selectFont(APPPATH.'/third_party/ezpdf/fonts/Helvetica-Oblique.afm');
    $pdf_info = array ('Title'=>$title,'Author'=>$nombresUsu,'Subject'=>$subject,);
    $this->pdf->addInfo($pdf_info);    
    $options = array(
        'shadeCol'=>array(0.10,0.10,0.10),                                        
        'width'=>400   //Ancho de la Tabla.
    );
    $this->pdf->ezImage("".base_url()."/imagenes/logo.jpg", 0, 350, 'none', 'center');
//    $this->pdf->ezText("\n",12,array('justification'=>'center'));
//    $this->pdf->ezText("Reporte realizado por: ".$nombresUsu."",8,array('justification'=>'lefth'));
//    $this->pdf->ezText("Tipo de usuario: Recepcionista",8,array('justification'=>'lefth'));
    date_default_timezone_set("America/Lima");
//    $this->pdf->ezText("Fecha del reporte: ". date("d/m/Y")."",8,array('justification'=>'lefth'));
//    $this->pdf->ezText("Hora del reporte: ". date("H:i:s")."",8,array('justification'=>'lefth'));
//    $this->pdf->ezText("\n",12,array('justification'=>'center'));
//    $this->pdf->ezText("\n",12,array('justification'=>'center'));
//    $this->pdf->ezText($title."\n",16,array('justification'=>'center'));
    $this->pdf->ezText("Reporte realizado el ". date("d/m/Y")." a las ".  date("H:i:s")." por ".$nombresUsu."",8,array('justification'=>'right'));
    $this->pdf->ezText("\n",12,array('justification'=>'center'));
    $this->pdf->ezText($title."\n",16,array('justification'=>'center'));
    foreach ($content as $results) {
        $contenido[]=array
        (
            $this->pdf->ezText("<u>ID:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("". $results->id_reservaciones."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Paciente:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("". $results->nombresPacien."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Fecha:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("". $results->fecha_horarios."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Turno:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("". $results->turno."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Estado:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("". $results->estado_reser."",10,array('justification'=>'lefth'))
//            $this->pdf->ezText("ID: ". $results->id_reservaciones."",11,array('justification'=>'lefth')),
//            $this->pdf->ezText("Paciente: ".$results->nombresPacien."",11,array('justification'=>'lefth')),
//            $this->pdf->ezText("Fecha: ".$results->fecha_horarios."",11,array('justification'=>'lefth')),
//            $this->pdf->ezText("Turno: ".$results->turno."",11,array('justification'=>'lefth')),
//            $this->pdf->ezText("Estado: Reservado",11,array('justification'=>'lefth'))
        );
    }
    ob_end_clean();
    $this->pdf->ezStream();
?>