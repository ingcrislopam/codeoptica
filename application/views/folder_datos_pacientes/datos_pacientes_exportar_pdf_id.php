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
//    $this->pdf->ezText("Reporte realizado por: ".$nombresUsu."",8,array('justification'=>'lefth'));
//    $this->pdf->ezText("Tipo de usuario: Medico",8,array('justification'=>'lefth'));
    date_default_timezone_set("America/Lima");
//    $this->pdf->ezText("Fecha del reporte: ". date("d/m/Y")."",8,array('justification'=>'lefth'));
//    $this->pdf->ezText("Hora del reporte: ". date("H:i:s")."",8,array('justification'=>'lefth'));
//    $this->pdf->ezText("\n",12,array('justification'=>'center'));
//    $this->pdf->ezText("\n",12,array('justification'=>'center'));
//    $this->pdf->ezText($title."\n",18,array('justification'=>'center'));
    $this->pdf->ezText("Reporte realizado el ". date("d/m/Y")." a las ".  date("H:i:s")."",8,array('justification'=>'right'));
    $this->pdf->ezText("\n",12,array('justification'=>'center'));
    $this->pdf->ezText($title."\n",16,array('justification'=>'center'));
    foreach ($content as $results) {
        $contenido[]=array
        (
            $this->pdf->ezText("<u>ID:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->id_datos_pacientes."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Paciente:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->nombresPaci."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Cedula:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->cedula."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Fecha de nacimiento:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->fechaPaci."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Sexo:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->sexoPaci."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Ciudad:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->ciudad."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Direccion:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->direccion."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("\n",6,array('justification'=>'lefth')),
            $this->pdf->ezText("<u>Correo:</u>",12,array('justification'=>'lefth')),
            $this->pdf->ezText("".$results->correoPaci."",10,array('justification'=>'lefth'))
//            $this->pdf->ezText("ID: ". $results->id_datos_pacientes."",11,array('justification'=>'lefth')),
//            $this->pdf->ezText("Medico: ".$results->nombresMedi."",11,array('justification'=>'lefth')),
//            $this->pdf->ezText("Paciente: ".$results->nombresPaci."",11,array('justification'=>'lefth')),
//            $this->pdf->ezText("Cedula: ".$results->cedula."",11,array('justification'=>'lefth')),
//            $this->pdf->ezText("Fecha de nacimiento: ".$results->fechaPaci."",11,array('justification'=>'lefth')),
//            $this->pdf->ezText("Sexo: ".$results->sexoPaci."",11,array('justification'=>'lefth')),
//            $this->pdf->ezText("Ciudad: ".$results->ciudad."",11,array('justification'=>'lefth')),
//            $this->pdf->ezText("Direccion: ".$results->direccion."",11,array('justification'=>'lefth')),
//            $this->pdf->ezText("Correo: ".$results->correoPaci."",11,array('justification'=>'lefth'))
        );
    }
    
//    $this->pdf->ezTable($contenido);
    
    //sirve para poner la imagen
    ob_end_clean();
    //sirve para poner la imagen
    $this->pdf->ezStream();
?>