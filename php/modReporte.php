<?php

  require __DIR__ . '/conexion.php';

  /* $id = $_POST['valorBoton']; */
  $idModReporte = $_POST["idModReporte"];
  $otherModelEdit = $_POST["otherModelEdit"];
  $RDescriptionEdit = $_POST["RDescriptionEdit"];

  $sql = "UPDATE wp_reportes SET R_product = '$otherModelEdit', R_Description = '$RDescriptionEdit' WHERE R_id = '$idModReporte' AND R_estado = 'Pendiente'";
  $res = $conexion->query($sql);
  



  /* $sql = "SELECT * FROM wp_reportes WHERE R_id = '$id'";
  $resultado = $conexion->query($sql);
  $row = mysqli_fetch_array($resultado);
  $idServices = $row['R_id_servicio'];
  $email = $row['R_usuario_agente'];
  $description = $row['R_Description'];
  $categorie = $row['R_category'];
  $model = $row['R_product'];
  $level = $row['R_Nivel'];
  $status = $row['R_estado'];
  $observation = $row['R_observacion'];
  $quote = $row['R_id_cotizacion'];
  $sql2 = "SELECT * FROM wp_account WHERE account_correo = '$email'";
  $resultado2 = $conexion->query($sql2);
  $row2 = mysqli_fetch_array($resultado2);
  $name = $row2['account_nombre'];
  $lastname = $row2['account_apellido'];
  $nameAgent = $name.' '.$lastname;

  $sql3 = "SELECT * FROM wp_servicios WHERE SE_id = '$idServices'";
  $resultado3 = $conexion->query($sql3);
  $row3 = mysqli_fetch_array($resultado3);
  $nameService = $row3['SE_servicio']; */

  /* $html = "
    <span><b>Agente de soporte:</b> $nameAgent</span>
    <span><b>Servicios:</b> $nameService</span>
    <span><b>Categoria:</b> $categorie</span>
    <span><b>Modelo:</b> $model</span>
    <span><b>Descripción:</b> $description</span> 
    <span><b>Nivel:</b> $level</span>
    <hr>
  ";

  if ($status == 'Pendiente'){
    $html.="
      <span style='text-align: center; width: 100%; height: 4rem; padding-top: 1rem; background-color: #e38512; color: #fff;'>$status</span>
    ";
  }else{
    $html.="
      <span style='text-align: center; width: 100%; height: 4rem; padding-top: 1rem; background-color: #0eab13; color: #fff;'>$status</span><br>
      <span><b>Observation applied:</b> $observation</span><br>
      <button class='btn' id='btnViewQuoteReportClient' value='$quote' style='width: 100%; height: 4rem; padding-top: 1rem; background-color: #213280; color: #fff;'><center>Ver cotización$quote</center></button>
    ";
  }

  echo $html; */

  echo $res;

  /* echo json_encode($array, JSON_FORCE_OBJECT); */

  $conexion->close();