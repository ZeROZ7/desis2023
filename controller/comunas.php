<?php
    include_once('../database.php');
    $db_con = open();
    $comunas = [];
    if ($result = $db_con->query("SELECT * FROM desis_comunas WHERE region_id = ".$_GET['region_id'])) {
        while ($row = mysqli_fetch_assoc($result)) {     		
            $comunas[] = $row;
        }
        $result->free_result();
    }
    close($db_con);
    echo json_encode($comunas);
?>

