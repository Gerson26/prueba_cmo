<!-- ABRE MODAL -->
<!-- <div class="modal fade" id="Modal_Caja" role="dialog" aria-labelledby="" aria-hidden="">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Caja de Comentarios
                </h5>

                <span type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal" aria-label="Close">
                    X
                </span>
            </div>
            <center>
            <div class="modal-body">
                <p style="font-size: 16px">¿Experimentó algún problema con la página? ¡Déjanos saber
                en la caja de comentarios!</p>
                <hr>
                <form method="POST" enctype="multipart/form-data" id="form_datos_caja">

                    <div class="row">
                        <center>
                        <div class="col-8">
                            <label class="control-label col-12" for="nombre_completo">Escribe tu nombre completo <span class="required">*</span></label>
                            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" placeholder="¡Escribe nombre aquí!" require>
                        </div>
                        </center>
                        
                    </div>
                    <div class="row">
                        <center>
                        <div class="col-8">
                            <label class="control-label col-12" for="comentario">Caja de Comentarios <span class="required">*</span></label>
                           
                            <textarea class="form-control mb-3" name="comentario" id="comentario" cols="30" rows="5"></textarea>
                            <input type="hidden" class="form-control" id="sitio" name="sitio">
                        </div>
                        </center>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-gradient-success" id="btn_upload" name="btn_upload">Aceptar</button>
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
            </center>
        </div>
    </div>
</div> -->
<!-- CIERRA MODAL -->
<!-- <script>
    $(document).ready(function() {
        var currentUrl = window.location.pathname;
        $("#sitio").val(currentUrl);

        $("#form_datos_caja").on("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(document.getElementById("form_datos_caja"));
            $.ajax({
                url: "/Login/saveComentario",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    console.log("Procesando....");
                    // alert('Se está borrando');

                },
                success: function(respuesta) {
                    console.log(respuesta);

                    if (respuesta == 'success') {
                        Swal.fire("¡Recibimos tu comentario, gracias!", "", "success").
                        then((value) => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire("¡Hubo un error, inténtalo de nuevo!", "", "warning").
                        then((value) => {
                            window.location.reload();
                        });
                    }
                },
                error: function(respuesta) {
                    console.log(respuesta);
                    // alert('Error');
                    Swal.fire("¡Hubo un error, inténtalo de nuevo!", "", "warning").
                    then((value) => {
                        window.location.reload();
                    });
                }
            });
        });
    });
</script> -->