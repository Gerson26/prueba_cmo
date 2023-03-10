<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\Controller;
use \App\models\TrabajosLibres AS trabajos_libres_grupo1Dao;

class TrabajosLibresUno extends Controller{

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
            Cursos - Neuropediatría
      </title>
html;

        $trabajos_libres_grupo1 = '';
        $card_trabajos_libres_grupo1 = '';
        $heart = '';

        $trabajos_libres_grupo1 =  trabajos_libres_grupo1Dao::getTableTrabajosLibresGrupo1($_SESSION['id_trabajo_libre']);

        foreach ($trabajos_libres_grupo1 as $key => $value) {


            $like = trabajos_libres_grupo1Dao::getlike($value['id_trabajo'],$_SESSION['user_id']);
            if ($like['status'] == 1) {
                $heart = <<<html
                    <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"  data-bs-placement="top" data-bs-toggle="tooltip" data-bs-original-title="Votaste por ese trabajo"></span>
html;
            } else {
                $heart = <<<html
                    <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2 " data-bs-placement="top" data-bs-toggle="tooltip" data-bs-original-title="Da click para votar (Si todavía no has votado por ningun trabajo)"></span>
html;
            }

            if($value['grupo'] == 1){
                $ruta = '/trabajos_files/img/grupo_1/'.$value['caratula'];
            }elseif($value['grupo'] == 2){
                $ruta = '/trabajos_files/img/grupo_2/'.$value['caratula'];
            }

            $card_trabajos_libres_grupo1 .= <<<html
            
            
            <div class="col-12 col-md-4 text-center " >
                <div class="card card-body card-course p-0 border-radius-15">
                {$heart}
                <img class="caratula-trabajo-img border-radius-15" src="{$ruta}">
                        <div class="mt-2 color-black font-5 text-bold iframe" data-toggle="modal" data-target="#pdf" data-pdf="{$value['pdf']}"><p class="font-14"><b> {$value['titulo']} <span class="fa fa-mouse-pointer" aria-hidden="true"></span></b></p>
                        </div>
                        <div class="color-black font-14"><p>{$value['descripcion']}</p></div>
                        <div class="color-vine font-12"><p>{$value['nombre_participante']}</p></div>
                        
                        <!--<span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>-->
                </div>
            </div>
html;
        }

        View::set('header',$this->_contenedor->header($extraHeader));
        //View::set('permisos_mexico',$permisos_mexico);
        //View::set('tabla',$tabla);
        View::set('card_trabajos_libres_grupo1',$card_trabajos_libres_grupo1);
        View::render("trabajos_libres_grupo1");
    }

    public function Likes(){
        $clave = $_POST['clave'];
        $id_trabajo = trabajos_libres_grupo1Dao::getTrabajoByClave($clave)['id_trabajo'];

        $hay_like = trabajos_libres_grupo1Dao::getlike($id_trabajo,$_SESSION['user_id']);
        // var_dump($hay_like);

        if ($hay_like) {
            // $status = 0;
            // if ($hay_like['status'] == 1) {
            //     $status = 0;
            // } else if ($hay_like['status'] == 0){
            //     $status = 1;
            // }
            // TalleresDao::updateLike($id_curso,$_SESSION['id_registrado'],$status);
            // echo 'siuu '.$clave;
            echo "ya_votaste";
        } else {
            $insertLike = trabajos_libres_grupo1Dao::insertLike($id_trabajo,$_SESSION['user_id']);

            if($insertLike){
                echo "votar";
            }else{
                echo "hubo error al votar";
            }
            // echo 'nooouuu '.$clave;
        }
    }

}
