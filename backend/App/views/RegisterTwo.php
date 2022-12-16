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
                        <ul class="navbar-nav d-lg-inline d-none">
                           
                            <li class="nav-item">
                                <!-- <a href="#" class="btn btn-sm btn-round mb-0 me-1" onclick="history.go(-1)"><i class="fas fa-undo"></i>  REGRESAR</a> -->
                                <a href="/Register" class="btn btn-sm btn-round mb-0 me-1"><i class="fas fa-undo"></i>  REGRESAR</a>
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
                                                <?php //var_dump($dataUser);?>
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 m-auto">
                                                        <form class="multisteps-form__form" id="add" action="/Register/passThree" method="POST">
                                                            <!--single form panel-->
                                                            <input type="hidden" name="dataUser" value='<?php echo serialize($dataUser)?>' >
                                                            
                                                            <div id="card_two" class="card multisteps-form__panel p-3 border-radius-xl bg-white js-active" id="card_one" data-animation="FadeIn">

                                                                <?php if ($dataUser['categorias'] == 3): ?>
                                                                    <!-- <div class="row text-center">
                                                                        <div class="col-10 mx-auto">
                                                                            <h5 class="font-weight-normal">Residente</h5>
                                                                            <p class="bg-gradient-red-info">Para poder acceder al evento deberá presentar credencial vigente de residencia o carta de residencia, con sellos del hospital.
                                                                            </p>
                                                                        </div>
                                                                    </div> -->
                                                                
                                                                <?php elseif($dataUser['categorias'] == 5):?>
                                                                    <!-- <div class="row text-center">
                                                                        <div class="col-10 mx-auto">
                                                                            <h5 class="font-weight-normal">Estudiante</h5>
                                                                            <p class="bg-gradient-red-info">Para poder acceder al evento deberá presentar credencial vigente de la escuela, de lo contrario deberá cubrir el costo total. 
                                                                            </p>
                                                                        </div>
                                                                    </div>     -->

                                                                <?php endif?>

                                                                

                                                                <div class="row text-center">
                                                                    <div class="col-10 mx-auto">
                                                                        <h5 class="font-weight-normal">Muy Importante</h5>
                                                                        <p>Colegio Mexicano de Ortopedia y Traumatología es una sociedad sin fines de lucro, 
                                                                            y puede expedir comprobantes deducibles de impuestos para personas físicas y 
                                                                            morales mexicanas. Recuerda que los comprobantes 
                                                                            fiscales solo pueden ser emitidos en el mes en el cual realizaste tu pago. Si necesitas factura,
                                                                             por favor selecciona la opción en los botones siguientes.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="multisteps-form__content row text-center">
                                                                    <div class="row mt-4 row text-center">
                                                                        <div class="col-sm-3 ms-auto">
                                                                            <input type="checkbox" class="btn-check" id="btncheck2" name="group1[]" value="Si">
                                                                            <label class="btn btn-lg btn-outline-secondary border-2 px-6 py-5" for="btncheck2">
                                                                                <i class="fas fa-check" style="color: green;"></i>
                                                                            </label>
                                                                            <h6>SI
                                                                            </h6>
                                                                        </div>
                                                                        <div class="col-sm-3 me-auto">
                                                                            <input type="checkbox" class="btn-check" id="btncheck3" name="group1[]" value="No">
                                                                            <label class="btn btn-lg btn-outline-secondary border-2 px-6 py-5" for="btncheck3">
                                                                                <i class="fas fa-times" style="color: red;"></i>
                                                                            </label>
                                                                            <h6>NO</h6>
                                                                        </div>
                                                                    </div>
                                                                    <br>

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

        $("#btncheck2").on("click",function(){
            // alert($(this).val());
            $("#add").attr('action','/Register/passThree');
            $("#add").attr("enctype","multipart/form-data");
            $("#add").submit();
        });

        $("#btncheck3").on("click",function(){
            // alert($(this).val());
            $("#add").attr('action','/Register/passFinalize_');
            $("#add").attr("enctype","multipart/form-data");
            $("#add").submit();
        });

    });
</script>