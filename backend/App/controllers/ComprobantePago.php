<?php

namespace App\controllers;

defined("APPPATH") or die("Access denied");
require_once dirname(__DIR__) . '/../public/librerias/fpdf/fpdf.php';

use \Core\View;
use \Core\Controller;
use \App\models\ComprobantePago as ComprobantePagoDao;
use \App\models\Talleres as TalleresDao;
use \App\models\Register as RegisterDao;
use Core\App;
use DOMDocument;
use nusoap_client;
use ZipArchive;

class ComprobantePago extends Controller
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

        View::set('tabla', $this->getAllComprobantesPagoById($_SESSION['user_id']));
        View::set('header', $this->_contenedor->header($extraHeader));
        View::render("comprobante_pago_all");
    }




    public function getAllComprobantesPagoById($id_user)
    {

        $html = "";
        foreach (ComprobantePagoDao::getAllComprobantes($id_user) as $key => $value) {

            $total_array = array();
            $array_pro = array();
            $precio = 0;

            // if ($value['status'] == 0) {
            //     // $icon_status = '<i class="fa fad fa-hourglass" style="color: #4eb8f7;"></i>';
            //     $status = '<span class="badge badge-info">En espera de validación</span>';
            // } else if ($value['status'] == 1) {
            //     // $icon_status = '<i class="far fa-check-circle" style="color: #269f61;"></i>';
            //     $status = '<span class="badge badge-success">Aceptado</span>';
            // } else {
            //     // $icon_status = '<i class="far fa-times-circle" style="color: red;"></i>';
            //     $status = '<span class="badge badge-danger">Carga un Archivo PDF valido</span>';
            // }

            if ($value['tipo_pago'] == "Efectivo" || $value['tipo_pago'] == "Transferencia" || $value['tipo_pago'] == "" || $value['tipo_pago'] == "Registro_Becado") {

                $reimprimir_ticket = '<a href="/comprobantePago/ticketImp/' . $value["clave"] . '" class="btn bg-pink btn-icon-only morado-musa-text text-center"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Reimprimir Ticket" target="_blank"><i class="fas fa-print"></i></a>';
            } else if ($value['tipo_pago'] == "Paypal" && empty($value['url_archivo'])) {
                $total_array_paypal = array();
                $nombre_producto = '';

                foreach (ComprobantePagoDao::getAllComprobantesStatusCero($id_user, $value['clave']) as $key => $value) {



                    $precio = $value['monto'];

                    array_push($total_array_paypal, $precio);

                    $nombre_producto .= $value['nombre'] . ",";

                    $array_productos = [
                        'id_product' => $value['id_producto']
                    ];

                    array_push($array_pro, $array_productos);
                }

                $array_pro = json_encode($array_pro);

                $total_paypal = array_sum($total_array_paypal);
                $reimprimir_ticket = "<form method='POST'  action='https://www.paypal.com/es/cgi-bin/webscr' data-form-paypal=" . $value['id_pendiente_pago'] . " class='form-paypal'>
                                        <input type='hidden' name='business' value='pagos@grupolahe.com'> 
                                        <input type='hidden' name='item_name' value='" . $nombre_producto . "'> 
                                        <input type='hidden' name='item_number' value='" . $value['clave'] . "'> 
                                        <input type='hidden' name='amount' value='" . $total_paypal . "'> 
                                        <input type='hidden' name='currency_code' value='" . $value['tipo_moneda'] . "'> 
                                        <input type='hidden' name='notify_url' value=''> 
                                        <input type='hidden' name='return' value='https://registro.lasra-mexico.org/OrdenPago/PagoExistoso/?productos=$array_pro'> 
                                        <input type='hidden' name='cmd' value='_xclick'>  
                                        <input type='hidden' name='order' value='" . $value['clave'] . "'>  
                                        <input name='upload' type='hidden' value='1' />              
                                        <button class='btn btn-primary btn-only-icon mt-2 btn_pay_paypal' type='button'>Realizar pago Paypal</button>
                                    </form>";

                $nombre_producto = '';
            } else if ($value['tipo_pago'] == "Paypal" && !empty($value['url_archivo'])) {
                $reimprimir_ticket = '';
            }


            if ($value['tipo_pago'] == "Transferencia" && empty($value['url_archivo']) || $value['status'] == 2) {
                $button_comprobante = '<form method="POST" enctype="multipart/form-data" action="/ComprobantePago/uploadComprobante" data-id-pp=' . $value["id_pendiente_pago"] . ' id="file">
                                    <input type="hidden" name="id_pendiente_pago" id="id_pendiente_pago" value="' . $value["id_pendiente_pago"] . '"/>
                                    <input type="hidden" name="clave" id="clave" value="' . $value["clave"] . '"/>
                                    <span class="badge badge-info" style="font-size:8px;">Subir archivo jpg, jpeg, png ó pdf con un tamaño maximo de 5 mb</span>                                    
                                    <input type="file" accept="image/*,.pdf" class="form-control mt-1 " id="file_input" name="file_input" style="width: auto; margin: 0 auto;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="">
                                    <button class="btn btn-primary btn-only-icon mt-2 d-none" id="btn_submit" type="submit">Subir</button>
                                    </form>';
            } else if ($value['tipo_pago'] == "Paypal") {
                $button_comprobante = '';
            } else if ($value['tipo_pago'] == "Tarjeta_Credito" || $value['tipo_pago'] == 'Tarjeta_Debito') {
                $button_comprobante = '<a href="/Register/ticketImpCompraU/' . $value['clave'] . '/' . base64_encode($this->getUsuario()) . '" class="btn bg-pink btn-icon-only morado-musa-text text-center"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Ver mi comprobante" target="_blank"><i class="fas fa-file"> </i></a>';
            } else {
                $button_comprobante = '<a href="/comprobantesPago/' . $_SESSION['user_id'] . '/' . $value["url_archivo"] . '" class="btn bg-pink btn-icon-only morado-musa-text text-center"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Ver mi comprobante" target="_blank"><i class="fas fa-file"> </i></a>';
            }

            if (($value['tipo_pago'] == "Transferencia" || $value['tipo_pago'] == "Tarjeta_Credito" || $value['tipo_pago'] == 'Tarjeta_Debito') &&  $value['status'] == 1) {

                $getFactura =  ComprobantePagoDao::getFacturas($value['clave']);
                if (count($getFactura) > 0) {
                    $button_factura = '<button class="btn btn-icon-only" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Ver Factura"><i class="far fa-file"></i></button>';
                } else {

                    $button_factura = '<button class="btn btn-icon-only btn_factura" data-clave="'.$value['clave'].'" data-userid="'.$_SESSION['user_id'].'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Facturar"><i class="far fa-file"></i></button>';
                }
            } else {
                $button_factura = '';
            }


            $html .= <<<html
        <tr>
            <td style="width:70%">
                <div class="text-center"> 
html;

            foreach (ComprobantePagoDao::getAllComprobantesbyClave($id_user, $value['clave']) as $key => $value2) {



                // if($value2['es_congreso'] == 1 && $value2['clave_socio'] == ""){
                //     $precio = $value2['amout_due'];
                //     // $precio = $value2['precio_publico'];
                // }elseif($value2['es_congreso'] == 1 && $value2['clave_socio'] != ""){
                //     $precio = $value2['amout_due'];
                // }
                // else if($value2['es_servicio'] == 1 && $value2['clave_socio'] == ""){
                //     $precio = $value2['precio_publico'];
                // }else if($value2['es_servicio'] == 1 && $value2['clave_socio'] != ""){
                //     $precio = $value2['precio_socio'];
                // }
                // else if($value2['es_curso'] == 1  && $value2['clave_socio'] == ""){
                //     $precio = $value2['precio_publico'];
                // }else if($value2['es_curso'] == 1  && $value2['clave_socio'] != ""){
                //     $precio = $value2['precio_socio'];
                // }

                $precio = $value2['monto'];


                if ($value2['comprado_en'] == 1) {
                    $comprado_en = '<span style="text-decoration: underline;">Sito web</span>';
                } else if ($value2['comprado_en'] == 2) {
                    $comprado_en = '<span style="text-decoration: underline;">Caja</span>';
                } else {
                    $comprado_en = '';
                }


                if ($value2['status'] == 0) {
                    $icon_status = '<i class="fa fad fa-hourglass" style="color: #4eb8f7;"></i>';
                    $status = '<span class="badge badge-info">En espera de validación</span>';
                } else if ($value2['status'] == 1) {
                    $icon_status = '<i class="far fa-check-circle" style="color: #269f61;"></i>';
                    $status = '<span class="badge badge-success">Aceptado</span>';
                } else {
                    $icon_status = '<i class="far fa-times-circle" style="color: red;"></i>';
                    $status = '<span class="badge badge-danger">Carga un archivo válido</span>';
                }

                if ($value2['status'] == 0 || $value2['status'] == 2) {
                    array_push($total_array, $precio);

                    $precio = number_format($precio, 2);
                } else {
                    $reimprimir_ticket = '';
                }

                $html .= <<<html
                        <p>{$icon_status} {$value2['nombre']} $ {$precio} {$comprado_en} - {$status}</p>
html;
            }
            $total = number_format(array_sum($total_array), 2);

            $tipo_pago_split = explode("_", $value['tipo_pago']);
            // <p>{$icon_status} {$value['nombre']}</p>                       
            $html .= <<<html
                </div>
            </td>
     
            

            <td style="text-align:left; vertical-align:middle;" >                 
                <div class="text-center">                
                <p>$ {$total} {$value['tipo_moneda']}</p>
            </div>
          
        </td>

            <td style="text-align:left; vertical-align:middle;" > 
                
                <div class="text-center">
                    <p>{$tipo_pago_split[0]} {$tipo_pago_split[1]}</p>
                </div>
            
            </td>  

            <td>
                {$reimprimir_ticket}
            </td>

            
            <td  class="text-center">
               {$button_comprobante}
                
            </td>

            <td  class="text-center">
                {$button_factura}
                
            </td>

    </tr>
html;
        }

        return $html;
    }

    // //anterior
    // public function ticketImp($clave)
    // {

    //     date_default_timezone_set('America/Mexico_City');


    //     $metodo_pago = $_POST['metodo_pago'];
    //     $user_id = $_SESSION['user_id'];        
    //     $datos_user = RegisterDao::getUser($this->getUsuario())[0];
    //     $productos = TalleresDao::getTicketUserCompra($user_id, $clave);


    //     // $fecha =  date("Y-m-d"); 
    //     $fecha = $productos[0]['fecha_asignacion'];
    //     // $d = $this->fechaCastellano($fecha);
    //     $nombre_completo = $datos_user['nombre'] . " " . $datos_user['apellidom'] . " " . $datos_user['apellidop'];


    //     $pdf = new \FPDF($orientation = 'P', $unit = 'mm', $format = 'A4');
    //     $pdf->AddPage();
    //     $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
    //     $pdf->setY(1);
    //     $pdf->SetFont('Arial', 'B', 16);
    //     $pdf->Image('constancias/plantillas/orden_cmo.jpeg', 0, 0, 210, 300);
    //     // $pdf->SetFont('Arial', 'B', 25);
    //     // $pdf->Multicell(133, 80, $clave_ticket, 0, 'C');

    //     $espace = 142;
    //     $total = array();
    //     foreach ($productos as $key => $value) {


    //         $precio = $value['monto'];

    //         array_push($total, $precio);

    //         //Nombre Curso
    //         $pdf->SetXY(28, $espace);
    //         $pdf->SetFont('Arial', 'B', 8);
    //         $pdf->SetTextColor(0, 0, 0);
    //         $pdf->Multicell(100, 4, utf8_decode($value['nombre']), 0, 'C');

    //         //Costo
    //         $pdf->SetXY(135, $espace);
    //         $pdf->SetFont('Arial', 'B', 8);
    //         $pdf->SetTextColor(0, 0, 0);
    //         $pdf->Multicell(100, 4, '$ ' . $precio . ' ' . $value['tipo_moneda'], 0, 'C');

    //         $espace = $espace + 8;
    //     }

    //     //folio
    //     $pdf->SetXY(1, 75);
    //     $pdf->SetFont('Arial', 'B', 13);
    //     $pdf->SetTextColor(0, 0, 0);
    //     $pdf->Multicell(100, 10, $productos[0]['clave'], 0, 'C');

    //     //fecha
    //     $pdf->SetXY(1, 110);
    //     $pdf->SetFont('Arial', 'B', 13);
    //     $pdf->SetTextColor(0, 0, 0);
    //     $pdf->Multicell(100, 10, $fecha, 0, 'C');

    //     // //nombre
    //     // $pdf->SetXY(88, 80);
    //     // $pdf->SetFont('Arial', 'B', 13);
    //     // $pdf->SetTextColor(0, 0, 0);
    //     // $pdf->Multicell(100, 10, utf8_decode($nombre_completo), 0, 'C');

    //      //total
    //     $pdf->SetXY(135, 255);
    //     $pdf->SetFont('Arial', 'B', 8);  
    //     $pdf->SetTextColor(0, 0, 0);
    //     $pdf->Multicell(100, 10,'$ '. number_format(array_sum($total),2).' '.$productos[0]['tipo_moneda'], 0, 'C');

    //     $pdf->Output();
    //     // $pdf->Output('F','constancias/'.$clave.$id_curso.'.pdf');

    //     // $pdf->Output('F', 'C:/pases_abordar/'. $clave.'.pdf');
    // }

    public function ticketImp($clave)
    {

        date_default_timezone_set('America/Mexico_City');


        $user_id = $_SESSION['user_id'];
        // $clave = $this->generateRandomString();
        $datos_user = RegisterDao::getUser($this->getUsuario())[0];
        $productos = TalleresDao::getTicketUser($user_id, $clave);


        $fecha =  date("Y-m-d");

        $fecha_limite = date("d-m-Y", strtotime($fecha . "+ 5 days"));

        // $d = $this->fechaCastellano($fecha);

        $nombre_completo = $datos_user['nombre'] . " " . $datos_user['apellidom'] . " " . $datos_user['apellidop'];


        $pdf = new \FPDF($orientation = 'P', $unit = 'mm', $format = 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
        $pdf->setY(1);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('constancias/plantillas/orden5.png', 0, 0, 210, 300);
        // $pdf->SetFont('Arial', 'B', 25);
        // $pdf->Multicell(133, 80, $clave_ticket, 0, 'C');

        $espace = 142;
        $total = array();
        foreach ($productos as $key => $value) {


            $precio = $value['monto'];

            $metodo_pago = $value['tipo_pago'];

            $tipo_moneda = $value['t_moneda'];

            array_push($total, $precio);

            // //Nombre Curso
            // $pdf->SetXY(28, $espace);
            // $pdf->SetFont('Arial', 'B', 8);
            // $pdf->SetTextColor(0, 0, 0);
            // $pdf->Multicell(100, 4, utf8_decode($value['nombre']), 0, 'C');

            // //Costo
            // $pdf->SetXY(129, $espace);
            // $pdf->SetFont('Arial', 'B', 8);
            // $pdf->SetTextColor(0, 0, 0);
            // $pdf->Multicell(100, 4, '$ ' . $precio . ' ' . $value['tipo_moneda'], 0, 'C');

            $espace = $espace + 10;
        }

        //folio
        $pdf->SetXY(3, 137);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(80, 10, $clave . '-' . $user_id, 0, 'C');

        //fecha
        $pdf->SetXY(6, 152);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, $fecha_limite, 0, 'C');

        //nombre
        $pdf->SetXY(10, 61);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, utf8_decode($nombre_completo), 0, 'C');

        //metodo pago
        $pdf->SetXY(16, 68);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(80, 10, utf8_decode($metodo_pago), 0, 'C');

        //numero de cuenta
        $pdf->SetXY(17, 92);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(80, 10, '0448759103', 0, 'C');

        //numero de cuenta clabe
        $pdf->SetXY(35, 99);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(80, 10, '012180004487591033', 0, 'C');

        //numero banco
        $pdf->SetXY(8, 114);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(80, 10, 'BBVA Sucursal 3646', 0, 'C');

        //nombre
        $pdf->SetXY(27, 121.5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, utf8_decode('Colegio Mexicano de Ortopedia y Traumatología A.C.'), 0, 'C');

        //descripcion
        $pdf->SetXY(13, 170);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(190, 5, utf8_decode('Favor de enviar copia de su depósito junto con sus datos de contacto al correo electrónico atencionsocios@smo.edu.mx'), 0, 'L');



        // total
        $pdf->SetXY(2, 144.5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, number_format(array_sum($total), 2) . ' ' . $tipo_moneda, 0, 'C');

        $pdf->Output();
        // $pdf->Output('F','constancias/'.$clave.$id_curso.'.pdf');

        // $pdf->Output('F', 'C:/pases_abordar/'. $clave.'.pdf');
    }

    public function uploadComprobante()
    {
        $numero_rand = $this->generateRandomString();
        $id_pendiente_pago = $_POST['id_pendiente_pago'];
        $clave = $_POST['clave'];
        $file = $_FILES["file_input"];
        $name_archivo = '';


        $formatos_permitidos_img = array("image/jpg", "image/jpeg", "image/gif", "image/png");

        if (in_array($_FILES['file_input']['type'], $formatos_permitidos_img)) {

            $tipos  = $_FILES['file_input']['type'];
            $tipo = explode("/", $tipos);
            $name_archivo = $numero_rand . '.' . $tipo[1];
        } else {
            $name_archivo = $numero_rand . '.pdf';
        }

        $nombre_fichero = 'comprobantesPago/' . $_SESSION['user_id'];


        if (!file_exists($nombre_fichero)) {
            mkdir('comprobantesPago/' . $_SESSION['user_id'], 0777, true);
        }

        if ($file['name'] != "") {

            // if (move_uploaded_file($file["tmp_name"], "comprobantesPago/" . $numero_rand . ".pdf")) {
            if (move_uploaded_file($file["tmp_name"], "comprobantesPago/" . $_SESSION['user_id'] . "/" . $name_archivo)) {

                $documento = new \stdClass();
                $documento->_id_pendiente_pago = $id_pendiente_pago;
                $documento->_clave = $clave;
                $documento->_url = $name_archivo;

                $id = ComprobantePagoDao::updateComprobante($documento);

                if ($id) {

                    // $data = [
                    //     'status' => 'success',
                    //     'img' => $numero_rand.'.png'
                    // ];
                    // echo "success";

                    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                    
                   <script>
                        $(document).ready(function () {
                            Swal.fire({
                                title: "¡Archivo subido con éxito!",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(function(result){
                                window.location.href = /ComprobantePago/;
                             });
                        });
                    </script>';
                } else {
                    // echo "fail";


                    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                    
                   <script>
                        $(document).ready(function () {
                            Swal.fire({
                                title: "¡Hubo un error al subir el archivo!",
                                icon: "error",
                                confirmButtonText: "OK"
                            }).then(function(result){
                                window.location.href = /ComprobantePago/;
                             });
                        });
                    </script>';

                    // $data = [
                    //     'status' => 'fail'

                    // ];
                }
            } else {


                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                    
                   <script>
                        $(document).ready(function () {
                            Swal.fire({
                                title: "¡Hubo un error al subir el archivo!",
                                icon: "error",
                                confirmButtonText: "OK"
                            }).then(function(result){
                                window.location.href = /ComprobantePago/;
                             });
                        });
                    </script>';
            }
            // move_uploaded_file($file["tmp_name"], "comprobantesPago/".$numero_rand.".pdf");

            // echo json_encode($data);


        } else {
            echo "<script>
                 alert('No selecciono ningun archivo');
                window.location.href = /ComprobantePago/;
            </script>";
        }
    }

    function fechaCastellano($fecha)
    {
        $fecha = substr($fecha, 0, 10);
        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));

        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

        return $nombredia . " " . $numeroDia . " de " . $nombreMes . " de " . $anio;
    }

    function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    function busUsoCfdi($cfdi){
        $cfdi = ComprobantePagoDao::busUsoCfdi($cfdi);
        return $cfdi['clave_uso_cfdi'];
    }

    function generarXmlFacturacion_3_3()
    { //Datos para AMN
        // $idSocio, $idCompra, $datos
        $idSocio = $_POST['user_id'];
        $idCompra = $_POST['clave'];
        
        // try {
            // $datosFiscalesSocio = $this->model->datosFiscales($idSocio)[0];
            $datosFiscalesSocio = ComprobantePagoDao::datosFiscales($idSocio);
            // $conceptos = $this->model->buscarDetalleCompra($idCompra, $idSocio);
            $conceptos = ComprobantePagoDao::buscarDetalleCompra($idCompra, $idSocio);

            $xml = new DOMDocument('1.0', 'UTF-8');

            $comprobante = $xml->createElement('cfdi:Comprobante');
            //$comprobante->setAttribute("Sello", $this->sello);//Se genera después y lo anexamos
            $comprobante->setAttribute("xmlns:cfdi", "http://www.sat.gob.mx/cfd/3");
            $comprobante->setAttribute("xmlns:detallista", "http://www.sat.gob.mx/detallista");
            $comprobante->setAttribute("xmlns:divisas", "http://www.sat.gob.mx/divisas");
            $comprobante->setAttribute("xmlns:implocal", "http://www.sat.gob.mx/implocal");
            $comprobante->setAttribute("xmlns:xs", "http://www.w3.org/2001/XMLSchema");
            $comprobante->setAttribute("xmlns:ecb", "http://www.sat.gob.mx/ecb");
            $comprobante->setAttribute("xmlns:ecc", "http://www.sat.gob.mx/ecc");
            $comprobante->setAttribute("xmlns:tfd", "http://www.sat.gob.mx/TimbreFiscalDigital");
            $comprobante->setAttribute("xmlns:terceros", "http://www.sat.gob.mx/terceros");
            $comprobante->setAttribute("xmlns:donat", "http://www.sat.gob.mx/donat");
            $comprobante->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
            $comprobante->setAttribute("xsi:schemaLocation", "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd");
            $subtotal_conceptos = 0;
            $impuestostrasladados = 0;
            $existen_impuestos = false;
            if ($conceptos != NULL) {
                foreach ($conceptos as $value) {
                    if ($value['iva_producto'] == 1) {
                        $costo_producto = number_format(($value['monto'] / 1.16), 2, '.', '');
                    } else {
                        $costo_producto = number_format(($value['monto']), 2, '.', '');
                    }
                    $subtotal_conceptos = $subtotal_conceptos + trim(preg_replace('/\s\s+/', ' ', $costo_producto));
                    if ($value['iva_producto'] == 1) {
                        $impuestostrasladados = $impuestostrasladados + number_format(trim(preg_replace('/\s\s+/', ' ', $costo_producto)) * 0.16, 2, ".", "");
                        $existen_impuestos = true;
                    } else {
                        //$impuestostrasladados = $impuestostrasladados + number_format(trim(preg_replace('/\s\s+/', ' ', number_format(($concepto['precio_compras'] / 1.16),2,'.',''))) * 0.16,2,".","");
                    }
                }
                //$subtotal = $subtotal_conceptos;
                $total = $subtotal_conceptos + $impuestostrasladados;
            }

          
            $comprobante->setAttribute("Moneda", "MXN");
            $comprobante->setAttribute("TipoCambio", "1");
            $comprobante->setAttribute("Version", "3.3");
            $comprobante->setAttribute("Serie", "CMO");
            $comprobante->setAttribute("Folio", $idCompra);
            $comprobante->setAttribute("Fecha", date("Y-m-d") . "T" . date("H:i:s"));
            $comprobante->setAttribute("TipoDeComprobante", "I");
            /* $comprobante->setAttribute("NoCertificado", "00001000000504291812");//Sacado del archivo guia de amegonline.com (impre_recibo_3.3.php)AMEG */
            $comprobante->setAttribute("NoCertificado", "00001000000511136211"); //Sacado del archivo guia de registroenlinea.mx (impre_Recibo1.php)AMN
            /* $comprobante->setAttribute("Certificado", "LS0tLS1CRUdJTiBDRVJUSUZJQ0FURS0tLS0tCk1JSUd0akNDQko2Z0F3SUJBZ0lVTURBd01ERXdNREF3TURBMU1EUXlPVEU0TVRJd0RRWUpLb1pJaHZjTkFRRUwKQlFBd2dnR0VNU0F3SGdZRFZRUUREQmRCVlZSUFVrbEVRVVFnUTBWU1ZFbEdTVU5CUkU5U1FURXVNQ3dHQTFVRQpDZ3dsVTBWU1ZrbERTVThnUkVVZ1FVUk5TVTVKVTFSU1FVTkpUMDRnVkZKSlFsVlVRVkpKUVRFYU1CZ0dBMVVFCkN3d1JVMEZVTFVsRlV5QkJkWFJvYjNKcGRIa3hLakFvQmdrcWhraUc5dzBCQ1FFV0cyTnZiblJoWTNSdkxuUmwKWTI1cFkyOUFjMkYwTG1kdllpNXRlREVtTUNRR0ExVUVDUXdkUVZZdUlFaEpSRUZNUjA4Z056Y3NJRU5QVEM0ZwpSMVZGVWxKRlVrOHhEakFNQmdOVkJCRU1CVEEyTXpBd01Rc3dDUVlEVlFRR0V3Sk5XREVaTUJjR0ExVUVDQXdRClEwbFZSRUZFSUVSRklFMUZXRWxEVHpFVE1CRUdBMVVFQnd3S1ExVkJWVWhVUlUxUFF6RVZNQk1HQTFVRUxSTU0KVTBGVU9UY3dOekF4VGs0ek1Wd3dXZ1lKS29aSWh2Y05BUWtDRTAxeVpYTndiMjV6WVdKc1pUb2dRVVJOU1U1SgpVMVJTUVVOSlQwNGdRMFZPVkZKQlRDQkVSU0JUUlZKV1NVTkpUMU1nVkZKSlFsVlVRVkpKVDFNZ1FVd2dRMDlPClZGSkpRbFZaUlU1VVJUQWVGdzB5TURBMk1qUXlNakE1TXpkYUZ3MHlOREEyTWpReU1qQTVNemRhTUlJQmd6RkoKTUVjR0ExVUVBeE5BUVZOUFEwbEJRMGxQVGlCTlJWaEpRMEZPUVNCRVJTQkZUa1JQVTBOUFVFbEJJRWRCVTFSUwpUMGxPVkVWVFZFbE9RVXdnV1NCRFQweEZSMGxQSUVSRklERmFNRmdHQTFVRUtSTlJRVk5QUTBsQlEwbFBUaUJOClJWaEpRMEZPUVNCRVJTQkZUa1JQVTBOUFVFbEJJRWRCVTFSU1QwbE9WRVZUVkVsT1FVd2dXU0JEVDB4RlIwbFAKSUVSRklGQlNUMFpGVTBsUFRrbFRWRUZUSUVGRE1Va3dSd1lEVlFRS0UwQkJVMDlEU1VGRFNVOU9JRTFGV0VsRApRVTVCSUVSRklFVk9SRTlUUTA5UVNVRWdSMEZUVkZKUFNVNVVSVk5VU1U1QlRDQlpJRU5QVEVWSFNVOGdSRVVnCk1TVXdJd1lEVlFRdEV4eEJUVVUzTVRBek1qa3pTRFVnTHlCVFQxTlROalF4TURJNU9Vd3lNUjR3SEFZRFZRUUYKRXhVZ0x5QlRUMU5UTmpReE1ESTVTRkJNVEU1U01UZ3hTREJHQmdOVkJBc1RQMEZUVDBOSlFVTkpUMDRnVFVWWQpTVU5CVGtFZ1JVNGdSVTVFVDFORFQxQkpRU0JIUVZOVVVrOUpUbFJGVTFSSlRrRk1JRmtnUTA5TVJVZEpUeUJFClJUQ0NBU0l3RFFZSktvWklodmNOQVFFQkJRQURnZ0VQQURDQ0FRb0NnZ0VCQUpac1RuMjJrdjdXeGdSZFgwZmQKMm5kN0Y3TWE1YjFkaGd4bDhZZU56OVpyZ1pQOGNhc1NOV2tZSkdpWUxJckVyUlkvN2dqUkJRWWtXcDVIenI3dQpKVFhnK3NDZGhxaWFCd3FERy93RFZuVitOWW80aWFlV3NxU0phL0FXYUhoSW1VNkxSaU55UTNERVFTajIwZGxHCk83ZnNUVktoaldlTFovcDRqdFRSWWpaU0QxbnJFSFVycC9LRWlKaDNrYmZyT2hBY3V0dmlLUFBLTytkcml6eFEKVTBRam81bnBUOGt2SUl0OEh1cG1HMk5NNU5uU1krWnNxcWpyTDJGdUFBTDJhWlJxRHhMN3NTWk9Ualhuckt5WApkNjVPVFAxU04yQTJkRkp4Y3dFb2I2eWlCQ2JBRmxnQXNhOWpYUEhlaXRBY2xQVG50R3ZwSGlraVlLK3Bya29LCkpaRUNBd0VBQWFNZE1Cc3dEQVlEVlIwVEFRSC9CQUl3QURBTEJnTlZIUThFQkFNQ0JzQXdEUVlKS29aSWh2Y04KQVFFTEJRQURnZ0lCQUFQenlLWmJpejRVZllHbmg3VnVHdnhFVjZ3WlFMQ0M0ZSsrT2dJaTFuMHdBaEV2aGJ0VQo3dExhQUV0V3FnN29LWmpFRlE2VGhBT0pnU3EwWUk5UGp2ZVMxUEFCMWlwQ1d6NWhzZDJJYTNoRHVaODhKYy90CkNEbFYxdTFacGtteUttTjl1enB5c20wbGF5dFJGKzM4V2NTaXc2VGJRaUNXR3UvcWNOSUdjMytiak00Zk54TGMKV2pYZlFWK3QvVURJYlNraHhFN2RHRjBkNmVVZHVDTDhCRFhRbkp2bFRhODBSektiOHhRaUVxRXRxQjJFeTQ4cApVYVFoWkE3R0lIbStoZHZJdHhIWnNjTFdxbStQU2pKT3hrRDJaRGhHUDJjQzRlVlpIYWUrNXpxQ3d5aEhMWTErClh4L2VkMDJYcUVNZldscU9KL1VsdnNjSHdTdHZ1NldzNDhGTmQrZk9ndy93SmlNMDNiemlyNTllRkxYS0lZUGUKOGNZMm1JWncvRnJ0bS8yMUZqUzB3YnRnYXVubEpGWlh5MzBhb0FyUkFkVHdSNnhEWTJNZFMvMXFpall1ZTRWdApuNGRacVdDYVU0R21JQUkyU3QwUHJkaFYzeG1mY2ljelBBSEdHWEk1SFRHdkU4QlJnR1FXbSt3Mk40WEdpaUlFCjYrcE9tSVNaVjg0SVBWUmFYSzFoRk4zVnFLOStocWk3U0FESkRGWUVEVmFzTTc1SWhCN3djVVhOc1NqVWJmV1UKdG85QWwwUUpJYTJmRnYwNHNkSFNJQXM5SWt1czlNZURDdGo2L0QyTEkvUFdraWI2Skp4RDNYeTRFbENubmYvUwpOQVBmZ1d5ZG44UnZRMUtqVW1BWE5WQzJyR3AzMG92dk5OVE9oUTRoYk1GNFg2YU5vMlRINWJ3NgotLS0tLUVORCBDRVJUSUZJQ0FURS0tLS0tCg==");//Sacado del archivo guia de amegonline.com (impre_recibo_3.3.php) */
            $comprobante->setAttribute("Certificado", "MIIGETCCA/mgAwIBAgIUMDAwMDEwMDAwMDA1MTExMzYyMTEwDQYJKoZIhvcNAQELBQAwggGEMSAwHgYDVQQDDBdBVVRPUklEQUQgQ0VSVElGSUNBRE9SQTEuMCwGA1UECgwlU0VSVklDSU8gREUgQURNSU5JU1RSQUNJT04gVFJJQlVUQVJJQTEaMBgGA1UECwwRU0FULUlFUyBBdXRob3JpdHkxKjAoBgkqhkiG9w0BCQEWG2NvbnRhY3RvLnRlY25pY29Ac2F0LmdvYi5teDEmMCQGA1UECQwdQVYuIEhJREFMR08gNzcsIENPTC4gR1VFUlJFUk8xDjAMBgNVBBEMBTA2MzAwMQswCQYDVQQGEwJNWDEZMBcGA1UECAwQQ0lVREFEIERFIE1FWElDTzETMBEGA1UEBwwKQ1VBVUhURU1PQzEVMBMGA1UELRMMU0FUOTcwNzAxTk4zMVwwWgYJKoZIhvcNAQkCE01yZXNwb25zYWJsZTogQURNSU5JU1RSQUNJT04gQ0VOVFJBTCBERSBTRVJWSUNJT1MgVFJJQlVUQVJJT1MgQUwgQ09OVFJJQlVZRU5URTAeFw0yMjAyMDEwMjE2NDNaFw0yNjAyMDEwMjE2NDNaMIHfMSswKQYDVQQDEyJBQ0FERU1JQSBNRVhJQ0FOQSBERSBORVVST0xPR0lBIEFDMSswKQYDVQQpEyJBQ0FERU1JQSBNRVhJQ0FOQSBERSBORVVST0xPR0lBIEFDMSswKQYDVQQKEyJBQ0FERU1JQSBNRVhJQ0FOQSBERSBORVVST0xPR0lBIEFDMSUwIwYDVQQtExxBTU43NzAyMDM3UzMgLyBNVVRDNjgwOTE2SlozMR4wHAYDVQQFExUgLyBNVVRDNjgwOTE2TURGUkxOMDYxDzANBgNVBAsTBk1hdHJpejCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAKJLvNZbXdEf03xHRF3iKzdC/jyDee6fn5B/mhz3QbzOfKfDRvoap1exT/w2bXUycJubnCoqMWNf6za+jTYJvt8I36LzEMOnDz0kk/TpQWrjkmAv2VvsyLiJuVvOd24OUvzfmUnJ6Eog5V4nweQENGdEsM8rmVGudueKl8EqN9fI55ZYmed6GYmZi4yPvTKg//dyzSi3CIDrCm/k9ztCiRw+2OFmju/+9UhXd93wlLjgZhuLZUjNZuhC1BQVphwQHx3AcuNxYEHiBwdlWYRX5Ez2QfR+jFoIix9H3G+VQoddn3vN/V8StXpvPDBVd3dk6m1/+Zf6noWeiu23O5QqXg0CAwEAAaMdMBswDAYDVR0TAQH/BAIwADALBgNVHQ8EBAMCBsAwDQYJKoZIhvcNAQELBQADggIBALX+wg75Z1qy8Z5L+r/D8P/isSPJ/vKV2+a6mlgchJztCNLfjOBGrI2LCJes8l4lDNkMkGSLxbTktBmm7D4rB8hWDnWz2NJFWOOqkeIn+WJm3kIv3mmc4yI2eOBpPGp1VxQZLIovmG4QJCXDALslRkeFuZOSM2Z+iY1JzRD7EaNz66w5g57ZwduJ5fdkjqHP1aFRFmGqf5zQw9/kFIAZl9LkfewSAOgRwEyICfxLWY2zEsFS6tcNDIWRzG4kEMcEVLGoqCl85pXZSX2kIv5yxVxI5CsTQWz5/ZpUNedStDGMrxHz6wbok+f9D8/wT3VftD3QHpLYQkZHUDeaWRlYnJB2zzDMKJXLlddMqa9lzn3AhnX/iltsL2oSMTMiOWHi9bd9444cA1Tgp/PmISxl5Fqaoxf0Iz89zm3APdXDYs8sRuz2Sl+SJNy6wNNQgqB5zjP1DlIWjWWwpxEWFtjmUgA8BcYsl8J/nSgganxpiC1mSawWGgOrHXG7WXUOmxfJZlwMxJ8e5rgYY4e2v7Qwr1NTcjYucM1/8+eGzMDi6ZXpnoneLXL0fakJTZoBvucN/0oWK1501zvCs/bUSpwCnuJ/4g01OE408MZgDMqFF8CPgqMK73sFD5ENQQfpPCqnX3pFZi4720h2lw/CYMTp+KpyklI8zylgKi9aoEoWdOR8"); //Sacado del archivo guia de rregistroenlinea.mx (impre_Recibo1.php)
            $comprobante->setAttribute("MetodoPago", "PUE");
            // if ($datos['caja_forma_pago'] == 23) {
            //     $metodos = array("1" => $datos['campomixtoefectivo'], "3" => $datos['campomixtotransferencia'], "4" => $datos['campomixtocredito'], "18" => $datos['campomixtodebito']);
            //     $metodo_mayor = array_search(max($metodos), $metodos);
            // } else {
            //     $metodo_mayor = $datos['caja_forma_pago'];
            // }
            $comprobante->setAttribute("FormaPago", $conceptos[0]['tipo_pago_clave']);
            $comprobante->setAttribute("LugarExpedicion", "12345");
            /* $comprobante->setAttribute("SubTotal", number_format($subtotal_conceptos,'2','.','')); */
            $comprobante->setAttribute("SubTotal", number_format($subtotal_conceptos, '2', '.', ''));
            $comprobante->setAttribute("Total", number_format($total, '2', '.', ''));
            //Datos del emisor
            $Emisor = $xml->createElement("cfdi:Emisor");
            $Emisor->setAttribute("Rfc", "AMN7702037S3"); //RFC de la sociedad
            $Emisor->setAttribute("Nombre", "Academia Mexicana de Neurología, A.C., 2022"); //Razón social de la sociedad
            $Emisor->setAttribute("RegimenFiscal", "603"); //Regimen Fiscal de la sociedad
            //Datos del receptor
            $Receptor = $xml->createElement("cfdi:Receptor");
            $Receptor->setAttribute("Rfc", $datosFiscalesSocio['rfc']);
            $Receptor->setAttribute("Nombre", $datosFiscalesSocio['razon_social']);
            $Receptor->setAttribute("UsoCFDI", $this->busUsoCfdi($datosFiscalesSocio['cfdi']));
            //Conceptos
            $impuestostrasladados = 0;
            $Conceptos = $xml->createElement("cfdi:Conceptos");
            foreach (ComprobantePagoDao::buscarDetalleCompra($idCompra, $idSocio) as $value) {
                if ($value['iva_producto'] == 1) {
                    $costo_producto = number_format(($value['monto'] / 1.16), 2, '.', '');
                } else {
                    $costo_producto = number_format(($value['monto']), 2, '.', '');
                }
                $Conceptos_aux = $xml->createElement("cfdi:Concepto");
                // $Conceptos_aux->setAttribute("Cantidad", trim(preg_replace('/\s\s+/', ' ', number_format($value['cantidad_compras'], 2, '.', ''))));
                $Conceptos_aux->setAttribute("Cantidad", trim(preg_replace('/\s\s+/', ' ', number_format(1, 2, '.', ''))));
                $Conceptos_aux->setAttribute("ClaveProdServ", trim(preg_replace('/\s\s+/', ' ', '94101600')));
                $Conceptos_aux->setAttribute("ClaveUnidad", trim(preg_replace('/\s\s+/', ' ', 'E48')));
                $Conceptos_aux->setAttribute("Descripcion", trim(preg_replace('/\s\s+/', ' ', $value['nombre_producto'])));
                $Conceptos_aux->setAttribute("ValorUnitario", trim(preg_replace('/\s\s+/', ' ', $costo_producto)));
                $Conceptos_aux->setAttribute("Importe", trim(preg_replace('/\s\s+/', ' ', $costo_producto)));
                $ImpuestosConceptos = $xml->createElement("cfdi:Impuestos");
                //TRASLADOS
                $TrasladosConceptos = $xml->createElement("cfdi:Traslados");

                if ($value['iva_producto'] == 1) {
                    $TrasladoTraslados = $xml->createElement("cfdi:Traslado");
                    $TrasladoTraslados->setAttribute("Base", trim(preg_replace('/\s\s+/', ' ', number_format(($value['monto'] / 1.16), 2, '.', ''))));
                    $TrasladoTraslados->setAttribute("Impuesto", "002");    //Clave IVA
                    $TrasladoTraslados->setAttribute("TipoFactor", "Tasa");
                    //$TrasladoTraslados->setAttribute("TasaOCuota", $value[15]);//Pendiente
                    $TrasladoTraslados->setAttribute("TasaOCuota", number_format(0.16, 6, ".", "")); //Pendiente 3
                    $impuestostrasladados = $impuestostrasladados + number_format(trim(preg_replace('/\s\s+/', ' ', number_format(($value['monto'] / 1.16), 2, '.', ''))) * 0.16, 2, ".", "");
                    $TrasladoTraslados->setAttribute("Importe", number_format(trim(preg_replace('/\s\s+/', ' ', number_format(($value['monto'] / 1.16), 2, '.', ''))) * 0.16, 2, ".", ""));
                } else {
                    $TrasladoTraslados = $xml->createElement("cfdi:Traslado");
                    $TrasladoTraslados->setAttribute("Base", trim(preg_replace('/\s\s+/', ' ', number_format(($value['monto'] / 1.16), 2, '.', ''))));
                    $TrasladoTraslados->setAttribute("Impuesto", "002");    //Clave IVA
                    $TrasladoTraslados->setAttribute("TipoFactor", "Exento");
                }
                $TrasladosConceptos->appendChild($TrasladoTraslados);
                $ImpuestosConceptos->appendChild($TrasladosConceptos);
                $Conceptos_aux->appendChild($ImpuestosConceptos);
                $Conceptos->appendChild($Conceptos_aux);
            }
            $Impuestos = $xml->createElement("cfdi:Impuestos");
            $Impuestos->setAttribute("TotalImpuestosTrasladados", number_format($impuestostrasladados, 2, ".", ""));
            if($existen_impuestos){
                $Traslados = $xml->createElement("cfdi:Traslados");
                $Traslados_aux = $xml->createElement("cfdi:Traslado");
                //$Traslados_aux->setAttribute("Base", number_format($subtotal_conceptos,'2','.',''));
                $Traslados_aux->setAttribute("Impuesto", '002');
                $Traslados_aux->setAttribute("TipoFactor", "Tasa");
                $Traslados_aux->setAttribute("TasaOCuota", number_format(0.16,6,".",""));//Pendiente 3
                $Traslados_aux->setAttribute("Importe", number_format($impuestostrasladados,2,".",""));//Pendiente 3
                $Traslados->appendChild($Traslados_aux);
            }
            $comprobante->appendChild($Emisor);
            $comprobante->appendChild($Receptor);
            $comprobante->appendChild($Conceptos);
            if($existen_impuestos){
                $Impuestos->appendChild($Traslados);
                $comprobante->appendChild($Impuestos);
            }
            
            $xml->appendChild($comprobante);
            //Crear la carpeta y archivo XML
            $ruta = "facturacion/";
            // $folio = $this->seriesociedad . $idCompra;
            $folio = 'C' . $idCompra;
            $carpeta_user = $idSocio;
            $carpeta_rfc = $datosFiscalesSocio['rfc'];
            $destino_n1 = $ruta . $carpeta_user;
            if (!file_exists($destino_n1)) {
                if (mkdir($destino_n1, 0777, true)) {
                    chmod($destino_n1, 0777);
                } else {
                    die('Fallo al crear la carpeta $destino_n1...');
                }
                //mkdir($destino_n1,0777,true);
                //chmod($destino_n1,0777);
            }
            $destino_n2 = $destino_n1 . "/" . $carpeta_rfc;
            if (!file_exists($destino_n2)) {
                if (mkdir($destino_n2, 0777, true)) {
                    chmod($destino_n2, 0777);
                } else {
                    die('Fallo al crear la carpeta $destino_n2...');
                }
                // mkdir($destino_n2,0777,true);
                //chmod($destino_n2,0777);
            }
            $destino_final = $destino_n2 . "/" . $folio . ".xml";
            $xmlcreado = $xml->saveXML(); //Invocamos el método que genera el XML con los valores previamente asignados
            $file = fopen($destino_final, "w+"); //Creamos el archivo en caso de no existir
            fwrite($file, $xmlcreado); //Escribimos lo que retorna el metodo CrearXML()
            fclose($file); //Cerramos el archivo

            //---------------------------------------------------------------------------------------------//
            //generacion de cadena original
            $nombrearchivo ='AMN7702037S3C' . str_pad($idCompra, 6, "0", STR_PAD_LEFT);
            $archivocotxt = "config_facturacion/txt_co/co" . $nombrearchivo . ".txt";
            $sellobintxt = "config_facturacion/sellobin/sellobin." . $nombrearchivo . ".txt";
            $sellotxt = "config_facturacion/sello/sello." . $nombrearchivo . ".txt";
            exec("xsltproc config_facturacion/cadenaoriginal_3_3.xslt $destino_final > $archivocotxt");

            //transformacion de .key a .pem
            exec("openssl pkcs8 -inform DER -in config_facturacion/archivos/CSD_Matriz_AMN7702037S3_20220131_201408.key -passin pass:Neur@2022 > config_facturacion/pem/AMN7702037S3_20220131_201408.pem");
            // exit;
            exec("openssl dgst -SHA256 -sign config_facturacion/pem/AMN7702037S3_20220131_201408.pem -out $sellobintxt $archivocotxt");
            exec("openssl enc -base64 -in $sellobintxt -out $sellotxt");
            //Borramos el archivo .pem y el sellobintxt
            unlink("config_facturacion/pem/AMN7702037S3_20220131_201408.pem");
            unlink($sellobintxt);
            //Asignamos la cadena original y el sello
            $cadenaoriginalread = fopen($archivocotxt, "r");
            $cadenaoriginal = fread($cadenaoriginalread, filesize($archivocotxt));
            $selloread = fopen($sellotxt, "r");
            $sello = fread($selloread, filesize($sellotxt));
            $sello = preg_replace("/\r|\n/", "", $sello);
            //              echo $cadenaoriginal;
            // exit(); 
            
   
            $xml = simplexml_load_file($destino_final);
        $xml->addAttribute('Sello', $sello);
            //echo $xml->asXML();  
            //exit();
            $xmllee = fopen($destino_final, "w");
            $xmlescribe = fwrite($xmllee, $xml->asXML());
            $xmlcierra = fclose($xmllee);
            //echo $cadenaoriginal;//Imprimimos la cedena original generada para verificar
            //mueve la cadena original, el sello y el xml a sus carpetas
            rename("$sellotxt", $sellotxt);
            rename("$archivocotxt", $archivocotxt);

            $nombre = $nombrearchivo;
            require_once('config_facturacion/lib_3_3/nusoap.php');
            $xmlnombre = $destino_final;

            $xmlzipnombre = $nombre . ".zip";
            $zip = new ZipArchive();
            $xmlzip_result = $zip->open("config_facturacion/zip/" . $xmlzipnombre, ZipArchive::CREATE);
            $zip->addFile($xmlnombre, $xmlzipnombre);
            $zip->close();
            $xmlzip_lee = fopen("config_facturacion/zip/" . $xmlzipnombre, "r");
            $xmlzip = fread($xmlzip_lee, filesize("config_facturacion/zip/" . $xmlzipnombre));
            //Conversión de ZIP a base64
            $xmlzipbase64nombre = 'config_facturacion/zip/' . $nombre . "base64.txt";
            
            exec("openssl enc -base64 -in config_facturacion/zip/$xmlzipnombre -out $xmlzipbase64nombre");

            $xmlzipbase64_lee = fopen($xmlzipbase64nombre, "r");
            $xmlzipbase64 = fread($xmlzipbase64_lee, filesize($xmlzipbase64nombre));
            
      
            $aParametros = array('user' => "AMC770614951", 'password' => "knxxhkwoi", 'file' => $xmlzipbase64);
            //$aParametros = array(user => "APU010212SN1", password => "wpgyvqsuv", file => $xmlzipbase64); 
            // echo $xmlzipbase64;
            
            try {
                $oSoapClient = new nusoap_client("https://cfdiws.sedeb2b.com/EdiwinWS/services/CFDi?wsdl", true);
                if (is_soap_fault($oSoapClient)) {
                    trigger_error("SOAP Fault: (faultcode: {$oSoapClient->faultcode}, faultstring: {$oSoapClient->faultstring})", E_USER_ERROR);
                    exit();
                }
                $oSoapClient->useHTTPPersistentConnection();
                //$response = $oSoapClient->call('getCfdi', $aParametros, 'https://cfdiws.sedeb2b.com/EdiwinWS/services/CFDi?wsdl');
                $response = $oSoapClient->call('getCfdiTest', $aParametros, 'https://cfdiws.sedeb2b.com/EdiwinWS/services/CFDi?wsdl');
               
                /* if(isset($response['getCfdiReturn'])){ */
                if (isset($response['getCfdiTestReturn'])) {
                    //echo "Crear el qr, pedf y sello de timbrado ";
                    //$xmlzip_despues=base64_decode($response['getCfdiReturn']);
                    $xmlzip_despues = base64_decode($response['getCfdiTestReturn']);
                    $xmlzip_despues_nombre = "config_facturacion/zip/" . $nombre . "_respuesta.zip";
                    $xmlzip_despues_abrir = fopen($xmlzip_despues_nombre, "w");
                    $xmlzip_despues_grabar = fwrite($xmlzip_despues_abrir, $xmlzip_despues);
                    $zip->open($xmlzip_despues_nombre);
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $filename = $zip->getNameIndex($i);
                        $fileinfo = pathinfo($filename);
                        copy("zip://" . $xmlzip_despues_nombre . "#" . $filename, "config_facturacion/zip/" . $fileinfo['filename'] . ".xml");
                    }
                    $zip->close();
                    /* $xml_despues=$zip->extractTo($xmlzip_despues_nombre);
                    $zip->close(); */
                    $xml_despues_nombre = "config_facturacion/zip/SIGN_" . $nombre . ".xml";
                    $co_xml_despues_nombre = "config_facturacion/zip/coSIGN_" . $nombre . ".txt";
                    $xml_despues_abrir = fopen($xml_despues_nombre, "r");
                    $xml_despues = fread($xml_despues_abrir, filesize($xml_despues_nombre));
                    //echo $xml_despues;
                    $dom = new DOMDocument();
                    $dom->loadXML($xml_despues); //XML con sellos fiscales del SAT
                    foreach ($dom->getElementsByTagNameNS('http://www.sat.gob.mx/TimbreFiscalDigital', '*') as $element) {
                        $uuid = $element->getAttribute('UUID');
                        $FechaTimbrado = $element->getAttribute('FechaTimbrado');
                        $selloCFD = $element->getAttribute('SelloCFD');
                        $noCertificadoSAT = $element->getAttribute('NoCertificadoSAT');
                        $selloSAT = $element->getAttribute('SelloSAT');
                    }
                    if (isset($uuid) && !empty($uuid) && isset($FechaTimbrado) && !empty($FechaTimbrado) && isset($selloCFD) && !empty($selloCFD) && isset($noCertificadoSAT) && !empty($noCertificadoSAT) && isset($selloSAT) && !empty($selloSAT)) {
                        //Empezamos la creación del PDF
                        /* echo $uuid."\n";
                        echo $FechaTimbrado."\n";
                        echo $selloCFD."\n";
                        echo $noCertificadoSAT."\n";
                        echo $selloSAT."\n"; */
                        $respuesta = [
                            'idSocio' => $idSocio,
                            'idCompra' => $idCompra,
                            'datos' => $datos,
                            'uuid' => $uuid,
                            'FechaTimbrado' => $FechaTimbrado,
                            'selloCFD' => str_replace("/", "λλ", $selloCFD),
                            'noCertificadoSAT' => str_replace("/", "λλ", $noCertificadoSAT),
                            'selloSAT' => str_replace("/", "λλ", $selloSAT)
                        ];
                        echo json_encode($respuesta);
                        //return $idSocio."||".$idCompra."||".$datos."||".$uuid."||".$FechaTimbrado."||".$selloCFD."||".$noCertificadoSAT."||".$selloSAT;
                        //$this->generarPdfFacturacion_3_3($idSocio,$idCompra,$datos,$uuid,$FechaTimbrado,$selloCFD,$noCertificadoSAT,$selloSAT);//Invocamos el método para crear el PDF
                    } else {
                        echo "Error recopilado: No se timbro correctamente el CFDI";
                    }
                } else {
                    echo "No existe respuesta getCfdiReturn u ocurrio un problema";
                    var_dump($response['detail']['fault']['text']);
                }
            } catch (CFDiException $e) {
                echo "CFDiException: " . $e->getMessage();
            } catch (RemoteException $f) {
                echo "RemoteException: " . $f->getMessage();
            } catch (Exception $g) {
                echo "Exception: " . $g->getMessage();
            }
            //---------------------------------------------------------------------------------------------//
        // } catch (\Throwable $th) {
        //     echo "Error recopilado generarXmlFacturacion_3_3: " . $th->getMessage();
        // }
    }
}
