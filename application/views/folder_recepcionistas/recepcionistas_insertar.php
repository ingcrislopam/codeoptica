<!--        <table border="1" align="center">-->
<div id="contenedor_insertar">
            <?php
                echo form_open('index.php/recepcionistas/insertar_recepcionista');
                echo "<h3>REGISTRO DE RECEPCIONISTA</h3>";
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Nombres:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'nombres','name'=>'nombres','placeholder'=>'Escriba sus nombres','value'=>set_value('nombres')));
                        echo form_error('nombres','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                    
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Apellidos:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'apellidos','name'=>'apellidos', 'placeholder'=>'Escriba sus apellidos','value'=>set_value('apellidos'))); 
                        echo form_error('apellidos','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                    
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Username:'); 
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'username','name'=>'username', 'placeholder'=>'Escriba un usuario','value'=>set_value('username')));
                        echo form_error('username','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Password:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'password','name'=>'password', 'type'=>'password', 'placeholder'=>'Escriba una password','value'=>set_value('password')));
                        echo form_error('password','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                    
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Fecha de nacimiento:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'fecha_nacimiento','name'=>'fecha_nacimiento', 'type'=>'date','value'=>set_value('fecha_nacimiento')));
                        echo form_error('fecha_nacimiento','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Sexo:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $sexos = array(
                            '' => 'Seleccione',
                            'Hombre' => 'Hombre',
                            'Mujer' => 'Mujer'
                           );
                        echo form_dropdown('sexo', $sexos);
                        echo form_error('sexo','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Celular:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'celular','name'=>'celular', 'placeholder'=>'Escriba un celular','value'=>set_value('celular')));
                        echo form_error('celular','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Correo:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'correo','name'=>'correo', 'type'=>'email', 'placeholder'=>'Escriba un correo','value'=>set_value('correo')));
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
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                        );
                        echo form_dropdown('agregar', $agregars);
                        echo form_error('agregar','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Buscar:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $buscars = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                        );
                        echo form_dropdown('buscar', $buscars);
                        echo form_error('buscar','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";                
                    
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Editar:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $editars = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                        );
                        echo form_dropdown('editar', $editars);
                        echo form_error('editar','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Eliminar:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $eliminars = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                        );
                        echo form_dropdown('eliminar', $eliminars);
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
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                        );
                        echo form_dropdown('word', $words);
                        echo form_error('word','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";    
                    
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Excel:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $excels = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                        );
                        echo form_dropdown('excel', $excels);
                        echo form_error('excel','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Pdf:');
                    echo "</td>";
                    echo "<td nowrap>";
                        $pdfs = array(
                            '' => 'Seleccione',
                            'Si' => 'Si',
                            'No' => 'No'
                        );
                        echo form_dropdown('pdf', $pdfs);
                        echo form_error('pdf','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "</table>";
                
                echo "<br>";
                
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_input(array('type'=>'image', 'src'=>'http://localhost/codeoptica/imagenes/guardar.png', 'title'=>'REGISTRAR'));
                        //echo form_submit(array('id'=>'submit','value'=>'REGISTRAR'));
                    echo "</td>";
                
                echo "</table>";
                
                echo form_close(); 
         ?> 
</div>
<!--        </table>-->
  