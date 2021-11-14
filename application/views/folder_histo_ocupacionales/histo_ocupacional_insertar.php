<div id="contenedor_insertar">
            <?php 
                echo form_open('index.php/histo_ocupacional/insertar_histo_ocupacional');
                echo "<table align='center'>";
                echo "<tr>";
                echo "<td>";
                
                echo "<h3 align='center'>REGISTRO DE HISTORIA CLINICA OCUPACIONAL</h3>";
                
                echo "<br>";
                
                echo "<table>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Médico:');
                    echo "</td>";
                    echo "<td>";
                        echo form_dropdown('id_medicos', $medicos);
                    echo "</td>";
//                    echo "<td>";
//                        echo form_label('Paciente:');
//                    echo "</td>";
//                    echo "<td>";
//                        echo form_dropdown('id_pacientes', $pacientes);
//                    echo "</td>";
//                    echo "<td>";
//                        echo form_label('Fecha:');
//                    echo "</td>";
//                    echo "<td>";
//                        echo "<input type='date' id='fecha' name='fecha' />";
////                        echo form_input(array('id'=>'fecha','name'=>'fecha', 'type'=>'date'));
//                        echo form_error('fecha','<span class="mensaje-error-azul">','</span>');
//                    echo "</td>";
                    echo "<td>";
                        echo form_label('Fecha y paciente:');
                        echo "</td>";
                        echo "<td>";
                        echo "<select id='id_reservaciones' name='id_reservaciones'>";
                            echo "<option value=''>Seleccione</option>";
                                foreach ($reservaciones as $i) {
                                    echo '<option value="'. $i->id_reservaciones .'">'. $i->fecha_paciente .'</option>';
                                }   
                       echo "</select>";
                        echo form_error('id_reservaciones','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Lentes:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'lentes','name'=>'lentes'));
                    echo "</td>";
                echo "</table>";
                
                echo "<br>";
                echo "<h3>AGUDEZA VISUAL</h3>";
                echo "<table>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('VISION LEJANA:');
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OD:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_vision_lejana_od','name'=>'agudeza_vision_lejana_od'));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OI:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_vision_lejana_oi','name'=>'agudeza_vision_lejana_oi'));
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('VISION CERCANA:');
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OD:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_vision_cercana_od','name'=>'agudeza_vision_cercana_od'));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OI:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_vision_cercana_oi','name'=>'agudeza_vision_cercana_oi'));
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('PERIMETRIA:');
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OD:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_perimetria_od','name'=>'agudeza_perimetria_od'));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OI:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_perimetria_oi','name'=>'agudeza_perimetria_oi'));
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('TONOMETRIA:');
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OD:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_tonometria_od','name'=>'agudeza_tonometria_od'));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OI:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_tonometria_oi','name'=>'agudeza_tonometria_oi'));
                    echo "</td>";
                    
                echo "<tr>";
                    echo "<td>";
                        echo form_label('FONDO DE OJO:');
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OD:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_fondo_ojo_od','name'=>'agudeza_fondo_ojo_od'));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OI:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_fondo_ojo_oi','name'=>'agudeza_fondo_ojo_oi'));
                    echo "</td>";
                    
                echo "<tr>";
                    echo "<td>";
                        echo form_label('EXAMEN EXTERNO:');
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OD:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_examen_externo_od','name'=>'agudeza_examen_externo_od'));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OI:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_examen_externo_oi','name'=>'agudeza_examen_externo_oi'));
                    echo "</td>";
                
                echo "</table>";
                
                echo "<br>";
                
                echo "<h3>FORIAS</h3>";
                echo "<table>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('VISION LEJANA:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'forias_vision_lejana','name'=>'forias_vision_lejana'));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('VISION PROXIMA:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'forias_vision_proxima','name'=>'forias_vision_proxima'));
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('TEST DE COLOR:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'forias_test_color','name'=>'forias_test_color'));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('TEST ESTERIOPSIS:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'forias_test_esteriopsis','name'=>'forias_test_esteriopsis'));
                    echo "</td>";    
                echo "</table>";
                    
                echo "<br>";
                
                echo "<table>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('DIAGNOSTICO:');
                        echo "<br>";
                        echo form_textarea(array('id'=>'forias_diagnostico','name'=>'forias_diagnostico'));
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
                
                //echo form_textarea(array('id'=>'ph_oi','name'=>'ph_oi'));
                
                echo "</td>";
                echo "</table>";
                
                echo form_close();
                echo "<br>";
         ?> 
</div>
<!--        </table>-->
    