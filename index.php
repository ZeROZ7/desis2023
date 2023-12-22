<!DOCTYPE HTML>

<html lang="en">
    <head>
        <title>Sistema de Votacion - Desis</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="Israel Jensen" content="testDesis">
        <link rel="stylesheet" type="text/css" href="style/style.css">        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <div class="form-wrapper">
            <form id="form_votacion" onsubmit="salvarFn();">              
                <legend><img src="public/logo-desis2.png" width="100px" height="30px"> Formulario de Votación</legend>                
                
                <input type="text" id="nombre" name="nombre" placeholder="Nombre y Apellido" autofocus minlength="3" autocomplete="on" required> <br><br>
                <input type="text" id="alias" name="alias" placeholder="Alias" autocomplete="on" minlength="6" required> <br><br>
                <input type="text" id="rut" name="rut" placeholder="RUT" minlength="9" required><br><br>
                <input type="email" id="email" placeholder="E-Mail" autocomplete="on" required> <br><br>           
                <select name='region' id='region' required>
                    <option disabled selected value>Selecciona Región</option>
                </select><br><br>
                <select name='comuna' id='comuna' required>
                    <option disabled selected value>Selecciona Comuna</option>
                </select><br><br>
                <select name='candidato' id='candidatos' required>
                    <option disabled selected value>Selecciona tu Candidato</option>
                </select><br><br>
                <label for="fuente">Como se entero de nosotros:</label></td>
                <div id="fuente">                            
                </div><br><br>
                <input type="hidden" id="fuentes" name="fuentes" value="0">
                
                <input class="submit" type="submit" value="VOTAR">            
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>