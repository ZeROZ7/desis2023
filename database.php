<?php
    // Database settings come from environment variables (see .env.example).
    function open(){
        $host     = getenv('DB_HOST') ?: 'localhost';
        $port     = (int) (getenv('DB_PORT') ?: 3306);
        $database = getenv('DB_NAME') ?: 'desis2023';
        $user     = getenv('DB_USER') ?: '';
        $password = getenv('DB_PASS') ?: '';
        $conexion = new mysqli($host, $user, $password, $database, $port);
        if ($conexion->connect_error) {
            die("Connection failed: " . $conexion->connect_error);
        }
        $conexion->set_charset('utf8');
        return $conexion;
    }
    function close($conexion){
        $conexion->close();
    }
