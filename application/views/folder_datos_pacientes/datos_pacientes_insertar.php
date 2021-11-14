<div id="contenedor_insertar">        
            <?php 
                echo form_open('index.php/datos_pacientes/insertar_datos_paciente');
                echo "<h3 align='center'>REGISTRO DE PERFIL DEL PACIENTE</h3>";
                echo "<table align='center'>";
//                echo "<tr>";
//                    echo "<td>";
//                        echo form_label('Médico:');
//                    echo "</td>";
//                    echo "<td>";
//                        echo form_dropdown('id_medicos', $medicos);
//                        echo form_error('id_medicos','<span class="mensaje-error-azul">','</span>');
//                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Paciente:');
                    echo "</td>";
                    echo "<td>";
                        echo form_dropdown('id_pacientes', $pacientes);
                        echo form_error('id_pacientes','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Cédula:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'cedula','name'=>'cedula', 'placeholder'=>'Escriba su cédula', 'value'=>set_value('cedula')));
                        echo form_error('cedula','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Fecha de nacimiento:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'fecha_nacimiento','name'=>'fecha_nacimiento', 'type'=>'date', 'value'=>set_value('fecha_nacimiento')));
                        echo form_error('fecha_nacimiento','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Sexo:');
                    echo "</td>";
                    echo "<td>";
                        $sexos = array(
                            '' => 'Seleccione',
                            'Hombre' => 'Hombre',
                            'Mujer' => 'Mujer'
                           );
                        echo form_dropdown('sexo', $sexos);
                        echo form_error('sexo','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Ciudad:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'ciudad','name'=>'ciudad', 'placeholder'=>'Escriba una ciudad', 'value'=>set_value('ciudad'))); 
                        echo form_error('ciudad','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Dirección:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'direccion','name'=>'direccion', 'placeholder'=>'Escriba una dirección', 'value'=>set_value('direcccion')));
                        echo form_error('direccion','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Correo:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'correo','name'=>'correo', 'type'=>'email', 'placeholder'=>'Escriba un correo', 'value'=>set_value('correo')));
                        echo form_error('correo','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                echo "</table>";
                
                echo "<br>";
                
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td>";
                        echo form_input(array('type'=>'image', 'src'=>'http://localhost/codeoptica/imagenes/guardar.png', 'title'=>'REGISTRAR'));
                        //echo form_submit(array('id'=>'submit','value'=>'REGISTRAR'));
                    echo "</td>";
                
                echo "</table>";
                echo form_close(); 
         ?>
</div>
<!--        </table>-->
        
   