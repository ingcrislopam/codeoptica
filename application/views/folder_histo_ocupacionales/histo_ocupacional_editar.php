<div id="contenedor_editar">
            <?php 
                echo form_open('index.php/histo_ocupacional/editar_histo_ocupacional');
                echo form_hidden('old_id',$old_id);
                echo "<table align='center'>";
                echo "<tr>";
                echo "<td>";
                
                echo "<h3 align='center'>ACTUALIZAR HISTORIA CLINICA OCUPACIONAL</h3>";
                
                echo "<br>";
                
                echo "<table>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('ID:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'id_historias_clinicas','name'=>'id_historias_clinicas', 'readonly'=>'false', 'value'=>$datos[0]->id_histo_clinicas));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('Médico:');
                    echo "</td>";
                    echo "<td>";
                        echo form_dropdown('id_medicos', $medicos, $datosH[0]->id_medicos);
                    echo "</td>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('Fecha y paciente:');
                    echo "</td>";
                    echo "<td>";
                        echo form_dropdown('id_reservaciones', $reservaciones, $datosH[0]->id_reservaciones);
                    echo "</td>";
//                    echo "<td>";
//                        echo form_label('Fecha:');
//                    echo "</td>";
//                    echo "<td>";
//                        echo form_input(array('id'=>'fecha','name'=>'fecha', 'type'=>'date', 'value'=>$datosH[0]->fecha));
//                        echo form_error('fecha','<span class="mensaje-error-azul">','</span>');
//                    echo "</td>";
                    
//                echo "<tr>";
                    echo "<td>";
                        echo form_label('Lentes:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'lentes','name'=>'lentes', 'value'=>$datos[0]->lentes));
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
                        echo form_input(array('id'=>'agudeza_vision_lejana_od','name'=>'agudeza_vision_lejana_od', 'value'=>$datos[0]->agudeza_vision_lejana_od));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OI:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_vision_lejana_oi','name'=>'agudeza_vision_lejana_oi', 'value'=>$datos[0]->agudeza_vision_lejana_oi));
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('VISION CERCANA:');
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OD:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_vision_cercana_od','name'=>'agudeza_vision_cercana_od', 'value'=>$datos[0]->agudeza_vision_cercana_od));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OI:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_vision_cercana_oi','name'=>'agudeza_vision_cercana_oi', 'value'=>$datos[0]->agudeza_vision_cercana_oi));
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('PERIMETRIA:');
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OD:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_perimetria_od','name'=>'agudeza_perimetria_od', 'value'=>$datos[0]->agudeza_perimetria_od));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OI:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_perimetria_oi','name'=>'agudeza_perimetria_oi', 'value'=>$datos[0]->agudeza_perimetria_oi));
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('TONOMETRIA:');
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OD:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_tonometria_od','name'=>'agudeza_tonometria_od', 'value'=>$datos[0]->agudeza_tonometria_od));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OI:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_tonometria_oi','name'=>'agudeza_tonometria_oi', 'value'=>$datos[0]->agudeza_tonometria_oi));
                    echo "</td>";
                    
                echo "<tr>";
                    echo "<td>";
                        echo form_label('FONDO DE OJO:');
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OD:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_fondo_ojo_od','name'=>'agudeza_fondo_ojo_od', 'value'=>$datos[0]->agudeza_fondo_ojo_od));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OI:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_fondo_ojo_oi','name'=>'agudeza_fondo_ojo_oi', 'value'=>$datos[0]->agudeza_fondo_ojo_oi));
                    echo "</td>";
                    
                echo "<tr>";
                    echo "<td>";
                        echo form_label('EXAMEN EXTERNO:');
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OD:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_examen_externo_od','name'=>'agudeza_examen_externo_od', 'value'=>$datos[0]->agudeza_examen_externo_od));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('OI:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'agudeza_examen_externo_oi','name'=>'agudeza_examen_externo_oi', 'value'=>$datos[0]->agudeza_examen_externo_oi));
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
                        echo form_input(array('id'=>'forias_vision_lejana','name'=>'forias_vision_lejana', 'value'=>$datos[0]->forias_vision_lejana));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('VISION PROXIMA:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'forias_vision_proxima','name'=>'forias_vision_proxima', 'value'=>$datos[0]->forias_vision_proxima));
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_label('TEST DE COLOR:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'forias_test_color','name'=>'forias_test_color', 'value'=>$datos[0]->forias_test_color));
                    echo "</td>";
                    echo "<td>";
                        echo form_label('TEST ESTERIOPSIS:');
                    echo "</td>";
                    echo "<td>";
                        echo form_input(array('id'=>'forias_test_esteriopsis','name'=>'forias_test_esteriopsis', 'value'=>$datos[0]->forias_test_esteriopsis));
                    echo "</td>";    
                echo "</table>";
                    
                echo "<br>";
                
                echo "<table>";
                echo "<tr>";
                    echo "<td>";
                        echo form_label('DIAGNOSTICO:');
                        echo "<br>";
                        echo form_textarea(array('id'=>'forias_diagnostico','name'=>'forias_diagnostico', 'value'=>$datos[0]->forias_diagnostico));
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
    