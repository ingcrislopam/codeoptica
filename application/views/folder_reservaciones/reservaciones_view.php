<?php
    if (isset($this->session->userdata['logged_in'])) {
        $idUsuario = ($this->session->userdata['logged_in']['idUsuario']);
        $nombresUsu = ($this->session->userdata['logged_in']['nombresUsu']);
        $agregar= ($this->session->userdata['logged_in']['agregar']);
        $buscar= ($this->session->userdata['logged_in']['buscar']);
        $editar = ($this->session->userdata['logged_in']['editar']);
        $eliminar = ($this->session->userdata['logged_in']['eliminar']);
        $word = ($this->session->userdata['logged_in']['word']);
        $excel = ($this->session->userdata['logged_in']['excel']);
        $pdf = ($this->session->userdata['logged_in']['pdf']);
    }
    else {
        redirect('index.php/login/index');
    }
?>
<div id="reportes">
<h3>PANEL DE CONTROL</h3>
<?php
    if($word=="Si"){
        echo "<p align='center'><a href = '".base_url()."index.php/reservaciones/exportar_word/'><img src='".base_url()."imagenes/word.png' title='WORD'></a>";
    }
    else{
        echo "<p align='center'><a><img src='".base_url()."imagenes/wordbn.png' title='WORD'></a>";
    }
    echo " ";
    if($excel=="Si"){
        echo "<a href = '".base_url()."index.php/reservaciones/exportar_excel/'><img src='".base_url()."imagenes/excel.png' title='EXCEL'></a>";
    }
    else{
        echo "<a><img src='".base_url()."imagenes/excelbn.png' title='EXCEL'></a>";
    }
    echo " ";
    if($pdf=="Si"){
        echo "<a href = '".base_url()."index.php/reservaciones/exportar_pdf/'><img src='".base_url()."imagenes/pdf.png' title='PDF'></a></p>";
    }
    else{
        echo "<a><img src='".base_url()."imagenes/pdfbn.png' title='PDF'></a></p>";
    }
?>
</div>
<br>
<div id="contenedor">
<?php
    echo form_open('index.php/reservaciones/buscar_reservacion_view');
    echo "<h3>BUSQUEDA DE RESERVACION POR</h3>";
    echo "<table align='center'>";
    echo "<tr>";
        echo "<td nowrap>";
            $busquedas = array(
//                '' => 'Seleccione',
                'fecha_horarios' => 'Fecha'
               );
            echo form_dropdown('busqueda', $busquedas);
            echo form_error('busqueda','<span class="mensaje-error-azul">','</span>');
        echo "</td>";
        if($buscar=="Si"){
            echo "<td>";
                echo form_label('Desde:');
            echo "</td>";
            echo "<td nowrap>";
                echo form_input(array('id'=>'parametro','name'=>'parametro','type'=>'date','value'=>set_value('parametro')));
                echo form_error('parametro','<span class="mensaje-error-azul">','</span>');
            echo "</td>";
            echo "<td>";
                echo form_label('Hasta:');
            echo "</td>";
            echo "<td nowrap>";
                echo form_input(array('id'=>'parametroH','name'=>'parametroH','type'=>'date','value'=>set_value('parametroH')));
                echo form_error('parametroH','<span class="mensaje-error-azul">','</span>');
            echo "</td>";
            echo "<td nowrap>";
                echo form_input(array('type'=>'image', 'src'=>'http://localhost/codeoptica/imagenes/buscar.png', 'title'=>'BUSCAR HORARIO Y TURNOS'));
            echo "</td>";
        }
        else{
            echo "<td>";
                echo form_label('Desde:');
            echo "</td>";
            echo "<td nowrap>";
                echo form_input(array('id'=>'parametro','name'=>'parametro','type'=>'date', 'readonly'=>'false', 'value'=>set_value('parametro')));
                echo form_error('parametro','<span class="mensaje-error-azul">','</span>');
            echo "</td>";
            echo "<td>";
                echo form_label('Hasta:');
            echo "</td>";
            echo "<td nowrap>";
                echo form_input(array('id'=>'parametroH','name'=>'parametroH','type'=>'date', 'readonly'=>'false', 'value'=>set_value('parametroH')));
                echo form_error('parametroH','<span class="mensaje-error-azul">','</span>');
            echo "</td>";
            echo "<td nowrap>";
                echo "<a><img src='".base_url()."imagenes/buscarbn.png' title='BUSCAR HORARIO Y TURNOS'></a>";
            echo "</td>";
        }
    echo "</table>";
    echo form_close(); 
?>
<h3>LISTA DE RESERVACIONES</h3>
<?php
    echo "<table align='center'>";
    echo "<tr>";
    echo "<td>";
    if($agregar=="Si"){
        echo "<a href = '".base_url()."index.php/reservaciones/insertar_reservacion_view/'><img src='".base_url()."imagenes/agregar.png'> Nueva reservacion</a>";
    }
    else{
        echo "<a><img src='".base_url()."imagenes/agregarbn.png'> Nueva reservacion</a>";
    }
        echo "<div id='datos'>";
        echo "<table border = '1' align='center'>";
        echo "<thead id='cabecera'>";
        echo "<tr>"; 
        echo "<td nowrap><b>ID</b></td>";
        echo "<td nowrap><b>Paciente</b></td>";
        echo "<td nowrap><b>Fecha</b></td>";
        echo "<td nowrap><b>Turno</b></td>";
        echo "<td nowrap><b>Estado</b></td>";
        echo "<td align='center'><b>Opciones</b></td>";
        echo "<td align='center'><b>Reportes</b></td>";
        echo "</thead>";	
        foreach($lista as $d) { 
            echo "<tr>"; 
            echo "<td nowrap>".$d->id_reservaciones."</td>";
            echo "<td nowrap>".$d->nombresPacien."</td>"; 
            echo "<td nowrap>".$d->fecha_horarios."</td>";
            echo "<td nowrap>".$d->turno."</td>";
            echo "<td nowrap>".$d->estado_reser."</td>";
            if($eliminar=="Si" && $d->estado_reser=="No atendido"){
                echo "<td nowrap><a href = '".base_url()."index.php/reservaciones/eliminar_reservacion/"
                .$d->id_reservaciones."'><img src='".base_url()."imagenes/eliminar.png' title='CANCELAR RESERVACION'></a></td>";
            }
            else{
                echo "<td nowrap><a><img src='".base_url()."imagenes/eliminarbn.png' title='CANCELAR RESERVACION'></a></td>";
            }

            if($word=="Si"){
                echo "<td nowrap><a href = '".base_url()."index.php/reservaciones/exportar_word_id/"
                .$d->id_reservaciones."'><img src='".base_url()."imagenes/word.png' title='WORD'></a>";
            }
            else{
                echo "<td nowrap><a><img src='".base_url()."imagenes/wordbn.png' title='WORD'></a>";
            }
            echo " ";
            if($excel=="Si"){
                echo "<a href = '".base_url()."index.php/reservaciones/exportar_excel_id/"
                .$d->id_reservaciones."'><img src='".base_url()."imagenes/excel.png' title='EXCEL'></a>";
            }
            else{
                echo "<a><img src='".base_url()."imagenes/excelbn.png' title='EXCEL'></a>";
            }
            echo " ";
            if($pdf=="Si"){
                echo "<a href = '".base_url()."index.php/reservaciones/exportar_pdf_id/"
                .$d->id_reservaciones."'><img src='".base_url()."imagenes/pdf.png' title='PDF'></a></td>";
            }
            else{
                echo "<a><img src='".base_url()."imagenes/pdfbn.png' title='PDF'></a></td>";
            }
        }
        echo "</table>";
        echo "</div>";
    echo "</td>";
    echo "</table>";
?>
<p align="center"><?php echo $paginacion;?></p>
</div>