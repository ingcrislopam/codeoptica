
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
        <h3>REPORTES GENERALES</h3>
        <?php
            if($word=="Si"){
                echo "<p align='center'><a href = '".base_url()."index.php/datos_pacientes/exportar_word/'><img src='".base_url()."imagenes/word.png' title='WORD'></a>";
            }
            else{
                echo "<p align='center'><a><img src='".base_url()."imagenes/wordbn.png' title='WORD'></a>";
            }
            echo " ";
            if($excel=="Si"){
                echo "<a href = '".base_url()."index.php/datos_pacientes/exportar_excel/'><img src='".base_url()."imagenes/excel.png' title='EXCEL'></a>";
            }
            else{
                echo "<a><img src='".base_url()."imagenes/excelbn.png' title='EXCEL'></a>";
            }
            echo " ";
            if($pdf=="Si"){
                echo "<a href = '".base_url()."index.php/datos_pacientes/exportar_pdf/'><img src='".base_url()."imagenes/pdf.png' title='PDF'></a></p>";
            }
            else{
                echo "<a><img src='".base_url()."imagenes/pdfbn.png' title='PDF'></a></p>";
            }
        ?>
        </div>
        <br>
        <div id="contenedor">
        <?php
                echo form_open('index.php/datos_pacientes/buscar_datos_paciente_view');
                echo "<h3>BUSQUEDA DEL PERFIL DEL PACIENTE POR</h3>";
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td nowrap>";
                        $busquedas = array(
//                            '' => 'Seleccione',
                            'cedula' => 'Cedula',
                            'fechaPaci' => 'Fecha de nacimiento',
                            'sexoPaci' => 'Sexo',
                            'ciudad' => 'Ciudad',
                            'direccion' => 'Direccion',
                            'correoPaci' => 'Correo'
                           );
                        echo form_dropdown('busqueda', $busquedas);
                        echo form_error('busqueda','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                    if($buscar=="Si"){
                        echo "<td nowrap>";
                            echo form_input(array('id'=>'parametro','name'=>'parametro','placeholder'=>'Escriba los datos a buscar','value'=>set_value('parametro')));
                            echo form_error('parametro','<span class="mensaje-error-azul">','</span>');
                        echo "</td>";
                        echo "<td nowrap>";
                            echo form_input(array('type'=>'image', 'src'=>'http://localhost/codeoptica/imagenes/buscar.png', 'title'=>'BUSCAR PERFIL DEL PACIENTE'));
                        echo "</td>";
                    }
                    else{
                        echo "<td nowrap>";
                            echo form_input(array('id'=>'parametro','name'=>'parametro','placeholder'=>'Escriba los datos a buscar', 'readonly'=>'false', 'value'=>set_value('parametro')));
                            echo form_error('parametro','<span class="mensaje-error-azul">','</span>');
                        echo "</td>";
                        echo "<td nowrap>";
                            echo "<a><img src='".base_url()."imagenes/buscarbn.png' title='BUSCAR PERFIL DEL PACIENTE'></a>";
                        echo "</td>";
                    }
                echo "</table>";
                echo form_close(); 
         ?> 
        
        <h3>LISTA DE PERFILES DE PACIENTES</h3>
        <?php
        echo "<table align='center'>";
        echo "<tr>";
        echo "<td>";
        if($agregar=="Si"){
            echo "<a href = '".base_url()."index.php/datos_pacientes/insertar_datos_paciente_view/'><img src='".base_url()."imagenes/agregar.png'> Nuevo perfil del paciente</a>";
        }
        else{
            echo "<a><img src='".base_url()."imagenes/agregarbn.png'> Nuevo perfil del paciente</a>";
        }
            echo "<div id='datos'>";
            echo "<table border = '1' align='center'>";
            echo "<thead id='cabecera'>";
            echo "<tr>"; 
            echo "<td nowrap><b>ID</b></td>";
//            echo "<td nowrap><b>Médico</b></td>";
            echo "<td nowrap><b>Paciente</b></td>"; 
            echo "<td nowrap><b>Cedula</b></td>";
            echo "<td nowrap><b>Fecha de nacimiento</b></td>";
            echo "<td nowrap><b>Sexo</b></td>";
            echo "<td nowrap><b>Ciudad</b></td>";
            echo "<td nowrap><b>Direccion</b></td>";
            echo "<td nowrap><b>Correo</b></td>";
            echo "<td align='center'><b>Opciones</b></td>";
            echo "<td align='center'><b>Reportes</b></td>";
            echo "</thead>";
//            echo "<tr>"; 
				
            foreach($lista as $d) { 
                echo "<tr>"; 
                echo "<td nowrap>".$d->id_datos_pacientes."</td>";
//                echo "<td nowrap>".$d->nombresMedi."</td>";
                echo "<td nowrap>".$d->nombresPaci."</td>";
                echo "<td nowrap>".$d->cedula."</td>";
                echo "<td nowrap>".$d->fechaPaci."</td>";
                echo "<td nowrap>".$d->sexoPaci."</td>";
                echo "<td nowrap>".$d->ciudad."</td>";
                echo "<td nowrap>".$d->direccion."</td>";
                echo "<td nowrap>".$d->correoPaci."</td>";
                
                if($editar=="Si"){
                    echo "<td nowrap><a href = '".base_url()."index.php/datos_pacientes/editar_datos_paciente_view/"
                    .$d->id_datos_pacientes."'><img src='".base_url()."imagenes/editar.png' title='EDITAR'></a>";
                }
                else{
                    echo "<td nowrap><a><img src='".base_url()."imagenes/editarbn.png' title='EDITAR'></a>";
                }
                echo "  ";
                if($eliminar=="Si"){
                    echo "<a href = '".base_url()."index.php/datos_pacientes/eliminar_datos_paciente/"
                    .$d->id_datos_pacientes."'><img src='".base_url()."imagenes/eliminar.png' title='ELIMINAR'></a></td>";
                }
                else{
                    echo "<a><img src='".base_url()."imagenes/eliminarbn.png' title='ELIMINAR'></a></td>";
                }
                
                if($word=="Si"){
                    echo "<td nowrap><a href = '".base_url()."index.php/datos_pacientes/exportar_word_id/"
                    .$d->id_datos_pacientes."'><img src='".base_url()."imagenes/word.png' title='WORD'></a>";
                }
                else{
                    echo "<td nowrap><a><img src='".base_url()."imagenes/wordbn.png' title='WORD'></a>";
                }
                echo " ";
                if($excel=="Si"){
                    echo "<a href = '".base_url()."index.php/datos_pacientes/exportar_excel_id/"
                    .$d->id_datos_pacientes."'><img src='".base_url()."imagenes/excel.png' title='EXCEL'></a>";
                }
                else{
                    echo "<a><img src='".base_url()."imagenes/excelbn.png' title='EXCEL'></a>";
                }
                echo " ";
                if($pdf=="Si"){
                    echo "<a href = '".base_url()."index.php/datos_pacientes/exportar_pdf_id/"
                    .$d->id_datos_pacientes."'><img src='".base_url()."imagenes/pdf.png' title='PDF'></a></td>";
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
        
        <p><?php echo $paginacion ?></p>
        </div>