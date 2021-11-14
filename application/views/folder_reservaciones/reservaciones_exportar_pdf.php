<?php
    if (isset($this->session->userdata['logged_in'])) {
        $nombresUsu = ($this->session->userdata['logged_in']['nombresUsu']);
    }
    else {
        redirect('index.php/login/index');
    }
?>
<?php 
    $this->pdf->selectFont(APPPATH.'/third_party/ezpdf/fonts/Helvetica-Oblique.afm');
    $pdf_info = array ('Title'=>$title,'Author'=>$nombresUsu,'Subject'=>$subject,);
    $this->pdf->addInfo($pdf_info);    
    foreach ($content as $results) {
        $contenido[]=array
        (
            'ID'=>$results->id_reservaciones,
            'Paciente'=>$results->nombresPacien,
            'Fecha'=>$results->fecha_horarios,
            'Turno'=>$results->turno,
            'Estado'=>$results->estado_reser
        );
    }
    $options = array(
        'shadeCol'=>array(0.10,0.10,0.10),                                        
        'width'=>400
    );
    $this->pdf->ezImage("".base_url()."/imagenes/logo.jpg", 0, 300, 'none', 'center');
//    $this->pdf->ezText("\n",12,array('justification'=>'center'));
//    $this->pdf->ezText("Reporte realizado por: ".$nombresUsu."",10,array('justification'=>'lefth'));
//    $this->pdf->ezText("Tipo de usuario: Recepcionista",10,array('justification'=>'lefth'));
    date_default_timezone_set("America/Lima");
//    $this->pdf->ezText("Fecha del reporte: ". date("d/m/Y")."",10,array('justification'=>'lefth'));
//    $this->pdf->ezText("Hora del reporte: ". date("H:i:s")."",10,array('justification'=>'lefth'));
//    $this->pdf->ezText("\n",12,array('justification'=>'center'));
//    $this->pdf->ezText($title."\n",16,array('justification'=>'center'));
    $this->pdf->ezText("Reporte realizado el ". date("d/m/Y")." a las ".  date("H:i:s")." por ".$nombresUsu."",8,array('justification'=>'right'));
    $this->pdf->ezText("\n",12,array('justification'=>'center'));
    $this->pdf->ezText($title."\n",16,array('justification'=>'center'));
    $this->pdf->ezTable($contenido);
    ob_end_clean();
    $this->pdf->ezStream();
?>