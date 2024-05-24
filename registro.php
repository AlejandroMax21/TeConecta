<?php
session_abort();
session_start();
if (empty($_SESSION["id"])) {
    header("location: login2.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro en TeConecta</title>
    <link rel="stylesheet" href="css/registro.css">
    <link rel="stylesheet" href="/TeConecta/TeConecta/css/iniciar_sesion.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="#" id="navbar__logo"><img src="images/logo_tec.png" alt="Logo Tec Tepic">TeConecta</a>
        </div>
    </nav>
    <main class="main">
        <div class="login-container">
            <h2>Crear Cuenta</h2>
            <form action="/register" method="post">
                <div class="form-group">
                    <label for="name">Nombre Completo:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirmar Contraseña:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <div class="form-group">
                    <label>¿Eres Alumno o Docente?</label>
                    <div>
                        <input type="radio" id="alumno" name="role" value="Alumno" checked>
                        <label for="alumno">Alumno</label>
                    </div>
                    <div>
                        <input type="radio" id="docente" name="role" value="Docente">
                        <label for="docente">Docente</label>
                    </div>
                </div>
                <div class="form-group" id="control-number-div" style="display: block;">
                    <label for="control-number">Número de Control:</label>
                    <input type="text" id="control-number" name="control-number">
                </div>
                <div class="form-group" id="employee-number-div" style="display: none;">
                    <label for="employee-number">Número de Empleado:</label>
                    <input type="text" id="employee-number" name="employee-number">
                </div>
                <div class="form-group">
                    <label for="birth-year">Fecha de Nacimiento:</label>
                    <select id="birth-year" name="birth-year"></select>
                    <select id="birth-month" name="birth-month">
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                    <select id="birth-day" name="birth-day"></select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="submit-btn">Registrarse</button>
                </div>
                <div class="login-links">
                    <a href="iniciar_sesion.php">¿Ya tienes cuenta? Inicia sesión</a>
                </div>
            </form>
        </div>
    </main>

    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>
</body>
</html>

<script src="js/registro.js"></script>