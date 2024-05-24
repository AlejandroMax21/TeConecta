<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Eventos</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="admin.php" id="navbar__logo"><img src="images/logo_tec.png" alt="Logo Tec Tepic">TeConecta Admin</a>
        </div>
    </nav>

    <main class="main">
        <div class="admin-container">
            <h1>Gestión de Eventos</h1>
            <form action="php/submit_event.php" method="post">
                <div class="form-group">
                    <label for="event-title">Título del Evento:</label>
                    <input type="text" id="event-title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="event-date">Fecha del Evento:</label>
                    <input type="date" id="event-date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="event-time">Hora del Evento:</label>
                    <input type="time" id="event-time" name="time" required>
                </div>
                <div class="form-group">
                    <label for="event-location">Ubicación:</label>
                    <input type="text" id="event-location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="event-url">URL del Evento:</label>
                    <input type="url" id="event-url" name="url" required>
                </div>
                <div class="form-group">
                    <label for="event-description">Descripción:</label>
                    <textarea id="event-description" name="description" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="submit-btn">Guardar Evento</button>
                </div>
            </form>
        </div>
    </main>

    <footer class="footer__container">
        <p>Contacto: info@teconecta.com</p>
    </footer>
</body>
</html>
