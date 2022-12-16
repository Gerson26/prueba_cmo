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

class OrdenPagoRegister
{

    private $_contenedor;

    function __construct()
    {
       
        
    }
    

    function PagoExistoso(){
        try {
            $prodcutos = json_decode($_GET['productos'],true);
            foreach($prodcutos as $key => $value){

                $documento = new \stdClass();
        
                $documento->_id_producto = $value['id_product'];
                $documento->_id_registrado = $_GET['u'];
                
                $updatePediente = HomeDao::updateStatusPendientePaypal($documento);
    
                if($updatePediente){
                    $insert_asigna = RegisterDao::insertAsignaProducto($_GET['u'], $value['id_product']);

                    if($value['id_product'] == 2 || $value['id_product'] == 35 ){
                        $updateDatosSocio = RegisterDao::updateDatosSocio($_GET['u']);
                    }
                }
            }

            $status = true;
        } catch (\Throwable $th) {
            $status = false;
        }

         header('Location: /Login');
        
    }

    function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

}
