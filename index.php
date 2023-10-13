<?php require_once 'configs/database.php'; ?>
<?php require_once 'controllers/helpers.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="style/style.css">
    <script src="javascript/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Formulario Requerido -->
    <div class="formulary">
        <h1>FORMULARIO DE VOTACIÓN:</h1>
        <br>
        <!-- Respuesta -->
        <form id="form" class="form"> 

            <div class="form-input">
                <label name="nombres">Nombre y Apellido</label>
                <input type="text" name="nombres" required>
            </div> 

            <div class="form-input">
                <label>Alias</label>
                <input type="text" name="alias" minlength="5" pattern="^(?=.*[a-zA-Z])(?=.*\d).+$" required>
            </div> 

            <div class="form-input">
                <label>RUT</label>
                <input type="text" name="rut" id="rut" minlength="9" required>
                <div id="resultado"></div>
            </div> 

            <div class="form-input">
                <label>Email</label>
                <input type="email" name="email" required>
            </div> 

            <div class="form-input">
                <label>Región</label>
                <select name="id_region" id="id_region"  onchange="getCity()">
                    <?php
                        $sql = "SELECT * FROM regiones";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id'];
                                $region = $row['region'];
                                echo "<option value='$id'>$region</option>";
                            }
                        } else {
                            echo "<option value=''>No hay regiones registrada</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="form-input">
                <label>Comuna</label>
                <select name="id_comuna" id="comuna">
                    <option value="">Seleccione comuna</option>
                </select>
            </div> 

            <div class="form-input">
                <label>Candidato</label>
                <select name="id_candidato">
                    <?php
                        $sql = "SELECT * FROM candidatos";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id'];
                                $nombre_candidato = $row['nombre_candidato'];
                                echo "<option value='$id'>$nombre_candidato</option>";
                            }
                        } else {
                            echo "<option value=''>No hay candidatos disponibles</option>";
                        }
                    ?>
                </select>
            </div> 

            <div class="form-input">
                <label>Como se enteró de Nosotros</label>
                <input type="checkbox" id="1" name="medios[]" value="1"> Web
                <input type="checkbox" id="2" name="medios[]" value="2"> TV
                <input type="checkbox" id="3" name="medios[]" value="3"> Redes Sociales
                <input type="checkbox" id="4" name="medios[]" value="4"> Amigo
            </div> 

            <input id="sendForm" type="submit" value="Votar">
        </form>
        <?php deleteMessage()?>
            <!-- Aqui se revise si fue o no ingresado correctamente los datos de formulario -->
        <div id="result"><h3>Respuesta</h3></div>
        
    </div>

    <!-- SCRIPT -->
    <script>
        const checkboxes = document.querySelectorAll('input[name="medios[]"]');
        const sendButton = document.getElementById('sendForm');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCheckboxes = document.querySelectorAll('input[name="medios[]"]:checked');
                if (checkedCheckboxes.length >= 2) {
                    sendButton.disabled = false; // Activa el botón de envío
                } else {
                    sendButton.disabled = true; // Desactiva el botón de envío
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
        $('#form').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
            url: 'controllers/send.php', 
            method: 'GET',
            data: formData,
            success: function(response) {
                $('#result').text(response);
            },
            error: function() {
                $('#result').text('Error');
            }
            });
        });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.getElementById('rut');
            
            input.addEventListener('input', function() {
                if (this.value.length > 9) {
                    this.value = this.value.slice(0, 9);
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var inputRut = document.getElementById('rut');
            var resultado = document.getElementById('resultado');

            inputRut.addEventListener('input', function() {
                var rut = inputRut.value;

                if (validarRut(rut)) {
                    resultado.innerHTML = "El RUT " + rut + " es válido.";
                    document.getElementById("sendForm").disabled = false; // Desactiva el botón de envío
                } else {
                    resultado.innerHTML = "El RUT " + rut + " no es válido.";
                    document.getElementById("sendForm").disabled = true; // Desactiva el botón de envío
                }
            });

            function validarRut(rut) {
                rut = rut.replace(/[^k0-9]/i, ''); // Elimina caracteres no válidos
                var dv = rut.slice(-1); // Último dígito verificador
                var numero = rut.slice(0, -1); // Números del RUT

                var factor = 2;
                var suma = 0;

                // Realiza la suma ponderada de los dígitos del RUT
                for (var i = numero.length - 1; i >= 0; i--) {
                    suma += factor * parseInt(numero[i]);
                    factor = factor === 7 ? 2 : factor + 1;
                }

                var dvCalculado = 11 - (suma % 11);
                dvCalculado = dvCalculado === 11 ? 0 : (dvCalculado === 10 ? 'k' : dvCalculado);

                return dv.toLowerCase() === dvCalculado.toString();
            }
        });
    </script>
</body>
</html>