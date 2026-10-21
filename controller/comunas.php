<?php
    include_once('../database.php');
    $region_id = filter_var($_GET['region_id'] ?? null, FILTER_VALIDATE_INT);
    $comunas = [];
    if ($region_id !== false && $region_id !== null) {
        $db_con = open();
        $stmt = $db_con->prepare("SELECT * FROM desis_comunas WHERE region_id = ?");
        $stmt->bind_param('i', $region_id);
        if ($stmt->execute() && ($result = $stmt->get_result())) {
            while ($row = mysqli_fetch_assoc($result)) {
                $comunas[] = $row;
            }
            $result->free_result();
        }
        $stmt->close();
        close($db_con);
    }
    echo json_encode($comunas);
?>
