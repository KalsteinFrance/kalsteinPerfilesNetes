<?php
    require __DIR__.'/../conexion.php';
   
    if (isset($_POST['quote_id'])){


        $foreignId = $_POST['quote_id'];

        $consulta = "SELECT * FROM wp_cotizacion_detalle WHERE cotizacion_detalle_id = $foreignId";

        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows > 0) {

            $quotes = array();

            while ($row = $resultado->fetch_assoc()) {
                $name = $row['cotizacion_detalle_name'];
                $model = $row['cotizacion_detalle_model'];
                $cant = $row['cotizacion_detalle_cant'];
                $image = $row['cotizacion_detalle_image'];

                $quote = array(
                    "product_name" => $name,
                    "product_model" => $model,
                    "product_quantity" => $cant,
                    "product_image" => $image
                );

                array_push($quotes, $quote);
            }
        }
    }
    
    echo json_encode($quotes);
?>
