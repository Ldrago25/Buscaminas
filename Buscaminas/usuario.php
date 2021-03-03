<?php
require_once 'Conectar.php';
session_start();
class Usuario{
    public $idNombre;
    public $Nombre;
    public $Apellido;
    public $Tiempo;

    public function __construct() {
        $this->conec = new Conectar();
		$this->conec->ConectarBD();
	}

    public function save(){
        $consulta = "INSERT INTO usuario VALUE (NULL, '{$this->Nombre}', '{$this->Apellido}', '{$this->Tiempo}' );";
        $save =  $this->conec->getConexion()->query($consulta);
		
		$resultado = false;

		if($save) {
			$resultado = 1;
		}

		return $resultado;
    }

    public function all(){
    $consulta = "SELECT * FROM usuario";
	$resultado_consulta = $this->conec->getConexion()->query($consulta);
    if($resultado_consulta &&  mysqli_num_rows($resultado_consulta) == 1) {
		$usuario = mysqli_fetch_assoc($resultado_consulta);
		$_SESSION['usuario'] = $usuario;
	
	} else {
	   unset($_SESSION['usuario']);
	}
    }
    public function edite()
    {
      
	
      $Edita="UPDATE usuario SET Nombre='$this->Nombre',Apellido='$this->Apellido',Tiempo='$this->Tiempo' WHERE Nombre='$this->idNombre'";
     
      $edito=$this->conec->getConexion()->query($Edita);
      var_dump($edito);
      if($edito )
      {
//        $completo = mysqli_fetch_row($edito);
$completo=1;
        return $completo;
      }


    }
}