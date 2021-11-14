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
            $this->pdf->ezText("<u>Medico:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText($results->nombresMedi,10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Paciente:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText($results->nombresPacien,10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Fecha:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText($results->fecha_horarios,10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",12,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>AGUDEZA VISUAL</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>VL</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->vl_od."    O. IZQUIERDO:".$results->vl_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>CC</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->cc_od."    O. IZQUIERDO:".$results->cc_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>VP</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->vp_od."    O. IZQUIERDO:".$results->vp_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>CC</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->cc2_od."    O. IZQUIERDO:".$results->cc2_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>PH</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->ph_od."    O. IZQUIERDO:".$results->ph_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("DP: ". $results->dp."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("PPC: ". $results->ppc."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("FORIA: ". $results->foria."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>MOTIVO DE CONSULTA</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText($results->motivo_consulta,10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>SIGNOS Y SINTOMAS</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText($results->signos_sintomas,10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>EXAMEN EXTERNO</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->examen_externo_od."    O. IZQUIERDO:".$results->examen_externo_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>ANTECEDENTES</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText($results->antecedentes,10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>ANTECEDENTES P</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText($results->antecedentes_p,10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>FONDO DE OJO</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->fondo_ojo_od."    O. IZQUIERDO:".$results->fondo_ojo_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>QUERATONERIA</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->queratoneria_od."    O. IZQUIERDO:".$results->queratoneria_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>RETINOSCOPIA</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->retinoscopia_od."    O. IZQUIERDO:".$results->retinoscopia_oi."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>SUBJETIVO</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("O. DERECHO:". $results->subjetivo_od."    O. IZQUIERDO:".$results->subjetivo_oi."",10,array('justification'=>'lefth'))
        );
    }
    ob_end_clean();
    $this->pdf->ezStream();
?>