<?php


class Conectar {


    private $conexion;
        public function __construct(){
    
        }
    
        public function getConexion() {
            return $this->conexion;
        }
    
        public function ConectarBD() {
            $this->conexion = new mysqli("localhost","root","","buscaminas");
    
            if($this->conexion->connect_errno) {
                echo "NO ES POSIBLE CONECTARSE A LA BASE DE DATOS";
                exit;
            } 
        }
    }