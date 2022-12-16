<?php

namespace App\models;

defined("APPPATH") or die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Register
{


  public static function getUserRegister($email)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    SELECT uad.*, p.pais, e.estado
      FROM utilerias_administradores uad 
      INNER JOIN paises p
      ON p.id_pais = uad.id_pais
      INNER JOIN estados e
      ON e.id_estado = uad.id_estado
      WHERE usuario = '$email'
sql;

    return $mysqli->queryAll($query);
  }

  public static function updateImg($user)
  {
    $mysqli = Database::getInstance(true);
    // var_dump($user);
    $query = <<<sql
    UPDATE utilerias_administradores SET avatar_img = ''  WHERE usuario = :email;
sql;
    $parametros = array(
      ':email' => $user->_email
    );


    $accion = new \stdClass();
    $accion->_sql = $query;
    $accion->_parametros = $parametros;
    $accion->_id = $user->_administrador_id;
    // UtileriasLog::addAccion($accion);
    $mysqli->update($query, $parametros);



    $query1 = <<<sql
    UPDATE utilerias_administradores SET avatar_img = :img  WHERE usuario = :email;
sql;
    $parametros1 = array(
      ':img' => $user->_img,
      ':email' => $user->_email

    );


    $accion = new \stdClass();
    $accion->_sql = $query1;
    $accion->_parametros = $parametros1;
    $accion->_id = $user->_administrador_id;
    // UtileriasLog::addAccion($accion);
    return $mysqli->update($query1, $parametros1);
  }

  public static function insertNewUser($register)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
        INSERT INTO utilerias_administradores(usuario,title,nombre,apellidop,apellidom,telefono,id_categoria,especialidades,id_pais,id_estado,referencia,monto_congreso,clave_socio,txt_especialidad,status) VALUES(:usuario,:title,:nombre,:apellidop,:apellidom,:telefono,:id_categoria,:especialidades,:id_pais,:id_estado,:referencia,:monto_congreso,:clave_socio,:txt_especialidad,1)                        
sql;

    $parametros = array(
      ':usuario' => $register->_email,
      ':title' => $register->_prefijo,
      ':nombre' => $register->_nombre,
      ':apellidop' => $register->_apellidop,
      ':apellidom' => $register->_apellidom,
      ':telefono' => $register->_telephone,
      ':id_categoria' => $register->_categorias,
      ':especialidades' => $register->_especialidades,
      ':id_pais' => $register->_nationality,
      ':id_estado' => $register->_state,
      ':referencia' => $register->_referencia,
      ':monto_congreso' => $register->_monto_congreso,
      ':clave_socio' => $register->_clave_socio,
      ':txt_especialidad' => $register->_txt_especialidad,
    );

    $id = $mysqli->insert($query, $parametros);
    return $id;
  }

  public static function insertPendienteEstudiante($fecha_pendiente, $user_id)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
        INSERT INTO pendiente_estudiante
        (user_id,fecha,url_archivo,status) VALUES($user_id,'$fecha_pendiente','',0)                        
sql;

    $parametros = array();

    $ida = $mysqli->insert($query, $parametros);
    return $ida;
  }

  public static function updateBecado($user)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    UPDATE utilerias_administradores SET title = :prefijo, nombre = :nombre, apellidop = :apellidop, apellidom = :apellidom, telefono = :telefono, id_pais = :id_pais, id_estado = :id_estado, status = 1 WHERE usuario = :email;
sql;
    $parametros = array(
      ':prefijo' => $user->_prefijo,
      ':nombre' => $user->_nombre,
      ':apellidop' => $user->_apellidop,
      ':apellidom' => $user->_apellidom,
      ':telefono' => $user->_telephone,
      ':id_pais' => $user->_nationality,
      ':id_estado' => $user->_state,
      ':email' => $user->_email

    );

    return $mysqli->update($query, $parametros);
  }

  public static function UpdateUser($user)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    UPDATE utilerias_administradores SET title = :prefijo, nombre = :nombre, apellidop = :apellidop, apellidom = :apellidom, telefono = :telefono, referencia = :referencia,id_categoria = :id_categoria, especialidades = :especialidades,id_pais = :id_pais, id_estado = :id_estado ,monto_congreso = :monto_congreso, clave_socio = :clave_socio, txt_especialidad = :txt_especialidad ,status = 1 WHERE usuario = :email;
sql;

    $parametros = array(
      ':prefijo' => $user->_prefijo,
      ':nombre' => $user->_nombre,
      ':apellidop' => $user->_apellidop,
      ':apellidom' => $user->_apellidom,
      ':telefono' => $user->_telephone,
      ':referencia' => $user->_referencia,
      ':id_categoria' => $user->_categorias,
      ':especialidades' => $user->_especialidades,
      ':id_pais' => $user->_nationality,
      ':id_estado' => $user->_state,
      ':email' => $user->_email,
      ':monto_congreso' => $user->_monto_congreso,
      ':clave_socio' => $user->_clave_socio,
      ':txt_especialidad' => $user->_txt_especialidad

    );

    return $mysqli->update($query, $parametros);
  }




  public static function getUser($email)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
        SELECT * FROM utilerias_administradores  WHERE usuario = '$email'
sql;

    return $mysqli->queryAll($query);
  }

  public static function getUserAnualidad($usuario)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
      SELECT ua.usuario,ua.motivo,ua.user_id,pe.id_pendiente_pago,pe.status, pe.id_producto
      FROM utilerias_administradores ua
      INNER JOIN pendiente_pago pe ON pe.user_id = ua.user_id
      WHERE ua.usuario = '$usuario' AND ua.motivo = 'Anualidad' AND pe.id_producto = 2 AND pe.status = 0;
sql;

    return $mysqli->queryOne($query);
  }

  public static function getEstudiante($usuario)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    SELECT ua.usuario,pe.* FROM utilerias_administradores ua
    INNER JOIN pendiente_estudiante pe ON pe.user_id = ua.user_id
    WHERE ua.usuario = '$usuario' AND pe.status = 0;
sql;

    return $mysqli->queryOne($query);
  }

  public static function getUserById($id)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
        SELECT monto_congreso as amout_due FROM utilerias_administradores  WHERE user_id = '$id'
sql;

    return $mysqli->queryAll($query);
  }

  public static function getCountryAll()
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
      SELECT * FROM paises WHERE id_pais != 156 ORDER BY country ASC
sql;
    return $mysqli->queryAll($query);
  }

  public static function getState($pais)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
     SELECT * FROM estados WHERE id_pais = $pais;
sql;
    return $mysqli->queryAll($query);
  }

  public static function getPais()
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
        SELECT * FROM paises
sql;
    return $mysqli->queryAll($query);
  }

  public static function getPaisById($id)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
        SELECT * FROM paises WHERE id_pais = $id 
sql;
    return $mysqli->queryAll($query);
  }

  public static function getStateByCountry($id_pais)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
        SELECT * FROM estados where id_pais = '$id_pais'
sql;

    return $mysqli->queryAll($query);
  }

  public static function getAllEspecialidades()
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
        SELECT * FROM especialidades
sql;
    return $mysqli->queryAll($query);
  }

  public static function getMontoPago($id_categoria)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
        SELECT * FROM categorias where id_categoria = '$id_categoria'
sql;

    return $mysqli->queryOne($query);
  }

  public static function updateFiscalData($user)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    UPDATE utilerias_administradores SET business_name_iva = :business_name_iva, code_iva = :code_iva, email_receipt_iva = :email_receipt_iva,
    postal_code_iva = :cp, regimen_fiscal = :regimen_fiscal, cfdi = :cfdi  WHERE usuario = :usuario;
sql;



    $parametros = array(
      ':business_name_iva' => $user->_business_name_iva,
      ':code_iva' => $user->_code_iva,
      ':email_receipt_iva' => $user->_email_receipt_iva,
      ':cp' => $user->_cp,
      ':regimen_fiscal' => $user->_regimen_fiscal,
      ':cfdi' => $user->_cfdi,
      ':usuario' => $user->_email
    );

    return $mysqli->update($query, $parametros);
  }

  public static function getDataUser($user)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    SELECT * FROM utilerias_administradores WHERE usuario = '$user'
sql;
    return $mysqli->queryOne($query);
  }


  /* Pendiente de Pago */
  public static function inserPendientePago($data)
  {
    $mysqli = Database::getInstance(1);
    $query = <<<sql
    INSERT INTO pendiente_pago (id_producto, user_id, reference, clave,fecha, monto, tipo_moneda,tipo_pago,tipo_pago_clave,status, comprado_en, terminacion_tarjeta) VALUES (:id_producto, :user_id, :reference, :clave, :fecha, :monto, :tipo_moneda,:tipo_pago, :tipo_pago_clave,:status, 1, :terminacion_tarjeta);
sql;

    $parametros = array(
      ':id_producto' => $data->_id_producto,
      ':user_id' => $data->_user_id,
      ':reference' => $data->_reference,
      ':clave' => $data->_clave,
      ':fecha' => $data->_fecha,
      ':monto' => $data->_monto,
      ':tipo_pago' => $data->_tipo_pago,
      ':tipo_moneda' => $data->_tipo_moneda,
      ':status' => $data->_status,
      ':tipo_pago_clave' => $data->_metodo_pago_clave,
      ':terminacion_tarjeta' => $data->_no_tarjeta

    );
    $id = $mysqli->insert($query, $parametros);
    return $id;
  }

  public static function getProductosPendientesPagoByUser($user_id)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
  SELECT ua.monto_congreso as amout_due,ua.clave_socio,p.*,pp.*
  FROM utilerias_administradores ua 
  INNER JOIN pendiente_pago pp ON(ua.user_id = pp.user_id)
  INNER JOIN productos p ON (p.id_producto = pp.id_producto)
  WHERE pp.user_id = $user_id AND pp.status = 0
sql;
    return $mysqli->queryAll($query);
  }

  public static function getProductosPendientesPagoByUserandClave($user_id, $clave)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
  SELECT ua.monto_congreso as amout_due,ua.clave_socio,p.*,pp.*
  FROM utilerias_administradores ua 
  INNER JOIN pendiente_pago pp ON(ua.user_id = pp.user_id)
  INNER JOIN productos p ON (p.id_producto = pp.id_producto)
  WHERE pp.user_id = $user_id AND pp.clave = '$clave' AND pp.status = 0
sql;
    return $mysqli->queryAll($query);
  }

  public static function insertAsignaProducto($id_registrado, $id_producto)
  {

    $mysqli = Database::getInstance();
    $query = <<<sql
    INSERT INTO asigna_producto (user_id,id_producto,fecha_asignacion,status) 
    VALUES($id_registrado,$id_producto,NOW(),1)
sql;

    $parametros = array();

    $id = $mysqli->insert($query, $parametros);

    return $id;
  }

  public static function getProductosPendientesPago($user_id, $id_producto)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
  SELECT * FROM pendiente_pago WHERE id_producto = $id_producto AND user_id = $user_id 
sql;
    return $mysqli->queryAll($query);
  }

  public static function getPendientesResidentes($user_id)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
  SELECT * FROM pendiente_pago WHERE id_producto IN (34,35)  AND user_id = $user_id 
sql;
    return $mysqli->queryAll($query);
  }

  public static function getProductosAsignaProducto($user_id, $id_producto)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
  SELECT * FROM asigna_producto WHERE user_id = $user_id and id_producto = $id_producto
sql;
    return $mysqli->queryAll($query);
  }

  public static function getCfdi()
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
        SELECT * FROM cat_uso_cfdi
sql;

    return $mysqli->queryAll($query);
  }

  public static function getRegimenFiscal()
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
        SELECT * FROM cat_regimen_fiscal
sql;

    return $mysqli->queryAll($query);
  }

  public static function getCategorias()
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
    SELECT * FROM categorias WHERE id_categoria IN (3,7)
sql;
    return $mysqli->queryAll($query);
  }

  public static function updateDatosSocio($user_id)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    UPDATE utilerias_administradores SET socio = 1 WHERE user_id = $user_id;
sql;
    return $mysqli->update($query);
  }

  public static function updateStatusEmailInvi($user_id)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    UPDATE utilerias_administradores SET email_invitacion = 1 WHERE user_id = $user_id;
sql;
    return $mysqli->update($query);
  }

  public static function updateStatusEmailConfi($user_id)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    UPDATE utilerias_administradores SET email_confirmacion = 1 WHERE user_id = $user_id;
sql;
    return $mysqli->update($query);
  }

  public static function userDataForEmail($user_id)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    SELECT ua.user_id, ua.title,ua.usuario,ua.nombre, ua.apellidop,ua.apellidom,ua.telefono, cat.categoria, esp.nombre as nombre_especialidad, p.pais,e.estado
    FROM utilerias_administradores ua
    INNER JOIN categorias cat on (ua.id_categoria = cat.id_categoria)
    INNER JOIN especialidades esp on(ua.especialidades = esp.id_especialidad)
    INNER JOIN paises p on(ua.id_pais = p.id_pais)
    INNER JOIN estados e on(ua.id_estado = e.id_estado)
    WHERE ua.user_id = $user_id
sql;
    return $mysqli->queryOne($query);
  }

  public static function restarStock($id_producto)
  {
    $mysqli = Database::getInstance(true);
    $query = <<<sql
    UPDATE productos set cupo = (SELECT cupo FROM productos WHERE id_producto = $id_producto) - 1 WHERE id_producto = $id_producto;
sql;
    return $mysqli->update($query);
  }

  public static function deletePendientePagoByClave($clave)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
      DELETE FROM pendiente_pago WHERE clave = '$clave'
sql;

    return $mysqli->delete($query);
  }

  public static function insertCompraConekta($data)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
        INSERT INTO compra_pasarela(clave_pp,user_id,id_conekta,fecha,status) VALUES(:clave_pp,:user_id,:id_conekta,NOW(),1)                        
sql;

    $parametros = array(
      ':clave_pp' => $data->_clave_pp,
      ':user_id' => $data->_user_id,
      ':id_conekta' => $data->_id_conekta
    );

    $id = $mysqli->insert($query, $parametros);
    return $id;
  }
}
