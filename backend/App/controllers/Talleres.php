<?php

namespace App\controllers;

defined("APPPATH") or die("Access denied");
require_once dirname(__DIR__) . '/../public/librerias/fpdf/fpdf.php';

use \Core\View;
use \Core\Controller;
use \App\models\Talleres as TalleresDao;
use \App\models\Transmision as TransmisionDao;
use \App\models\Register as RegisterDao;
use \App\models\Home as HomeDao;

class Talleres extends Controller
{

    private $_contenedor;

    function __construct()
    {
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header', $this->_contenedor->header());
        View::set('footer', $this->_contenedor->footer());
    }

    public function getUsuario()
    {
        return $this->__usuario;
    }

    public function index()
    {
        $extraHeader = <<<html
html;
        $extraFooter = <<<html
    <!--footer class="footer pt-0">
              <div class="container-fluid">
                  <div class="row align-items-center justify-content-lg-between">
                      <div class="col-lg-6 mb-lg-0 mb-4">
                          <div class="copyright text-center text-sm text-muted text-lg-start">
                              © <script>
                                  document.write(new Date().getFullYear())
                              </script>,
                              made with <i class="fa fa-heart"></i> by
                              <a href="https://www.creative-tim.com" class="font-weight-bold" target="www.grupolahe.com">Creative CMO</a>.
                          </div>
                      </div>
                      <div class="col-lg-6">
                          <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                              <li class="nav-item">
                                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">privacy policies</a>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </footer--    >
          <!-- jQuery -->
            <script src="/js/jquery.min.js"></script>
            <!--   Core JS Files   -->
            <script src="/assets/js/core/popper.min.js"></script>
            <script src="/assets/js/core/bootstrap.min.js"></script>
            <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
            <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
            <!-- Kanban scripts -->
            <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
            <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
            <script src="/assets/js/plugins/chartjs.min.js"></script>
            <script src="/assets/js/plugins/threejs.js"></script>
            <script src="/assets/js/plugins/orbit-controls.js"></script>
            
          <!-- Github buttons -->
            <script async defer src="https://buttons.github.io/buttons.js"></script>
          <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
            <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>

          <!-- VIEJO INICIO -->
            <script src="/js/jquery.min.js"></script>
          
            <script src="/js/custom.min.js"></script>

            <script src="/js/validate/jquery.validate.js"></script>
            <script src="/js/alertify/alertify.min.js"></script>
            <script src="/js/login.js"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
          <!-- VIEJO FIN -->
   <script>
    $( document ).ready(function() {

          $("#form_vacunacion").on("submit",function(event){
              event.preventDefault();
              
                  var formData = new FormData(document.getElementById("form_vacunacion"));
                  for (var value of formData.values()) 
                  {
                     console.log(value);
                  }
                  $.ajax({
                      url:"/Talleres/uploadComprobante",
                      type: "POST",
                      data: formData,
                      cache: false,
                      contentType: false,
                      processData: false,
                      beforeSend: function(){
                      console.log("Procesando....");
                  },
                  success: function(respuesta){
                      if(respuesta == 'success'){
                         // $('#modal_payment_ticket').modal('toggle');
                         
                          swal("¡Se ha guardado tu prueba correctamente!", "", "success").
                          then((value) => {
                              window.location.replace("/Talleres/");
                          });
                      }
                      console.log(respuesta);
                  },
                  error:function (respuesta)
                  {
                      console.log(respuesta);
                  }
              });
          });

        

      });
</script>

html;

        $data_user = HomeDao::getDataUser($this->__usuario);
        $modalComprar = '';
        // var_dump($data_user);

        $permisos_congreso = $data_user['congreso'] != '1' ? "style=\"display:none;\"" : "";

        // $usuarios = HomeDao::getAllUsers();
        // $free_courses = HomeDao::getFreeCourses();


        // foreach ($free_courses as $key => $value) {
        //     // HomeDao::insertCursos($_SESSION['id_registrado'],$value['id_curso']);
        //     $hay = HomeDao::getAsignaCursoByUser($_SESSION['id_registrado'], $value['id_curso']);
        //     // var_dump($hay);
        //     if ($hay == NULL || $hay == 'NULL ') {
        //         HomeDao::insertCursos($_SESSION['id_registrado'], $value['id_curso']);
        //     }
        // }

        //CURSOS COMPRADOS
        // $cursos = TalleresDao::getAll();
        $cursos = TalleresDao::getAsignaProducto($_SESSION['user_id']);

        $card_cursos = '';

        foreach ($cursos as $key => $value) {

            // if($value['es_congreso'] == 1 && $value['clave_socio'] == ""){
            //     $precio = $value['amout_due'];
            // }elseif($value['es_congreso'] == 1 && $value['clave_socio'] != ""){
            //     $precio = $value['amout_due'];
            // }
            // else if($value['es_servicio'] == 1 && $value['clave_socio'] == ""){
            //     $precio = $value['precio_publico'];
            // }else if($value['es_servicio'] == 1 && $value['clave_socio'] != ""){
            //     $precio = $value['precio_socio'];
            // }
            // else if($value['es_curso'] == 1  && $value['clave_socio'] == ""){
            //     $precio = $value['precio_publico'];
            // }else if($value['es_curso'] == 1  && $value['clave_socio'] != ""){
            //     $precio = $value['precio_socio'];
            // }

            $precio = $value['monto'];

            $progreso = TalleresDao::getProductProgreso($_SESSION['user_id'], $value['id_producto']);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time, strlen($max_time) - 2, 2);
            $duracion_min = substr($max_time, strlen($max_time) - 5, 2);
            $duracion_hrs = substr($max_time, 0, strpos($max_time, ':'));

            $secs_totales = (intval($duracion_hrs) * 3600) + (intval($duracion_min) * 60) + intval($duracion_sec);

            $porcentaje = round(($progreso['segundos'] * 100) / $secs_totales);

            $card_cursos .= <<<html



            <div class="col-12 col-md-4 mt-3">
            <div class="card card-course p-0 border-radius-15">
                <div class="card-body " style="height:100px;">
                    <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                    <div class="caratula-content">
                       <!-- <a href="/Talleres/Video/{$value['clave']}"> 
                            <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">-->
                        <!--</a>-->
                        <!--<div class="duracion"><p>{$value['duracion']}</p></div>-->
                        <!--<button class="btn btn-outline-danger"></button-->
                        
html;

            $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
            if ($like['status'] == 1) {
                $card_cursos .= <<<html
                    <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
            } else {
                $card_cursos .= <<<html
                    <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
            }

            $card_cursos .= <<<html
                       <!-- <div class="row">
                            <div class="col-11 m-auto" id="">
                                <progress class="barra_progreso_small mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                            </div>
                        </div>-->
                    </div>
                    <a href="/Talleres/Video/{$value['clave']}">
                        <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p>               
                        
        
                        <!--<p class="text-left mx-3 text-sm">{$value['fecha_curso']}
                            {$value['descripcion']}<br>
                            {$value['vistas']} vistas
                            <br> <br>
                            <b>Avance: $porcentaje %</b>
                        </p>-->
        
html;
            if ($value['status'] == 2 || $porcentaje >= 80) {
                $card_cursos .= <<<html
                            <!--<div class="ms-3 me-3 msg-encuesta px-2 py-1">Se ha habilitado un examen para este taller</div><br><br>-->
html;
            }

            $card_cursos .= <<<html
                    </a>
        
                    <div>
                        
                    </div>
                </div>
                <div class="card-footer">
                <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$precio} {$value['tipo_moneda']}</b></p>
                <div style = "display: flex; justify-content:start">
                <p class="badge badge-success" style="margin-left: 5px;margin-bottom: 38px;">
                  Este curso ya lo compraste.
                </p>
               
            </div>
          </div>
                </div>
                
            </div>
        
            <script>
                // $('#video_{$value['clave']}').on('click', function(){
                //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
                    
                //     if (like){
                //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
                //     } else {
                //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
                //     }
                // });
            </script>
html;
        }
        //FIN CURSOS COMPRADOS


        //CURSOS SIN COMPRAR

        $cursos = TalleresDao::getAllProductCursosNotInUser($_SESSION['user_id']);

        foreach ($cursos as $key => $value) {
            $progreso = TalleresDao::getProductProgreso($_SESSION['user_id'], $value['id_producto']);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time, strlen($max_time) - 2, 2);
            $duracion_min = substr($max_time, strlen($max_time) - 5, 2);
            $duracion_hrs = substr($max_time, 0, strpos($max_time, ':'));

            $precio = 2000;

            $secs_totales = (intval($duracion_hrs) * 3600) + (intval($duracion_min) * 60) + intval($duracion_sec);

            $porcentaje = round(($progreso['segundos'] * 100) / $secs_totales);

            $pendientes_pago = TalleresDao::getProductosPendientesPago($_SESSION['user_id'], $value['id_producto'])[0];

            if (isset($pendientes_pago['status'])) {

                if ($pendientes_pago['status'] == 0) {
                    //pediente de pago
                    $card_cursos .= <<<html
    
    
                <div class="col-12 col-md-4 mt-3">
                    <div class="card card-course p-0 border-radius-15">
                        <div class="card-body " style="height:100px;">
                            <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                            <div class="caratula-content">
                          
                                <!--<img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">-->
                           
html;

                    $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                    if ($like['status'] == 1) {
                        $card_cursos .= <<<html
                            <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                    } else {
                        $card_cursos .= <<<html
                            <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                    }

                    $card_cursos .= <<<html
                       
                        </div>
                        
                            <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p> 

                           

html;


                    $link_parametro_user_id = base64_encode($_SESSION['user_id']);
                    $link_parametro_id_producto = base64_encode($value['id_producto']);

                    $card_cursos .= <<<html
                            

                            <div>
                    
                        </div>
                    </div>
                    <div class="card-footer">
                        <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$pendientes_pago['monto']} {$value['tipo_moneda']}</b></p>
                        <div style = "display: flex; justify-content:start">
                        <!--<button class="btn btn-primary" style="margin-right: 5px;margin-left: 5px; width:145px;" data-toggle="modal" data-target="#comprar-curso{$value['id_producto']}">Comprar</button>-->
                        <!--<a class="btn btn-primary" href="/OrdenPago/impticket/{$link_parametro_user_id}/{$link_parametro_id_producto})" target="_blank" style="margin-right: 5px;margin-left: 5px; width:auto;">Reimprimir orden de pago</a>-->
                        <div style = "display: flex; justify-content:start">
                            <p class="badge badge-info" style="margin-left: 5px;margin-bottom: 38px;">
                            En espera de validación de pago. <br>Si usted ya realizo su pago ó desea reimprimir el formato <br> de pago de <a href="/ComprobantePago/" style="color: #08a1c4; text-decoration: underline; font-weight: bold; font-size: 15px;">clic aquí.</a>
                            </p>
                   
                        </div>
                    
                    </div>
                </div>
            </div>        
        </div>

    <script>
        // $('#video_{$value['clave']}').on('click', function(){
        //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
            
        //     if (like){
        //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
        //     } else {
        //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
        //     }
        // });
    </script>
html;
                } else if ($pendientes_pago['status'] == 2) {
                    //pago rechazado
                    $card_cursos .= <<<html
    
    
                    <div class="col-12 col-md-4 mt-3">
                        <div class="card card-course p-0 border-radius-15">
                            <div class="card-body " style="height:100px;">
                                <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                                <div class="caratula-content">
                              
                                    <!--<img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">-->
                               
html;

                    $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                    if ($like['status'] == 1) {
                        $card_cursos .= <<<html
                                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                    } else {
                        $card_cursos .= <<<html
                                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                    }

                    $card_cursos .= <<<html
                           
                            </div>
                            
                                <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p> 
    
                               
    
html;


                    $link_parametro_user_id = base64_encode($_SESSION['user_id']);
                    $link_parametro_id_producto = base64_encode($value['id_producto']);

                    $card_cursos .= <<<html
                                
    
                                <div>
                        
                            </div>
                        </div>
                        <div class="card-footer">
                            <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$value['precio_publico']} {$value['tipo_moneda']}</b></p>
                            <div style = "display: flex; justify-content:start">
                            <!--<button class="btn btn-primary" style="margin-right: 5px;margin-left: 5px; width:145px;" data-toggle="modal" data-target="#comprar-curso{$value['id_producto']}">Comprar</button>-->
                            <!--<a class="btn btn-primary" href="/OrdenPago/impticket/{$link_parametro_user_id}/{$link_parametro_id_producto})" target="_blank" style="margin-right: 5px;margin-left: 5px; width:auto;">Reimprimir orden de pago</a>-->
                            <div style = "display: flex; justify-content:start">
                                <p class="badge badge-danger" style="margin-left: 5px;margin-bottom: 38px;">
                                    No se pudo validar tu pago, vuelve a subir tu <br> comprobante dando <a href="/ComprobantePago/" style="color: #bd0000; text-decoration: underline; font-weight: bold; font-size: 15px;">clic aquí.</a>
                                </p>
                       
                            </div>
                        
                        </div>
                    </div>
                </div>        
            </div>
    
        <script>
            // $('#video_{$value['clave']}').on('click', function(){
            //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
                
            //     if (like){
            //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
            //     } else {
            //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
            //     }
            // });
        </script>
html;
                } else {
                    //echo "pagado";
                }
            } else {
                //comprar
                $card_cursos .= <<<html
    
    
                <div class="col-12 col-md-4 mt-3">
                    <div class="card card-course p-0 border-radius-15">
                        <div class="card-body " style="height:100px;">
                            <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                            <div class="caratula-content">
                            <!-- <a href="/Talleres/Video/{$value['clave']}"> 
                                <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">-->
                            <!--</a>-->
                            <!--<div class="duracion"><p>{$value['duracion']}</p></div>-->
                            <!--<button class="btn btn-outline-danger"></button-->
                
html;

                $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                if ($like['status'] == 1) {
                    $card_cursos .= <<<html
                            <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                } else {
                    $card_cursos .= <<<html
                            <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                }

                $card_cursos .= <<<html
                        
                        </div>
                       
                            <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p> 

html;
                if ($data_user['socio'] == "" || $data_user['socio'] != 1) {
                    $costo = $value['precio_publico'] . " " . $value['tipo_moneda'];
                } else {
                    $costo = $value['precio_socio'] . " " . $value['tipo_moneda'];
                }

                $card_cursos .= <<<html
                            

                            <div>
                    
                        </div>
                    </div>
                    <div class="card-footer">
                        <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$costo}</b></p>
                        <div style = "display: flex; justify-content:start">
html;

                // if($data_user['clave_socio'] == "" || empty($data_user['clave_socio'])){


                $card_cursos .= <<<html
                        <button class="btn btn-primary btn_comprar_individual" style="margin-right: 5px;margin-left: 5px; width:145px;"  value="{$value['id_producto']}">Comprar</button>
                        <button class="btn btn-primary btn_cart" value="{$value['id_producto']}" style="margin-right: 5px;margin-left: 5px;">Agregar <i class="fa far fa-cart-plus"></i></button>
html;
                //                 }else{
                //                     $card_cursos .= <<<html
                //                         <button class="btn btn-primary btn_obtener_curso" style="margin-right: 5px;margin-left: 5px; width:auto;"  value="{$value['id_producto']}">Obtener Curso</button>

                // html;
                //                 }
                $card_cursos .= <<<html
                    
                    </div>
                </div>
            </div>        
        </div>

    <script>
        // $('#video_{$value['clave']}').on('click', function(){
        //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
            
        //     if (like){
        //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
        //     } else {
        //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
        //     }
        // });
    </script>
html;

                $modalComprar .= $this->generateModalComprar($value);
            }
        }

        //CURSOS SIN COMPRAR


        //CONGRESOS COMPRADOS
        // $cursos = TalleresDao::getAll();
        $cursos = TalleresDao::getAsignaProductoCongreso($_SESSION['user_id']);

        $card_congresos = '';

        foreach ($cursos as $key => $value) {

            if ($value['es_congreso'] == 1 && $value['clave_socio'] == "") {
                $precio = $value['amout_due'];
            } elseif ($value['es_congreso'] == 1 && $value['clave_socio'] != "") {
                $precio = $value['amout_due'];
            } else if ($value['es_servicio'] == 1 && $value['clave_socio'] == "") {
                $precio = $value['precio_publico'];
            } else if ($value['es_servicio'] == 1 && $value['clave_socio'] != "") {
                $precio = $value['precio_socio'];
            } else if ($value['es_curso'] == 1  && $value['clave_socio'] == "") {
                $precio = $value['precio_publico'];
            } else if ($value['es_curso'] == 1  && $value['clave_socio'] != "") {
                $precio = $value['precio_socio'];
            }

            $progreso = TalleresDao::getProductProgreso($_SESSION['user_id'], $value['id_producto']);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time, strlen($max_time) - 2, 2);
            $duracion_min = substr($max_time, strlen($max_time) - 5, 2);
            $duracion_hrs = substr($max_time, 0, strpos($max_time, ':'));

            $secs_totales = (intval($duracion_hrs) * 3600) + (intval($duracion_min) * 60) + intval($duracion_sec);

            $porcentaje = round(($progreso['segundos'] * 100) / $secs_totales);

            $card_congresos .= <<<html



            <div class="col-12 col-md-4 mt-3">
            <div class="card card-course p-0 border-radius-15">
                <div class="card-body " style="height:100px;">
                    <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                    <div class="caratula-content">
                       <!-- <a href="/Talleres/Video/{$value['clave']}"> 
                            <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">-->
                        <!--</a>-->
                        <!--<div class="duracion"><p>{$value['duracion']}</p></div>-->
                        <!--<button class="btn btn-outline-danger"></button-->
                        
html;

            $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
            if ($like['status'] == 1) {
                $card_congresos .= <<<html
                    <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
            } else {
                $card_congresos .= <<<html
                    <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
            }

            $card_congresos .= <<<html
                       <!-- <div class="row">
                            <div class="col-11 m-auto" id="">
                                <progress class="barra_progreso_small mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                            </div>
                        </div>-->
                    </div>
                    <a href="/Talleres/Video/{$value['clave']}">
                        <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p>               
                        
        
                        <!--<p class="text-left mx-3 text-sm">{$value['fecha_curso']}
                            {$value['descripcion']}<br>
                            {$value['vistas']} vistas
                            <br> <br>
                            <b>Avance: $porcentaje %</b>
                        </p>-->
        
html;
            if ($value['status'] == 2 || $porcentaje >= 80) {
                $card_congresos .= <<<html
                            <!--<div class="ms-3 me-3 msg-encuesta px-2 py-1">Se ha habilitado un examen para este taller</div><br><br>-->
html;
            }

            $card_congresos .= <<<html
                    </a>
        
                    <div>
                        
                    </div>
                </div>
                <div class="card-footer">
                <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>{$precio} {$value['tipo_moneda']}</b></p>
                <div style = "display: flex; justify-content:start">
                    <p class="badge badge-success" style="margin-left: 5px;margin-bottom: 38px;">
                    Este curso ya lo compraste.
                    </p>
               
                </div>
          </div>
                </div>
                
            </div>
        
            <script>
                // $('#video_{$value['clave']}').on('click', function(){
                //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
                    
                //     if (like){
                //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
                //     } else {
                //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
                //     }
                // });
            </script>
html;
        }
        //FIN CONGRESOS COMPRADOS

        //CONGRESOS SIN COMPRAR

        $cursos = TalleresDao::getAllProductCongresosNotInUser($_SESSION['user_id']);

        $costoUser  = RegisterDao::getUserById($_SESSION['user_id'])[0]['amout_due'];


        foreach ($cursos as $key => $value) {
            $progreso = TalleresDao::getProductProgreso($_SESSION['user_id'], $value['id_producto']);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time, strlen($max_time) - 2, 2);
            $duracion_min = substr($max_time, strlen($max_time) - 5, 2);
            $duracion_hrs = substr($max_time, 0, strpos($max_time, ':'));

            $secs_totales = (intval($duracion_hrs) * 3600) + (intval($duracion_min) * 60) + intval($duracion_sec);

            $porcentaje = round(($progreso['segundos'] * 100) / $secs_totales);

            $pendientes_pago = TalleresDao::getProductosPendientesPago($_SESSION['user_id'], $value['id_producto'])[0];



            if (isset($pendientes_pago['status'])) {

                if ($pendientes_pago['status'] == 0) {
                    //echo "pendiente pago";

                    $card_congresos .= <<<html
    
    
                <div class="col-12 col-md-4 mt-3">
                    <div class="card card-course p-0 border-radius-15">
                        <div class="card-body " style="height:100px;">
                            <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                            <div class="caratula-content">
                                <!-- <a href="/Talleres/Video/{$value['clave']}"> 
                                <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">-->
                                <!--</a>-->
                                <!--<div class="duracion"><p>{$value['duracion']}</p></div>-->
                                <!--<button class="btn btn-outline-danger"></button-->
                
html;

                    $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                    if ($like['status'] == 1) {
                        $card_congresos .= <<<html
                                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                    } else {
                        $card_congresos .= <<<html
                                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                    }

                    $card_congresos .= <<<html
                                <!-- <div class="row">
                                        <div class="col-11 m-auto" id="">
                                            <progress class="barra_progreso_small mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                                        </div>
                                    </div>-->
                            </div>
                            <!--<a href="/Talleres/Video/{$value['clave']}">-->
                                <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p> 

                            <!--<p class="text-left mx-3 text-sm">{$value['fecha_curso']}
                                {$value['descripcion']}<br>
                                {$value['vistas']} vistas
                                <br> <br>
                                <b>Avance: $porcentaje %</b>
                            </p>-->

html;
                    if ($value['status'] == 2 || $porcentaje >= 80) {
                        $card_congresos .= <<<html
                                <!--<div class="ms-3 me-3 msg-encuesta px-2 py-1">Se ha habilitado un examen para este taller</div><br><br>-->
html;
                    }
                    $link_parametro_user_id = base64_encode($_SESSION['user_id']);
                    $link_parametro_id_producto = base64_encode($value['id_producto']);

                    $card_congresos .= <<<html
                            <!--</a>-->

                        <div>                
                    </div>
                </div>
                <div class="card-footer">
                    <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$pendientes_pago['monto']} {$value['tipo_moneda']}</b></p>
                    <div style = "display: flex; justify-content:start">
                        <!--<button class="btn btn-primary" style="margin-right: 5px;margin-left: 5px; width:145px;" data-toggle="modal" data-target="#comprar-curso{$value['id_producto']}">Comprar</button>-->

                        <!--<a class="btn btn-primary" href="/OrdenPago/impticket/{$link_parametro_user_id}/{$link_parametro_id_producto})" target="_blank" style="margin-right: 5px;margin-left: 5px; width:auto;">Reimprimir orden de pago</a>-->

                        <div style = "display: flex; justify-content:start">
                            <p class="badge badge-info" style="margin-left: 5px;margin-bottom: 38px;">
                            En espera de validación de pago. <br>Si usted ya realizo su pago ó desea reimprimir el formato <br> de pago de <a href="/ComprobantePago/" style="color: #08a1c4; text-decoration: underline; font-weight: bold; font-size: 15px;">clic aquí.</a>
                            </p>
                
                        </div>
       
                    </div>
                </div>
            </div>        
        </div>

        <script>
            // $('#video_{$value['clave']}').on('click', function(){
            //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
                
            //     if (like){
            //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
            //     } else {
            //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
            //     }
            // });
        </script>
html;
                }
                if ($pendientes_pago['status'] == 2) {
                    //echo "no se pudo validar el pago";

                    $card_congresos .= <<<html


            <div class="col-12 col-md-4 mt-3">
                <div class="card card-course p-0 border-radius-15">
                    <div class="card-body " style="height:100px;">
                        <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                        <div class="caratula-content">
                            <!-- <a href="/Talleres/Video/{$value['clave']}">
                            <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;"> -->
                            <!--</a>-->
                            <!--<div class="duracion"><p>{$value['duracion']}</p></div>-->
                            <!--<button class="btn btn-outline-danger"></button-->

html;

                    $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                    if ($like['status'] == 1) {
                        $card_congresos .= <<<html
                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                    } else {
                        $card_congresos .= <<<html
                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                    }

                    $card_congresos .= <<<html
                                <!-- <div class="row">
                                        <div class="col-11 m-auto" id="">
                                            <progress class="barra_progreso_small mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                                        </div>
                                    </div>-->
                            </div>
                            <!--<a href="/Talleres/Video/{$value['clave']}">-->
                                <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p> 

                            <!--<p class="text-left mx-3 text-sm">{$value['fecha_curso']}
                                {$value['descripcion']}<br>
                                {$value['vistas']} vistas
                                <br> <br>
                                <b>Avance: $porcentaje %</b>
                            </p>-->

html;
                    if ($value['status'] == 2 || $porcentaje >= 80) {
                        $card_congresos .= <<<html
                            <!--<div class="ms-3 me-3 msg-encuesta px-2 py-1">Se ha habilitado un examen para este taller</div><br><br>-->
html;
                    }
                    $link_parametro_user_id = base64_encode($_SESSION['user_id']);
                    $link_parametro_id_producto = base64_encode($value['id_producto']);

                    $card_congresos .= <<<html
                                <!--</a>-->

                            <div>                
                        </div>
                    </div>
                    <div class="card-footer">
                        <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$costoUser} {$value['tipo_moneda']}</b></p>
                        <div style = "display: flex; justify-content:start">
                            <!--<button class="btn btn-primary" style="margin-right: 5px;margin-left: 5px; width:145px;" data-toggle="modal" data-target="#comprar-curso{$value['id_producto']}">Comprar</button>-->

                            <!--<a class="btn btn-primary" href="/OrdenPago/impticket/{$link_parametro_user_id}/{$link_parametro_id_producto})" target="_blank" style="margin-right: 5px;margin-left: 5px; width:auto;">Reimprimir orden de pago</a>-->

                            <div style = "display: flex; justify-content:start">
                                <p class="badge badge-danger" style="margin-left: 5px;margin-bottom: 38px;">
                                No se pudo validar tu pago, vuelve a subir tu <br> comprobante dando <a href="/ComprobantePago/" style="color: #bd0000; text-decoration: underline; font-weight: bold; font-size: 15px;">clic aquí.</a>
                                </p>

                            </div>

                        </div>
                    </div>
                    </div>        
                    </div>

                    <script>
                    // $('#video_{$value['clave']}').on('click', function(){
                    //     let like = $('#video_{$value['clave']}').hasClass('heart-like');

                    //     if (like){
                    //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
                    //     } else {
                    //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
                    //     }
                    // });
                    </script>
html;
                } else {
                    //echo "pagado";
                }
            } else {
                //echo "comprar";
                $card_congresos .= <<<html
    
    
                <div class="col-12 col-md-4 mt-3">
                    <div class="card card-course p-0 border-radius-15">
                        <div class="card-body " style="height:100px;">
                            <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                            <div class="caratula-content">
                                <!-- <a href="/Talleres/Video/{$value['clave']}"> 
                                <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">-->
                                <!--</a>-->
                                <!--<div class="duracion"><p>{$value['duracion']}</p></div>-->
                                <!--<button class="btn btn-outline-danger"></button-->
                
html;

                $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                if ($like['status'] == 1) {
                    $card_congresos .= <<<html
                                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                } else {
                    $card_congresos .= <<<html
                                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                }

                $card_congresos .= <<<html
                                <!-- <div class="row">
                                        <div class="col-11 m-auto" id="">
                                            <progress class="barra_progreso_small mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                                        </div>
                                    </div>-->
                            </div>
                            <!--<a href="/Talleres/Video/{$value['clave']}">-->
                                <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p> 

                            <!--<p class="text-left mx-3 text-sm">{$value['fecha_curso']}
                                {$value['descripcion']}<br>
                                {$value['vistas']} vistas
                                <br> <br>
                                <b>Avance: $porcentaje %</b>
                            </p>-->

html;
                if ($value['status'] == 2 || $porcentaje >= 80) {
                    $card_congresos .= <<<html
                                <!--<div class="ms-3 me-3 msg-encuesta px-2 py-1">Se ha habilitado un examen para este taller</div><br><br>-->
html;
                }

                $card_congresos .= <<<html
                            <!--</a>-->

                        <div>                
                    </div>
                </div>
                <div class="card-footer">
                    <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$costoUser} {$value['tipo_moneda']}</b></p>
                    <div style = "display: flex; justify-content:start">
                        <button class="btn btn-primary btn_comprar_individual" style="margin-right: 5px;margin-left: 5px; width:145px;" value="{$value['id_producto']}">Comprar</button>
                        <button class="btn btn-primary btn_cart" value="{$value['id_producto']}" style="margin-right: 5px;margin-left: 5px;">Agregar <i class="fa far fa-cart-plus"></i></button>
       
                    </div>
                </div>
            </div>        
        </div>

        <script>
            // $('#video_{$value['clave']}').on('click', function(){
            //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
                
            //     if (like){
            //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
            //     } else {
            //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
            //     }
            // });
        </script>
html;

                $cost = ['amout_due' => $costoUser];
                $value = array_merge($value, $cost);
                // array_push($value, ['amout_due'=>$costoUser]);
                $modalComprar .= $this->generateModalComprar($value);
            }
        }

        //CONGRESOS SIN COMPRAR

        // $modalComprar = '';
        // foreach (TalleresDao::getAll() as $key => $value) {
        //     $modalComprar .= $this->generateModalComprar($value);
        // }

        View::set('header', $this->_contenedor->header($extraHeader));
        View::set('permisos_congreso', $permisos_congreso);
        View::set('datos', $data_user['datos']);
        View::set('card_cursos', $card_cursos);
        View::set('card_congresos', $card_congresos);
        View::set('modalComprar', $modalComprar);
        View::render("talleres_all");
    }

    public function byProducts()
    {

        // $user_email = $_GET['e'];
        // $user_email = base64_decode($user_email);



        $data_user = HomeDao::getDataUser($this->__usuario);

        $header = <<<html
        <!DOCTYPE html>
        <html lang="es">
        
          <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/logo_cmo.png">
            <link rel="icon" type="image/png" href="/assets/img/logo_cmo.png">
            <title>
               CMO
            </title>
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Nucleo Icons -->
            <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- Font Awesome Icons -->
            <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- CSS Files -->
            <link id="pagestyle" href="../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
            <!-- TEMPLATE VIEJO-->
            <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
            <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />

            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="icon" type="image/png" href="../../assets/img/favicon.png">

            <!--     Fonts and icons     -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Nucleo Icons -->
            <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- Font Awesome Icons -->
            <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- CSS Files -->
            <link id="pagestyle" href="../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />

            <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

            <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
              
            <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
            
            <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

           <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
           <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
           <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
           <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

           <script charset="UTF-8" src="//web.webpushs.com/js/push/9d0c1476424f10b1c5e277f542d790b8_1.js" async></script>
           
            <!-- TEMPLATE VIEJO-->

            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Nucleo Icons -->
            <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
            <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- Font Awesome Icons -->
            <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
            <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- CSS Files -->
            <link id="pagestyle" href="../../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <style>
            .select2-container--default .select2-selection--single {
            height: 38px!important;
            border-radius: 8px!important;
            
            }
            .select2-container {
              width: 100%!important;
              
          }
           
            </style>
        </head>
html;

        $extraFooter = <<<html
     
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
       <!--   Core JS Files   -->
          <script src="../../../assets/js/core/popper.min.js"></script>
          <script src="../../../assets/js/core/bootstrap.min.js"></script>
          <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/multistep-form.js"></script>
          <!-- Kanban scripts -->
          <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
          <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
          <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
              var options = {
                damping: '0.5'
              }
              Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
          </script>
          <!-- Github buttons -->
          <script async defer src="https://buttons.github.io/buttons.js"></script>
          <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
          <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
        window.addEventListener("keypress", function(event){
            if (event.keyCode == 13){
                event.preventDefault();
            }
        }, false);
        
          window.onload = function() {
          var myInput = document.getElementById('confirm_email');
          var myInput_conf = document.getElementById('confirm_email_iva');
          myInput.onpaste = function(e) {
            e.preventDefault();
          }
          myInput_conf.onpaste = function(e) {
            e.preventDefault();
          }
          
          myInput.oncopy = function(e) {
            e.preventDefault();
          }
          myInput_conf.oncopy = function(e) {
            e.preventDefault();
          }
        }
        
        $('#email').on('keypress', function() {
            var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
            if(!re) {
                $('#error').show();
                 document.getElementById('confirm_email').disabled = true;
                 
            } else {
                $('#error').hide();
                document.getElementById('confirm_email').disabled = false;
                
            }
        })
        
        
        $('#confirm_email').on('keypress', function() {
            document.getElementById('email').disabled = true;
            var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
            if(!re) {
                $('#error_confirm').show();
            } else {
                $('#error_confirm').hide();
            }
        })
        
         $("#confirm_email").on("keyup", function() 
        {
    	    var email_uno = document.getElementById('email').value;
            var email_dos = document.getElementById('confirm_email').value;

            console.log($(this).val());

                  
            if(email_uno == email_dos)
            {
                // document.getElementById('confirm_email').disabled = true;
                $("#confirm_email").attr('readonly', true);
                $("#btn_next_1").removeAttr('disabled');
                document.getElementById('title').disabled = false;
                document.getElementById('apellidop').disabled = false;
                document.getElementById('apellidom').disabled = false;
                document.getElementById('telephone').disabled = false;
                document.getElementById('nationality').disabled = false;
                document.getElementById('state').disabled = false;
                document.getElementById('nombre').disabled = false;
                document.getElementById('especialidades').disabled = false;
                document.getElementById('categorias').disabled = false;
                document.getElementById("email_validado").value = email_uno;

                console.log(document.getElementById('nombre'));

            }
        });
     
        $('#email_receipt_iva').on('keypress', function() {
            var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
            if(!re) {
                $('#error_email_send').show();
            } else {
                $('#error_email_send').hide();
            }
        })
        $('#confirm_email_iva').on('keypress', function() {
            var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
            if(!re) {
                $('#error_email_send_confirm').show();
            } else {
                $('#error_email_send_confirm').hide();
            }
        })
        

        
        function myFunction() 
        {
            var one = document.getElementById("card_one");
            var two = document.getElementById("card_two");
            var three = document.getElementById("card_three");
            var four = document.getElementById("card_four");
            var five = document.getElementById("card_five");
            var card_progress = document.getElementById("card_progress");
            var Menu_Two = document.getElementById("Menu_Two");
            
            if (five.style.display === 'none') 
            {
                one.style.display = 'none';
                two.style.display = 'none';
                three.style.display = 'none';
                four.style.display = 'none';
                card_progress.style.display = 'none';
                five.style.display = 'block';
                Menu_Two.style.display = 'block';
                 $("#ModalPayOne").modal('hide');
            }
        }
        
        function myFunctionDiscardVAT() 
        {
            var one = document.getElementById("card_one");
            var two = document.getElementById("card_two");
            var three = document.getElementById("card_three");
            var four = document.getElementById("card_four");
            var six = document.getElementById("card_six");
            var card_progress = document.getElementById("card_progress");
            var Menu_Two = document.getElementById("Menu_Two");
            
            if (six.style.display === 'none') 
            {
                one.style.display = 'none';
                two.style.display = 'none';
                three.style.display = 'none';
                four.style.display = 'none';
                card_progress.style.display = 'none';
                six.style.display = 'block';
                Menu_Two.style.display = 'block';
            }

            
        }
        
        function myFunction_TermsConditions() 
        {
            var five = document.getElementById("card_five");
            var six = document.getElementById("card_six");
             
            if (six.style.display === 'none') 
            {
                six.style.display = 'block';
                five.style.display = 'none';
            }
        }
        
        function actualizaEdos(pais = null) {
        var pais = $('#nationality').val();
        $.ajax({
          url: '/Register/ObtenerEstado',
          type: 'POST',
          dataType: 'json',
          data: {pais:pais},
    
        })
        .done(function(json) {
            if(json.success)
            {
                $("#state").html(json.html);
            }
        })
        .fail(function() 
        {
          alert("Ocurrio un error al actualizar el estado intenta de nuevo");
        })
      }
        
        $(document).ready(function(){
                
                $('input[type="checkbox"]').on('change', function() 
                {
                    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
                    $('#ModalPayOne').show();
                });
                
                $.validator.addMethod("checkUserName",function(value, element) {
                  var response = false;
                    $.ajax({
                        type:"POST",
                        async: false,
                        url: "/Login/isUserValidate",
                        data: {usuario: $("#usuario").val()},
                        success: function(data) {
                            if(data=="true"){
                                $('#btnEntrar').attr("disabled", false);
                                response = true;
                            }else{
                                $('#btnEntrar').attr("disabled", true);
                            }
                        }
                    });

                    return response;
                },"El usuario no es correcto");
            });
      </script>
      
html;




        $productos_pendientes_comprados = HomeDao::getProductosPendComprados($data_user['user_id']);
        $checks = '';
        $checked = '';
        $total_productos = 0;
        $total_pago = 0;
        $check_disabled = '';
        $array_precios = [];
        $array_productos = [];



        // // $clave = HomeDao::getProductosPendCompradosClave($data_user['user_id'])[0]['clave'];

        // $clave = HomeDao::getLastQrPendientePago($data_user['user_id'])['clave'];


        // if($clave != ""){
        //     // $src_qr = '/qrs/'.$productos_pendientes_comprados[0]['clave'].'.png';
        //     $src_qr = '/qrs/'.$clave.'.png';           
        //     // $btn_block = 'style = "display:none"';
        //     // $check_disabled = 'disabled';
        // }else{
        //     $src_qr = '';
        //     $btn_block = '';

        // }   


        // if(count($productos_pendientes_comprados) > 0){
        foreach ($productos_pendientes_comprados as $key => $value) {
            $disabled = '';
            $checked = '';
            $pend_validar = '';

            $precio = $value['monto'];


            $f = $value['fecha_producto'];
            $fechas = explode(" ", $f);
            $f1 = $fechas[0]; 


            if($value['tipo'] == 'Taller'){
                $fecha = $f1;
            }else{
                $fecha = '';
            }

            $count_producto = HomeDao::getCountProductos($data_user['user_id'], $value['id_producto'])[0];



            if ($value['estatus_compra'] == 1) {
                $disabled = 'disabled';
                $checked = 'checked';
                $pend_validar = 'Pagado y validado por CMO';
                // $btn_imp = '';
                // $productos_pendientes_comprados[0]['clave'].'" target="blank_">Imprimir Formato de Pago</a>';
                // $ocultar = 'display:none;';

            } else if ($value['estatus_compra'] == null) {
                $pend_validar = 'Pendiente de Pagar';
                // $btn_imp = '<a class="btn btn-primary" href="/Home/print/'.$productos_pendientes_comprados[0]['clave'].'" target="blank_">Imprimir Formato de Pago</a>';
                // $ocultar = '';
                $disabled = 'disabled';
                $checked = 'checked';
                $total_productos += $count_producto['numero_productos'];
                $total_pago += $count_producto['numero_productos'] * $precio;
                array_push($array_precios, ['id_product' => $value['id_producto'], 'precio' => $precio, 'cantidad' => $count_producto['numero_productos']]);
                array_push($array_productos, ['id_product' => $value['id_producto'], 'precio' => $precio, 'cantidad' => $count_producto['numero_productos'], 'nombre_producto' => $value['nombre_producto']]);
            }

            if ($value['max_compra'] <= 1) {
                $numero_productos = '<input type="number" id="numero_articulos' . $value['id_producto'] . '" name="numero_articulos" value="' . $value['max_compra'] . '" style="border:none;" readonly>';
            } else {
                $numero_productos = '<select class="form-control select_numero_articulos" id="numero_articulos' . $value['id_producto'] . '" name="numero_articulos" data-id-producto="' . $value['id_producto'] . '" data-precio="' . $precio . '" data-nombre-producto="' . $value['nombre_producto'] . '" ' . $disabled . '>';
                for ($i = 1; $i <= $value['max_compra']; $i++) {
                    $numero_productos .= '<option value="' . $i . '">' . $i . '</option>';
                }
                $numero_productos .= '</select>';
            }

            $checks .= <<<html
            
            <div id="cont_check{$value['id_producto']}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-check">
                            <input class="form-check-input checks_product" type="checkbox" value="{$value['id_producto']}" id="check_curso_{$value['id_producto']}" name="checks_cursos[]" {$disabled} {$checked} data-precio="{$precio}" data-precio-usd="{$value['precio_publico_usd']}" data-precio-socio="{$value['precio_socio']}" data-precio-socio-usd="{$value['precio_socio_usd']}" data-nombre-producto="{$value['nombre_producto']}">
                            <label class="form-check-label" for="check_curso_{$value['id_producto']}">
                            {$value['tipo']} {$value['nombre_producto']} - {$value['descripcion']} <span style="font-size: 13px; text-decoration: underline; color: green;">{$pend_validar}</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <span class="cont_precio" id="cont_precio_{$value['id_producto']}">{$precio} <span>- {$value['tipo_moneda']}
                    </div>

                    <div class="col-md-2">
                        {$numero_productos}
                    </div>
                </div>

                <hr>
            </div>
html;

            $numero_productos = '';
        }
        // }
        $clave = $this->generateRandomString();

        $productos_no_comprados = HomeDao::getProductosNoComprados($data_user['user_id']);

        foreach ($productos_no_comprados as $key => $value) {

            if($value['socio'] == 1 || $value['socio'] == '1'){
                $precio = $value['precio_socio'];
            }else{
                $precio = $value['precio_publico'];
            }


            //Esto se tiene que modificar por el nombre prducto 
            // if ($value['es_congreso'] == 1 && $value['nombre_producto'] == "V Congreso LASRA México (socio)" || $value['nombre_producto'] == "V Congreso LASRA México (Residente)") {
            //     $precio = $value['precio_publico'];
            // } elseif ($value['es_congreso'] == 1) {
            //     $precio = $value['amout_due'];
            // } else if ($value['es_servicio'] == 1 && $value['clave_socio'] == "") {
            //     $precio = $value['precio_publico'];
            // } else if ($value['es_servicio'] == 1 && $value['clave_socio'] != "") {
            //     $precio = $value['precio_socio'];
            // } else if ($value['es_curso'] == 1  && $value['clave_socio'] == "") {
            //     $precio = $value['precio_publico'];
            // } else if ($value['es_curso'] == 1  && $value['clave_socio'] != "") {
            //     $precio = $value['precio_socio'];
            // }

            if ($value['max_compra'] <= 1) {
                $numero_productos = '<input type="number" id="numero_articulos' . $value['id_producto'] . '" name="numero_articulos" value="' . $value['max_compra'] . '" style="border:none;" readonly>';
            } else {
                $numero_productos = '<select class="form-control select_numero_articulos" id="numero_articulos' . $value['id_producto'] . '" name="numero_articulos" data-id-producto="' . $value['id_producto'] . '"  data-precio="' . $precio . '" data-nombre-producto="' . $value['nombre_producto'] . '">';
                for ($i = 1; $i <= $value['max_compra']; $i++) {
                    $numero_productos .= '<option value="' . $i . '">' . $i . '</option>';
                }
                $numero_productos .= '</select>';
            }

            $f = $value['fecha_producto'];
            $fechas = explode(" ", $f);
            $f1 = $fechas[0]; 

            if($value['tipo'] == 'TALLER'){
                $fecha = $f1;
            }else{
                $fecha = '';
            }

            $checks .= <<<html
            <div id="cont_check{$value['id_producto']}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-check">
                            <input class="form-check-input checks_product checks_product_no_comprados" type="checkbox" value="{$value['id_producto']}" id="check_curso_{$value['id_producto']}" name="checks_cursos[]" data-precio="{$precio}" data-precio-usd="{$value['precio_publico_usd']}" data-precio-socio="{$value['precio_socio']}" data-precio-socio-usd="{$value['precio_socio_usd']}" data-nombre-producto="{$value['nombre_producto']}" {$check_disabled}>
                            <label class="form-check-label" for="check_curso_{$value['id_producto']}">
                            {$value['tipo']} {$value['nombre_producto']} - {$value['descripcion']}
                            </label>
                        </div>
                    </div>
                
                    <div class="col-md-2">
                        <span class="cont_precio" id="cont_precio_{$value['id_producto']}">{$precio} <span>- {$value['tipo_moneda']}
                    </div>

                    <div class="col-md-2">
                            {$numero_productos}
                    </div>

                </div>

                <hr>
            </div>
html;

            $numero_productos = '';
        }

        $tipo_cambio = HomeDao::getTipoCambio();

        $formaPago = '';
        foreach (HomeDao::getFormaPago() as $key => $value) {
            // $cfdi = ($value['id_pais'] == $userData['id_pais']) ? 'selected' : '';  
            $formaPago .= <<<html
                    <option value="{$value['clave_forma_pago']}">{$value['descripcion_forma_pago']}</option>
html;
        }
        // $total_mx = intval($total_pago) * floatval($tipo_cambio['tipo_cambio']);
        $total_mx = intval($total_pago);


        View::set('header', $header);
        View::set('datos', $data_user);
        View::set('clave', $clave);
        View::set('checks', $checks);
        View::set('formaPago', $formaPago);
        // View::set('src_qr',$src_qr); 
        // View::set('btn_block',$btn_block); 
        View::set('total_productos', $total_productos);
        View::set('total_pago', $total_pago);
        View::set('total_pago_mx', $total_mx);
        // View::set('btn_imp',$btn_imp); 
        // View::set('ocultar',$ocultar);
        View::set('tipo_cambio', $tipo_cambio['tipo_cambio']);
        View::set('array_precios', $array_precios);
        View::set('array_productos', $array_productos);
        View::render("buy_products_plataforma");
    }

    public function chooseWorkshops()
    {

        // $user_email = $_GET['e'];
        // $user_email = base64_decode($user_email);



        $data_user = HomeDao::getDataUser($this->__usuario);

        if($data_user['check_talleres'] == 1){
            header('Location: /Home/');
        }
        $checks = '';
        $checked = '';
        $total_productos = 0;
        $total_pago = 0;
        $check_disabled = '';
        $array_precios = [];
        $array_productos = [];
        $numero_talleres = 0;
        $nombre_combo = '';
        $clave = '';

        $getCombo = HomeDao::getCombo($data_user['user_id']);

        foreach($getCombo as $key => $value){
            if($value['id_producto'] == 38 || $value['id_producto'] == 41){
                $numero_talleres = 2;
                $nombre_combo = 'SUPRA Clinical WorkShop 2 hands on';
                $clave = $value['clave'];
                break;
            }else if($value['id_producto'] == 37 || $value['id_producto'] == 40){
                $numero_talleres = 3;
                $nombre_combo = 'SUPRA Clinical WorkShop 3 hands on';
                $clave = $value['clave'];
                break;
            }else if($value['id_producto'] == 36 || $value['id_producto'] == 39){
                $numero_talleres = 4;
                $nombre_combo = 'SUPRA Clinical WorkShop 4 hands on';
                $clave = $value['clave'];
                break;
            }
        }

        $header = <<<html
        <!DOCTYPE html>
        <html lang="es">
        
          <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/logo_cmo.png">
            <link rel="icon" type="image/png" href="/assets/img/logo_cmo.png">
            <title>
               LASRA - CMO
            </title>
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Nucleo Icons -->
            <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- Font Awesome Icons -->
            <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- CSS Files -->
            <link id="pagestyle" href="../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
            <!-- TEMPLATE VIEJO-->
            <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
            <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />

            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="icon" type="image/png" href="../../assets/img/favicon.png">

            <!--     Fonts and icons     -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Nucleo Icons -->
            <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- Font Awesome Icons -->
            <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- CSS Files -->
            <link id="pagestyle" href="../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />

            <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
              
            <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
            
            <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

           <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
           <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
           <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
           <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

           <script charset="UTF-8" src="//web.webpushs.com/js/push/9d0c1476424f10b1c5e277f542d790b8_1.js" async></script>
           
            <!-- TEMPLATE VIEJO-->

            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Nucleo Icons -->
            <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
            <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- Font Awesome Icons -->
            <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
            <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- CSS Files -->
            <link id="pagestyle" href="../../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <style>
            .select2-container--default .select2-selection--single {
            height: 38px!important;
            border-radius: 8px!important;
            
            }
            .select2-container {
              width: 100%!important;
              
          }
           
            </style>
        </head>
html;
       
        $productos_no_comprados = HomeDao::getTalleres($data_user['user_id']);

        foreach ($productos_no_comprados as $key => $value) {

            if($value['socio'] == 1 || $value['socio'] == '1'){
                $precio = $value['precio_socio'];
            }else{
                $precio = $value['precio_publico'];
            }


            

            if ($value['max_compra'] <= 1) {
                $numero_productos = '<input type="number" id="numero_articulos' . $value['id_producto'] . '" name="numero_articulos" value="' . $value['max_compra'] . '" style="border:none;" readonly>';
            } else {
                $numero_productos = '<select class="form-control select_numero_articulos" id="numero_articulos' . $value['id_producto'] . '" name="numero_articulos" data-id-producto="' . $value['id_producto'] . '"  data-precio="' . $precio . '" data-nombre-producto="' . $value['nombre_producto'] . '">';
                for ($i = 1; $i <= $value['max_compra']; $i++) {
                    $numero_productos .= '<option value="' . $i . '">' . $i . '</option>';
                }
                $numero_productos .= '</select>';
            }

            $f = $value['fecha_producto'];
            $fechas = explode(" ", $f);
            $f1 = $fechas[0]; 

            if($value['tipo'] == 'TALLER'){
                $fecha = $f1;
            }else{
                $fecha = '';
            }

            $checks .= <<<html
            <div id="cont_check{$value['id_producto']}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-check">
                            <input class="form-check-input checks_product checks_product_no_comprados" type="checkbox" value="{$value['id_producto']}" id="check_curso_{$value['id_producto']}" name="checks_cursos[]" data-precio="{$precio}" data-precio-usd="{$value['precio_publico_usd']}" data-precio-socio="{$value['precio_socio']}" data-precio-socio-usd="{$value['precio_socio_usd']}" data-nombre-producto="{$value['nombre_producto']}" {$check_disabled}>
                            <label class="form-check-label" for="check_curso_{$value['id_producto']}">
                            {$value['tipo']} {$value['nombre_producto']} - {$fecha}
                            </label>
                        </div>
                    </div>
                
                    <div class="col-md-2" style="display:none;">
                        <span class="cont_precio" id="cont_precio_{$value['id_producto']}">{$precio} <span>- {$value['tipo_moneda']}
                    </div>

                    <div class="col-md-2" style="display:none;">
                            {$numero_productos}
                    </div>

                </div>

                <hr>
            </div>
html;

            $numero_productos = '';
        }

        $tipo_cambio = HomeDao::getTipoCambio();

        // $total_mx = intval($total_pago) * floatval($tipo_cambio['tipo_cambio']);
        $total_mx = intval($total_pago);

        View::set('numero_talleres',$numero_talleres);
        View::set('nombre_combo',$nombre_combo);
        View::set('header', $header);
        View::set('datos', $data_user);
        View::set('clave', $clave);
        View::set('checks', $checks);
        // View::set('src_qr',$src_qr); 
        // View::set('btn_block',$btn_block); 
        View::set('total_productos', $total_productos);
        View::set('total_pago', $total_pago);
        View::set('total_pago_mx', $total_mx);
        // View::set('btn_imp',$btn_imp); 
        // View::set('ocultar',$ocultar);
        View::set('tipo_cambio', $tipo_cambio['tipo_cambio']);
        View::set('array_precios', $array_precios);
        View::set('array_productos', $array_productos);
        View::render("choose_products_plataforma");
    }

    public function generateModalComprar($datos)
    {
        if (isset($datos['amout_due'])) {
            $precio_curso = '$ ' . $datos['amout_due'] . " " . $datos['tipo_moneda'];
            $solo_precio_curso = $datos['amout_due'];
        } else {
            $precio_curso = '$ ' . $datos['precio_publico'] . " " . $datos['tipo_moneda'];
            $solo_precio_curso = $datos['precio_publico'];
        }

        $clave = $this->generateRandomString();

        $modal = <<<html
        <div class="modal fade" id="comprar-curso{$datos['id_producto']}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="comprar-curso">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                Completa tu compra
                </h5>

                <span type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal" aria-label="Close">
                    X
                </span>
            </div>
            <div class="modal-body">
              <form class="form_compra" method="POST" action="" target="_blank">              
              <div class="row">
                <div class="col-md-8">
                    <div style="display:flex; justify-content:center;">
                        <img src="/caratulas/{$datos['caratula']}" style="width:60%; border-radius: 10px;" alt="" />
                    </div>

                    <p class="text-center mt-3"><b>{$datos['nombre']}</b></p>

                    <p class="text-center" style="color: #2B932B;"><b>{$precio_curso}</b></p>
                    <input type="hidden" value="{$solo_precio_curso}" name="costo"/>
                    <input type="hidden" value="{$datos['tipo_moneda']}" name="tipo_moneda"/>
                    <input type="hidden" value="{$datos['id_producto']}" name="id_producto"/>
                    <input type="hidden" value="{$datos['nombre']}" name="nombre_curso"/>
                    <input type="hidden" class="tipo_pago" name="tipo_pago"/>

                    <br>

                    <!-- campos para paypal -->
                    <input type="hidden" name="charset" value="utf-8">
                    <input type='hidden' name='business' value='aspsiqm@prodigy.net.mx'> 
                    <input type='hidden' name='item_name' value='{$datos['nombre']}'> 
                    <input type='hidden' name='item_number' value="{$clave}"> 
                    <input type='hidden' name='amount' value='{$solo_precio_curso}'> 
                    <input type='hidden' name='currency_code' value='{$datos['tipo_moneda']}'> 
                    <input type='hidden' name='notify_url' value=''> 
                    <input type='hidden' name='return' value='https://registro.dualdisorderswaddmexico2022.com/ComprobantePago/'> 
                    <input type="hidden" name="cmd" value="_xclick">  
                    <input type="hidden" name="order" value="{$clave}">

                    <div class="row d-flex justify-content-center">
                        <div class="col-4">
                            <label>Elige tu metodo de pago *</label>
                            <select class="multisteps-form__select form-control all_input_second_select metodo_pago" name="metodo_pago" required>
                                <option value="" disabled selected>Selecciona una Opción</option>
                                <option value="Paypal">Paypal</option>
                                <option value="Efectivo">Efectivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center mt-3">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary btn_comprar" style="width: 100%;" name="btn_tipo_pago" data-id={$datos['id_producto']} >Comprar</button>
                        </div>
                    </div>
                    
                    
                
                </div>
                <div class="col-md-4">
                </div>
              </div>
              </form>
                
              <form id="form_compra_paypal{$datos['id_producto']}">
                    <input type="hidden" value="{$solo_precio_curso}" name="costo"/>
                    <input type="hidden" value="{$datos['tipo_moneda']}" name="tipo_moneda"/>
                    <input type="hidden" value="{$datos['id_producto']}" name="id_producto"/>
                    <input type="hidden" value="{$datos['nombre']}" name="nombre_curso"/>
                    <input type="hidden" class="tipo_pago" name="tipo_pago"/>                    
                    <input type='hidden' name='clave' value="{$clave}">                    


              </form>
            </div>
          </div>
        </div>
      </div>

      
html;



        return $modal;
    }

    public function AsignarCursoSocio()
    {

        $id_pro = $_POST['id_producto'];
        $prorducto = TalleresDao::getPorductById($id_pro);
        $datos_user = HomeDao::getDataUserById($_SESSION['user_id']);
        $clave = $this->generateRandomString();


        $documento = new \stdClass();

        $nombre_curso = $prorducto['nombre'];
        $id_producto = $id_pro;
        $user_id = $_SESSION['user_id'];
        $reference = $datos_user['reference'];
        $fecha =  date("Y-m-d");
        $monto = 0;
        $tipo_pago = 'socio';
        $status = 1;

        $documento->_id_producto = $id_producto;
        $documento->_user_id = $user_id;
        $documento->_reference = $reference;
        $documento->_clave = $clave;
        $documento->_fecha = $fecha;
        $documento->_monto = $monto;
        $documento->_tipo_pago = $tipo_pago;
        $documento->_status = $status;

        $id = TalleresDao::inserPendientePago($documento);
        if ($id) {
            $data = new \stdClass();
            $data->_user_id = $user_id;
            $data->_id_producto = $id_pro;

            $insertAsiganProducto = TalleresDao::insertAsignaProducto($data);

            if ($insertAsiganProducto) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            echo "fail";
        }
    }

    public function Video($clave)
    {
        $extraHeader = <<<html
html;
        $extraFooter = <<<html
            <!--footer class="footer pt-0">
                    <div class="container-fluid">
                        <div class="row align-items-center justify-content-lg-between">
                            <div class="col-lg-6 mb-lg-0 mb-4">
                                <div class="copyright text-center text-sm text-muted text-lg-start">
                                    © <script>
                                        document.write(new Date().getFullYear())
                                    </script>,
                                    made with <i class="fa fa-heart"></i> by
                                    <a href="https://www.creative-tim.com" class="font-weight-bold" target="www.grupolahe.com">Creative CMO</a>.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">privacy policies</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer--    >
                <!-- jQuery -->
                    <script src="/js/jquery.min.js"></script>
                    <!--   Core JS Files   -->
                    <script src="/assets/js/core/popper.min.js"></script>
                    <script src="/assets/js/core/bootstrap.min.js"></script>
                    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
                    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
                    <!-- Kanban scripts -->
                    <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
                    <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
                    <script src="/assets/js/plugins/chartjs.min.js"></script>
                    <script src="/assets/js/plugins/threejs.js"></script>
                    <script src="/assets/js/plugins/orbit-controls.js"></script>
                    
                <!-- Github buttons -->
                    <script async defer src="https://buttons.github.io/buttons.js"></script>
                <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
                    <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>

                <!-- VIEJO INICIO -->
                    <script src="/js/jquery.min.js"></script>
                
                    <script src="/js/custom.min.js"></script>

                    <script src="/js/validate/jquery.validate.js"></script>
                    <script src="/js/alertify/alertify.min.js"></script>
                    <script src="/js/login.js"></script>
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                <!-- VIEJO FIN -->
        <script>
            $( document ).ready(function() {

                $("#form_vacunacion").on("submit",function(event){
                    event.preventDefault();
                    
                        var formData = new FormData(document.getElementById("form_vacunacion"));
                        for (var value of formData.values()) 
                        {
                            console.log(value);
                        }
                        $.ajax({
                            url:"/Talleres/uploadComprobante",
                            type: "POST",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function(){
                            console.log("Procesando....");
                        },
                        success: function(respuesta){
                            if(respuesta == 'success'){
                                // $('#modal_payment_ticket').modal('toggle');
                                
                                swal("¡Se ha guardado tu prueba correctamente!", "", "success").
                                then((value) => {
                                    window.location.replace("/Talleres/");
                                });
                            }
                            console.log(respuesta);
                        },
                        error:function (respuesta)
                        {
                            console.log(respuesta);
                        }
                    });
                });

            });
        </script>

html;

        $curso = TalleresDao::getProductCursoByClave($clave);

        $contenido_taller = '';

        $permiso_taller = TalleresDao::getContenidoProdductCursoByAsignacion($_SESSION['user_id'], $clave);

        $progreso_curso = TalleresDao::getProductProgreso($_SESSION['user_id'], $curso['id_producto']);
        if ($progreso_curso) {
            $progreso_curso = TalleresDao::getProductProgreso($_SESSION['user_id'], $curso['id_producto']);
        } else {
            TalleresDao::insertProductCursoProgreso($_SESSION['user_id'], $curso['id_producto']);
            $progreso_curso = TalleresDao::getProductProgreso($_SESSION['user_id'], $curso['id_producto']);
        }

        $duracion = $curso['duracion'];

        $duracion_sec = substr($duracion, strlen($duracion) - 2, 2);
        $duracion_min = substr($duracion, strlen($duracion) - 5, 2);
        $duracion_hrs = substr($duracion, 0, strpos($duracion, ':'));

        $secs_totales = (intval($duracion_hrs) * 3600) + (intval($duracion_min) * 60) + intval($duracion_sec);

        $progreso_curso = TalleresDao::getProductProgreso($_SESSION['user_id'], $curso['id_producto']);
        if ($progreso_curso) {
            $progreso_curso = TalleresDao::getProductProgreso($_SESSION['user_id'], $curso['id_producto']);
        } else {
            TalleresDao::insertProductCursoProgreso($_SESSION['user_id'], $curso['id_producto']);
            $progreso_curso = TalleresDao::getProductProgreso($_SESSION['user_id'], $curso['id_producto']);
        }

        $porcentaje = round(($progreso_curso['segundos'] * 100) / $secs_totales);

        if ($curso) {
            $id_curso = TalleresDao::getProductCursoByClave($clave)['id_producto'];
            $url = TalleresDao::getProductCursoByClave($clave)['url'];
            $nombre_taller = TalleresDao::getProductCursoByClave($clave)['nombre'];
            $descripcion = TalleresDao::getProductCursoByClave($clave)['descripcion'];

            if ($permiso_taller) {
                $contenido_taller .= <<<html
                <div class="row">
                <div class="embed-responsive embed-responsive-16by9">
         <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="{$url}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
        </div>
                   <!-- <iframe id="iframe" class="bg-gradient-warning iframe-course" src="{$url}" allow="autoplay; fullscreen; style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0"></iframe>-->
                    <!-- <iframe src="{$url}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:640;height:521;"></iframe>-->
                </div>
    
                <input type="text" value="{$clave}" id="clave_video" readonly hidden>
    
                <div>
                    <p>
                        <hr class="horizontal dark my-1">
                        <h6 class="mb-1 mt-2 text-center">{$descripcion}</h6>
                    </p>
                </div>
    
                
                
html;
                if ($curso['status'] == 2 || $porcentaje >= 80) {
                    //                     $btn_encuesta = <<<html
                    //                     <button type="button" class="btn btn-primary" style="background-color: orangered!important;" data-toggle="modal" data-target="#encuesta">
                    //                         Examen
                    //                     </button>
                    // html;
                } else {
                    $btn_encuesta = '';
                }
            } else {
                $contenido_taller .= <<<html
                <hr>
                <div class="row mt-3">
                    <div class="col-10 m-auto text-center">
                        <h2 class="text-bolder text-gradient text-danger">
                            <i class="fas fa-exclamation"></i><br>
                            Lo sentimos no tiene acceso a este curso, contacte a soporte.
                        </h2>
                    </div>
                </div>                
html;
                $btn_encuesta = '';
            }

            $encuesta = '';

            $preguntas  = TalleresDao::getPreguntasByProductCursoUsuario($id_curso);
            $ha_respondido = TalleresDao::getRespuestasCurso($_SESSION['user_id'], $id_curso);

            if ($preguntas) {

                $num_pregunta = 1;

                if ($ha_respondido) {

                    foreach ($preguntas as $key => $value) {
                        $opcion1 = $value['opcion1'];
                        $opcion2 = $value['opcion2'];
                        $opcion3 = $value['opcion3'];
                        $opcion4 = $value['opcion4'];

                        $encuesta .= <<<html
                        <div class="col-12 encuesta_completa">
                            <div class="mb-3 text-dark">
                                <h6 class="">$num_pregunta. {$value['pregunta']}</h6>
                            </div>
                            <input id="id_pregunta_$num_pregunta" value="{$value['id_pregunta_encuesta']}" hidden readonly>
                            <div class="form-group encuesta_curso_$num_pregunta">
html;
                        if ($value['respuesta_correcta'] == 1) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        if ($value['respuesta_correcta'] == 2) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        if ($value['respuesta_correcta'] == 3) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        if ($value['respuesta_correcta'] == 4) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        if ($value['respuesta_correcta'] == 5) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        $encuesta .= <<<html
                            </div>
                        </div>
    
                        <script>
                            $(document).ready(function(){
                                
                                // Pinta la respuesta si es correcta o no
                                console.log({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']});
                                if({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']} == 1){
                                    $('.encuesta_curso_$num_pregunta #op1 input').attr('checked','');
                                    if(!$('.encuesta_curso_$num_pregunta #op1 label').hasClass('text-success')){
                                        $('.encuesta_curso_$num_pregunta #op1 label').removeClass('text-dark').addClass('text-danger');
                                    }
                                } else if({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']} == 2){
                                    $('.encuesta_curso_$num_pregunta #op2 input').attr('checked','');
                                    if(!$('.encuesta_curso_$num_pregunta #op2 label').hasClass('text-success')){
                                        $('.encuesta_curso_$num_pregunta #op2 label').removeClass('text-dark').addClass('text-danger');
                                    }
                                } else if({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']} == 3){
                                    $('.encuesta_curso_$num_pregunta #op3 input').attr('checked','');
                                    if(!$('.encuesta_curso_$num_pregunta #op3 label').hasClass('text-success')){
                                        $('.encuesta_curso_$num_pregunta #op3 label').removeClass('text-dark').addClass('text-danger');
                                    }
                                } else if({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']} == 4){
                                    $('.encuesta_curso_$num_pregunta #op4 input').attr('checked','');
                                    if(!$('.encuesta_curso_$num_pregunta #op4 label').hasClass('text-success')){
                                        $('.encuesta_curso_$num_pregunta #op4 label').removeClass('text-dark').addClass('text-danger');
                                    }
                                }

                                $('.encuesta_curso_$num_pregunta').on('click',function(){
                                    let respuesta = $('.encuesta_curso_$num_pregunta input[name=pregunta_$num_pregunta]:checked');
                                    if($('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' input').prop('checked')){
                                        $('.encuesta_curso_$num_pregunta label').removeClass('opacity-5');
                                        $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').addClass('opacity-5');
                                    }
        
                                    // Pinta la respuesta si es correcta o no
                                    // if(respuesta.val() == {$value['respuesta_correcta']}){
                                    //     $('.encuesta_curso_$num_pregunta label').addClass('text-dark');
                                    //     $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').removeClass('text-dark').addClass('text-success');
                                    // } else {
                                    //     $('.encuesta_curso_$num_pregunta label').addClass('text-dark');
                                    //     $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').removeClass('text-dark').addClass('text-danger');
                                    // }
                                });
                                
                            });
                        </script>
html;
                        $num_pregunta = $num_pregunta + 1;
                    }
                } else {
                    foreach ($preguntas as $key => $value) {
                        $encuesta .= <<<html
                        <div class="col-12 encuesta_completa">
                            <div class="mb-3 text-dark">
                                <h6 class="">$num_pregunta. {$value['pregunta']}</h6>
                            </div>
                            <input id="id_pregunta_$num_pregunta" value="{$value['id_pregunta_encuesta']}" hidden readonly>
                            <div class="form-group encuesta_curso_$num_pregunta">
                                <div id="op1">
                                    <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" required>
                                    <label class="form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                                </div>
    
                                <div id="op2">
                                    <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2">
                                    <label class="form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                                </div>
    
                                <div id="op3">
                                    <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3">
                                    <label class="form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                                </div>
    
                                <div id="op4">
                                    <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4">
                                    <label class="form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                                </div>
                                
                            </div>
                        </div>
    
                        <script>
                            $('.encuesta_curso_$num_pregunta').on('click',function(){
                                let respuesta = $('.encuesta_curso_$num_pregunta input[name=pregunta_$num_pregunta]:checked');
                                if($('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' input').prop('checked')){
                                    $('.encuesta_curso_$num_pregunta label').removeClass('opacity-5');
                                    $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').addClass('opacity-5');
                                }
    
                                // Pinta la respuesta si es correcta o no
                                // if(respuesta.val() == {$value['respuesta_correcta']}){
                                //     $('.encuesta_curso_$num_pregunta label').addClass('text-dark');
                                //     $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').removeClass('text-dark').addClass('text-success');
                                // } else {
                                //     $('.encuesta_curso_$num_pregunta label').addClass('text-dark');
                                //     $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').removeClass('text-dark').addClass('text-danger');
                                // }
                            });
                                
                            
                        </script>
html;
                        $num_pregunta = $num_pregunta + 1;
                    }
                }
            } else {
                $encuesta = <<<html
                <h3 class="text-danger">Aún no hay preguntas para este Curso.</h3>
html;
            }

            $data = new \stdClass();
            $data->_tipo = 2;
            $data->_sala = 1;
            $data->_id_tipo = $id_curso;

            $chat_taller = TransmisionDao::getNewChatByID($data);
            $cont_chat = '';
            $avatar = '';


            foreach ($chat_taller as $chat => $value) {
                $nombre_completo = $value['name_user'] . ' ' . $value['surname'] . ' ' . $value['second_surname'];
                $nombre_completo = utf8_encode($nombre_completo);
                $cont_chat .= <<<html
            <div class="d-flex mt-3">
                <div class="flex-shrink-0">
                    <img alt="Image placeholder" class="avatar rounded-circle" src="../../../img/users_musa/{$value['avatar_img']}">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="h5 mt-0">{$nombre_completo}</h6>
                    <p class="text-sm">{$value['chat']}</p>
                    
                </div>
            </div>
html;
                $avatar = $value['avatar_img'];
            }


            // var_dump($preguntas)

            View::set('clave', $clave);
            View::set('encuesta', $encuesta);
            View::set('id_curso', $id_curso);
            View::set('descripcion', $descripcion);
            View::set('nombre_taller', $nombre_taller);
            View::set('url', $url);
            View::set('btn_encuesta', $btn_encuesta);
            View::set('porcentaje', $porcentaje);
            View::set('contenido_taller', $contenido_taller);
            View::set('progreso_curso', $progreso_curso);
            View::set('secs_totales', $secs_totales);
            View::set('cont_chat', $cont_chat);
            View::set('avatar', $avatar);
            View::set('header', $this->_contenedor->header($extraHeader));
            View::set('footer', $this->_contenedor->footer($extraFooter));
            View::render("video_all");
        } else {
            View::render("404");
        }
    }

    public function Cart()
    {
        $extraHeader = <<<html
html;
        $extraFooter = <<<html
    <!--footer class="footer pt-0">
              <div class="container-fluid">
                  <div class="row align-items-center justify-content-lg-between">
                      <div class="col-lg-6 mb-lg-0 mb-4">
                          <div class="copyright text-center text-sm text-muted text-lg-start">
                              © <script>
                                  document.write(new Date().getFullYear())
                              </script>,
                              made with <i class="fa fa-heart"></i> by
                              <a href="https://www.creative-tim.com" class="font-weight-bold" target="www.grupolahe.com">Creative CMO</a>.
                          </div>
                      </div>
                      <div class="col-lg-6">
                          <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                              <li class="nav-item">
                                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">privacy policies</a>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </footer--    >
          <!-- jQuery -->
            <script src="/js/jquery.min.js"></script>
            <!--   Core JS Files   -->
            <script src="/assets/js/core/popper.min.js"></script>
            <script src="/assets/js/core/bootstrap.min.js"></script>
            <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
            <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
            <!-- Kanban scripts -->
            <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
            <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
            <script src="/assets/js/plugins/chartjs.min.js"></script>
            <script src="/assets/js/plugins/threejs.js"></script>
            <script src="/assets/js/plugins/orbit-controls.js"></script>
            
          <!-- Github buttons -->
            <script async defer src="https://buttons.github.io/buttons.js"></script>
          <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
            <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>

          <!-- VIEJO INICIO -->
            <script src="/js/jquery.min.js"></script>
          
            <script src="/js/custom.min.js"></script>

            <script src="/js/validate/jquery.validate.js"></script>
            <script src="/js/alertify/alertify.min.js"></script>
            <script src="/js/login.js"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
          <!-- VIEJO FIN -->
   <script>
    $( document ).ready(function() {

          $("#form_vacunacion").on("submit",function(event){
              event.preventDefault();
              
                  var formData = new FormData(document.getElementById("form_vacunacion"));
                  for (var value of formData.values()) 
                  {
                     console.log(value);
                  }
                  $.ajax({
                      url:"/Talleres/uploadComprobante",
                      type: "POST",
                      data: formData,
                      cache: false,
                      contentType: false,
                      processData: false,
                      beforeSend: function(){
                      console.log("Procesando....");
                  },
                  success: function(respuesta){
                      if(respuesta == 'success'){
                         // $('#modal_payment_ticket').modal('toggle');
                         
                          swal("¡Se ha guardado tu prueba correctamente!", "", "success").
                          then((value) => {
                              window.location.replace("/Talleres/");
                          });
                      }
                      console.log(respuesta);
                  },
                  error:function (respuesta)
                  {
                      console.log(respuesta);
                  }
              });
          });

        

      });
</script>

html;

        $productos = TalleresDao::getCarritoByIdUser($_SESSION['user_id']);
        $precios = array();
        $total = 0;

        foreach ($productos as $key => $value) {
            // echo $value['precio_publico'];
            if ($value['es_congreso'] == 1 && $value['clave_socio'] == "") {
                $precio = $value['amout_due'];
            } elseif ($value['es_congreso'] == 1 && $value['clave_socio'] != "") {
                $precio = $value['amout_due'];
            } else if ($value['es_servicio'] == 1 && $value['clave_socio'] == "") {
                $precio = $value['precio_publico'];
            } else if ($value['es_servicio'] == 1 && $value['clave_socio'] != "") {
                $precio = $value['precio_socio'];
            } else if ($value['es_curso'] == 1  && $value['clave_socio'] == "") {
                $precio = $value['precio_publico'];
            } else if ($value['es_curso'] == 1  && $value['clave_socio'] != "") {
                $precio = $value['precio_socio'];
            }
            array_push($precios, $precio);
        }

        if (count($productos) >= 1) {
            $style = 'display:flex;';
        } else {
            $style = 'display:none';
        }

        $total = array_sum($precios);

        //get productos
        $nombres_productos = '';
        $productos = TalleresDao::getCarritoByIdUser($_SESSION['user_id']);
        foreach ($productos as $key => $value) {
            // array_push($nombres_productos,$value['nombre']);
            $nombres_productos .= $value['nombre'] . ", ";
        }
        $nombres_productos = substr($nombres_productos, 0, -2);
        $clave = $this->generateRandomString();

        View::set('clave', $clave);
        View::set('producto_s', $nombres_productos);
        View::set('header', $this->_contenedor->header($extraHeader));
        View::set('footer', $this->_contenedor->footer($extraFooter));
        View::set('tabla', $this->getAllProductsCartByUser($_SESSION['user_id']));
        View::set('style', $style);
        View::set('total', intval($total));
        View::render("carrito");
    }

    public function getAllProductsCartByUser($id_user)
    {

        $html = "";
        foreach (TalleresDao::getCarritoByIdUser($id_user) as $key => $value) {

            if ($value['es_congreso'] == 1 && $value['clave_socio'] == "") {
                $precio = $value['amout_due'];
            } elseif ($value['es_congreso'] == 1 && $value['clave_socio'] != "") {
                $precio = $value['amout_due'];
            } else if ($value['es_servicio'] == 1 && $value['clave_socio'] == "") {
                $precio = $value['precio_publico'];
            } else if ($value['es_servicio'] == 1 && $value['clave_socio'] != "") {
                $precio = $value['precio_socio'];
            } else if ($value['es_curso'] == 1  && $value['clave_socio'] == "") {
                $precio = $value['precio_publico'];
            } else if ($value['es_curso'] == 1  && $value['clave_socio'] != "") {
                $precio = $value['precio_socio'];
            }

            $html .= <<<html
            <tr>
                <td >
                    
                    
                    <div class=""> 
                                                   
                            <p><button class="btn btn-danger btn-sm btn-icon-only btn-delete" style="margin-top: 10px; margin-right:10px;" value="{$value['id_carrito']}">x</button><img src="/caratulas/{$value['caratula']}" style="width:100px;heigth:100px; border-radius:8px;"> {$value['nombre']}</p>                       
                    </div>
                </td>
         
                <td style="text-align:left; vertical-align:middle;" > 
                    
                    <div class="text-center">
                        <p>{$precio} - {$value['tipo_moneda']}</p>
                    </div>
                  
                </td>

                <td style="text-align:left; vertical-align:middle;" > 
                    
                    <div class="text-center">
                        <p>{$precio} - {$value['tipo_moneda']}</p>
                    </div>
                
                </td>  

               
        </tr>
html;
        }

        if ($html == "") {

            $html .= <<<html

            <tr>
                    <td class="text-center">
                        
                        
                      
                    
                    </td>  

                    <td class="text-center">
                        
                            
                        No hay productos en su carrito
                    
                    </td>  

                 <td class="text-center">
                        
    
                
                </td>  

                
            </tr>
html;
        }

        return $html;
    }

    public function getNumberPorducts()
    {

        $user_id = $_SESSION['user_id'];

        $getNumberProducts = TalleresDao::getProductsNumber($user_id)[0]['total_productos'];

        echo $getNumberProducts;
    }


    public function searchProductCart()
    {
        $id_producto = $_POST['id_producto'];
        $data = [];
        $getProductCart = TalleresDao::getProductCart($_SESSION['user_id'], $id_producto);

        if ($getProductCart) {
            $data = [
                "msg" => "Este producto ya esta en su cesta",
                "status" => "warning"
            ];
        } else {
            $data = [
                "status" => "success"
            ];
        }

        echo json_encode($data);
    }

    // public function cartShopping(){
    //     $id_producto =  $_POST['id_producto'];


    //     // $producto = TalleresDao::getProductoById($id_producto);

    //     $getProductCart = TalleresDao::getProductCart($_SESSION['user_id'],$id_producto);

    //     if($getProductCart){
    //         $data = [
    //             "msg" => "Este producto ya esta en su cesta",
    //             "status" => "warning"
    //         ];
    //     }else{
    //         $documento = new \stdClass();
    //         $documento->_id_producto = $id_producto;
    //         $documento->_user_id = $_SESSION['user_id'];

    //         $insertProductCart = TalleresDao::insertProductCart($documento);

    //         if($insertProductCart){
    //             $data = [
    //                 "msg" => "Se ingreso el producto a su cesta",
    //                 "status" => "success"
    //             ];
    //         }else{
    //             $data = [
    //                 "msg" => "Error al gurdar el producto",
    //                 "status" => "error"
    //             ];
    //         }
    //     }

    //     echo json_encode($data);
    // }

    public function cartShopping()
    {
        $id_producto =  $_POST['id_producto'];

        // if($id_producto == 24){
        //     $id_p1 = 25;
        //     $id_p2 = 26; 

        // }

        // if($id_producto == 25){
        //     $id_p1 = 24;
        //     $id_p2 = 26; 
        // }

        // if($id_producto == 26){
        //     $id_p1 = 24;
        //     $id_p2 = 25; 

        // }
        // $producto = TalleresDao::getProductoById($id_producto);

        $getProductCart = TalleresDao::getProductCart($_SESSION['user_id'], $id_producto);

        if ($getProductCart) {
            $data = [
                "msg" => "Este producto ya esta en su cesta",
                "status" => "warning"
            ];
        } else {
            $documento = new \stdClass();
            $documento->_id_producto = $id_producto;
            $documento->_user_id = $_SESSION['user_id'];

            $insertProductCart = TalleresDao::insertProductCart($documento);

            if ($insertProductCart) {
                $data = [
                    "msg" => "Se ingreso el producto a su cesta",
                    "status" => "success"
                ];
            } else {
                $data = [
                    "msg" => "Error al gurdar el producto",
                    "status" => "error"
                ];
            }
        }

        echo json_encode($data);
    }

    public function remove()
    {
        $id = $_POST['id'];

        $delete = TalleresDao::deleteItem($id);

        if ($delete) {
            echo "success";
        } else {
            echo "fail";
        }
    }



    public function saveChat()
    {
        $chat = $_POST['txt_chat'];
        $sala = $_POST['sala'];
        $id_tipo = $_POST['id_tipo'];

        $data = new \stdClass();
        $data->_id_registrado = $_SESSION['user_id'];
        $data->_chat = $chat;
        $data->_tipo = 2; //taller
        $data->_id_tipo = $id_tipo;
        $data->_sala = $sala;

        $id = TransmisionDao::insertNewChat($data);

        if ($id) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    public function getChatById()
    {
        $id_tipo = $_POST['id_tipo'];
        $sala = $_POST['sala'];

        $taller = TalleresDao::getPorductById($id_tipo);
        $data = new \stdClass();
        $data->_tipo = 2;
        $data->_sala = $sala;
        $data->_id_tipo = $taller['id_producto'];

        $chat_taller = TransmisionDao::getNewChatByID($data);

        echo json_encode($chat_taller);
    }




    public function savePregunta()
    {
        $pregunta = $_POST['txt_pregunta'];
        $sala = $_POST['sala'];
        $id_tipo = $_POST['id_tipo'];

        $data = new \stdClass();
        $data->_id_registrado = $_SESSION['user_id'];
        $data->_pregunta = $pregunta;
        $data->_tipo = 2; //taller
        $data->_id_tipo = $id_tipo;
        $data->_sala = $sala;

        $id = TransmisionDao::insertNewPregunta($data);

        if ($id) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    public function getPreguntaById()
    {
        $id_tipo = $_POST['id_tipo'];
        $sala = $_POST['sala'];

        $taller = TalleresDao::getPorductById($id_tipo);
        $data = new \stdClass();
        $data->_tipo = 2;
        $data->_sala = $sala;
        $data->_id_tipo = $taller['id_producto'];

        $pregunta_taller = TransmisionDao::getNewPreguntaByID($data);

        echo json_encode($pregunta_taller);
    }






    public function guardarRespuestas()
    {
        $respuestas = $_POST['list_r'];
        $id_curso = $_POST['id_curso'];

        $ha_respondido = TalleresDao::getRespuestasCurso($_SESSION['user_id'], $id_curso);

        // var_dump($respuestas);
        $userData = RegisterDao::getUser($this->getUsuario())[0];

        // var_dump($userData['clave']);

        // exit;

        if ($ha_respondido) {
            // echo 'fail';
            $data = [
                'status' => 'success',
                'clave_user' => $userData['clave']
            ];
            echo json_encode($data);
        } else {
            foreach ($respuestas as $key => $value) {
                $id_pregunta = $value[0];
                $respuesta = $value[1];
                TalleresDao::insertRespuestaProductCurso($_SESSION['user_id'], $id_pregunta, $respuesta);
            }
            // echo 'success';
            $data = [
                'status' => 'success',
                'clave_user' => $userData['clave'],
                'href' => '/Talleres/abrirConstancia/' . $userData['clave'] . '/' . $id_curso,
                'href_download' => 'constancias/' . $userData['clave'] . $id_curso . '.pdf'
            ];
            echo json_encode($data);
        }
    }

    public function updateProgress()
    {
        $progreso = $_POST['segundos'];
        $curso = $_POST['curso'];

        TalleresDao::updateProgresoFechaProducto($curso, $_SESSION['user_id'], $progreso);

        echo 'minuto ' . $progreso . ' ' . $curso;
    }

    public function Vistas()
    {
        $clave = $_POST['clave_video'];
        $vistas = TalleresDao::getCursoByClave($clave)['vistas'];
        $vistas++;

        TalleresDao::updateVistasByClave($clave, $vistas);

        echo $clave;
    }

    public function Likes()
    {
        $clave = $_POST['clave'];
        $id_curso = TalleresDao::getProductCursoByClave($clave)['id_producto'];


        $hay_like = TalleresDao::getlikeProductCurso($id_curso, $_SESSION['user_id']);
        // var_dump($hay_like);

        if ($hay_like) {
            $status = 0;
            if ($hay_like['status'] == 1) {
                $status = 0;
            } else if ($hay_like['status'] == 0) {
                $status = 1;
            }
            TalleresDao::updateLikeProductos($id_curso, $_SESSION['user_id'], $status);
            // echo 'siuu '.$clave;
        } else {
            TalleresDao::insertLikeProducto($id_curso, $_SESSION['user_id']);
            // echo 'nooouuu '.$clave;
        }
    }

    public function uploadComprobante()
    {

        $documento = new \stdClass();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $marca_ = '';
            $usuario = $_POST["user_"];
            $numero_dosis = $_POST['numero_dosis'];
            foreach ($_POST['checkbox_marcas'] as $selected) {
                $marca_ = $selected . "/ ";
            }
            $marca = $marca_;
            $file = $_FILES["file_"];

            $pdf = $this->generateRandomString();

            move_uploaded_file($file["tmp_name"], "comprobante_vacunacion/" . $pdf . '.pdf');

            $documento->_url = $pdf . '.pdf';
            $documento->_user = $usuario;
            $documento->_numero_dosis = $numero_dosis;
            $documento->_marca_dosis = $marca;

            $id = TalleresDao::insert($documento);

            if ($id) {
                echo 'success';
            } else {
                echo 'fail';
            }
        } else {
            echo 'fail REQUEST';
        }
    }

    function generateRandomString($length = 6)
    {
        // return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        return substr(str_shuffle("0123456789"), 0, $length);
    }
}
