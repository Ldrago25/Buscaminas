<?php 
require_once 'usuario.php';
$user=new Usuario();
$user->all();
    if(isset($_SESSION["matriz"]) && isset($_SESSION["visible"])&& isset($_SESSION["contadorM"])){
        unset($_SESSION["matriz"]);
        unset($_SESSION["visible"]);
        unset( $_SESSION["contadorM"]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <title>Buscaminas</title>
</head>
<body>
    <div id="title">
        <h1>Bienvenido al juego del ¡¡Buscaminas!!</h1>
    </div>
    <div id="information">
        <h4>
            Debes ingresar el valor de N para tu tablero
            donde N es desde 8 hasta 20.
        </h4>
    </div>
    <div id="form">
        <form action="game.php" method="POST" id="formBody">
        <label>Valor de N</label>
        <input type="text" id="text" name="value" require>
        <button type="submit" class="button">Jugar</button>
        </form>
        <?php if(isset($_SESSION["error"])){
            echo '<h2>el numero: '.$_SESSION["error"].' no esta en el rango </h2>';
            unset($_SESSION["error"]);
        }?>
    </div>
</body>
</html>