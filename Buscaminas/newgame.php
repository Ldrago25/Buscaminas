<?php
session_start();
unset($_SESSION["matriz"]);
unset($_SESSION["visible"]);
unset( $_SESSION["contadorM"]);
unset( $_SESSION["win"]);
unset( $_SESSION["cantidad"]);
unset( $_SESSION["cantidadM"]);
unset( $_SESSION["status"]);
unset( $_SESSION["Casillas"]);

header("Location:index.php");
die();