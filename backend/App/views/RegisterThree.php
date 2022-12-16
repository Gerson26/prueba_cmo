<?php
echo $header;
?>

<body>

    <main class="main-content main-content-bg mt-0">
        <section>
            <nav class="navbar navbar-expand-lg  blur blur-rounded top-0  z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                <div class="container-fluid">
                    <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 ">
                        <img src="/assets/img/logo_cmo.png" height="40" alt="">
                        <!-- <img src="/assets/img/logos/waddn.png" style="width: 40px; height: 40px; margin-left: 5px; margin-right: 5px;"> -->
                        CMO
                    </a>

                    <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
                        <ul class="navbar-nav navbar-nav-hover mx-auto">
                        </ul>
                        <ul class="navbar-nav d-lg-block d-none">
                            <li class="nav-item">
                                <a href="/Register" class="btn btn-sm btn-round mb-0 me-1"><i class="fas fa-undo"></i> REGRESAR</a>
                                <a href="/Inicio/" class="btn btn-sm  bg-gradient-info  btn-round mb-0 me-1" onclick="smoothToPricing('pricing-soft-ui')">INICIAR SESIÓN</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-10 col-lg-10 col-md-12 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-7">
                                <div class="container-fluid py-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="multisteps-form">
                                                <!--progress bar-->
                                                <div class="row" id="card_progress">
                                                    <div class="col-12 col-lg-12 mx-auto my-4">
                                                        <div class="multisteps-form__progress">
                                                            <button class="multisteps-form__progress-btn js-active" title="User Info" disabled>
                                                                <span>Información de usuario</span>
                                                            </button>
                                                            <button class="multisteps-form__progress-btn" title="Others" disabled>Otros</button>
                                                            <!-- <button class="multisteps-form__progress-btn" title="Payment" disabled>Pago</button> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--form panels-->
                                                <!-- <?php var_dump($dataUser); ?> -->
                                                <input type="hidden" id="ano_residente" name="ano_residente" value="<?php echo $dataUser['ano_residencia']?>">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 m-auto">
                                                        <input type="hidden" id="email" name="email" value="<?php echo $dataUser['email'] ?>">
                                                        <form class="multisteps-form__form" id="add" method="POST">
                                                            <!--single form panel-->
                                                            <input type="hidden" name="dataUser" value='<?php echo serialize($dataUser) ?>'>
                                                            <div class="row text-center">
                                                                <div class="row text-center">
                                                                    <div class="row text-center mt-1">
                                                                        <div class="col-10 mx-auto">
                                                                            <h5 class="font-weight-normal">Información Fiscal:</h5>
                                                                            <p class="mb-0 text-sm">
                                                                                AVISO SAT: Si usted requiere factura, solo necesitamos la siguiente información para la expedición.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="multisteps-form__content">
                                                                <div class="row mt-0">
                                                                    <div class="row mt-1">
                                                                        <div class="col-12 col-sm-4">
                                                                            <label>Razón Social *</label>
                                                                            <input class="multisteps-form__input form-control" type="text" id="business_name_iva" name="business_name_iva" placeholder="eg. Christopher Prior Jones" maxlength="100" onfocus="focused(this)" onfocusout="defocused(this)">
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 mt-1 mt-sm-0">
                                                                            <label>RFC *</label>
                                                                            <input class="multisteps-form__input form-control" type="text" id="code_iva" name="code_iva" placeholder="eg. CPJ41250AS" maxlength="13" onfocus="focused(this)" onfocusout="defocused(this)" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                                        </div>
                                                                        <!-- <div class="col-12 col-sm-4 mt-1 mt-sm-0">
                                                                                <label>Método de Pago *</label>
                                                                                <select class="multisteps-form__select form-control all_input_select" name="payment_method_iva" id="payment_method_iva">
                                                                                    <option value="" disabled selected>Selecciona una Opción</option>
                                                                                    <option value="ELECTRONIC TRANSFER">ELECTRONIC TRANSFER</option>
                                                                                    <option value="CREDIT OR DEBIT CARD">CREDIT OR DEBIT CARD</option>
                                                                                </select>
                                                                            </div> -->

                                                                        <div class="col-md-4 col-sm-12">
                                                                            <label>Correo Electrónico facturación * </label>
                                                                            <input class="multisteps-form__input form-control" type="text" id="email_receipt_iva" name="email_receipt_iva" placeholder="eg. user@domain.com" onfocus="focused(this)" onfocusout="defocused(this)">

                                                                        </div>

                                                                        <div class="col-md-4 col-sm-12 mt-2">
                                                                            <label>CP * </label>
                                                                            <input class="multisteps-form__input form-control" type="text" id="cp_fac" name="cp_fac" placeholder="" onfocus="focused(this)" onfocusout="defocused(this)">

                                                                        </div>

                                                                        <div class="col-md-4 col-sm-12 mt-2">
                                                                            <label>CFDI * </label>
                                                                            <select class="multisteps-form__select form-control all_input_select" name="cfdi" id="cfdi">
                                                                                <option value="">Selecciona una opción</option>
                                                                                <?= $usoCfdi ?>

                                                                            </select>

                                                                        </div>

                                                                        <div class="col-md-4 col-sm-12 mt-2">
                                                                            <label>RÉGIMEN FISCAL * </label>
                                                                            <select class="multisteps-form__select form-control all_input_select" name="regimen_fiscal" id="regimen_fiscal">
                                                                                <option value="">Selecciona una opción</option>
                                                                                <?= $remigenFiscal ?>

                                                                            </select>

                                                                        </div>


                                                                    </div>
                                                                    <div class="row mt-1">

                                                                        <!-- <div class="col-12 col-sm-2">
                                                                                <label>C.P *</label>
                                                                                <input class="multisteps-form__input form-control" type="text" id="postal_code_iva" name="postal_code_iva" maxlength="5" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" placeholder="eg. 50398">
                                                                            </div> -->
                                                                    </div>
                                                                    <div class="row mt-1">

                                                                    </div>
                                                                    <!-- <div class="row text-center mt-1">
                                                                            <div class="col-10 mx-auto">
                                                                                <p class="mb-0 text-sm">Una vez que el pago haya sido identificado, usted recibirá su factura 
                                                                                    dentro de las 48 horas posteriores. Para reportar retrasos, favor de enviar un correo con su 
                                                                                    comprobante de pago adjunto a secretario@hepatologia.org.mx. recuerde que la expedición de 
                                                                                    facturas solo podrá realizarse en el mes correspondiente al pago.</p>
                                                                            </div>
                                                                        </div> -->
                                                                    <div class="button-row d-flex mt-1">
                                                                        <button class="btn bg-gradient-success ms-auto mb-0" type="button" id='btn_next'>Siguiente</button>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal -->
        <footer class="footer pt-12">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            © <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            made with <i class="fa fa-heart"></i> by
                            <a href="" class="font-weight-bold" target="www.grupolahe.com">Creative CMO</a>.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="#" class="nav-link pe-0 text-muted">privacy policies</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- <div class="fixed-bottom space-wa">
            <div class="m-5">
                <a href="#" data-bs-toggle="modal" data-bs-target="#Modal_Caja">
                    <span title="Caja de Comentarios" class="fa fa-comment px-2 py-3-3 icon-wa bg-gradient-dark"></span>
                </a>
            </div>
        </div> -->
        <?php echo $footer; ?>
    </main>
</body>

<?php include 'Comentarios.php';?>

<script>
    $(document).ready(function() {

        let userDataFiscal = JSON.parse(localStorage.getItem("user_data_fiscal"));

        if (userDataFiscal) {


            $("#business_name_iva").val(userDataFiscal.razon_social);
            $("#code_iva").val(userDataFiscal.rfc_social);
            $("#email_receipt_iva").val(userDataFiscal.email_social);
            $("#cp_fac").val(userDataFiscal.cp_social);
            $("#cfdi").val(userDataFiscal.cfdi_social);
            $("#regimen_fiscal").val(userDataFiscal.regimen_fiscal_social);


            // setTimeout(function() {
            //     $("#state option[value=" + userData.state + "]").attr('selected', true)
            // }, 100)



        }

        $("#btn_next").on("click", function(event) {
            event.preventDefault();

            const form_update_fiscal = {
                razon_social: $("#business_name_iva").val(),
                rfc_social: $("#code_iva").val(),
                email_social: $("#email_receipt_iva").val(),
                cp_social: $("#cp_fac").val(),
                cfdi_social: $("#cfdi").val(),
                regimen_fiscal_social: $("#regimen_fiscal").val()
            }

            localStorage.setItem('user_data_fiscal', JSON.stringify(form_update_fiscal));

            var email = $("#email").val();

            var formData = new FormData(document.getElementById("add"));
            for (var value of formData.values()) {
                console.log(value);
            }


            $.ajax({
                url: "/Register/updateFiscalData",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    console.log("Procesando....");


                },
                success: function(respuesta) {
                    console.log(respuesta);

                    if (respuesta == "success") {
                        Swal.fire('Datos Guardados Correctamente', '', 'success');
                        setTimeout(function() {
                            location.href = '/Register/passFinalize?e=' + btoa(email) + '&a='+$("#ano_residente").val();
                        }, 1000)

                    } else {
                        // Swal.fire('Hubo un error al actualizar sus datos contacte a soporte.', '', 'info');
                        Swal.fire('Datos Guardados Correctamente', '', 'success');
                        setTimeout(function() {
                            location.href = '/Register/passFinalize?e=' + btoa(email) + '&a='+$("#ano_residente").val();
                        }, 1000)
                    }

                },
                error: function(respuesta) {
                    console.log(respuesta);
                }

            });
        });

    });
</script>