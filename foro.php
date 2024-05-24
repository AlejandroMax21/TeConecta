<?php include('header.php')?>
<main class="main" style="padding: 20px;">
        <h1>Foro de Discusión</h1>
        <div class="forum-container">
            <section class="forum-threads">
                <h2>Discusiones Recientes</h2>
                <?php include ('admin/verDiscusiones.php')?>
                <!-- Repetir bloques .thread para más hilos -->
            </section>
            <section class="post-message">
                <h2>Crear Nueva Discusión</h2>
                <form action="admin/nuevaDiscusion.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="tituloForo" placeholder="Título de la discusión" required>
                    <textarea name="contenido" placeholder="Escribe tu mensaje aquí..." required></textarea>
                    <button type="submit" class="submit-btn">Confirmar</button>
                    <button type="button" class="cancel-btn">Cancelar</button>
                </form>
            </section>
        </div>
</main>
<?php include('footer.php')?>