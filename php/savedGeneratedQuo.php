<?php
  require __DIR__ . '/conexion.php';

  $description = $_POST['description'];
  $datas = $_POST['datas'];
  $id = $_POST['id'];
  $precioMoneda = $_POST["precioMoneda"];
  
  $sql = "SELECT * FROM wp_reportes WHERE R_id = '$id'";
  $result = $conexion->query($sql);
  $row = mysqli_fetch_array($result);
  $idServices = $row['R_id_servicio'];
  $email = $row['R_usuario'];
  $emailAgent = $row['R_usuario_agente'];
  $description2 = $row['R_Description'];
  $categorie = $row['R_category'];
  $model = $row['R_product'];
  $level = $row['R_Nivel'];
  $status = $row['R_estado'];

  $sql2 = "SELECT * FROM wp_account WHERE account_correo = '$email'";
  $result2 = $conexion->query($sql2);
  $row2 = mysqli_fetch_array($result2);
  $name = $row2['account_nombre'];
  $lastname = $row2['account_apellido'];
  $nameUser = $name.' '.$lastname;

  $sql3 = "SELECT * FROM wp_servicios WHERE SE_id = '$idServices'";
  $result3 = $conexion->query($sql3);
  $row3 = mysqli_fetch_array($result3);
  $nameService = $row3['SE_servicio'];
  $total = '0';

  foreach ($datas as $key => $value) {
    $cant = $value['cant'];
    $price = $value['price'];
    $subtotal = $price * $cant;
    $total = $total + $subtotal;
  }

  $register = "INSERT INTO wp_cotizacion(cotizacion_id, cotizacion_id_user, cotizacion_sres, cotizacion_atencion, cotizacion_create_at, cotizacion_divisa, cotizacion_total, cotizacion_status, cotizacion_id_remitente) VALUES ('', '$emailAgent', '$nameUser', '$nameUser', CURRENT_TIMESTAMP, '$precioMoneda', '$total', 'Pendiente', '$email')";
  if ($conexion->query($register) === TRUE) {   
    $query = "SELECT * FROM wp_cotizacion ORDER BY cotizacion_id DESC";
    $result = $conexion->query($query);
    $col = mysqli_fetch_array($result);
    $idCotizacion = $col['cotizacion_id'];
    foreach ($datas as $key => $value) {
      $cant = $value['cant'];
      $description3 = $value['description'];
      $price = $value['price'];
      $subtotal = $price * $cant;
      $register2 = "INSERT INTO wp_cotizacion_detalle(cotizacion_detalle_aid, cotizacion_detalle_id, cotizacion_detalle_name, cotizacion_detalle_cant,  cotizacion_detalle_valor_unit, cotizacion_detalle_valor_total, cotizacion_divisa) VALUES ('', '$idCotizacion', '$description3', '$cant', '$price', '$subtotal', '$precioMoneda')";
      if ($conexion -> query($register2) === TRUE) {
        $update = "UPDATE wp_reportes SET R_observacion = '$description', R_estado = 'Procesado', R_id_cotizacion = '$idCotizacion' WHERE R_id = '$id'";
        if ($conexion -> query($update) === TRUE) {
          $correct = 'correcto';
        }else{
          $correct = 'incorrecto';
        }
      }
    }
  }

  $datos = array(
    'registro' => $correct,
    'id' => $idCotizacion
);

echo json_encode($datos, JSON_FORCE_OBJECT);
$conexion->close();