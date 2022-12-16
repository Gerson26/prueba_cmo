<?php

namespace App\models;

defined("APPPATH") or die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class ComprobantePago
{

  public static function getAll($id)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
      SELECT pro.nombre, pp.id_pendiente_pago,pp.status,pp.tipo_pago,pp.url_archivo
      FROM productos pro
      INNER JOIN pendiente_pago pp ON (pro.id_producto = pp.id_producto)
      WHERE pp.user_id = $id
sql;
    return $mysqli->queryAll($query);
  }

  public static function getAllComprobantes($id)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
      SELECT pro.id_producto,pro.nombre,pro.precio_publico,pro.precio_socio,pro.tipo_moneda,pro.caratula,pro.es_curso,pro.es_servicio,pro.es_congreso,ua.monto_congreso as amout_due,ua.clave_socio,pp.id_pendiente_pago,pp.status,pp.tipo_pago,pp.url_archivo,pp.clave,pp.monto,pp.monto,pp.tipo_moneda as t_moneda
      FROM productos pro
      INNER JOIN pendiente_pago pp ON (pro.id_producto = pp.id_producto)
      INNER JOIN utilerias_administradores ua ON(ua.user_id = pp.user_id)
      WHERE pp.user_id = $id   GROUP BY pp.clave
sql;
    return $mysqli->queryAll($query);
  }

  public static function getAllComprobantesStatusCero($id,$clave){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT pro.id_producto,pro.nombre,pro.precio_publico,pro.precio_socio,pro.tipo_moneda,pro.caratula,pro.es_curso,pro.es_servicio,pro.es_congreso,pp.id_pendiente_pago,pp.status,pp.tipo_pago,pp.url_archivo,pp.clave,pp.tipo_moneda,pp.monto,c.costo
    FROM productos pro
    INNER JOIN pendiente_pago pp ON (pro.id_producto = pp.id_producto)
    INNER JOIN utilerias_administradores ua ON(ua.user_id = pp.user_id)
    INNER JOIN categorias c ON (c.id_categoria = ua.id_categoria)
    WHERE pp.user_id = $id AND pp.status = 0 AND pp.clave = '$clave' 
sql;
    return $mysqli->queryAll($query);
  }

  public static function getAllComprobantesbyClave($id, $clave)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
      SELECT pro.nombre,pro.precio_publico,pro.precio_socio,pro.tipo_moneda,pro.caratula,pro.es_curso,pro.es_servicio,pro.es_congreso,ua.monto_congreso as amout_due,ua.clave_socio,pp.id_pendiente_pago,pp.status,pp.tipo_pago,pp.url_archivo,pp.clave, pp.comprado_en, pp.monto,pp.tipo_moneda as t_moneda
      FROM productos pro
      INNER JOIN pendiente_pago pp ON (pro.id_producto = pp.id_producto)
      INNER JOIN utilerias_administradores ua ON(ua.user_id = pp.user_id)
      WHERE pp.user_id = $id and pp.clave = '$clave'
sql;
    return $mysqli->queryAll($query);
  }

  public static function getAllComprobantesbyClaveAndStatus($id, $clave)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
      SELECT pro.nombre,pro.precio_publico,pro.precio_socio,pro.tipo_moneda,pro.caratula,pro.es_curso,pro.es_servicio,pro.es_congreso,ua.monto_congreso as amout_due,ua.clave_socio,pp.id_pendiente_pago,pp.status,pp.tipo_pago,pp.url_archivo,pp.clave, pp.comprado_en
      FROM productos pro
      INNER JOIN pendiente_pago pp ON (pro.id_producto = pp.id_producto)
      INNER JOIN utilerias_administradores ua ON(ua.user_id = pp.user_id)
      WHERE pp.user_id = $id and pp.clave = '$clave' and pp.status = 0
sql;
      return $mysqli->queryAll($query);
    }

    public static function updateComprobante($data){
        $mysqli = Database::getInstance(true);
        // var_dump($user);
        $query=<<<sql
        UPDATE pendiente_pago SET url_archivo = :url_archivo, status = 0  WHERE clave = :clave;
sql;
        $parametros = array(
          ':url_archivo'=>$data->_url,
          ':clave' => $data->_clave
          // ':id_pendiente_pago'=>$data->_id_pendiente_pago
        );
       
        return $mysqli->update($query, $parametros);

    }

    public static function updateUser($user_id){
      $mysqli = Database::getInstance(true);
      // var_dump($user);
      $query=<<<sql
      UPDATE utilerias_administradores SET motivo = 'Anualidad'  WHERE user_id = $user_id;
sql;
      $parametros = array(
      );
     
      return $mysqli->update($query, $parametros);

  }

    public static function insertComprobante($data)
  {
    $mysqli = Database::getInstance(1);
    $query = <<<sql
    INSERT INTO pendiente_pago (id_producto, user_id, reference, clave,fecha, monto, tipo_moneda,tipo_pago,
    url_archivo, status, comprado_en) 
    VALUES (2, :user_id, :reference, :clave, :fecha, :monto, 'MXN',
    'Transferencia',:url_archivo,'0', '1');
sql;

    $parametros = array(
      ':user_id' => $data->_user_id,
      ':reference' => $data->_reference,
      ':clave' => $data->_clave,
      ':fecha' => $data->_fecha,
      ':monto' => $data->_monto,
      ':url_archivo' => $data->_url_archivo,
    );
    $id = $mysqli->insert($query, $parametros);
    return $id;
  }

    public static function updateComprobanteEstudiante($data){
      $mysqli = Database::getInstance(true);
      // var_dump($user);
      $query=<<<sql
      UPDATE pendiente_estudiante SET url_archivo = :url_archivo, status = 0  WHERE user_id = :user_id;
sql;
      $parametros = array(
        ':url_archivo'=>$data->_url,
        ':user_id' => $data->_user_id
        // ':id_pendiente_pago'=>$data->_id_pendiente_pago
      );
     
      return $mysqli->update($query, $parametros);

    return $mysqli->queryAll($query);
  }

  public static function insertComprobanteEstudiante($data)
  {
    $mysqli = Database::getInstance(1);
    $query = <<<sql
    INSERT INTO pendiente_estudiante (user_id, fecha, url_archivo, ano_residencia, status) VALUES (:user_id, NOW(), :url_archivo, :ano_residencia, 0);
sql;

    $parametros = array(
      ':user_id' => $data->_user_id,
      ':url_archivo' => $data->_url,
      ':ano_residencia' => $data->_ano_residencia,
    );
    $id = $mysqli->insert($query, $parametros);
   
    return $id;
  }

  public static function getAllComprobantesEstudiante($id)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
    SELECT pe.*,ua.usuario,CONCAT(ua.nombre," ",ua.apellidop," ",ua.apellidom) as nombre_completo, pe.status
    FROM pendiente_estudiante pe
    INNER JOIN utilerias_administradores ua ON(ua.user_id = pe.user_id)
    WHERE pe.user_id = $id
    GROUP BY pe.user_id;
sql;
    return $mysqli->queryAll($query);
  }

  public static function getFacturas($clave)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
    SELECT *
    FROM detalle_facturacion 
    WHERE clave_pp = '$clave'
sql;
    return $mysqli->queryOne($query);
  }

  public static function datosFiscales($user_id)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
    SELECT business_name_iva as razon_social, code_iva as rfc, email_receipt_iva as email_facturacion, postal_code_iva as cp, regimen_fiscal,cfdi
    FROM utilerias_administradores 
    WHERE user_id = $user_id
sql;
    return $mysqli->queryOne($query);
  }

  public static function buscarDetalleCompra($clave, $user_id)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
    SELECT pp.*, pro.iva_producto, pro.nombre as nombre_producto
    FROM pendiente_pago pp
    INNER JOIN productos pro ON (pp.id_producto = pro.id_producto)
    WHERE pp.user_id = $user_id and pp.clave = '$clave'
sql;
    return $mysqli->queryAll($query);
  }

  public static function busUsoCfdi($cfdi)
  {
    $mysqli = Database::getInstance();
    $query = <<<sql
    SELECT *
    FROM cat_uso_cfdi 
    WHERE id_uso_cfdi  = $cfdi
sql;
    return $mysqli->queryOne($query);
  }

  

  
  
}
