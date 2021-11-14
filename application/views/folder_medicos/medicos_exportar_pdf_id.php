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
//    $this->pdf->ezText("Tipo de usuario: Administrador",8,array('justification'=>'lefth'));
    date_default_timezone_set("America/Lima");
//    $this->pdf->ezText("Fecha del reporte: ". date("d/m/Y")."",8,array('justification'=>'lefth'));
//    $this->pdf->ezText("Hora del reporte: ". date("H:i:s")."",8,array('justification'=>'lefth'));
//    $this->pdf->ezText("\n",12,array('justification'=>'center'));
    $this->pdf->ezText("Reporte realizado el ". date("d/m/Y")." a las ".  date("H:i:s")."",8,array('justification'=>'right'));
    $this->pdf->ezText("\n",12,array('justification'=>'center'));
    $this->pdf->ezText($title."\n",16,array('justification'=>'center'));
    
    foreach ($content as $results) {
        $contenido[]=array
        (
            $this->pdf->ezText("ID: ". $results->id_usuarios."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("Nombres: ".$results->nombres."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("Apellidos: ".$results->apellidos."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("Username: ".$results->username."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("Fecha de nacimiento: ".$results->fecha_nacimiento."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("Sexo: ".$results->sexo."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("Celular: ".$results->celular."",10,array('justification'=>'lefth')),
            $this->pdf->ezText("Correo: ".$results->correo."",10,array('justification'=>'lefth'))
        );
    }
//    $this->pdf->ezTable($contenido);
    //sirve para poner la imagen
    ob_end_clean();
    //sirve para poner la imagen
    $this->pdf->ezStream();
?>