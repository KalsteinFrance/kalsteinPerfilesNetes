<?php
  require __DIR__ .'/conexion.php';

  $id = $_POST['consulta'];

  $sql = "SELECT * FROM wp_servicios WHERE SE_id = '$id'";
  $resultado = $conexion->query($sql);
  $row = mysqli_fetch_array($resultado);
  $email = $row['SE_correo'];
  $description = $row['SE_description'];
  $categorie = $row['SE_category'];

  $sql2 = "SELECT * FROM wp_account WHERE account_correo = '$email'";
  $resultado2 = $conexion->query($sql2);
  $row2 = mysqli_fetch_array($resultado2);
  $name = $row2['account_nombre'];
  $lastname = $row2['account_apellido'];

  $nameAgent = '<input type="hidden" id="emailAgent" value="'.$email.'"/><input type="hidden" id="idServices" value="'.$id.'"/><b>Agente de Soporte:</b> '.$name.' '.$lastname;
  $descriptionService = '<b>Descripción:</b> '.$description;
  $categorieService = '<b>Categoria:</b> '.$categorie;
  
  $html = "<option selected value='0'>elige una opción</option>";
  $sql3 = "SELECT * FROM wp_k_products WHERE product_category = '$categorie'";
  $resultado3 = $conexion->query($sql3);
  
  while ($model = $resultado3->fetch_assoc()){
    $html .= '<option value="'.$model['product_model'].'">'.$model['product_model'].' - '.$model['product_brand'].'</option>';
  }
  $html .= '<option value="Other">Otro</option>';

  $datos = array(
    'nameAgent' => $nameAgent,
    'descriptionService' => $descriptionService,
    'categorieService' => $categorieService,
    'categorie' => $html
  );

  echo json_encode($datos, JSON_FORCE_OBJECT);

  ?>