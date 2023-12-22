<?php
    function open(){
        $host = "localhost";
        $database = 'desis2023';
        $user = 'root';
        $password = '';    
        $conexion = new mysqli($host, $user, $password,$database) or die("Connección fallida: ". $conexion->error);
        return $conexion;
    }
    function close($conexion){
        $conexion->close();
    }

?>