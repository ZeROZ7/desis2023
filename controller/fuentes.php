<?php
    include_once('../database.php');
    $db_con = open();
    $fuentes = [];
    if ($result = $db_con->query("SELECT * FROM desis_fuentes WHERE activo = 1")) {
        while ($row = mysqli_fetch_assoc($result)) {     		
            $fuentes[] = $row;
        }
        $result->free_result();
    }
    close($db_con);
    echo json_encode($fuentes);
?>

