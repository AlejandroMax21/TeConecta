<?php include ('header.php')?>

    <div class="main-container">
        <div class="busqueda">
            <form method="post" id="form-busqueda" class="form-container">
                <div class="container">
                    <div>
                        <label>Búsqueda</label>
                        <input style="padding-left: 7px;" class="busqueda-input" type="text" name="nombreArchivo" placeholder="Buscar..." value="<?php echo isset($_POST['nombreArchivo']) ? htmlspecialchars($_POST['nombreArchivo']) : ''; ?>">
                    </div>
                    <div class="filters">
                        <div>
                            <label for="fecha">Fecha</label>
                            <input name="fecha" type="date" id="fecha" value="<?php echo isset($_POST['fecha']) ? $_POST['fecha'] : ''; ?>" min="1960-01-01" max="">
                        </div>
                        <div>
                            <label>Calificacion</label>
                            <input name="Calif" id="Calif" type=number min='0' max='100' placeholder="0-100">
                        </div>
                        <div>
                        
                            <label for="SelCarrera">Carrera</label>
                            <select name="SelCarrera" id="SelCarrera">
                                <option value="">Seleccionar</option>
                                <option value="Ingenieria en Sistemas Computacionales">Sistemas Computacionales</option>
                                <option value="Ingenieria Electrica">Electrica</option>
                                <option value="Ingenieria Mecatronica">Mecatronica</option>
                                <option value="Arquitectura">Arquitectura</option>
                                <option value="Ingenieria Civil">Civil</option>
                                <option value="Ingenieria Industrial">Industrial</option>
                                <option value="Administracion">Administración</option>
                            </select>
                        </div>
                        <div>
                            <label>Extension</label>
                            <input class="extensionF-input" name="extensionF" type="textF" placeholder="pdf, docx, ..." value="<?php echo isset($_POST['extensionF']) ? $_POST['extensionF'] : ''; ?>">
                        </div>
                        <div>
                            <label for="gen">Generacion</label>
                            <select name="gen" id="gen">
                                <option value="">Seleccionar</option>
                                <option value="16">2016</option>
                                <option value="17">2017</option>
                                <option value="18">2018</option>
                                <option value="19">2019</option>
                                <option value="20">2020</option>
                                <option value="21">2021</option>
                                <option value="22">2022</option>
                                <option value="23">2023</option>
                            </select>
                        </div>
                        <div>
                            <label for="TipoUsuario">T. usuario</label>
                            <select name="TipoUsuario" id="TipoUsuario">
                                <option value="">Seleccionar</option>
                                <option value="Docente">Docente</option>
                                <option value="Alumno">Alumno</option>
                            </select>
                        </div>
                        <div class="button-submit" style="margin-bottom: 5px;"><button type="submit">BUSCAR</button></div>
                    </div>
                </div>
                

            </form>

        </div>
        
        <div class="resultados">
            <?php
            if (isset($_POST['nombreArchivo'])) {
                // Parámetros de conexión a la bd
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "teconecta";

                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }

                $busqueda = $_POST['nombreArchivo'];


                $sql = "SELECT c.id_Publi, c.Titulo_Publi, c.Tema_Publi, c.Fecha_Publi, 
                    CONCAT('admin/', SUBSTRING(c.Archivo_Publi, LOCATE('files/', c.Archivo_Publi))) AS Archivo_Publi, 
                    COALESCE(v.promedio_valoraciones, '--') AS Punto_Valor, u.Nom_User, u.ApellPat_User
                    FROM contenido c 
                    INNER JOIN usuario u ON c.Usuario_id_User = u.id_User 
                    LEFT JOIN (SELECT Contenido_id_Publi, round(AVG(Punto_Valor)) AS promedio_valoraciones 
                    FROM valoracion GROUP BY Contenido_id_Publi) v ON c.id_Publi = v.Contenido_id_Publi 
                    WHERE c.Titulo_Publi LIKE '%$busqueda%'";


                if (!empty($_POST['fecha'])) {
                    $fecha = $_POST['fecha'];
                    $sql .= " AND Fecha_Publi = '$fecha'";
                }

                if (!empty($_POST['Calif'])) {
                    $calificacion = $_POST['Calif'];
                    $sql .= " AND promedio_valoraciones >= $calificacion";
                }

                if (!empty($_POST['SelCarrera'])) {
                    $carrera = $_POST['SelCarrera'];
                    $sql .= " AND u.Carre_User  = '$carrera'";
                }

                if (!empty($_POST['extensionF'])) {
                    $extensionF = $_POST['extensionF'];
                    $sql .= " AND SUBSTRING_INDEX(archivo_publi, '.', -1) = '$extensionF'";
                }

                if (!empty($_POST['gen'])) {
                    $gen = $_POST['gen'];
                    $primeros_dos_numeros = substr($gen, 0, 2);
                    $sql .= " AND SUBSTRING(id_User, 1, 2) = '$primeros_dos_numeros'";
                }
                if (!empty($_POST['TipoUsuario'])) {
                    $TipoUsuario = $_POST['TipoUsuario'];
                    $sql .= " AND u.Perfil_User = '$TipoUsuario'";
                }

                // Ejecutar la consulta
                $result = $conn->query($sql);

                // Mostrar los resultados
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $IDP = $row["id_Publi"];
                        $archivo_pdf = $row["Archivo_Publi"];
                        $extension = pathinfo($archivo_pdf, PATHINFO_EXTENSION);

                        echo "<div class='resultado-panel' data-document-id='$IDP' onclick='redirectToDocument(this)'>";
                        if (strtolower($extension) == 'pdf') {
                            echo "<embed width='191' height='207' name='plugin' src='{$row["Archivo_Publi"]}' type='application/pdf'>";
                        } elseif (in_array(strtolower($extension), ['docx', 'doc', 'docm', 'dot', 'dotx', 'wbk', 'wpd', 'wp5'])) {
                            echo "<img class='Docimg' src='img/docLogo.png' alt='Imagen del documento'>";
                        } elseif (in_array(strtolower($extension), ['pot', 'potm', 'potx', 'ppam', 'pps', 'ppsm', 'ppsx', 'ppt', 'pptx', 'pptm', 'sldx', 'sldm'])) {
                            echo "<img class='Pptximg' src='img/pptxLogo.png' alt='Imagen del documento'>";
                        } else {
                            echo "<p>Archivo no compatible: {$archivo_pdf}</p>";
                        }
                        echo "<h1>{$row["Titulo_Publi"]}</h1>";
                        echo "<p>{$row["Tema_Publi"]}</p>";
                        echo "<h3>Fecha: {$row["Fecha_Publi"]}</h3>";
                        echo "<img src='img/estrella.png' alt='calificacion' class='caliImg'>";
                        echo "<h2 class='CalNumero'>Calificacion: {$row["Punto_Valor"]}</h2>";
                        echo "<h2>Autor: </h2>";
                        echo "<h2 class='nombre-autor'>{$row["Nom_User"]} {$row["ApellPat_User"]} </h2>";
                        echo "</div>";
                        
                        echo "<form class='botonesLado' action='admin/guardar_documentos.php' method='post'>";
                        // Campo oculto para enviar el ID
                        echo "<input type='hidden' name='id_Publi' value='$IDP'>";
                        echo "<button type='submit' class='favo_button'>";
                        echo "<img src='img/favorito2.png' alt='Guardar' style='width: 50px; height: 50px;'></button>";
                        echo "<a href='{$row["Archivo_Publi"]}' download='{$row["Titulo_Publi"]}.{$extension}'>";
                        echo "<img src='img/descargas.png' alt='Descargar' class='decargarcosa'></a>";
                        echo "</form><br>";
                        echo "<div><br></div>";
                    }
                } else {
                    echo "<h1>No se encontraron resultados.</h1>";
                    if (!isset($_POST['nombreArchivo'])){
                        echo "<p>No se encontraron resultados para '$busqueda'.</p>";
                    }else{
                        echo "<p>No se encontraron resultados para busqueda general.</p>";
                    }
                }

                // Cerrar la conexión
                $conn->close();
            }
            ?>

        </div>
    </div>

    <script>
        function realizarBusqueda() {
            var formData = new FormData(); // Crear objeto FormData

            var forms = document.querySelectorAll('form#form-busqueda');
            console.log(forms)

            forms.forEach(function(form) {
                var formInputs = new FormData(form);
                formInputs.forEach(function(value, key) {
                    formData.append(key, value);
                });
            });

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "busqueda.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.responseText;
                    console.log(response);
                }
            };
            xhr.send(formData);
        }
    </script>

    <script>
        document.getElementById('formFiltro').addEventListener('submit', function(event) {
            console.log(forms)
            console.log(event)
        });

        function onSubmit() {
            console.log(forms);
        }

        function redirectToDocument(element) {
            const documentId = element.getAttribute('data-document-id');
            window.location.href = `archivoAbierto.php?id_publicacion=${documentId}`;
        }
    </script>


</body>

</html>