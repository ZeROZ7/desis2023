<?php
    include_once('../database.php');
    $db_con = open();
    $regiones = [];
    if ($result = $db_con->query("SELECT * FROM desis_regiones")) {
        while ($row = mysqli_fetch_assoc($result)) {     		
            $regiones[] = $row;
        }
        $result->free_result();
    }
    close($db_con);
    echo json_encode($regiones);
?>

