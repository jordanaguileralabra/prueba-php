<?php 

require_once '../configs/database.php';

if(isset($_GET)){

    // Validamos si se ha recibido las variables traida por GET, ademas de validar que cumpla con ser string//
    $nombres = isset($_GET['nombres']) ? mysqli_real_escape_string($conn, $_GET['nombres']) : false;
    $alias = isset($_GET['alias']) ? mysqli_real_escape_string($conn, $_GET['alias']) : false;
    $rut = isset($_GET['rut']) ? $_GET['rut'] : false;
    $email = isset($_GET['email']) ? $_GET['email'] : false;
    $id_region = isset($_GET['id_region']) ? $_GET['id_region'] : false;
    $id_comuna = isset($_GET['id_comuna']) ? $_GET['id_comuna'] : false;
    $id_candidato = isset($_GET['id_candidato']) ? $_GET['id_candidato'] : false;
    $medios = isset($_GET['medios']) ? $_GET['medios'] : array();

    // Hacemos un ARRAY de errores, para señalar cual de los siguiente en caso de fallar, pudiesemos identificar el error de manera rapida y efectiva.//
    $errors = array();
    
    // Validamos que cumpla los requisitos de la votación.//
    if(!empty($nombres) && !is_numeric($nombres)){ $success_name = true;}else{ $errors['nombres'] = 'Nombre vacio o mal escrito';}
    if(!empty($alias) && !is_numeric($alias)){ $success_alias = true;}else{ $errors['alias'] = 'Alias Vacio o sin ingresar numero o letra';}
    if(!empty($rut)){ $success_rut = true;}else{ $errors['rut'] = 'Ingrese correctamente el rut';}
    if(!empty($email)){ $success_email = true;}else{ $errors['email'] = 'Ingresar Email Correctamente';}
    if(!empty($id_region) && is_numeric($id_region)){ $success_region = true;}else{ $errors['id_region'] = 'Falta seleccionar Region';}
    if(!empty($id_comuna) && is_numeric($id_comuna)){ $success_comuna = true;}else{ $errors['id_comuna'] = 'Falta seleccionar comuna';}
    if(!empty($id_candidato) && is_numeric($id_candidato)){ $success_candidato = true;}else{ $errors['id_candidato'] = 'Falta ingresar un candidato';}
    if(!empty($medios)){ $success_medios = true;}else{ $errors['medios'] = 'Debe seleccionar almenos 2 medios';}

    // Si encuentra errores enviara un mensaje, de no ser asi enviara la query de insert.//
    if(count($errors) == 0){
        // Valido el Rut si existe.
        $rut_verify = "SELECT * FROM votaciones WHERE rut = '$rut'";
        $duplicate_rut = mysqli_query($conn, $rut_verify);

        if(mysqli_num_rows($duplicate_rut) > 0){
            echo $_SESSION['error_save'] = "Lamentablemente ya se ha votado con este rut, favor ingresar otro";
        } else {
            $insert_votacion = "INSERT INTO votaciones (rut, nombres, alias, email, id_region, id_comuna, id_candidato) VALUES ('$rut', '$nombres', '$alias', '$email', $id_region, $id_comuna, $id_candidato)";
            $sequel_votacion = mysqli_query($conn, $insert_votacion);

            if($sequel_votacion){
                $votacion_id = mysqli_insert_id($conn);

                // Insertar en la tabla de respuestas_checkbox
                foreach ($medios as $medio_id) {
                    $insert_respuestas = "INSERT INTO response_checkbox (id_votacion, id_medio) VALUES ($votacion_id, $medio_id)";
                    $sequel_respuestas = mysqli_query($conn, $insert_respuestas);
                }

                if($sequel_respuestas){
                    echo $_SESSION['success_save'] = 'Se ha guardado exitosamente su votacion';
                } else {
                    echo $_SESSION['error_save'] = 'Hay problema, necesita ingresar almenos 2 opciones';
                }
            } else {
                echo $_SESSION['error_save'] = 'Necesita ingresar almenos 2 opciones de como se entero de nosotros';
            }
        }
    } else {
        $error_messages = "Errores en el formulario:\n";
        foreach ($errors as $field => $message) {
            $error_messages .= " - $message\n";
        }
        echo $_SESSION['error_save'] = $error_messages;
    }
} else {
    echo $_SESSION['error_post'] = "No se ha enviado ninguna peticion, revisar por favor";
}
?>