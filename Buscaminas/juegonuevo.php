<?php
session_start();
unset($_SESSION["matriz"]);
unset($_SESSION["visible"]);
unset( $_SESSION["contadorM"]);
unset( $_SESSION["Casillas"]);


header("Location:game.php");
die();