<?php include("header.php")?>
<title>Subir Documentos </title>
<div class="col-md-6 offset-md-3" style="margin-top: 55px; margin-right: 100px; margin-left: 32%;">
    <div class="card">
        <div class="card-body text-center" >
            <h2 class="upload-title" style="text-align: center; margin-bottom: 20px; color: black;"><strong>Subir Documentos</h2>
                <div class="container">
                    <div class="mb-3">
                        <form action="admin/subir.php" method="POST" enctype="multipart/form-data"> 
                            <label for="exampleFormControlInput1" class="form-label" style="font-size: 18px;">Titulo del documento:</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="txtTitulo" placeholder=""
                                style="width: 400px; margin: 0 auto; display: block; background-color: white;border: 1px solid grey;" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 18px;">Descripción:</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="txtDescripcion" rows="3"
                                    style="width: 400px;margin: 0 auto; display: block; resize: none; border: 1px solid grey;" required></textarea>
                            </div>
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
                                <button type="button" class="cancel-btn">Cancelar</button>
                            </div>
                        </form>
                            
                </div>
        </div>
    </div>

</div>
<?php include("footer.php")?>

