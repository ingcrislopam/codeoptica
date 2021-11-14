<!DOCTYPE html> 
<html>
    <head> 
        <meta charset = "utf-8"> 
        <title>Ocean Optical</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>estilos/css/login.css">
    </head>
    <body background="<?= base_url() ?>imagenes/fondo.jpg" >
            <?php 
                echo form_open('index.php/login/iniciar');
                echo "<div>";
                //echo "<h1 align='center'>OCEAN OPTICAL</h1>";
                echo "<h1 align='center'>Ocean Optical</h1>";
                echo "<img class='imagen' src='http://localhost/codeoptica/imagenes/logotipo.jpg'>";
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td>";
                        echo form_input(array('id'=>'username','name'=>'username', 'placeholder'=>'USUARIO', 'value'=>set_value('username')));
                        echo form_error('username','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                
                echo "<tr>";
                    echo "<td>";
                        echo form_input(array('id'=>'password','name'=>'password', 'type'=>'password', 'placeholder'=>'CONTRASEÑA', 'value'=>set_value('password')));
                        echo form_error('password','<span class="mensaje-error-azul">','</span>');
                    echo "</td>";
                    echo form_error('validar','<span class="mensaje-error-azul">','</span>');
                echo "</table>";
                
                echo "<br>";
                
                echo "<table align='center'>";
                echo "<tr>";
                    echo "<td>";
                        echo form_submit(array('id'=>'submit','value'=>'INICIAR SESIÓN'));
                    echo "</td>";
                
                echo "</table>";
                echo "</div>";
                echo form_close(); 
         ?>
   </body>
</html>