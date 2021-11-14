<div id="contenedor_editar">        
            <?php
                echo form_open('index.php/pacientes/editar_paciente');
                echo form_hidden('old_id',$old_id);
                echo "<h3 align='center'>ACTUALIZAR PACIENTE</h3>";
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('ID:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'id_pacientes','name'=>'id_pacientes', 'readonly'=>'false', 'value'=>$datos[0]->id_pacientes));
                        echo form_error('id_pacientes','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Recepcionista:');
                    echo "</td>";
                    echo "<td>";
                        echo form_dropdown('id_recepcionistas', $recepcionista, $datos[0]->id_recepcionistas);
                        echo form_error('id_recepcionistas','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Nombres:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'nombresPaci','name'=>'nombresPaci', 'placeholder'=>'Escriba sus nombres', 'value'=>$datos[0]->nombresPaci));
                        echo form_error('nombresPaci','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Apellidos:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'apellidosPaci','name'=>'apellidosPaci', 'placeholder'=>'Escriba sus apellidos', 'value'=>$datos[0]->apellidosPaci));
                        echo form_error('apellidosPaci','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Celular:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'celularPaci','name'=>'celularPaci', 'placeholder'=>'Escriba un celular', 'value'=>$datos[0]->celularPaci));
                        echo form_error('celularPaci','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Convencional:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'convencionalPaci','name'=>'convencionalPaci', 'placeholder'=>'Escriba un convencional', 'value'=>$datos[0]->convencionalPaci));
                        echo form_error('convencionalPaci','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                echo "</table>";
                
                echo "<br>";
                
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td>";
                        //echo form_submit(array('id'=>'submit','value'=>'ACTUALIZAR'));
                        echo form_input(array('type'=>'image', 'src'=>'http://localhost/codeoptica/imagenes/guardar.png', 'title'=>'ACTUALIZAR'));
                    echo "</td>";
                echo "<tr>";
                echo "</table>";
                echo form_close(); 
            ?>
</div>
<!--        </table>-->
   