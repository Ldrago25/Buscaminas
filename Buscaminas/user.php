<?php 
require_once "usuario.php";

$user=new Usuario();
$user->idNombre=$_SESSION["usuario"]["Nombre"];
$user->Nombre=$_POST["Nombre"];
$user->Apellido=$_POST["Apellido"];
$user->Tiempo=$_POST["Tiempo"];
$user-> edite();
unset($_SESSION["matriz"]);
unset($_SESSION["visible"]);
unset( $_SESSION["contadorM"]);
unset( $_SESSION["win"]);
unset( $_SESSION["cantidad"]);
unset( $_SESSION["cantidadM"]);
unset( $_SESSION["status"]);
unset( $_SESSION["Casillas"]);
header("Location:index.php");