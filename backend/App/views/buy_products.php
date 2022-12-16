<?php echo $header; ?>
<link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />

<body class="bg-body" id="body-home">

    <main>
        <div class="barra-azul"></div>
        <nav class="navbar navbar-main navbar-expand-lg bg-gradient-info position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <!-- <li class="breadcrumb-item text-sm">
                            <a class="opacity-3 text-dark" href="javascript:;">
                                <svg width="12px" height="12px" class="mb-1" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>shop </title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1716.000000, -439.000000)" fill="#252f40" fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(0.000000, 148.000000)">
                                                    <path d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                                                    <path d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </li> -->
                        <!-- <li class="breadcrumb-item text-sm"><a class="opacity-10 text-dark" href="javascript:;">Inicio</a></li> -->

                    </ol>


                </nav>

                <div id="cont_menu_end">



                    <!-- <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="/Account" class="nav-link text-body font-weight-bold  mx-0  px-0">
                                <i class="fa fa-user me-sm-0"></i>

                                <?php
                                // $apellido = $datos['apellidop'];
                                // $arr1 = str_split($apellido);

                                ?>
                                <span class="d-sm-inline "><?php //echo $datos['nombre'] . " " . $arr1[0] . "."; 
                                                            ?></span>
                            </a>
                        </li>

                        <li class="nav-item d-flex align-items-center">
                            <a href="/Login" class="nav-link text-body font-weight-bold px-0">
                                <i class="fa fa-power-off me-sm-1"></i>
                                <span class="d-sm-inline ">Salir</span>
                            </a>
                        </li>

                    </ul> -->

                </div>

                <input type="hidden" id="categoria" value="<?= $categoria['categoria']; ?>">
                <input type="hidden" name="datos" id="datos" value="<?php echo $datos; ?>">
                <input type="hidden" name="id_pais" id="id_pais" value="<?= $datos['id_pais'] ?>">
                <input type="hidden" id="user_id" name="user_id" value="<?= $datos['user_id'] ?>">

                <!-- <?php var_dump($datos) ?> -->

                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group"></div>
                    </div>



                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="/Register" class="btn btn-sm btn-round mb-0 me-1" style="color: #176DBA; background-color: #fff;"><i class="fas fa-undo"></i> REGRESAR</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="/Account" class="nav-link text-body font-weight-bold mx-lg-4 mx-0  px-0" style="color: #fff;">
                                <i class="fa fa-user me-sm-0"></i>

                                <?php
                                $apellido = $datos['apellidop'];
                                $arr1 = str_split($apellido);

                                ?>
                                <span class="d-sm-inline"><?php echo $datos['nombre'] . " " . $arr1[0] . "."; ?></span>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="/Login" class="nav-link text-body font-weight-bold px-0" style="color: #fff;">
                                <i class="fa fa-power-off me-sm-1"></i>
                                <span class="d-sm-inline">Salir</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


        </nav>

        <div class="container-fluid py-0">
            <div class="card col-lg-12 mt-lg-4 mt-1">
                <div class="card-header pb-0 p-3">
                    <p style="font-size: 14px">(Seleccione a continuación lo que desea pagar y presione el boton de pagar y muestre el codigo de pago en caja)</p>
                </div>
                <div class="card-body px-5 pb-5">


                    <div class="row">
                        <div class="col-md-8">

                            <div id="cont-checks">

                                <?php echo $checks ?>


                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div id="buttons">
                                        <input type="hidden" id="tipo_cambio" value="<?= $tipo_cambio ?>">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p>Productos agregados: <span id="productos_agregados"><?= $total_productos ?></span></p>

                                            </div>

                                            <div class="col-md-6">
                                                <!-- <p>Su pago en dolares es: $ <span id="total"><? //= $total_pago 
                                                                                                    ?></span> USD</p> -->
                                                <p>Su pago en pesos mexicanos es: $ <span id="total_mx">0</span> </p>
                                                <!-- <p>Su pago en USD: $ <span id="total_usd">0</span> </p> -->

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-12">

                                    <div id="buttons">

                                        <div class="row">
                                            <div class="col-md-6">
                                            <select id="forma_pago" name="forma_pago" class="form-control">
                                                    <option value="">Seleccione una Opción de pago</option>
                                                    <!-- <?=$formaPago?> -->
                                                    <option value="Transferencia">Depósito/Transferencia</option>
                                                    <!-- <option value="Paypal">Paypal</option> -->
                                                    <option value="Tarjeta_Credito">Tarjeta Crédito</option>
                                                    <option value="Tarjeta_Debito">Tarjeta Débito</option>
                                                </select>
                                                <input type="text" id="forma_pago_clave" name="forma_pago_clave">
                                                <br>
                                                <select id="tipo_moneda_pago" name="tipo_moneda_pago" class="form-control">
                                                    <option value="">Seleccione tipo de moneda de pago</option>
                                                    <option value="MXN" selected>$ Pesos Mexicanos - MXN</option>
                                                    <!-- <option value="USD">$ Dolares - USD</option> -->
                                                </select>

                                                <form class="form_compra" method="POST" action="">

                                                    <input type="hidden" id="clave_socio" name="clave_socio" value="<?= $datos['clave_socio'] ?>">
                                                    <input type="hidden" id="email_usuario" name="email_usuario" value="<?= $datos['usuario'] ?>">
                                                    <input type="hidden" id="metodo_pago" name="metodo_pago" value="">
                                                    <input type="hidden" id="clave" name="clave" value="<?= $clave ?>">

                                                    <hr>

                                                    <input type='hidden' id='business' name='business' value='pagos@grupolahe.com'>
                                                    <input type='hidden' id='item_name' name='item_name' value='<?= $producto_s ?>'>
                                                    <input type='hidden' id='item_number' name='item_number' value="<?= $clave ?>">
                                                    <input type='hidden' id='amount' name='amount' value='<?= $total ?>'>
                                                    <input type='hidden' id='currency_code' name='currency_code' value="MXN">
                                                    <input type='hidden' id='notify_url' name='notify_url' value=''>
                                                    <input type='hidden' id='return' name='return' value=''>
                                                    <input type="hidden" id="cmd" name="cmd" value="_xclick">
                                                    <input type="hidden" id="order" name="order" value="<?= $clave ?>">
                                                    <input type='hidden' name='upload' value='1' />

                                                    <br>

                                                    <div class="row d-none" id="cont-pay-tarjeta">
                                                        <p style="background-color: rgb(36,71,155); border-radius: 5px; color: #fff;">*Ingresa los datos de tu tarjeta.</p>
                                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                            <label for="">Titular</label>
                                                            <input type="text" name="titular" data-conekta="card[name]" class="form-control mayusculas" placeholder="Nombre del titular" style="text-transform: uppercase;" required>
                                                            <div class="invalid-feedback">
                                                                Ingrese el titular de la tarjeta.
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                            <label for="">Número de tarjeta</label>
                                                            <input pattern="[A-Za-z0-9]{15,19}" type="text" name="tarjeta" id="tarjeta" size="19" maxlength="19" data-conekta="card[number]" class="form-control" placeholder="Número de tarjeta" required>
                                                            <div class="invalid-feedback">
                                                                Ingrese un número de tarjeta válido.
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                                            <label for="">Mes de vencimiento</label>
                                                            <input pattern="[A-Za-z0-9]{1,2}" type="text" name="mesvencimiento" size="2" maxlength="2" data-conekta="card[exp_month]" class="form-control" placeholder="MM" required>
                                                            <div class="invalid-feedback">
                                                                Ingrese un mes de vencimiento válido.
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                                            <label for="">Año de vencimiento</label>
                                                            <input pattern="[A-Za-z0-9]{4}" type="text" name="aniovencimiento" size="4" maxlength="4" data-conekta="card[exp_year]" class="form-control" placeholder="AAAA" required>
                                                            <div class="invalid-feedback">
                                                                Ingrese un año de vencimiento válido.
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                                            <label for="">CVC</label>
                                                            <input pattern="[A-Za-z0-9]{2,3}" type="password" name="codigoseguridad" size="3" maxlength="3" data-conekta="card[cvc]" class="form-control" placeholder="Código de seguridad" required>
                                                            <div class="invalid-feedback">
                                                                Ingrese un código de seguridad válido.
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                            <label for="">&nbsp;</label>
                                                            <div class="alert alert-danger d-none" role="alert"></div>
                                                        </div>
                                                        <input name="conektaTokenId" id="conektaTokenId" type="hidden">

                                                    </div>

                                                </form>


                                                <!-- <form id="form_compra_paypal" method="POST">
                                                    <input type="text" id="tipo_pago_paypal" name="tipo_pago_paypal">
                                                    <input type='text' id='clave_paypal' name='clave_paypal' value="<?= $clave ?>">
                                                </form> -->

                                            </div>

                                            <div class="col-md-6" style="display: flex; justify-content: end; align-items:end;">



                                                <button class="btn bg-gradient-info" id="btn_pago" <?= $btn_block ?>>Proceder al pago</button>
                                                <button class="btn bg-gradient-info" id="btn_pruebas">Prueba</button>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>

                        <form role="form" class="text-start" id="login" action="/Login/crearSessionFinalize" method="POST" class="form-horizontal" style="display: none;">
                            <input type="email" name="usuario" id="usuario" class="form-control" aria-label="Email" value="<?= $datos['usuario'] ?>">
                            <button type="submit" id="btn_crearSesion"></button>
                        </form>

                        <div class="col-md-4">
                            <div id="cont-image">
                                <img src="<?= $src_qr ?>" id="img_qr" style="width: auto; display: block; margin: 0 auto;<?= $ocultar ?>" alt="">


                            </div>
                            <div style="display: flex; justify-content: center;">
                                <?= $btn_imp ?>
                            </div>
                        </div>

                    </div>
                    <br>

                </div>
            </div>
        </div>
    </main>

    <!-- ABRE MODAL -->
    <div class="modal fade" id="Modal_Caja" role="dialog" aria-labelledby="" aria-hidden="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Subir Comprobante
                    </h5>
                </div>
                <center>
                    <div class="modal-body">
                        <p style="font-size: 16px">¡Si cuentas con tu comprobante súbelo aquí!</p>
                        <hr>
                        <form method="POST" enctype="multipart/form-data" id="form_datos_caja">
                            <div class="row">
                                <center>
                                    <div class="col-8">
                                        <label class="control-label col-12" for="comentario">Comprobante de Anualidad 2022<span class="required">*</span></label>
                                        <label for="">Sube tu archivo</label><input type="file" accept="image/*,.pdf" class="form-control" id="file-input" name="file-input" style="width: auto; margin: 0 auto;" required>
                                        <input type="hidden" class="form-control" id="sitio" name="sitio">
                                        <input type="hidden" id="clave_socio" name="clave_socio" value="<?= $datos['clave_socio'] ?>">
                                        <input type="hidden" id="email_usuario" name="email_usuario" value="<?= $datos['usuario'] ?>">
                                        <input type="hidden" id="metodo_pago" name="metodo_pago" value="<?= $datos['metodo_pago'] ?>">
                                        <input type="hidden" id="clave" name="clave" value="<?= $clave ?>">
                                    </div>
                                </center>
                                <div class="modal-footer">
                                    <button type="submit" class="btn bg-gradient-success" id="btn_upload" name="btn_upload">Aceptar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </center>
            </div>
        </div>
    </div>
    <!-- CIERRA MODAL -->

    <!-- ABRE MODAL -->
    <div class="modal fade" id="modal_archivo_residente" role="dialog" aria-labelledby="" aria-hidden="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_archivo_residenteLabel">
                        Subir Comprobante
                    </h5>
                </div>
                <center>
                    <div class="modal-body">

                        <form method="POST" enctype="multipart/form-data" id="form_archivo_residente">
                            <div class="row">
                                <center>
                                    <div class="col-8 mb-3">
                                        <label class="control-label col-12" for="comentario">Comprobante<span class="required">*</span></label>
                                        <input type="file" accept="image/*,.pdf" class="form-control" id="archivo_residente" name="archivo_residente" style="width: auto; margin: 0 auto;" required>
                                        <input type="hidden" class="form-control" id="_user_id" name="_user_id" value="<?php echo $datos['user_id'] ?>">
                                        <input type="hidden" class="form-control" id="ano_residencia" name="ano_residencia" value="<?php echo $array_user['ano_residencia']; ?>">

                                    </div>
                                </center>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn bg-gradient-success" id="btn_upload" name="btn_upload">Aceptar</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </center>
            </div>
        </div>
    </div>
    <!-- CIERRA MODAL -->



    <!-- Modal -->
    <div class="modal fade" id="modalProcesarPago" tabindex="-1" role="dialog" aria-labelledby="modalProcesarPagoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProcesarPagoLabel">Procesando Pago.....</h5>

                </div>
                <div class="modal-body d-flex justify-content-center p-5">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
    <script>
        $(document).ready(function() {

            //pruebas
            //Conekta.setPublicKey('key_Mi5yEKHBa4PgwaqY5w2mATs');
            //produccion
            Conekta.setPublicKey('key_YavyHapvGZCmo5dw1gdbwZT');

            var conektaSuccessResponseHandler = function(token) {
                var $form = $(".form_compra");
                console.log(token);
                //Inserta el token_id en la forma para que se envíe al servidor
                $('#conektaTokenId').val(token.id);
                procesar($form, productos);
                //$form.get(0).click(); //Hace submit
            };
            var conektaErrorResponseHandler = function(response) {
                var $form = $(".form_compra");
                console.log(response.message_to_purchaser);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al intentar procesar el pago!',
                    text: response.message_to_purchaser,
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    allowOutsideClick: false,
                    buttons: false,
                    timer: 4000
                });

                $.ajax({
                    url: "/Register/removePendientesPago",
                    type: "POST",
                    data: {
                        clave : $("#clave").val()
                    },
                    cache: false,
                    beforeSend: function() {
                        console.log("Procesando eliminacion....");

                    },
                    success: function(respuesta) {

                        console.log(respuesta);

                    },
                    error: function(respuesta) {
                        console.log(respuesta);
                    }

                });
                /* $form.find(".card-errors").text(response.message_to_purchaser).removeClass('d-none');
                setTimeout($(".card-errors").addClass('d-none'), 2000) */
                // $form.find("button").prop("disabled", false);
            };

            function procesar(formulario, productos) {
                $("#btn_pago").prop("disabled", true);
                console.log(formulario.get(0));
                console.log(productos);
                var formData = new FormData(formulario.get(0));
                formData.append('productos', JSON.stringify(productos))
                formData.append('tipo_moneda_pago', $("#tipo_moneda_pago").val());
                $.ajax({
                    type: 'POST',
                    url: '/Register/procesarPago',
                    dataType: 'json',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        // setting a timeout
                        $('#modalProcesarPago').modal('show');
                        console.log("Procesando Pago...")
                    },
                    success: function(data) {
                        // console.log("aqui esd la magia del pagos");
                        console.log(data);
                        if (data.estatus_resp == 'success') {
                            Swal.fire({
                                icon: data.estatus_resp,
                                title: data.titulo_resp,
                                text: data.mensaje_resp,
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                                allowOutsideClick: false,
                                buttons: false,
                                timer: 2000
                            });
                            $("#btn_pago").prop("disabled", false);

                            window.open("/Register/ticketImpCompraU/" + $("#clave").val() + "/" + btoa($("#email_usuario").val()));

                            setTimeout(function() {
                                // window.location.href = "/Login";
                                $("#btn_crearSesion").click();
                            }, 2000);
                        } else {
                            Swal.fire({
                                icon: data.estatus_resp,
                                title: data.titulo_resp,
                                text: data.mensaje_resp,
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                                allowOutsideClick: false,
                                buttons: false,
                                timer: 2000
                            });
                        }


                        // recargar();
                    },
                    error: function(data) {
                        console.log("Error");
                        Swal.fire({
                            icon: data.estatus_resp,
                            title: data.titulo_resp,
                            text: data.mensaje_resp,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                            allowOutsideClick: false,
                            buttons: false,
                            timer: 4000
                        });
                        $("#btn_pago").prop("disabled", false);
                    },
                    complete: function() {
                        $('#modalProcesarPago').modal('hide');
                    }
                });
            }


            $("#form_archivo_residente").on("submit", function(event) {
                event.preventDefault();
                var formData = new FormData(document.getElementById("form_archivo_residente"));
                $.ajax({
                    url: "/Register/uploadComprobanteResidente",
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
                            Swal.fire({
                                title: '¡Correcto!',
                                text: "Una vez validado tu comprobante, podras comprar desde la plataforma",
                                icon: 'info',
                                showCancelButton: true,
                                showCancelButton: true,
                                allowOutsideClick: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar',
                                cancelButtonText: 'Cancelar',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // window.location.href = '/Login/';
                                    window.location.reload();
                                }
                            })
                        } else {
                            Swal.fire("¡Hubo un error, inténtalo de nuevo!", "", "warning").
                            then((value) => {
                                // window.location.reload();
                            });
                        }
                    },
                    error: function(respuesta) {
                        console.log(respuesta);
                        // alert('Error');
                        Swal.fire("¡Hubo un error, inténtalo de nuevo!", "", "warning").
                        then((value) => {
                            // window.location.reload();
                        });
                    }
                });
            });



            $('#forma_pago').on('change', function(e) {
                var tipo = $(this).val();
                $("#metodo_pago").val(tipo);
                if (tipo == 'Paypal') {
                    // $(".form_compra").attr('action','/OrdenPago/PagarPaypal');
                    $(".form_compra").attr('action', 'https://www.paypal.com/es/cgi-bin/webscr');
                    // $(".btn_comprar").val('Paypal');
                    // $("#tipo_pago_paypal").val('Paypal');
                    $("#cont-pay-tarjeta").addClass('d-none');
                } else if (tipo == 'Transferencia') {
                    $(".form_compra").attr('action', '/Register/ticketAll');
                    // $("#tipo_pago_paypal").val('');
                    $("#cont-pay-tarjeta").addClass('d-none');
                    $("#forma_pago_clave").val("03"); 
                    // $(".btn_comprar").val('Efectivo');
                    // $(".tipo_pago").val('Efectivo');

                } else if (tipo == 'Tarjeta_Credito' || tipo == 'Tarjeta_Debito') {
                    $(".form_compra").attr('action', '/Register/procesarPago');
                    $("#cont-pay-tarjeta").removeClass('d-none');
                    if(tipo == 'Tarjeta_Credito'){
                        $("#forma_pago_clave").val("04");
                    }else if(tipo == 'Tarjeta_Debito'){
                        $("#forma_pago_clave").val("28");
                    }
                }else{
                    $("#forma_pago_clave").val("");
                }

            });


            // var precios = <?php echo json_encode($array_precios); ?>;
            // var productos = <?php echo json_encode($array_productos); ?>;


            // console.log(precios);
            // console.log(productos);

            var precios = [];
            var productos = [];
            var total = 0;




            $(".checks_product").on("change", function() {
                var id_product = $(this).val();
                var precio = $(this).attr('data-precio');
                var precio_socio = $(this).attr('data-precio-socio');
                var precio_usd = $(this).attr('data-precio-usd');
                var precio_socio_usd = $(this).attr('data-precio-socio-usd');
                var cantidad = $("#numero_articulos" + id_product).val();
                var nombre_producto = $(this).attr('data-nombre-producto');



                if (this.checked) {

                    precios.push({
                        'id_product': id_product,
                        'precio': precio,
                        'precio_usd': precio_usd,
                        'cantidad': cantidad
                    });


                    productos.push({
                        'id_product': id_product,
                        'precio': precio,
                        'precio_usd': precio_usd,
                        'cantidad': cantidad,
                        'nombre_producto': nombre_producto
                    });

                    sumarPrecios(precios);
                    sumarProductos(productos);


                } else if (!this.checked) {



                    for (var i = 0; i < precios.length; i++) {

                        if (precios[i].id_product === id_product) {
                            // console.log("remover");
                            precios.splice(i, 1);

                            productos.splice(i, 1);
                            sumarPrecios(precios);
                            sumarProductos(productos);
                        } else if (precios[i].id_product === id_product && precios[i].cantidad === cantidad) {
                            precios.splice(i, 1);

                            productos.splice(i, 1);
                            sumarPrecios(precios);
                            sumarProductos(productos);

                        }
                    }

                    // $.ajax({
                    //     url: "/Home/removePendientesPago",
                    //     type: "POST",
                    //     data: {
                    //         id_product,cantidad
                    //     },
                    //     cache: false,
                    //     beforeSend: function() {
                    //         console.log("Procesando....");

                    //     },
                    //     success: function(respuesta) {

                    //         console.log(respuesta);
                    //         if(respuesta == "success"){
                    //             location.reload();
                    //         }


                    //     },
                    //     error: function(respuesta) {
                    //         console.log(respuesta);
                    //     }

                    // });
                }
                // console.log(productos);
                // sumarPrecios(precios);
                // sumarProductos(productos);

            });


            $(".select_numero_articulos").on("change", function() {
                var id_producto = $(this).attr('data-id-producto');
                var cantidad = $(this).val();
                var precio = $(this).attr('data-precio');
                var nombre_producto = $(this).attr('data-nombre-producto');

                if ($("#check_curso_" + id_producto).is(':checked')) {

                    for (var i = 0; i < precios.length; i++) {

                        if (precios[i].id_product === id_producto && precios[i].cantidad != cantidad) {
                            console.log("remover");
                            precios.splice(i, 1, {
                                'id_product': id_producto,
                                'precio': precio,
                                'cantidad': cantidad
                            });

                            productos.splice(i, 1, {
                                'id_product': id_producto,
                                'precio': precio,
                                'cantidad': cantidad,
                                'nombre_producto': nombre_producto
                            });

                            // precios.push({'id_product':id_product,'precio':precio,'cantidad':cantidad});
                        }

                    }
                    console.log(precios.length);

                    console.log(productos);

                    sumarPrecios(precios);

                }

            });

            function sumarPrecios(precios) {
                console.log(precios);

                // var sumaPrecios = <?= $total_pago ?>;
                // var sumaArticulos = <?= $total_productos ?>;

                var sumaPrecios = 0;
                var sumaPreciosUsd = 0;
                var sumaArticulos = 0;
                var sumaArticulosUsd = 0;

                precios.forEach(function(precio, index) {

                    console.log("precio " + index + " | id_product: " + precio.id_product + " precio: " + parseInt(precio.precio) + " cantidad: " + parseInt(precio.cantidad))

                    sumaPrecios += parseInt(precio.precio * precio.cantidad);
                    sumaArticulos += parseInt(precio.cantidad);

                    sumaPreciosUsd += parseInt(precio.precio_usd * precio.cantidad);


                });



                console.log("Suma precios " + sumaPrecios);
                console.log("--------------");
                console.log("Suma precios usd " + sumaPreciosUsd);

                $("#total").html(sumaPrecios);

                //depende del tipo de pago
                var tipo_pago = $("#tipo_moneda_pago").val();
                if (tipo_pago == 'MXN') {
                    $("#amount").val(sumaPrecios);
                } else if (tipo_pago == 'USD') {
                    $("#amount").val(sumaPreciosUsd);
                } else {
                    $("#amount").val(sumaPrecios);
                }

                // $("#total_mx").html(($("#tipo_cambio").val() * sumaPrecios).toFixed(2));
                // $("#total_mx").html((sumaPrecios).toFixed(2));
                $("#total_mx").html((sumaPrecios).toLocaleString('en'));

                // const localeString = numero.toLocaleString('en');
                $("#total_usd").html((sumaPreciosUsd).toLocaleString('en'));

                console.log("Suma Articulos " + sumaArticulos);

                $("#productos_agregados").html(sumaArticulos);

            }

            function sumarPreciosOnchangeTipo(precios) {
                console.log(precios);

                // var sumaPrecios = <?= $total_pago ?>;
                // var sumaArticulos = <?= $total_productos ?>;

                var sumaPrecios = 0;
                var sumaPreciosUsd = 0;
                var sumaArticulos = 0;
                var sumaArticulosUsd = 0;

                precios.forEach(function(precio, index) {

                    console.log("precio " + index + " | id_product: " + precio.id_product + " precio: " + parseInt(precio.precio) + " cantidad: " + parseInt(precio.cantidad))

                    sumaPrecios += parseInt(precio.precio * precio.cantidad);
                    sumaArticulos += parseInt(precio.cantidad);

                    sumaPreciosUsd += parseInt(precio.precio_usd * precio.cantidad);


                });


                var tipo_pago = $("#tipo_moneda_pago").val();
                if (tipo_pago == 'MXN') {
                    $("#amount").val(sumaPrecios);
                } else if (tipo_pago == 'USD') {
                    $("#amount").val(sumaPreciosUsd);
                }

            }

            function sumarProductos(productos) {
                console.log(productos);
                var nombreProductos = '';

                productos.forEach(function(producto, index) {

                    console.log("precio " + index + " | id_product: " + producto.id_product + " precio: " + parseInt(producto.precio) + " cantidad: " + parseInt(producto.cantidad) + " producto: " + producto.nombre_producto)

                    nombreProductos += producto.nombre_producto + ',';
                });

                console.log(nombreProductos);
                $("#item_name").val(nombreProductos);


            }

            $("#tipo_moneda_pago").on("change", function() {
                var tipo_moneda_pago = $(this).val();
                $("#currency_code").val(tipo_moneda_pago);
                sumarPreciosOnchangeTipo(precios);
            });


            $("#btn_pruebas").on("click",function(){
                var tarjeta = $('input[name="tarjeta"]').val();
                var t = tarjeta.slice(-4)

                alert(t);
            })


            $("#btn_pago").on("click", function(event) {
                event.preventDefault();
                // var metodo_pago = $("#metodo_pago").val();
                var clave = $("#clave").val();
                var usuario = $("#email_usuario").val();
                var metodo_pago = $("#metodo_pago").val();
                var metodo_pago_clave = $("#forma_pago_clave").val();
                var tipo_moneda = $("#tipo_moneda_pago").val();
                var t = ''; 

                //CAMBIAR POR LA RUTA DE PRODUCCION
                // var urlRegresoPaypal = 'https://registro.lasra-mexico.org/OrdenPagoRegister/PagoExistoso/?productos=' + JSON.stringify(precios) + '&u=' + $("#user_id").val();

                // $("#return").val(urlRegresoPaypal);

                // console.log("precios ------");
                // console.log(precios);


                if (precios.length <= 0) {

                    Swal.fire("¡Debes seleccionar al menos un producto!", "", "warning")


                } else if (precios.length >= 2 && $("#forma_pago").val() == '' && $("#clave_socio").val() != '') {
                    Swal.fire("¡Debes seleccionar un metodo de pago!", "", "warning")
                } else if ($("#forma_pago").val() == '' && $("#clave_socio").val() == '') {
                    Swal.fire("¡Debes seleccionar un metodo de pago!", "", "warning")
                } else if ($("#tipo_moneda_pago").val() == '') {
                    Swal.fire("¡Debes seleccionar el tipo de Cambio a pagar!", "", "warning")
                } else if (($("#forma_pago").val() === 'Tarjeta_Credito' || $("#forma_pago").val() === 'Tarjeta_Debito') && ($('input[name="titular"]').val() === '' || $('input[name="tarjeta"]').val() === '' || $('input[name="mesvencimiento"]').val() === '' || $('input[name="aniovencimiento"]').val() === '' || $('input[name="codigoseguridad"]').val() === '')) {
                    Swal.fire("¡Debes de llenar todos los campos, para el pago con tarjeta!", "", "warning")

                } else {
                    var plantilla_productos = '';

                    plantilla_productos += `<ul>`;


                    $.each(productos, function(key, value) {
                        console.log("funcioina");
                        console.log(value);
                        plantilla_productos += `<li style="text-align: justify; font-size:14px;">
                                                    ${value.nombre_producto} Cant. ${value.cantidad}
                                                </li>`;
                    });

                    plantilla_productos += `</ul>`;
                    if (tipo_moneda == "USD") {
                        plantilla_productos += `<p><strong>Total en dolares: $ ${$("#total_usd").text()} USD </strong></p>`;
                    } else {
                        plantilla_productos += `<p><strong>Total en pesos mexicanos: $ ${$("#total_mx").text()} MXN</strong></p>`;
                    }

                    if (metodo_pago == 'Paypal') {
                        plantilla_productos += `<p>Su pago se realizará con PAYPAL</p>`;
                        plantilla_productos += `<p style="background-color: yellow;"><strong>Una vez finalizado su pago en PAYPAL, dar click en el botón REGRESAR AL SITIO WEB DEL COMERCIO para poder validar su pago</strong></p>`;
                        plantilla_productos += `<img src ="/img/btn_fin_paypal.png"/>`;
                    } else if (metodo_pago == 'Tarjeta_Credito' || metodo_pago == 'Tarjeta_Debito') {
                        plantilla_productos += `<p>Su pago se realizará con Tarjeta</p>`;
                        //numeros de tarjeta
                        var tarjeta = ($('input[name="tarjeta"]').val()).trim();
                        var t = tarjeta.slice(-4);
                    }

                    // plantilla_productos += `<p>Confirme su selección y de clic en procesar compra y espere su turno en línea de cajas.</p>`;


                    Swal.fire({
                        title: 'Usted selecciono los siguientes productos',
                        text: '',
                        html: plantilla_productos,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Procesar Compra'
                    }).then((result) => {
                        if (result.isConfirmed) {


                            console.log($("#total_mx").text());

                            var enviar_email = 1;
                            // $(".form_compra").submit();
                            $.ajax({
                                url: "/Register/generaterQr",
                                type: "POST",
                                data: {
                                    'array': JSON.stringify(precios),
                                    clave,
                                    usuario,
                                    metodo_pago,
                                    enviar_email,
                                    tipo_moneda,                                    
                                    metodo_pago_clave,
                                    no_tarjeta: t
                                },
                                cache: false,
                                dataType: "json",
                                // contentType: false,
                                // processData: false,
                                beforeSend: function() {
                                    console.log("Procesando....");

                                },
                                success: function(respuesta) {

                                    console.log(respuesta);

                                    if (respuesta.status == 'success') {

                                        if (metodo_pago == 'Tarjeta_Credito' || metodo_pago == 'Tarjeta_Debito') {
                                            // $(".form_compra").submit();

                                            Conekta.Token.create($(".form_compra"), conektaSuccessResponseHandler, conektaErrorResponseHandler);
                                            return false;
                                        } else {
                                            $(".form_compra").submit();
                                            Swal.fire({
                                                icon: 'success',
                                                title: '¡Se generó su preregistro, correctamente!',
                                                text: '',
                                                closeOnClickOutside: false,
                                                closeOnEsc: false,
                                                allowOutsideClick: false,
                                                buttons: false,
                                                timer: 2000
                                            });
                                            // localStorage.clear();
                                            setTimeout(function() {

                                                if (metodo_pago == 'Transferencia') {
                                                    localStorage.clear();
                                                    // location.href = '/Home';
                                                    $("#btn_crearSesion").click();
                                                }

                                            }, 2000);
                                        }


                                    }

                                },
                                error: function(respuesta) {
                                    console.log(respuesta);
                                }

                            });



                        }
                    })
                }
            });


        });
    </script>

    <script>
        $(document).ready(function() {
            var currentUrl = window.location.pathname;
            $("#sitio").val(currentUrl);

            $("#form_datos_caja").on("submit", function(event) {
                event.preventDefault();
                var formData = new FormData(document.getElementById("form_datos_caja"));
                $.ajax({
                    url: "/Register/saveComprobante",
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
                            Swal.fire("¡Recibimos tu archivo! Una vez validado tu comprobante, podras comprar desde la plataforma", "", "success").
                            then((value) => {
                                // window.location.href = '/Login/';
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
    </script>


</body>