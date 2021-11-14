<!DOCTYPE html> 
<html>
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
    <head> 
        <meta charset = "utf-8"> 
        <title>Ocean Optical</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>estilos/css/medicos.css">
    </head>
	
    <body>
        <div id="logo">
            <h1><img class="imagen" src="<?= base_url() ?>imagenes/logo.png"><?php echo " " ?>Ocean Optical<?php echo " " ?><img class="imagen" src="<?= base_url() ?>imagenes/logo.png"></h1>
        </div>
        <div>
            <h2>Bienvenido(a) al sistema: <?php echo "" .$nombresUsu ?> | Tipo de usuario: Médico</h2>
        </div>
        
        