<div id="contenedor_insertar">        
<?php 
    echo form_open('index.php/reservaciones/insertar_reservacion');
    echo "<h3 align='center'>REGISTRO DE RESERVACION DEL PACIENTE</h3>";
    echo "<table align='center'>";
    echo "<tr>";
        echo "<td>";
            echo form_label('Paciente:');
        echo "</td>";
        echo "<td>";
            echo "<select id='id_pacientes' name='id_pacientes'>";
            echo "<option value=''>Seleccione</option>";
            foreach ($pacientes as $i) {
                echo '<option value="'. $i->id_pacientes .'">'. $i->nombresPacien .'</option>';
            }   
            echo "</select>";
            echo form_error('id_pacientes','<span class="mensaje-error-azul">','</span>');
        echo "</td>";
    echo "<tr>";
        echo "<td>";
            echo form_label('Fecha:');
        echo "</td>";
        echo "<td>";
        echo "<select id='id_horarios' name='id_horarios'>";
        echo "<option value=''>Seleccione</option>";
        foreach ($horarios as $i) {
            echo '<option value="'. $i->id_horarios .'">'. $i->fecha_horarios .'</option>';
        }   
        echo "</select>";
        echo form_error('id_horarios','<span class="mensaje-error-azul">','</span>');
        echo "</td>";
    echo "<tr>";
        echo "<td nowrap>";
            echo form_label('Turno:');
        echo "</td>";
        echo "<td nowrap>";
        echo "<select id='id_turnos' name='id_turnos'>";
            echo "<option value=''>Seleccione</option>";
        echo "</select>";
        echo form_error('id_turnos','<span class="mensaje-error-azul">','</span>');
        echo "</td>";      
    echo "</table>";
    echo "<br>";
    echo "<table align='center'>";
    echo "<tr>";
        echo "<td>";
            echo form_input(array('type'=>'image', 'src'=>'http://localhost/codeoptica/imagenes/guardar.png', 'title'=>'REGISTRAR'));
        echo "</td>";
    echo "</table>";
    echo form_close(); 
?>
</div>
<script type="text/javascript">   
$(document).ready(function() {                       
    $("#id_horarios").change(function() {
        $("#id_horarios option:selected").each(function() {
            id_horarios = $('#id_horarios').val();
            $.post("<?php echo base_url(); ?>index.php/reservaciones/fillTurnos", {
                id_horarios : id_horarios
            }, function(data) {
                $("#id_turnos").html(data);
            });
        });
    });
});
</script>