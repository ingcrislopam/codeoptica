        <?php
            if (isset($this->session->userdata['logged_in'])) {
                $idUsuario = ($this->session->userdata['logged_in']['idUsuario']);
                $nombresUsu = ($this->session->userdata['logged_in']['nombresUsu']);
                $agregar= ($this->session->userdata['logged_in']['agregar']);
                $buscar= ($this->session->userdata['logged_in']['buscar']);
                $editar = ($this->session->userdata['logged_in']['editar']);
                $eliminar = ($this->session->userdata['logged_in']['eliminar']);
                $word = ($this->session->userdata['logged_in']['word']);
                $excel = ($this->session->userdata['logged_in']['excel']);
                $pdf = ($this->session->userdata['logged_in']['pdf']);
            }
            else {
                redirect('index.php/login/index');
            }
        ?>
        <div id="reportes">
        <?php
                echo form_open('index.php/histo_ocupacional/buscar_histo_ocupacional_view');
                echo "<h3>BUSQUEDA DE HISTORIA OCUPACIONAL POR</h3>";
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td nowrap>";
                        $busquedas = array(
//                            '' => 'Seleccione',
                            'fecha_horarios' => 'Fecha'
                           );
                        echo form_dropdown('busqueda', $busquedas);
                        echo form_error('busqueda','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                    if($buscar=="Si"){
                        echo "<td>";
                            echo form_label('Desde:');
                        echo "</td>";
                        echo "<td nowrap>";
                            echo form_input(array('id'=>'parametro','name'=>'parametro','type'=>'date','value'=>set_value('parametro')));
                            echo form_error('parametro','<span class="mensaje-error-azul">','</span>');
                        echo "</td>";
                        echo "<td>";
                            echo form_label('Hasta:');
                        echo "</td>";
                        echo "<td nowrap>";
                            echo form_input(array('id'=>'parametroH','name'=>'parametroH','type'=>'date','value'=>set_value('parametroH')));
                            echo form_error('parametroH','<span class="mensaje-error-azul">','</span>');
                        echo "</td>";
                        echo "<td nowrap>";
                            echo form_input(array('type'=>'image', 'src'=>'http://localhost/codeoptica/imagenes/buscar.png', 'title'=>'BUSCAR HISTORIA CLINICA'));
                        echo "</td>";
                    }
                    else{
                        echo "<td>";
                            echo form_label('Desde:');
                        echo "</td>";
                        echo "<td nowrap>";
                            echo form_input(array('id'=>'parametro','name'=>'parametro','type'=>'date', 'readonly'=>'false', 'value'=>set_value('parametro')));
                            echo form_error('parametro','<span class="mensaje-error-azul">','</span>');
                        echo "</td>";
                        echo "<td>";
                            echo form_label('Hasta:');
                        echo "</td>";
                        echo "<td nowrap>";
                            echo form_input(array('id'=>'parametroH','name'=>'parametroH','type'=>'date', 'readonly'=>'false', 'value'=>set_value('parametroH')));
                            echo form_error('parametroH','<span class="mensaje-error-azul">','</span>');
                        echo "</td>";
                        echo "<td nowrap>";
                            echo "<a><img src='".base_url()."imagenes/buscarbn.png' title='BUSCAR HISTORIA CLINICA'></a>";
                        echo "</td>";
                    }
                echo "</table>";
                echo form_close(); 
        ?>
        </div>
        <br>
        <div id="contenedor">
        <h3>LISTA DE HISTORIAS CLINICAS OCUPACIONALES</h3>
        <?php
        echo "<table align='center'>";
        echo "<tr>";
        echo "<td>";
        if($agregar=="Si"){
            echo "<a href = '".base_url()."index.php/histo_ocupacional/insertar_histo_ocupacional_view/'><img src='".base_url()."imagenes/agregar.png'> Nueva historia clinica ocupacional</a>";
        }
        else{
            echo "<a><img src='".base_url()."imagenes/agregarbn.png'> Nueva historia clinica ocupacional</a>";
        }
            echo "<div id='datos'>";
            echo "<table border = '1' align='center'>";
            echo "<thead id='cabecera'>";
            echo "<tr>"; 
            echo "<td nowrap><b>ID</b></td>";
//            echo "<td nowrap><b>Médico</b></td>";
            echo "<td nowrap><b>Paciente</b></td>"; 
            echo "<td nowrap><b>Fecha</b></td>";
            echo "<td nowrap><b>Ficha</b></td>";
//            echo "<td nowrap><b>VL (OD)</b></td>";
//            echo "<td nowrap><b>VL (OI)</b></td>";
//            echo "<td nowrap><b>CC (OD)</b></td>";
//            echo "<td nowrap><b>CC (OI)</b></td>";
//            echo "<td nowrap><b>VP (OD)</b></td>";
//            echo "<td nowrap><b>VP (OI)</b></td>";
//            echo "<td nowrap><b>CC (OD)</b></td>";
//            echo "<td nowrap><b>CC (OI)</b></td>";
//            echo "<td nowrap><b>PH (OD)</b></td>";
//            echo "<td nowrap><b>PH (OI)</b></td>";
//            echo "<td nowrap><b>DP</b></td>";
//            echo "<td nowrap><b>PPC</b></td>";
//            echo "<td nowrap><b>Foria</b></td>";
//            echo "<td nowrap><b>Motivo de consulta</b></td>";
//            echo "<td nowrap><b>Signos y sintomas</b></td>";
//            echo "<td nowrap><b>Examen externo (OD)</b></td>";
//            echo "<td nowrap><b>Examen externo (OI)</b></td>";
//            echo "<td nowrap><b>Antecedentes</b></td>";
//            echo "<td nowrap><b>Antecedentes p.</b></td>";
//            echo "<td nowrap><b>Fondo de ojo (OD)</b></td>";
//            echo "<td nowrap><b>Fondo de ojo (OI)</b></td>";
//            echo "<td nowrap><b>Queratoneria (OD)</b></td>";
//            echo "<td nowrap><b>Queratoneria (OI)</b></td>";
//            echo "<td nowrap><b>Retinoscopia (OD)</b></td>";
//            echo "<td nowrap><b>Retinoscopia (OI)</b></td>";
//            echo "<td nowrap><b>Subjetivo (OD)</b></td>";
//            echo "<td nowrap><b>Subjetivo (OI)</b></td>";
//            echo "<td><b>Editar</b></td>"; 
//            echo "<td><b>Eliminar</b></td>"; 
            echo "<td align='center'><b>Opciones</b></td>";
            echo "<td align='center'><b>Reportes</b></td>";
            echo "</thead>";
            
				
            foreach($lista as $d) { 
                echo "<tr>"; 
                echo "<td nowrap>".$d->id_historias_clinicas."</td>";
//                echo "<td nowrap>".$d->nombresMedi."</td>"; 
                echo "<td nowrap>".$d->nombresPacien."</td>";
                echo "<td nowrap>".$d->fecha_horarios."</td>";
                echo "<td nowrap><a href = '".base_url()."index.php/histo_ocupacional/ver_histo_ocupacional_view/"
                    .$d->id_historias_clinicas."'><img src='".base_url()."imagenes/ver.png' title='VISTA PREVIA'></a></td>";
//                echo "<td nowrap>".$d->vl_od."</td>";
//                echo "<td nowrap>".$d->vl_oi."</td>";
//                echo "<td nowrap>".$d->cc_od."</td>";
//                echo "<td nowrap>".$d->cc_oi."</td>";
//                echo "<td nowrap>".$d->vp_od."</td>";
//                echo "<td nowrap>".$d->vp_oi."</td>";
//                echo "<td nowrap>".$d->cc2_od."</td>";
//                echo "<td nowrap>".$d->cc2_oi."</td>";
//                echo "<td nowrap>".$d->ph_od."</td>";
//                echo "<td nowrap>".$d->ph_oi."</td>";
//                echo "<td nowrap>".$d->dp."</td>";
//                echo "<td nowrap>".$d->ppc."</td>";
//                echo "<td nowrap>".$d->foria."</td>";
//                echo "<td nowrap>".$d->motivo_consulta."</td>";
//                echo "<td nowrap>".$d->signos_sintomas."</td>";
//                echo "<td nowrap>".$d->examen_externo_od."</td>";
//                echo "<td nowrap>".$d->examen_externo_oi."</td>";
//                echo "<td nowrap>".$d->antecedentes."</td>";
//                echo "<td nowrap>".$d->antecedentes_p."</td>";
//                echo "<td nowrap>".$d->fondo_ojo_od."</td>";
//                echo "<td nowrap>".$d->fondo_ojo_oi."</td>";
//                echo "<td nowrap>".$d->queratoneria_od."</td>";
//                echo "<td nowrap>".$d->queratoneria_oi."</td>";
//                echo "<td nowrap>".$d->retinoscopia_od."</td>";
//                echo "<td nowrap>".$d->retinoscopia_oi."</td>";
//                echo "<td nowrap>".$d->subjetivo_od."</td>";
//                echo "<td nowrap>".$d->subjetivo_oi."</td>";
//                echo "<td><a href = '".base_url()."index.php/histo_general/editar_histo_general_view/"
//                  .$d->idHisto."'><img aling='center' src='http://localhost/codeoptica/images/editar.png' title='EDITAR'></a></td>"; 
//                echo "<td><a href = '".base_url()."index.php/histo_general/eliminar_histo_general/"
//                  .$d->idHisto."'><img aling='center' src='http://localhost/codeoptica/images/eliminar.png' title='ELIMINAR'></a></td>";
                if($editar=="Si"){
                    echo "<td nowrap><a href = '".base_url()."index.php/histo_ocupacional/editar_histo_ocupacional_view/"
                    .$d->id_historias_clinicas."'><img src='".base_url()."imagenes/editar.png' title='EDITAR'></a>";
                }
                else{
                    echo "<td nowrap><a><img src='".base_url()."imagenes/editarbn.png' title='EDITAR'></a>";
                }
                echo "  ";
                if($eliminar=="Si"){
                    echo "<a href = '".base_url()."index.php/histo_ocupacional/eliminar_histo_ocupacional/"
                    .$d->id_historias_clinicas."'><img src='".base_url()."imagenes/eliminar.png' title='ELIMINAR'></a></td>";
                }
                else{
                    echo "<a><img src='".base_url()."imagenes/eliminarbn.png' title='ELIMINAR'></a></td>";
                }
                
                if($word=="Si"){
                    echo "<td nowrap><a href = '".base_url()."index.php/histo_ocupacional/exportar_word_id/"
                    .$d->id_historias_clinicas."'><img src='".base_url()."imagenes/word.png' title='WORD'></a>";
                }
                else{
                    echo "<td nowrap><a><img src='".base_url()."imagenes/wordbn.png' title='WORD'></a>";
                }
                echo " ";
                if($excel=="Si"){
                    echo "<a href = '".base_url()."index.php/histo_ocupacional/exportar_excel_id/"
                    .$d->id_historias_clinicas."'><img src='".base_url()."imagenes/excel.png' title='EXCEL'></a>";
                }
                else{
                    echo "<a><img src='".base_url()."imagenes/excelbn.png' title='EXCEL'></a>";
                }
                echo " ";
                if($pdf=="Si"){
                    echo "<a href = '".base_url()."index.php/histo_ocupacional/exportar_pdf_id/"
                    .$d->id_historias_clinicas."'><img src='".base_url()."imagenes/pdf.png' title='PDF'></a></td>";
                }
                else{
                    echo "<a><img src='".base_url()."imagenes/pdfbn.png' title='PDF'></a></td>";
                }
            }
            echo "</table>";
            echo "</div>";
        echo "</td>";
        echo "</table>";
        ?>
<!--        </table>-->
        <p align="center"><?php echo $paginacion;?></p>
        </div>
   