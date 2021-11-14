<?php
        if (isset($this->session->userdata['logged_in'])) {
            $idUsuario = ($this->session->userdata['logged_in']['idUsuario']);
            $nombresUsu = ($this->session->userdata['logged_in']['nombresUsu']);
        }
        else {
            redirect('index.php/login/index');
        }
    ?>
<div id="contenedor_desarrollador">
<form id="formulario-home">
    <h2>Información de contacto del desarrollador</h2>
    <br>
    <h4>Nombres y apellidos: Cristhian Adrián López Mora</h4>
    <h4>Universidad / Facultad: ULEAM / FACCI</h4>
    <h4>Carrera: Ingeniería en sistemas</h4>
    <h4>Dirección: Antes: Av. 19 entre calles 7 y 8 Ahora: Ceibo Renacer</h4>
    <h4>Telefono / Celular: 622-524 / 0979750175</h4>
    <h4>Correo electrónico: cristhianl2010@hotmail.com</h4>
</form>
</div>