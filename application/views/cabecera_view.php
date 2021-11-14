<!DOCTYPE html> 
<html>
    <?php
        if (isset($this->session->userdata['logged_in'])) {
            $nombresUsu = ($this->session->userdata['logged_in']['nombresUsu']);
        }
        else {
            redirect('index.php/login/index');
        }
    ?>
    <head> 
        <meta charset = "utf-8"> 
        <title>OCEAN OPTICAL</title>
        <style type="text/css">
            h2 {
                text-align: center;
            }
            h3 {
                text-align: center;
            }
            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #333;
            }
            li {
                float: left;
                border-right: 1px solid #bbb;
            }
            li:last-child {
                border-right: none;
            }
            li a {
                display: block;
                color: white;
                text-align: center;
                padding: 10px 16px;
                text-decoration: none;
            }
            li a:hover {
                background-color: #111;
            }
            code {
                text-align: center;
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 16px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
            }
        </style>
    </head>
	
    <body>
        
        <h2>Bienvenido(a) al sistema: <?php echo "" .$nombresUsu ?></h2>
        <?php
            echo "<a href = '".base_url()."index.php/login/logout/'><img src='http://localhost/codeoptica/images/cerrar.png' title='CERRAR SESIÓN' align='right'></a>"
        ?>