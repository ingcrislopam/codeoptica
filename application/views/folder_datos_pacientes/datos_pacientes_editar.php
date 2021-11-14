<div id="contenedor_editar">        
            <?php
                echo form_open('index.php/datos_pacientes/editar_datos_paciente');
                echo form_hidden('old_id',$old_id);
                echo "<h3 align='center'>ACTUALIZAR PERFIL DEL PACIENTE</h3>";
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('ID:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'id_datos_pacientes','name'=>'id_datos_pacientes', 'readonly'=>'false', 'value'=>$datos[0]->id_datos_pacientes));
                        echo form_error('id_datos_pacientes','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
//                echo "<tr>";
//                    echo "<td>";
//                        echo form_label('Médico:');
//                    echo "</td>";
//                    echo "<td>";
//                        echo form_dropdown('id_medicos', $medicos, $datos[0]->id_medicos);
//                        echo form_error('id_medicos','<span class="mensaje-error-azul">','</span>');
//                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Paciente:');
                    echo "</td>";
                    echo "<td>";
                        echo form_dropdown('id_pacientes', $pacientes, $datos[0]->id_pacientes);
                        echo form_error('id_pacientes','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Cédula:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'cedula','name'=>'cedula', 'placeholder'=>'Escriba su cédula', 'value'=>$datos[0]->cedula));
                        echo form_error('cedula','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Fecha de nacimiento:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'fecha_nacimiento','name'=>'fecha_nacimiento', 'type'=>'date', 'value'=>$datos[0]->fecha_nacimiento));
                        echo form_error('fecha_nacimiento','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Sexo:');
                    echo "</td>";
                    echo "<td>";
                        $sexos = array(
                            'Hombre' => 'Hombre',
                            'Mujer' => 'Mujer'
                           );
                        echo form_dropdown('sexo', $sexos, $datos[0]->sexo);
                        echo form_error('sexo','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Ciudad:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'ciudad','name'=>'ciudad', 'placeholder'=>'Escriba una ciudad', 'value'=>$datos[0]->ciudad));
                        echo form_error('ciudad','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Dirección:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'direccion','name'=>'direccion', 'placeholder'=>'Escriba una dirección', 'value'=>$datos[0]->direccion));
                        echo form_error('direccion','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Correo:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'correo','name'=>'correo', 'type'=>'email', 'placeholder'=>'Escriba un correo', 'value'=>$datos[0]->correo));
                        echo form_error('correo','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                echo "</table>";
                
                echo "<br>";
                
                echo "<table align='center'>";
                echo "<tr>";
                    
                    echo "<td>";
                        //echo form_submit(array('id'=>'submit','value'=>'ACTUALIZAR'));
                        echo form_input(array('type'=>'image', 'src'=>'http://localhost/codeoptica/imagenes/guardar.png', 'title'=>'ACTUALIZAR'));
                    echo "</td>";
                
                echo "</table>";
                echo form_close(); 
            ?>
</div>
<!--        </table>-->
        
   