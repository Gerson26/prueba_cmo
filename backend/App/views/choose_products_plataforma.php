<?php echo $header; ?>
<link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />

<body class="bg-body" id="body-home">

    <main>
        <div class="barra-azul"></div>
        <nav class="navbar text-white navbar-main navbar-expand-lg bg-gradient-info position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb text-white">
                    <ol class="breadcrumb text-white bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm text-white">
                            <a class="opacity-3 text-white" href="javascript:;">
                                <svg width="12px" height="12px" class="mb-1 text-white" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
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
                        </li>
                        <li class="breadcrumb-item text-sm"><a class="opacity-10" href="/Home">Inicio</a></li>
                    </ol>
                </nav>

                <input type="hidden" name="datos" id="datos" value="<?php echo $datos; ?>">
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group"></div>
                    </div>

                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="/Account" class="nav-link text-white font-weight-bold mx-lg-4 mx-0  px-0">
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
                            <a href="/Login/cerrarSession" class="nav-link text-white font-weight-bold px-0">
                                <i class="fa fa-power-off me-sm-1"></i>
                                <span class="d-sm-inline">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>


            </div>
        </nav>

        <div class="container-fluid py-0">
            <div class="card col-lg-12 mt-lg-4 mt-1">
                <div class="card-header pb-0 p-3">
                    <p style="font-size: 14px">Compro el paquete <b><?= $nombre_combo ?></b> (Seleccione a continuación los <b><span id="numero_talleres"><?= $numero_talleres ?></span></b> Talleres para crear su paquete)</p>

                    <input type="hidden" name="id_pais" id="id_pais" value="<?= $datos['id_pais'] ?>">
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
                                                <p>Productos agregados: <span id="productos_agregados"></span></p>

                                            </div>

                                            <div class="col-md-6">

                                                <p style="display: none;">Su pago en pesos mexicanos es: $ <span id="total_mx">0</span> </p>
                                                <p style="display: none;">Su pago en USD: $ <span id="total_usd">0</span> </p>

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
                                                <input type="hidden" id="clave" name="clave" value="<?= $clave ?>">
                                                <input type="hidden" id="email_usuario" name="email_usuario" value="<?= $datos['usuario'] ?>">
                                                <!-- <select id="forma_pago" name="forma_pago" class="form-control">
                                                    <option value="">Seleccione una Opción de pago</option>
                                                    <option value="Transferencia">Depósito/Transferencia</option>
                                                    <option value="Paypal">Paypal</option>
                                                </select>

                                                <br>
                                                <select id="tipo_moneda_pago" name="tipo_moneda_pago" class="form-control">
                                                    <option value="">Seleccione tipo de moneda de pago</option>
                                                    <option value="MXN">$ Pesos Mexicanos - MXN</option>
                                                    <option value="USD">$ Dolares - USD</option>
                                                    
                                                </select> -->

                                                <!-- <form class="form_compra" method="POST" action="">

                                                    <input type="hidden" id="clave_socio" name="clave_socio" value="<?= $datos['clave_socio'] ?>">
                                                    <input type="hidden" id="email_usuario" name="email_usuario" value="<?= $datos['usuario'] ?>">
                                                    <input type="hidden" id="metodo_pago" name="metodo_pago" value="">
                                                    <input type="hidden" id="clave" name="clave" value="<?= $clave ?>">

                                                    <hr>

                                                    <input type='hidden' id='business' name='business' value='pagos@grupolahe.com'>
                                                    <input type='hidden' id='item_name' name='item_name' value='<?= $producto_s ?>'>
                                                    <input type='hidden' id='item_number' name='item_number' value="<?= $clave ?>">
                                                    <input type='hidden' id='amount' name='amount' value='<?= $total ?>'>
                                                    <input type='hidden' id='currency_code' name='currency_code' value=''>
                                                    <input type='hidden' id='notify_url' name='notify_url' value=''>
                                                    <input type='hidden' id='return' name='return' value=''>
                                                    <input type="hidden" id="cmd" name="cmd" value="_xclick">
                                                    <input type="hidden" id="order" name="order" value="<?= $clave ?>">


                                                </form>

                                                <form id="form_compra_paypal" method="POST">
                                                    <input type="hidden" id="tipo_pago_paypal" name="tipo_pago_paypal">
                                                    <input type='hidden' id='clave_paypal' name='clave_paypal' value="<?= $clave ?>">
                                                </form> -->

                                            </div>

                                            <div class="col-md-6" style="display: flex; justify-content: end;">



                                                <button class="btn bg-gradient-info" id="btn_pago" <?= $btn_block ?>>Elegir Talleres</button>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>

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



                    <br>
                    <div class="row">
                        <div class="col-md-8">

                            <div id="buttons">





                            </div>
                        </div>
                    </div>


                    <br>



                </div>
            </div>
        </div>
        <div class="fixed-bottom space-wa">
                <div class="m-4">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#Modal_Caja">
                        <span title="Caja de Comentarios" class="fa fa-comment px-2 py-3-3 icon-wa bg-gradient-dark"></span>
                    </a>
                </div>

                <div class="m-4">
                    <a href="https://wa.link/0k8uv4" target="_blank">
                        <span class="fa fa-whatsapp px-1 py-3-3 icon-wa bg-gradient-success"></span>
                    </a>
                </div>
            </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>
        $(document).ready(function() {

            if ($("#id_pais").val() != 156) {
                $("#cont_check2").addClass('d-none');
                $("#cont_check23").addClass('d-none');
                $("#cont_check34").addClass('d-none');
                $("#cont_check35").addClass('d-none');
            }

            

            if ($('#categoria').val() == 'Socio') {
                Swal.fire("¡Te registraste como socio!", "Debemos validar tu información para que puedas comprar", "warning")

                setTimeout(function() {
                    window.location.replace('/Login')
                }, 3000);
            }

            $('#forma_pago').on('change', function(e) {
                var tipo = $(this).val();
                $("#metodo_pago").val(tipo);
                // alert(tipo);
                if (tipo == 'Paypal') {
                    // $(".form_compra").attr('action','/OrdenPago/PagarPaypal');
                    $(".form_compra").attr('action', 'https://www.paypal.com/es/cgi-bin/webscr');
                    // $(".btn_comprar").val('Paypal');
                    $("#tipo_pago_paypal").val('Paypal');
                } else if (tipo == 'Transferencia') {
                    $(".form_compra").attr('action', '/Register/ticketAll');
                    $("#tipo_pago_paypal").val('');
                    // $(".btn_comprar").val('Efectivo');
                    // $(".tipo_pago").val('Efectivo');

                }

            });


            var precios = [];
            var productos = [];
            var total = 0;

            // if ($("#clave_socio").val() != '') {
            //     precios.push({
            //         'id_product': 1,
            //         'precio': 0,
            //         'cantidad': 1
            //     });
            //     // sumarPrecios(precios);

            //     productos.push({
            //         'id_product': 1,
            //         'precio': 0,
            //         'cantidad': 1,
            //         'nombre_producto': 'Congreso'
            //     });

            //     // sumarProductos(productos);

            //     $("#check_curso_1").prop('checked', true);
            //     $("#check_curso_1").prop('disabled', true);
            // }



            $(".checks_product").on("change", function() {
                var id_product = $(this).val();
                var precio = $(this).attr('data-precio');
                var precio_socio = $(this).attr('data-precio-socio');
                var precio_usd = $(this).attr('data-precio-usd');
                var precio_socio_usd = $(this).attr('data-precio-socio-usd');
                var cantidad = $("#numero_articulos" + id_product).val();
                var nombre_producto = $(this).attr('data-nombre-producto');



                if (this.checked) {

                    //validacion para comprar con costo de socio y anualidad
                    if (nombre_producto == 'V Congreso LASRA México (socio)') {

                        $(".checks_product").each(function(index) {
                            $("#cont_precio_" + $(this).val()).html($(this).data('precio-socio') + ' - MXN');
                        });


                        if (!$("#check_curso_2").is(":checked")) {

                            Swal.fire('Aviso', 'Para obtener este costo se debe de pagar la anualidad también', 'info');
                            $("#check_curso_2").prop('checked', true);
                            $("#check_curso_2").attr('disabled', 'disabled');

                            precios.push({
                                'id_product': '2',
                                'precio': '2500', //cambiar manualmente
                                'precio_usd': '130',
                                'cantidad': '1'
                            });

                            productos.push({
                                'id_product': '2',
                                'precio': '2500', //cambiar manualmente
                                'cantidad': '1',
                                'precio_usd': '130',
                                'nombre_producto': 'ANUALIDAD (2022)'
                            });


                        } else {
                            $("#check_curso_2").attr('disabled', 'disabled');
                        }

                    }

                    if (nombre_producto == 'ANUALIDAD (2022) - (Residente)') {

                        $(".checks_product").each(function(index) {
                            $("#cont_precio_" + $(this).val()).html($(this).data('precio-socio') + ' - MXN');
                        });


                        if (!$("#check_curso_34").is(":checked")) {

                            // Swal.fire('Aviso', 'Para obtener este costo se debe de pagar la anualidad (Residente) también', 'info');
                            $("#check_curso_34").prop('checked', true);
                            $("#check_curso_34").attr('disabled', 'disabled');

                            precios.push({
                                'id_product': '34',
                                'precio': '1500', //cambiar manualmente
                                'precio_usd': '77',
                                'cantidad': '1'
                            });

                            productos.push({
                                'id_product': '34',
                                'precio': '1500', //cambiar manualmente
                                'precio_usd': '77',
                                'cantidad': '1',
                                'nombre_producto': 'V Congreso LASRA México (Residente)'
                            });


                        } else {
                            $("#check_curso_35").attr('disabled', 'disabled');
                        }
                    }


                    //precio socio si tiene anaulidad
                    if (nombre_producto == 'ANUALIDAD (2022)') {

                        $(".checks_product").each(function(index) {
                            $("#cont_precio_" + $(this).val()).html($(this).data('precio-socio') + ' - MXN ');

                        });
                    }

                    //precio socio si tiene anaulidad residente
                    if (nombre_producto == 'ANUALIDAD (2022) - (Residente)') {

                        $(".checks_product").each(function(index) {
                            $("#cont_precio_" + $(this).val()).html($(this).data('precio-socio') + ' - MXN ');

                        });
                    }

                    //validaciones para los talleres simultaneos 

                    if (nombre_producto == 'INDISPENSABLE BLOQUEOS BASICOS MIEMBRO SUPERIOR') {
                        $("#check_curso_27").attr('disabled', 'disabled');

                    }

                    if (nombre_producto == 'PERFUSIONES INTRAVENOSAS PARA SEDACIÓN DE LO MANUAL A TCI') {
                        $("#check_curso_24").attr('disabled', 'disabled');
                    }

                    if (nombre_producto == 'INDISPENSABLE BLOQUEOS BASICOS MIEMBRO INFERIOR') {
                        $("#check_curso_29").attr('disabled', 'disabled');
                    }

                    if (nombre_producto == 'ULTRASONIDO EN BLOQUEOS PARA DOLOR CRONICO') {
                        $("#check_curso_25").attr('disabled', 'disabled');
                    }

                    if (nombre_producto == 'BLOQUEOS AVANZADOS: NEUROMONITOREO, MIEMBRO SUPERIOR Y MIEMBO INFERIOR') {
                        $("#check_curso_43").attr('disabled', 'disabled');
                    }

                    if (nombre_producto == 'RECAT/ECO CRITICA') {
                        $("#check_curso_32").attr('disabled', 'disabled');
                    }

                    if (nombre_producto == 'ACCESOS VASCULARES PRAVE') {
                        $("#check_curso_30").attr('disabled', 'disabled');
                        $("#check_curso_28").attr('disabled', 'disabled');
                    }

                    if (nombre_producto == 'BLOQUEOS AVANZADOS :TORAX Y ABDOMEN') {
                        $("#check_curso_31").attr('disabled', 'disabled');
                        $("#check_curso_28").attr('disabled', 'disabled');
                    }

                    if (nombre_producto == 'SIMULADORES ESCANEA Y PRACTICA CON MODELO EN SIMULACION') {
                        $("#check_curso_31").attr('disabled', 'disabled');
                        $("#check_curso_30").attr('disabled', 'disabled');
                    }


                    //fin de validaciones para talleres simultaneos


                    //validar si esta checado la anualidad
                    // if ($("#check_curso_2").is(":checked") || $("#check_curso_35").is(":checked")) {

                    //     precios.push({
                    //         'id_product': id_product,
                    //         'precio': precio_socio,
                    //         'precio_usd': precio_socio_usd,
                    //         'cantidad': cantidad
                    //     });


                    //     productos.push({
                    //         'id_product': id_product,
                    //         'precio': precio_socio,
                    //         'precio_usd': precio_socio_usd,
                    //         'cantidad': cantidad,
                    //         'nombre_producto': nombre_producto
                    //     });


                    // } else {

                    precios.push({
                        'id_product': id_product,
                        'precio': '0',
                        'precio_usd': '0',
                        'cantidad': cantidad
                    });


                    productos.push({
                        'id_product': id_product,
                        'precio': '0',
                        'precio_usd': '0',
                        'cantidad': cantidad,
                        'nombre_producto': nombre_producto
                    });
                    // }
                    sumarPrecios(precios);
                    sumarProductos(productos);


                } else if (!this.checked) {

                    //Si se selecciona el prodicto 2

                    if (nombre_producto == 'V Congreso LASRA México (socio)' || nombre_producto == 'ANUALIDAD (2022)') {

                        // if ($("#check_curso_2").is(":checked")) {

                        $(".checks_product_no_comprados").each(function(index) {
                            $("#cont_precio_" + $(this).val()).html($(this).data('precio') + ' - MXN');

                        });

                        $("#check_curso_2").prop('checked', false);
                        $("#check_curso_2").removeAttr('disabled', 'disabled');


                        for (var i = 0; i < precios.length; i++) {


                            if (precios[i].id_product === '2') {
                                console.log("remover aqui");
                                precios.splice(i, 1);
                                productos.splice(i, 1);



                            } else if (precios[i].id_product === '2' && precios[i].cantidad === cantidad) {
                                precios.splice(i, 1);
                                productos.splice(i, 1);

                                // sumarPrecios(precios);
                                // sumarProductos(productos);

                            }

                            $(".checks_product_no_comprados").prop('checked', false);
                            $(".checks_product_no_comprados").removeAttr('disabled', 'disabled');
                            precios = [];
                            productos = [];

                            sumarPrecios(precios);
                            sumarProductos(productos);
                        }


                        // }
                    }

                    //si se selecciona residente
                    if (nombre_producto == 'ANUALIDAD (2022) - (Residente)' || nombre_producto == 'V Congreso LASRA México (Residente)') {

                        // if ($("#check_curso_2").is(":checked")) {

                        $(".checks_product").each(function(index) {
                            $("#cont_precio_" + $(this).val()).html($(this).data('precio') + ' - MXN ');

                        });

                        $("#check_curso_35").prop('checked', false);
                        $("#check_curso_35").removeAttr('disabled', 'disabled');


                        for (var i = 0; i < precios.length; i++) {


                            if (precios[i].id_product === '2') {
                                console.log("remover aqui");
                                precios.splice(i, 1);
                                productos.splice(i, 1);



                            } else if (precios[i].id_product === '2' && precios[i].cantidad === cantidad) {
                                precios.splice(i, 1);
                                productos.splice(i, 1);

                                // sumarPrecios(precios);
                                // sumarProductos(productos);

                            }

                            $(".checks_product").prop('checked', false);
                            $(".checks_product").removeAttr('disabled', 'disabled');
                            precios = [];
                            productos = [];

                            sumarPrecios(precios);
                            sumarProductos(productos);
                        }


                        // }
                    }



                    //validaciones para los talleres simultaneos 

                    if (nombre_producto == 'INDISPENSABLE BLOQUEOS BASICOS MIEMBRO SUPERIOR') {
                        $("#check_curso_27").removeAttr('disabled');

                    }

                    if (nombre_producto == 'PERFUSIONES INTRAVENOSAS PARA SEDACIÓN DE LO MANUAL A TCI') {
                        $("#check_curso_24").removeAttr('disabled');
                    }

                    if (nombre_producto == 'INDISPENSABLE BLOQUEOS BASICOS MIEMBRO INFERIOR') {
                        $("#check_curso_29").removeAttr('disabled');
                    }

                    if (nombre_producto == 'ULTRASONIDO EN BLOQUEOS PARA DOLOR CRONICO') {
                        $("#check_curso_25").removeAttr('disabled');
                    }

                    if (nombre_producto == 'BLOQUEOS AVANZADOS: NEUROMONITOREO, MIEMBRO SUPERIOR Y MIEMBO INFERIOR') {
                        $("#check_curso_43").removeAttr('disabled');
                    }

                    if (nombre_producto == 'RECAT/ECO CRITICA') {
                        $("#check_curso_32").removeAttr('disabled');
                    }

                    if (nombre_producto == 'ACCESOS VASCULARES PRAVE') {
                        $("#check_curso_30").removeAttr('disabled');
                        $("#check_curso_28").removeAttr('disabled');
                    }

                    if (nombre_producto == 'BLOQUEOS AVANZADOS :TORAX Y ABDOMEN') {
                        $("#check_curso_31").removeAttr('disabled');
                        $("#check_curso_28").removeAttr('disabled');
                    }

                    if (nombre_producto == 'SIMULADORES ESCANEA Y PRACTICA CON MODELO EN SIMULACION') {
                        $("#check_curso_31").removeAttr('disabled');
                        $("#check_curso_30").removeAttr('disabled');
                    }


                    //fin de validaciones para talleres simultaneos





                    //fin de validaciones para talleres simultaneos


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
                $("#total_mx").html((sumaPrecios).toFixed(2));
                $("#total_usd").html((sumaPreciosUsd).toFixed(2));

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



            $("#btn_pago").on("click", function(event) {
                event.preventDefault();
                // var metodo_pago = $("#metodo_pago").val();
                var clave = $("#clave").val();
                var usuario = $("#email_usuario").val();
                var metodo_pago = 'combo';
                var tipo_moneda = '-';
                var compra_en = 'plataforma';

                console.log("precios ------");
                console.log(precios);



                if (precios.length < $("#numero_talleres").text()) {
                    var resta = $("#numero_talleres").text() - precios.length;
                    if (resta == 1) {
                        var text = "producto";
                    } else {
                        var text = "productos";
                    }
                    Swal.fire("¡Alerta!", "Tienes que seleccionar " + resta + " " + text + " más", "warning");
                } else if (precios.length > $("#numero_talleres").text()) {
                    Swal.fire("¡Alerta!", "Solo puedes seleccionar " + $("#numero_talleres").text() + " productos", "warning");
                } else {
                    var plantilla_productos = '';

                    plantilla_productos += `<ul>`;


                    $.each(productos, function(key, value) {
                        console.log("funcioina");
                        console.log(value);
                        plantilla_productos += `<li style="text-align: justify; font-size:14px;">
                                                    ${value.nombre_producto} 
                                                </li>`;
                    });

                    plantilla_productos += `</ul>`;



                    Swal.fire({
                        title: 'Usted selecciono los siguientes productos',
                        text: '',
                        html: plantilla_productos,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).attr('disabled', 'disabled')

                            console.log($("#total_mx").text());

                            var enviar_email = 1;
                            $.ajax({
                                url: "/Register/choseWorkshops",
                                type: "POST",
                                data: {
                                    'array': JSON.stringify(precios),
                                    clave,
                                    usuario,
                                    metodo_pago,
                                    enviar_email,
                                    tipo_moneda
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

                                        Swal.fire("¡Se agregaron sus talleres correctamente!", "", "success").
                                        then((value) => {
                                            // $(".form_compra").submit();
                                            // if (metodo_pago == 'Transferencia') {
                                                setTimeout(function() {
                                                    location.href = '/Home';
                                                }, 1000);

                                            // }
                                        });
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


</body>