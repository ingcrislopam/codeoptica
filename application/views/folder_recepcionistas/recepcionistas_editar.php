<!--        <table border="1" align="center">-->
<div id="contenedor_editar">
            <?php
                echo form_open('index.php/recepcionistas/editar_recepcionista');
                echo form_hidden('old_id',$old_id);
                echo "<h3 align='center'>ACTUALIZAR RECEPCIONISTA</h3>";
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('ID:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'id_usuarios','name'=>'id_usuarios', 'readonly'=>'false', 'value'=>$datos[0]->id_usuarios));
                        echo form_error('id_usuarios','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Nombres:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'nombres','name'=>'nombres', 'placeholder'=>'Escriba sus nombres', 'value'=>$datos[0]->nombres));
                        echo form_error('nombres','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Apellidos:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'apellidos','name'=>'apellidos', 'placeholder'=>'Escriba sus apellidos', 'value'=>$datos[0]->apellidos));
                        echo form_error('apellidos','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Username:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'username','name'=>'username', 'placeholder'=>'Escriba un usuario', 'value'=>$datos[0]->username));
                        echo form_error('username','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Password:'); 
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'password','name'=>'password', 'type'=>'password', 'placeholder'=>'Escriba una password', 'value'=>$datos[0]->password));
                        echo form_error('password','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Fecha de nacimiento:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'fecha_nacimiento','name'=>'fecha_nacimiento', 'type'=>'date', 'value'=>$datos[0]->fecha_nacimiento));
                        echo form_error('fecha_nacimiento','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Sexo:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $sexos = array(
                            'Hombre' => 'Hombre',
                            'Mujer' => 'Mujer'
                           );
                        echo form_dropdown('sexo', $sexos, $datos[0]->sexo);
                        echo form_error('sexo','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Celular:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'celular','name'=>'celular', 'placeholder'=>'Escriba un celular', 'value'=>$datos[0]->celular));
                        echo form_error('celular','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Correo:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'correo','name'=>'correo', 'type'=>'email', 'placeholder'=>'Escriba un correo', 'value'=>$datos[0]->correo));
                        echo form_error('correo','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "</table>";
                 
                echo "<br>";
                
                echo "<h3>PERMISOS DENTRO DEL SISTEMA</h3>";
                echo "<h3>Opciones</h3>";
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Agregar:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $agregars = array(
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('agregar', $agregars, $datosPer[0]->agregar);
                        echo form_error('agregar','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Buscar:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $buscars = array(
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('buscar', $buscars, $datosPer[0]->buscar);
                        echo form_error('buscar','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";                
                    
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Editar:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $editars = array(
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('editar', $editars, $datosPer[0]->editar);
                        echo form_error('editar','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Eliminar:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $eliminars = array(
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('eliminar', $eliminars, $datosPer[0]->eliminar);
                        echo form_error('eliminar','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "</table>";
                
                echo "<br>";
                
                echo "<h3>Reportes</h3>";
                echo "<table align='center'>";    
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Word:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $words = array(
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('word', $words, $datosPer[0]->word);
                        echo form_error('word','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";    
                    
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Excel:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $excels = array(
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('excel', $excels, $datosPer[0]->excel);
                        echo form_error('excel','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Pdf:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $pdfs = array(
                            'Si' => 'Si',
                            'No' => 'No'
                           );
                        echo form_dropdown('pdf', $pdfs, $datosPer[0]->pdf);
                        echo form_error('pdf','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                    
                echo "</table>";
                
                echo "<br>";
                
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_input(array('type'=>'image', 'src'=>'http://localhost/codeoptica/imagenes/guardar.png', 'title'=>'ACTUALIZAR'));
                        //echo form_submit(array('id'=>'submit','value'=>'ACTUALIZAR'));
                    echo "</td>";
                echo "<tr>";
                echo "</table>";
                
                echo form_close(); 
            ?>
</div>
<!--        </table>-->
   