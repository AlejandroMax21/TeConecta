<?php include("header.php")?>
<title>Subir Documentos </title>
<div class="col-md-6 offset-md-3" style="margin-top: 55px; margin-right: 100px;">
    <div class="card">
        <div class="card-body text-center">
            <h2 class="upload-title"><strong>Subir Foto</h2>
                <div class="container">
                    <div class="mb-3">
                        <form action="admin/foto.php" method="POST" enctype="multipart/form-data"> 
                            
                            <div class="form-group">
                                <div class="dropzone-area">
                                    <div class="file-upload-icon">
                                        <i class="fa-regular fa-file"></i>
                                    </div>
                                    <p>Haga clic para cargar o arrastre y suelte</p>
                                    <input type="file" required id="upload-file" name="upload-file">
                                    <p class="message">No hay archivos seleccionados</p>
                                </div>
                            </div>
                            <div class="dropzone-actions">
                                <button type="submit" class="submit-btn">Confirmar</button>
                                <button type="button" class="cancel-btn" href="perfil_alumno.php">Cancelar</button>
                            </div>
                        </form>
                            
                </div>
        </div>
    </div>

</div>
<?php include("footer.php")?>