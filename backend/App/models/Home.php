<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Home{

    public static function getCountByUser($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
    SELECT count(*) as count from pickup where utilerias_asistentes_id = '$id';
sql;
      return $mysqli->queryAll($query);
    }

    public static function getCountPickUp($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT count(*) as count from pickup where utilerias_asistentes_id = '$id';
sql;
        return $mysqli->queryOne($query);
    }

    public static function getProductosById($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM productos WHERE id_producto = $id
sql;
      return $mysqli->queryOne($query);
        
    }

    public static function getProgresosById($id,$clave){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM progresos_productocursos pr
      INNER JOIN utilerias_administradores ua ON pr.user_id = ua.user_id
      WHERE pr.id_producto = $id AND ua.clave = '$clave'
sql;
      return $mysqli->queryOne($query);
        
    }

    public static function getProgresosCongresoById($id,$clave){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT SUM(pr.segundos) as segundos FROM progresos_productocongreso pr
      INNER JOIN videos_congreso vc ON vc.id_video_congreso = pr.id_video_congreso
      INNER JOIN utilerias_administradores ua ON ua.user_id = pr.user_id
      WHERE ua.clave = '$clave' AND vc.id_producto = $id
sql;
      return $mysqli->queryOne($query);
        
    }

    public static function insertImpresionConstancia($user_id,$tipo_constancia,$id_producto){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      INSERT INTO  impresion_constancia (user_id, tipo_constancia, id_producto,fecha_descarga) VALUES('$user_id', '$tipo_constancia','$id_producto',NOW())
sql;

      return $mysqli->insert($query);
    }

    public static function getQRById($id){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      SELECT ra.*
      FROM registros_acceso ra
      INNER JOIN utilerias_asistentes ua
      ON  ra.id_registro_acceso = ua.id_registro_acceso

      WHERE ua.utilerias_asistentes_id = '$id'
sql;
      return $mysqli->queryOne($query);
  }

  public static function getDataUser($user){
    $mysqli = Database::getInstance(true);
    $query=<<<sql
    SELECT * FROM utilerias_administradores WHERE usuario = '$user'
sql;
    return $mysqli->queryOne($query);
  }

  public static function getDataUserById($user_id){
    $mysqli = Database::getInstance(true);
    $query=<<<sql
    SELECT * FROM utilerias_administradores WHERE user_id = $user_id
sql;
    return $mysqli->queryOne($query);
  }

  public static function getFreeCourses(){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT *
      FROM cursos
      WHERE free = 1
sql;

      return $mysqli->queryAll($query);
  }

  public static function insertCursos($registrado, $curso){
    $mysqli = Database::getInstance(1);
    $query=<<<sql
    INSERT INTO asigna_curso (
        id_asigna_curso, 
        id_registrado, 
        id_curso, 
        fecha_asignacion,
        status)

    VALUES (
        null, 
        $registrado, 
        $curso, 
        NOW(), 
        1)
sql;
     

      $id = $mysqli->insert($query);


      $log = new \stdClass();
      $log->_sql= $query;
      // $log->_parametros = $parametros;
      $log->_id = $id;

  return $id;

  }

  public static function getProductosPendComprados($id){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT pp.id_producto,pp.clave, pp.comprado_en,pp.status,ua.nombre,ua.clave_socio,aspro.status as estatus_compra,ua.monto_congreso as amout_due,pro.nombre as nombre_producto, pro.descripcion,pro.precio_publico, pro.precio_socio, pro.tipo_moneda, pro.max_compra, pro.es_congreso, pro.es_servicio, pro.es_curso, pro.tipo, pro.fecha_producto, pp.monto
    FROM pendiente_pago pp
    INNER JOIN utilerias_administradores ua ON(ua.user_id = pp.user_id)
    INNER JOIN productos pro ON (pp.id_producto = pro.id_producto)
    LEFT JOIN asigna_producto aspro ON(pp.user_id = aspro.user_id AND pp.id_producto = aspro.id_producto)
    WHERE ua.user_id = $id GROUP BY id_producto ORDER BY pro.nombre;
sql;
    return $mysqli->queryAll($query);
  }

  public static function getCountProductos($user_id,$id_producto){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT count(*) as numero_productos FROM pendiente_pago WHERE user_id = $user_id and id_producto = $id_producto;
sql;
    return $mysqli->queryAll($query);
  }

  public static function getLastQrPendientePago($user_id){
    $mysqli = Database::getInstance(true);
    $query=<<<sql
    SELECT * FROM pendiente_pago WHERE user_id = $user_id ORDER BY id_pendiente_pago DESC LIMIT 1
sql;
    return $mysqli->queryOne($query);
  }

  public static function getProductosNoComprados($id){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT p.id_producto, p.nombre as nombre_producto, p.descripcion,p.precio_publico, p.precio_socio, p.tipo_moneda,p.precio_publico_usd, p.precio_socio_usd, p.tipo_moneda_usd, p.max_compra, p.es_congreso, p.es_servicio, p.es_curso, p.tipo,p.fecha_producto,ua.clave_socio, ua.monto_congreso as amout_due, ua.socio 
    FROM productos p
    INNER JOIN utilerias_administradores ua
    INNER JOIN costos_productos cp ON (cp.id_producto = p.id_producto and cp.id_categoria = ua.id_categoria)
    WHERE p.id_producto NOT IN (SELECT id_producto FROM pendiente_pago WHERE user_id = $id) AND ua.user_id = $id  and p.status = 1 and tipo != "TALLER" ORDER BY p.nombre;
sql;
    return $mysqli->queryAll($query);
  }

  public static function getTalleres($id){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT p.id_producto, p.nombre as nombre_producto, p.precio_publico, p.precio_socio, p.tipo_moneda,p.precio_publico_usd, p.precio_socio_usd, p.tipo_moneda_usd, p.max_compra, p.es_congreso, p.es_servicio, p.es_curso, p.tipo,p.fecha_producto,p.cupo,ua.clave_socio, ua.monto_congreso as amout_due, ua.socio 
    FROM productos p
    INNER JOIN utilerias_administradores ua
    INNER JOIN costos_productos cp ON (cp.id_producto = p.id_producto and cp.id_categoria = ua.id_categoria)
    WHERE p.id_producto NOT IN (SELECT id_producto FROM pendiente_pago WHERE user_id = $id) and ua.user_id = $id and p.tipo ="Taller"  and p.status = 1 and p.cupo > 0 ORDER BY p.nombre;
sql;
    return $mysqli->queryAll($query);
  }

//   public static function getProductosNoComprados($id){
//     $mysqli = Database::getInstance();
//     $query=<<<sql
//     SELECT p.id_producto, p.nombre as nombre_producto, p.precio_publico, p.tipo_moneda, p.max_compra, p.es_congreso, p.es_servicio, p.es_curso, ua.clave_socio, ua.monto_congreso as amout_due 
//     FROM productos p
//     INNER JOIN utilerias_administradores ua
//     WHERE ua.user_id = $id;
// sql;
//     return $mysqli->queryAll($query);
//   }

  public static function getTipoCambio(){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT * FROM tipo_cambio WHERE id_tipo_cambio = 1
sql;
    return $mysqli->queryOne($query);
  }

  public static function getFormaPago(){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT * FROM cat_forma_pago
sql;
    return $mysqli->queryAll($query);
  }

  public static function updateStatusPendientePaypal($data)
  {
    $mysqli = Database::getInstance(true);

    $query = <<<sql
    UPDATE pendiente_pago SET status = 1, url_archivo = 'PAGO_PAYPAL'  WHERE id_producto = :id_producto AND user_id = :id_registrado AND tipo_pago = 'Paypal' AND status = 0;
sql;
    $parametros = array(
      ':id_producto' => $data->_id_producto,
      ':id_registrado' => $data->_id_registrado
    );
    return $mysqli->update($query, $parametros);
  }

  public static function updateStatusPendienteTarjeta($data)
  {
    $mysqli = Database::getInstance(true);

    $query = <<<sql
    UPDATE pendiente_pago SET status = 1, url_archivo = 'PAGO_TARJETA'  WHERE id_producto = :id_producto AND user_id = :id_registrado AND (tipo_pago = 'Tarjeta_Debito' or tipo_pago = 'Tarjeta_Credito') AND status = 0;
sql;
    $parametros = array(
      ':id_producto' => $data->_id_producto,
      ':id_registrado' => $data->_id_registrado
    );
    return $mysqli->update($query, $parametros);
  }

  public static function getCombo($id_user){
    $mysqli = Database::getInstance(true);
    $query=<<<sql
    SELECT * FROM pendiente_pago WHERE user_id = '$id_user'
sql;
    return $mysqli->queryAll($query);
  }

  public static function updateCheckTalleres($user_id)
  {
    $mysqli = Database::getInstance(true);

    $query = <<<sql
    UPDATE utilerias_administradores SET check_talleres = 1 WHERE user_id = $user_id
sql;
    
    return $mysqli->update($query);
  }

  
}