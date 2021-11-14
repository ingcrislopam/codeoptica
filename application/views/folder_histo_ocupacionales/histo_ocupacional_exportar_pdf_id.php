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
        'width'=>400
    );
    $this->pdf->ezImage("".base_url()."/imagenes/logo.jpg", 0, 350, 'none', 'center');
//    $this->pdf->ezText("\n",12,array('justification'=>'center'));
//    $this->pdf->ezText("Reporte realizado por: ".$nombresUsu."",10,array('justification'=>'lefth'));
//    $this->pdf->ezText("Tipo de usuario: Medico",10,array('justification'=>'lefth'));
    date_default_timezone_set("America/Lima");
//    $this->pdf->ezText("Fecha del reporte: ". date("d/m/Y")."",10,array('justification'=>'lefth'));
//    $this->pdf->ezText("Hora del reporte: ". date("H:i:s")."",10,array('justification'=>'lefth'));
//    $this->pdf->ezText("\n",12,array('justification'=>'center'));
//    $this->pdf->ezText($title."\n",20,array('justification'=>'center'));
    $this->pdf->ezText("Reporte realizado el ". date("d/m/Y")." a las ".  date("H:i:s")."",8,array('justification'=>'right'));
    $this->pdf->ezText("\n",12,array('justification'=>'center'));
    $this->pdf->ezText($title."\n",16,array('justification'=>'center'));
    foreach ($content as $results) {
        $contenido[]=array
        (
            $this->pdf->ezText("<u>Medico</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText($results->nombresMedi,10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Paciente</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText($results->nombresPacien,10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Fecha de atencion</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText($results->fecha_horarios,10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Lentes</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText($results->lentes,10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",12,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>AGUDEZA VISUAL</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>VISION LEJANA</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->agudeza_vision_lejana_od."    O. IZQUIERDO:".$results->agudeza_vision_lejana_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>VISION CERCANA</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->agudeza_vision_cercana_od."    O. IZQUIERDO:".$results->agudeza_vision_cercana_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>PERIMETRIA</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->agudeza_perimetria_od."    O. IZQUIERDO:".$results->agudeza_perimetria_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>TONOMETRIA</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->agudeza_tonometria_od."    O. IZQUIERDO:".$results->agudeza_tonometria_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>FONDO DE OJO</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->agudeza_fondo_ojo_od."    O. IZQUIERDO:".$results->agudeza_fondo_ojo_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>EXAMEN EXTERNO</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->agudeza_examen_externo_od."    O. IZQUIERDO:".$results->agudeza_examen_externo_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>FORIAS</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>VISION LEJANA</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->forias_vision_lejana."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>VISION PROXIMA</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->forias_vision_proxima."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>TEST DE COLOR</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->forias_test_color."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>TEST ESTERIOPSIS</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->forias_test_esteriopsis."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>DIAGNOSTICO</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->forias_diagnostico."",10,array('justification'=>'lefth'))
        );
    }
    ob_end_clean();
    $this->pdf->ezStream();
?>