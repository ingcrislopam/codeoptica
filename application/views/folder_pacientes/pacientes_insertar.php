<div id="contenedor_insertar">        
            <?php 
                echo form_open('index.php/pacientes/insertar_paciente');
                echo "<h3 align='center'>REGISTRO DE PACIENTE</h3>";
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Recepcionista:');
                    echo "</td>";
                    echo "<td>";
                        echo form_dropdown('id_recepcionistas', $recepcionista);
                        echo form_error('id_recepcionistas','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
//                    echo "<td>";
//                        echo "<select id='id_recepcionistas' name='id_recepcionistas'>";
//                        echo "<option value=''>Seleccione</option>";
//                            foreach ($recepcionista as $i) {
//                                echo '<option value="'. $i->id_recepcionistas .'">'. $i->nombresCom .'</option>';
//                            }
//                        echo "</select>";
//                        echo form_error('id_recepcionistas','<span class="mensaje-error-azul">','</span>');
//                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Nombres:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'nombresPaci','name'=>'nombresPaci', 'placeholder'=>'Escriba sus nombres','value'=>set_value('nombresPaci')));
                        echo form_error('nombresPaci','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Apellidos:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'apellidosPaci','name'=>'apellidosPaci', 'placeholder'=>'Escriba sus apellidos','value'=>set_value('apellidosPaci')));
                        echo form_error('apellidosPaci','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Celular:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'celularPaci','name'=>'celularPaci', 'placeholder'=>'Escriba un celular','value'=>set_value('celularPaci')));
                        echo form_error('celularPaci','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Convencional:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'convencionalPaci','name'=>'convencionalPaci', 'placeholder'=>'Escriba un convencional','value'=>set_value('convencionalPaci')));
                        echo form_error('convencionalPaci','<span class="mensaje-error-azul">','</span>');
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
            
   