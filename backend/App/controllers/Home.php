<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");
require_once dirname(__DIR__) . '/../public/librerias/fpdf/fpdf.php';

use \Core\View;
use \Core\Controller;
use \App\models\Home AS HomeDao;
use App\models\Register as RegisterDao;
use \App\models\Talleres as TalleresDao;
use \App\models\General as GeneralDao;

class Home extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
    }

    public function getUsuario(){
      return $this->__usuario;
    }

    public function index() {
     $extraHeader =<<<html
      <link id="pagestyle" href="/assets/css/style.css" rel="stylesheet" />
      <title>
            Home
      </title>
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

        $permisos_congreso = $data_user['congreso'] != '1' ? "style=\"display:none;\"" : "";

       


        $hay_combo = false;
        $getCombo = HomeDao::getCombo($data_user['user_id']);

        foreach($getCombo as $key => $value){
            
            if(($value['id_producto'] == 38 || $value['id_producto'] == 41) && $value['status'] == 1){
                $numero_talleres = 2;
                $nombre_combo = 'SUPRA Clinical WorkShop 2 hands on';
                $clave = $value['clave'];
                $hay_combo = true;
                
                break;
            }else if(($value['id_producto'] == 37 || $value['id_producto'] == 40) && $value['status'] == 1){
                $numero_talleres = 3;
                $nombre_combo = 'SUPRA Clinical WorkShop 3 hands on';
                $clave = $value['clave'];
                $hay_combo = true;
                
                break;
            }else if(($value['id_producto'] == 36 || $value['id_producto'] == 39) && $value['status'] == 1){
                $numero_talleres = 4;
                $nombre_combo = 'SUPRA Clinical WorkShop 4 hands on';
                $clave = $value['clave'];
                $hay_combo = true;
                break;
            }

            
        }


        if($hay_combo && $data_user['check_talleres'] == 0){
            //seleccionar talleres
            $seleccionar_talleres = 0;
        }else{
            //ya selecciono los talleres
            $seleccionar_talleres = 1;
        }

       

        $comprobante = '';
        $byproducts = '';
            $datos_estudiante = RegisterDao::getEstudiante($_SESSION['usuario']);
            $datos_user_anualidad = RegisterDao::getUserAnualidad($_SESSION['usuario']);
            
            if($datos_user_anualidad){
                $comprobante .= <<<html
                <div class="col-6 m-auto m-md-0 col-lg-3 col-md-3 my-md-3 mt-4">
                    <a href="/ComprobantePago/">
                        <div class="card card-link btn-menu-home m-auto" style="background-image: url(/img/SMNP_Iconos/Web3.png); background-size: contain; background-repeat: no-repeat;">
                            <div class="card-body mt-md-3 text-center content-card-home">
                                <div class="col-12 text-center">
                                </div>
                            </div>
                        </div>                        
                    </a>
                    <a href="/ComprobantePago/">
                        <div class="d-flex justify-content-center">
                        Se está validando tu comprobante de anualidad.
                        </div>
                    </a>
                </div>
html;
                $byproducts = '';
            }
            else if($datos_estudiante){
                $comprobante .= <<<html
                <div class="col-6 m-auto m-md-0 col-lg-3 col-md-3 my-md-3 mt-4">
                    <a href="/ComprobanteEstudiante/">
                        <div class="card card-link btn-menu-home m-auto" style="background-image: url(/img/SMNP_Iconos/Web3.png); background-size: contain; background-repeat: no-repeat;">
                            <div class="card-body mt-md-4 text-center content-card-home">
                                <div class="col-12 text-center">
                                </div>
                            </div>
                        </div>                        
                    </a>
                    <a href="/ComprobanteEstudiante/">
                        <div class="d-flex justify-content-center">
                        Se necesita validar tu comprobante de Residente.
                        </div>
                    </a>
                </div>
html;
                $byproducts = '';
        }else{
            $comprobante .= <<<html
                <div class="col-6 m-auto m-md-0 col-lg-3 col-md-3 my-md-3 mt-4">
                    <a href="/ComprobantePago/">
                        <div class="card card-link btn-menu-home m-auto" style="background-image: url(/img/SMNP_Iconos/Web3.png); background-size: contain; background-repeat: no-repeat;">
                            <div class="card-body mt-md-4 text-center content-card-home">
                                <div class="col-12 text-center">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
html;
            $byproducts .= <<<html
                <div class="col-6 m-auto m-md-0 col-lg-3 col-md-3 my-md-3 mt-4">
                    <a href="/Talleres/byProducts">
                        <div class="card card-link btn-menu-home m-auto" style="background-image: url(/img/SMNP_Iconos/Web2.png); background-size: contain; background-repeat: no-repeat;">
                            <div class="card-body mt-md-4 text-center content-card-home">
                                <div class="col-12 text-center">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
html;
        }

        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer', $this->_contenedor->footer($extraFooter));
        View::set('permisos_congreso',$permisos_congreso);
        View::set('datos',$data_user);
        View::set('comprobante',$comprobante);
        View::set('byproducts',$byproducts);
        View::set('seleccionar_talleres',$seleccionar_talleres);
        // View::set('id_curso',$id_curso);
        View::render("principal_all");
    }

    public function generateModalComprar($datos){
        $modal = <<<html
        <div class="modal fade" id="comprar-curso{$datos['id_curso']}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                Comprar curso
                </h5>

                <span type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
                    X
                </span>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
html;
                                
                              

        return $modal;
    }

    public function getData(){
      echo $_POST['datos'];
    }
    
    public function abrirConstancia($clave, $id_producto, $no_horas = NULL)
    {

        // $this->generaterQr($clave_ticket);
        // echo $clave;

        $productos = HomeDao::getProductosById($id_producto);
        $progresos_productos = HomeDao::getProgresosById($id_producto,$clave);
        $progresos_productos_congreso = HomeDao::getProgresosCongresoById($id_producto,$clave);

        // echo $progresos_productos_congreso['segundos'];
        // exit;

        $nombre_constancia = $productos['nombre_ingles'];

        if ($id_producto == 1) {
            $attend = '';
            $progreso = $progresos_productos_congreso;
            $nombre_constancia = '';
            $fecha = 'June, 21 to 24, 2022';
        } 
        else if ($id_producto == 2) {
            $attend = 'Trans-Congress Course I';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } else if ($id_producto == 3) {
            $attend = 'Trans-Congress Course II';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } else if ($id_producto == 4) {
            $attend = 'Trans-Congress Course III';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } else if ($id_producto == 5) {
            $attend = 'Trans-Congress Course IV';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } else if ($id_producto == 6) {
            $attend = 'Trans-Congress Course V';
            $progreso = $progresos_productos;
            $fecha = 'Thursday 23 June, 2022';
        } 
        else if ($id_producto == 7) {
            $attend = 'Trans-Congress Course VI';
            // $nombre_imagen = 'constancia_transcongreso_7.png';
            $progreso = $progresos_productos;
            $fecha = 'Thursday 23 June, 2022';
        } else if ($id_producto == 8) {
            $attend = 'Trans-Congress Course VII';
            // $nombre_imagen = 'constancia_transcongreso_8.png';
            $progreso = $progresos_productos;
            $fecha = 'Thursday 23 June, 2022';
        } else if ($id_producto == 9) {
            $attend = 'Trans-Congress Course VIII';
            // $nombre_imagen = 'constancia_transcongreso_9.png';
            $progreso = $progresos_productos;
            $fecha = 'Friday 24th, June, 2022';
        }

        $datos_user = GeneralDao::getUserRegisterByClave($clave,$id_producto)[0];

        // $nombre = explode(" ", $datos_user['nombre']);

        // $nombre_completo = $datos_user['prefijo'] . " " . $nombre[0] . " " . $datos_user['apellidop']. " " . $datos_user['apellidom'];
        $nombre_completo = $datos_user['name_user']." ".$datos_user['middle_name']." ".$datos_user['surname']." ".$datos_user['second_surname'];
        $nombre_completo = mb_strtoupper($nombre_completo);

        $nombre = html_entity_decode($datos_user['name_user']);
        $segundo_nombre = html_entity_decode($datos_user['middle_name']);
        $apellido = html_entity_decode($datos_user['surname']);
        $segundo_apellido = html_entity_decode($datos_user['second_surname']);
        $nombre_completo = ($nombre)." ".($segundo_nombre)." ".($apellido)." ".($segundo_apellido);
        $nombre_completo = mb_strtoupper($nombre_completo);

        // echo $nombre_completo;
        // exit;

        $insert_impresion_constancia = HomeDao::insertImpresionConstancia($datos_user['user_id'],'Fisica',$id_producto);
        

        $pdf = new \FPDF($orientation = 'L', $unit = 'mm', $format = 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
        $pdf->setY(1);
        $pdf->SetFont('Arial', 'B', 16);
        // $pdf->Image('constancias/plantillas/constancia_congreso_1.jpeg', 0, 0, 296, 210);
        // $pdf->Image('constancias/plantillas/'.$nombre_imagen, 0, 0, 296, 210);
        // $pdf->SetFont('Arial', 'B', 25);
        // $pdf->Multicell(133, 80, $clave_ticket, 0, 'C');

        //$pdf->Image('1.png', 1, 0, 190, 190);
        $pdf->SetFont('Arial', 'B', 5);    //Letra Arial, negrita (Bold), tam. 20
        //$nombre = utf8_decode("Jonathan Valdez Martinez");
        //$num_linea =utf8_decode("Línea: 39");
        //$num_linea2 =utf8_decode("Línea: 39");
        if($id_producto == 1){
        $pdf->SetXY(15, 82);
        
        $pdf->SetFont('Arial', 'B', 30);
        #4D9A9B
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(273, 30, utf8_decode($nombre_completo), 0, 'C');
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Multicell(275, 25, utf8_decode('Attended the:'), 0, 'C');
        $pdf->SetFont('Arial', '',20);
        if($id_producto == 1){
            $pdf->Multicell(275, 10, utf8_decode($attend).' '.utf8_decode("$nombre_constancia").' ', 0, 'C');
        }else{
        $pdf->Multicell(275, 10, utf8_decode($attend).' "'.utf8_decode("$nombre_constancia").'"', 0, 'C');
        }
        //TIEMPO
        $pdf->SetFont('Arial', 'B',10);
        $pdf->SetXY(158, 177);
        $pdf->Multicell(10, 10, utf8_decode($no_horas), 0, 'C');
        //FECHA
        $pdf->SetFont('Arial', '',10);
        $pdf->SetXY(13, 179.99);
        $pdf->Multicell(275, 10, utf8_decode($fecha), 0, 'C');
        $pdf->Output();
        }
        else{
        $pdf->SetXY(15, 66);
        
        $pdf->SetFont('Arial', 'B', 30);
        #4D9A9B
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(273, 20, utf8_decode($nombre_completo), 0, 'C');
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Multicell(275, 20, utf8_decode('Attended the:'), 0, 'C');
        $pdf->SetFont('Arial', '',20);
        if($id_producto == 1){
            $pdf->Multicell(275, 10, utf8_decode($attend).' '.utf8_decode("$nombre_constancia").' ', 0, 'C');
        }else{
        $pdf->Multicell(275, 10, utf8_decode($attend).' "'.utf8_decode("$nombre_constancia").'"', 0, 'C');
        }
        //TIEMPO
        $pdf->SetFont('Arial', 'B',10);
        $pdf->SetXY(158, 177);
        $pdf->Multicell(10, 10, utf8_decode('5'), 0, 'C');
        //FECHA
        $pdf->SetFont('Arial', '',10);
        $pdf->SetXY(13, 179.99);
        $pdf->Multicell(275, 10, utf8_decode($fecha), 0, 'C');
        $pdf->Output();
            
        }
        // $pdf->Output('F','constancias/'.$clave.$id_curso.'.pdf');

        // $pdf->Output('F', 'C:/pases_abordar/'. $clave.'.pdf');
    }

    public function abrirConstanciaDigital($clave, $id_producto, $no_horas = NULL)
    {

        // $this->generaterQr($clave_ticket);
        // echo $clave;

        $productos = HomeDao::getProductosById($id_producto);
        $progresos_productos = HomeDao::getProgresosById($id_producto,$clave);
        $progresos_productos_congreso = HomeDao::getProgresosCongresoById($id_producto,$clave);

        // echo $progresos_productos_congreso['segundos'];
        // exit;

        $nombre_constancia = $productos['nombre_ingles'];

        if ($id_producto == 1) {
            $attend = '';
            $progreso = $progresos_productos_congreso;
            $nombre_constancia = '';
            $fecha = 'June, 21 to 24, 2022';
        } 
        else if ($id_producto == 2) {
            $attend = 'Trans-Congress Course I';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } else if ($id_producto == 3) {
            $attend = 'Trans-Congress Course II';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } else if ($id_producto == 4) {
            $attend = 'Trans-Congress Course III';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } else if ($id_producto == 5) {
            $attend = 'Trans-Congress Course IV';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } else if ($id_producto == 6) {
            $attend = 'Trans-Congress Course V';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } 
        else if ($id_producto == 7) {
            $attend = 'Trans-Congress Course VI';
            // $nombre_imagen = 'constancia_transcongreso_7.png';
            $progreso = $progresos_productos;
            $fecha = 'Thursday 23 June, 2022';
        } else if ($id_producto == 8) {
            $attend = 'Trans-Congress Course VII';
            // $nombre_imagen = 'constancia_transcongreso_8.png';
            $progreso = $progresos_productos;
            $fecha = 'Thursday 23 June, 2022';
        } else if ($id_producto == 9) {
            $attend = 'Trans-Congress Course VIII';
            // $nombre_imagen = 'constancia_transcongreso_9.png';
            $progreso = $progresos_productos;
            $fecha = 'Friday 24th, June, 2022';
        }

        $datos_user = GeneralDao::getUserRegisterByClave($clave,$id_producto)[0];

        // $nombre = explode(" ", $datos_user['nombre']);

        // $nombre_completo = $datos_user['prefijo'] . " " . $nombre[0] . " " . $datos_user['apellidop']. " " . $datos_user['apellidom'];
        $nombre_completo = $datos_user['name_user']." ".$datos_user['middle_name']." ".$datos_user['surname']." ".$datos_user['second_surname'];
        $nombre_completo = mb_strtoupper($nombre_completo);

        $nombre = html_entity_decode($datos_user['name_user']);
        $segundo_nombre = html_entity_decode($datos_user['middle_name']);
        $apellido = html_entity_decode($datos_user['surname']);
        $segundo_apellido = html_entity_decode($datos_user['second_surname']);
        $nombre_completo = ($nombre)." ".($segundo_nombre)." ".($apellido)." ".($segundo_apellido);
        $nombre_completo = mb_strtoupper($nombre_completo);

        // echo $nombre_completo;
        // exit;
        $insert_impresion_constancia = HomeDao::insertImpresionConstancia($datos_user['user_id'],'Digital',$id_producto);
        

        $pdf = new \FPDF($orientation = 'L', $unit = 'mm', $format = 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
        $pdf->setY(1);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('constancias/plantillas/constancia_congreso_1.jpeg', 0, 0, 296, 210);
        // $pdf->Image('constancias/plantillas/'.$nombre_imagen, 0, 0, 296, 210);
        // $pdf->SetFont('Arial', 'B', 25);
        // $pdf->Multicell(133, 80, $clave_ticket, 0, 'C');

        //$pdf->Image('1.png', 1, 0, 190, 190);
        $pdf->SetFont('Arial', 'B', 5);    //Letra Arial, negrita (Bold), tam. 20
        //$nombre = utf8_decode("Jonathan Valdez Martinez");
        //$num_linea =utf8_decode("Línea: 39");
        //$num_linea2 =utf8_decode("Línea: 39");
        
        if($id_producto == 1){
            $pdf->SetXY(15, 80);
            
            $pdf->SetFont('Arial', 'B', 30);
            #4D9A9B
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Multicell(273, 30, utf8_decode($nombre_completo), 0, 'C');
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Multicell(275, 25, utf8_decode('Attended the:'), 0, 'C');
            $pdf->SetFont('Arial', '',20);
            if($id_producto == 1){
                $pdf->Multicell(275, 10, utf8_decode($attend).' '.utf8_decode("$nombre_constancia").' ', 0, 'C');
            }else{
            $pdf->Multicell(275, 10, utf8_decode($attend).' "'.utf8_decode("$nombre_constancia").'"', 0, 'C');
            }
            // $pdf->SetFont('Arial', 'B',10);
            // $pdf->SetXY(156, 170.5);
            // $pdf->Multicell(10, 10, utf8_decode(round($progreso['segundos']/3600)), 0, 'C');
            //TIEMPO
            $pdf->SetFont('Arial', 'B',10);
            $pdf->SetXY(157, 170.5);
            $pdf->Multicell(10, 10, utf8_decode($no_horas), 0, 'C');
            $pdf->SetFont('Arial', '',10);
            $pdf->SetXY(13, 175);
            $pdf->Multicell(275, 10, utf8_decode($fecha), 0, 'C');
            $pdf->Output();
            }
            else{
            $pdf->SetXY(15, 66);
            
            $pdf->SetFont('Arial', 'B', 30);
            #4D9A9B
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Multicell(273, 20, utf8_decode($nombre_completo), 0, 'C');
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Multicell(275, 20, utf8_decode('Attended the:'), 0, 'C');
            $pdf->SetFont('Arial', '',20);
            if($id_producto == 1){
                $pdf->Multicell(275, 10, utf8_decode($attend).' '.utf8_decode("$nombre_constancia").' ', 0, 'C');
            }else{
            $pdf->Multicell(275, 10, utf8_decode($attend).' "'.utf8_decode("$nombre_constancia").'"', 0, 'C');
            }
            // $pdf->SetFont('Arial', 'B',10);
            // $pdf->SetXY(156, 170.5);
            // $pdf->Multicell(10, 10, utf8_decode(round($progreso['segundos']/3600)), 0, 'C');
            //TIEMPO
            $pdf->SetFont('Arial', 'B',10);
            $pdf->SetXY(156, 170.5);
            $pdf->Multicell(10, 10, utf8_decode('5'), 0, 'C');
            //FECHA
            $pdf->SetFont('Arial', '',10);
            $pdf->SetXY(13, 175);
            $pdf->Multicell(275, 10, utf8_decode($fecha), 0, 'C');
            $pdf->Output();
                
            }
        // $pdf->Output('F','constancias/'.$clave.$id_curso.'.pdf');

        // $pdf->Output('F', 'C:/pases_abordar/'. $clave.'.pdf');
    }
}
