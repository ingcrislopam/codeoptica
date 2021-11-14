<div id="contenedor_editar">  
      
            <?php 
                echo form_open('index.php/horarios/editar_horarios');
                echo form_hidden('old_id',$old_id);
                echo "<h3 align='center'>ACTUALIZAR HORARIO</h3>";
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('ID:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'id_horarios','name'=>'id_horarios', 'readonly'=>'false', 'value'=>$datos[0]->id_horarios));
                        echo form_error('id_horarios','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Médico:');
                    echo "</td>";
                    echo "<td>";
                        echo form_dropdown('id_medicos', $medicos, $datos[0]->id_medicos);
                        echo form_error('id_medicos','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Fecha:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'fecha_horarios','name'=>'fecha_horarios', 'type'=>'date', 'value'=>$datos[0]->fecha_horarios));
                        echo form_error('fecha_horarios','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                echo "</table>";
                
                echo "<br>";
                
                echo "<h3>Turnos (AM)</h3>";  
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('08:30 - 09:00');
                    echo "</td>";
                    echo "<td>";
                        $turnos1am = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno1am', $turnos1am, $datos1am[0]->laborar);
                        echo form_error('turno1am','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('09:00 - 09:30');
                    echo "</td>";
                    echo "<td>";
                        $turnos2am = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno2am', $turnos2am, $datos2am[0]->laborar);
                        echo form_error('turno2am','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('09:30 - 10:00');
                    echo "</td>";
                    echo "<td>";
                        $turnos3am = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno3am', $turnos3am, $datos3am[0]->laborar);
                        echo form_error('turno3am','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('10:00 - 10:30');
                    echo "</td>";
                    echo "<td>";
                        $turnos4am = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno4am', $turnos4am, $datos4am[0]->laborar);
                        echo form_error('turno4am','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('10:30 - 11:00');
                    echo "</td>";
                    echo "<td>";
                        $turnos5am = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno5am', $turnos5am, $datos5am[0]->laborar);
                        echo form_error('turno5am','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";    
                    
                echo "<tr>";
                    echo "<td>";
                        echo form_label('11:00 - 11:30');
                    echo "</td>";
                    echo "<td>";
                        $turnos6am = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno6am', $turnos6am, $datos6am[0]->laborar);
                        echo form_error('turno6am','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";    
                    
                echo "<tr>";
                    echo "<td>";
                        echo form_label('11:30 - 12:00');
                    echo "</td>";
                    echo "<td>";
                        $turnos7am = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno7am', $turnos7am, $datos7am[0]->laborar);
                        echo form_error('turno7am','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";    
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('12:00 - 12:30');
                    echo "</td>";
                    echo "<td>";
                        $turnos8am = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno8am', $turnos8am, $datos8am[0]->laborar);
                        echo form_error('turno8am','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                echo "</table>";
                
                echo "<br>";
                
                echo "<h3>Turnos (PM)</h3>";  
                echo "<table align='center'>"; 
                echo "<tr>";
                    echo "<td>";
                        echo form_label('14:30 - 15:00');
                    echo "</td>";
                    echo "<td>";
                        $turnos1pm = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno1pm', $turnos1pm, $datos1pm[0]->laborar);
                        echo form_error('turno1pm','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('15:00 - 15:30');
                    echo "</td>";
                    echo "<td>";
                        $turnos2pm = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno2pm', $turnos2pm, $datos2pm[0]->laborar);
                        echo form_error('turno2pm','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('15:30 - 16:00');
                    echo "</td>";
                    echo "<td>";
                        $turnos3pm = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno3pm', $turnos3pm, $datos3pm[0]->laborar);
                        echo form_error('turno3pm','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('16:00 - 16:30');
                    echo "</td>";
                    echo "<td>";
                        $turnos4pm = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno4pm', $turnos4pm, $datos4pm[0]->laborar);
                        echo form_error('turno4pm','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('16:30 - 17:00');
                    echo "</td>";
                    echo "<td>";
                        $turnos5pm = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno5pm', $turnos5pm, $datos5pm[0]->laborar);
                        echo form_error('turno5pm','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";    
                    
                echo "<tr>";
                    echo "<td>";
                        echo form_label('17:00 - 17:30');
                    echo "</td>";
                    echo "<td>";
                        $turnos6pm = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno6pm', $turnos6pm, $datos6pm[0]->laborar);
                        echo form_error('turno6pm','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";    
                    
                echo "<tr>";
                    echo "<td>";
                        echo form_label('17:30 - 18:00');
                    echo "</td>";
                    echo "<td>";
                        $turnos7pm = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('turno7pm', $turnos7pm, $datos7pm[0]->laborar);
                        echo form_error('turno7pm','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";    
                echo "</table>";
                
                echo "<br>";
                
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td>";
                        echo form_input(array('type'=>'image', 'src'=>'http://localhost/codeoptica/imagenes/guardar.png', 'title'=>'ACTUALIZAR'));
                        //echo form_submit(array('id'=>'submit','value'=>'REGISTRAR'));
                    echo "</td>";
                
                echo "</table>";
                echo form_close(); 
         ?>
</div>
<!--        </table>-->
        
   