<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
	<meta charset="utf-8">
	<title>Home</title>
        <link rel="shortcut icon" href="favicon-32x32.png" type="image/x-icon">
    </head>
    <body>
        <div id="container">
            <h1>Enviar Mensaje con Rabbitmq</h1>
            <form name="form_send" action="home/send" method="POST">
                <div>
                    Mensaje:
                    <input type="text" id="mensaje" name="mensaje" value="" autocomplete="off"/>
                    <button type="submit">Enviar</button>
                </div>
            </form>
            
        </div>
    </body>
</html>
