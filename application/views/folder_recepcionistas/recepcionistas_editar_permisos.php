<!--        <table border="1" align="center">-->
<div id="contenedor_editar_permisos">
            <?php
                echo form_open('index.php/recepcionistas/editar_recepcionista_permisos');
                echo form_hidden('old_id',$old_id);
                echo "<h3>PERMISOS DENTRO DEL SISTEMA</h3>";
                echo "<h3>Opciones</h3>";
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('ID:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'id_usuarios','name'=>'id_usuarios', 'readonly'=>'false', 'value'=>$datos[0]->id_usuarios));
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Nombres:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'nombres','name'=>'nombres', 'readonly'=>'false', 'placeholder'=>'Escriba sus nombres', 'value'=>$datos[0]->nombres));
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td nowrap>";
                        echo form_label('Apellidos:');
                    echo "</td>";
                    echo "<td nowrap>";
                        echo form_input(array('id'=>'apellidos','name'=>'apellidos', 'readonly'=>'false', 'placeholder'=>'Escriba sus apellidos', 'value'=>$datos[0]->apellidos));
                    echo "</td>";
                
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
   