<?php
    include_once('../database.php');

    // Server-side validation (mirrors the client-side checks in js/scripts.js)
    function validaRut($rutCompleto) {
        if (!preg_match('/^[0-9]+-[0-9K]$/', $rutCompleto)) return false;
        list($num, $dv) = explode('-', $rutCompleto);
        $m = 0; $s = 1;
        for ($t = (int) $num; $t; $t = intdiv($t, 10)) {
            $s = ($s + $t % 10 * (9 - $m++ % 6)) % 11;
        }
        $esperado = $s ? (string) ($s - 1) : 'K';
        return $esperado === $dv;
    }

    $nombre    = trim((string) ($_POST['nombre'] ?? ''));
    $alias     = (string) ($_POST['alias'] ?? '');
    $rutInput  = strtoupper(str_replace(".", "", (string) ($_POST['rut'] ?? '')));
    $email     = (string) ($_POST['email'] ?? '');
    $comuna    = filter_var($_POST['comuna'] ?? null, FILTER_VALIDATE_INT);
    $candidato = filter_var($_POST['candidato'] ?? null, FILTER_VALIDATE_INT);
    $fuentes   = $_POST['fuentes'] ?? [];

    if ($nombre === '') { printf("Error: Campo nombre no puede quedar en blanco"); return; }
    if (!(preg_match('/\d/', $alias) && preg_match('/[a-zA-Z]/', $alias))) {
        printf("Error: Campo Alias debe contener al menos 1 numero y 1 letra"); return;
    }
    if (!validaRut($rutInput)) { printf("Error: RUT Invalido"); return; }
    if ($comuna === false || $comuna === null || $candidato === false || $candidato === null) {
        printf("Error: Comuna o candidato invalido"); return;
    }
    if (!is_array($fuentes) || count($fuentes) < 2) {
        printf("Error: Debe seleccionar almenos 2 opciones de como se entero de nosotros"); return;
    }
    foreach ($fuentes as $f) {
        if (filter_var($f, FILTER_VALIDATE_INT) === false) { printf("Error: Fuente invalida"); return; }
    }

    // Same normalization as before: strip separators, K -> 0
    $rut = str_replace(["-", "K"], ["", "0"], $rutInput);

    $db_con = open();

    $stmt = $db_con->prepare("SELECT id FROM desis_votaciones WHERE rut = ?");
    $stmt->bind_param('s', $rut);
    $stmt->execute();
    $actual = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (is_array($actual)){
        printf("Error: RUT ya tiene registrado su voto");
        close($db_con);
        return;
    }

    $stmt = $db_con->prepare("INSERT INTO desis_votaciones ".
           "(rut, nombre, alias, email, comuna_id, candidato_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssii', $rut, $nombre, $alias, $email, $comuna, $candidato);
    if ($stmt->execute()) {
        $id_voto = $db_con->insert_id;
        $stmtF = $db_con->prepare("INSERT INTO desis_fuentes_voto (votacion_id, fuente_id) VALUES (?, ?)");
        foreach ($fuentes as $fuente) {
            $fuente = (int) $fuente;
            $stmtF->bind_param('ii', $id_voto, $fuente);
            $stmtF->execute();
        }
        $stmtF->close();
        printf("Voto guardado en forma exitosa!");
    }
    if ($db_con->errno) {
        printf("Error MySQL: %s<br />", $db_con->error);
    }
    $stmt->close();
    close($db_con);
?>
