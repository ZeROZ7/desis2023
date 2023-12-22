<?php
    include_once('../database.php');
    
    $nombre = $_POST['nombre'];
    $alias = $_POST['alias'];
    $rut = strtoupper($_POST['rut']);
    $rut = str_replace(".", "", $rut);    
    $rut = str_replace("-", "", $rut);    
    $rut = str_replace("K", "0", $rut);
    $email = $_POST['email'];
    $region = $_POST['region'];
    $comuna = $_POST['comuna'];
    $candidato = $_POST['candidato'];
    $fuentes = $_POST['fuentes'];
    $db_con = open();


    $result = $db_con->query("SELECT * FROM desis_votaciones WHERE rut = ".$rut);
    $actual = mysqli_fetch_assoc($result);
    if (is_array($actual)){
        printf("Error: RUT ya tiene registrado su voto");
        return;
    }

    $sql = "INSERT INTO desis_votaciones ".
           "(rut, nombre, alias, email, comuna_id, candidato_id) ".
           "VALUES('$rut','$nombre','$alias','$email','$comuna','$candidato');";
    if ($db_con->query($sql)) {
        $id_voto = $db_con->insert_id;
        foreach ($fuentes as $fuente) {    
            $sqlFuentes = "INSERT INTO desis_fuentes_voto (votacion_id, fuente_id) ".
            "VALUES('$id_voto', '$fuente');";     
            $db_con->query($sqlFuentes);
        }
        printf("Voto guardado en forma exitosa!");
    }
    if ($db_con->errno) {
        printf("Error MySQL: %s<br />", $db_con->error);
    }

    close($db_con);
?>
