<?php
    
    session_start();
    require __DIR__ . '/../conexion.php';

    $acc_id = $_SESSION['emailAccount'];

    $response = array();

    function days_until_monthend(){

        $total_mes = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));    
        $transcurrido = date("d");

        return $total_mes - $transcurrido;
    }

    function prevMonth($month, $delay){
        $res = 0;
        ($month - $delay) < 0 ? $res = $month - $delay + 12 : $res = $month - $delay;

        if ($res < 10) return "0".$res;
        else return $res;
    }

    // TOTAL INCOME

    $m = date('m');
    $m2 = prevMonth($m, 1);

    $before_1_month = date("Y-$m-00 00:00:00");
    $before_2_month = date("Y-$m2-00 00:00:00");

    $query1 = "SELECT SUM(wp_cotizacion.cotizacion_total)
    FROM wp_cotizacion
    WHERE (cotizacion_status = '3' OR cotizacion_status = 'Processed') AND cotizacion_id_remitente = '$acc_id' AND cotizacion_create_at >= '$before_1_month'";
    $query2 = "SELECT SUM(wp_cotizacion.cotizacion_total)
    FROM wp_cotizacion
    WHERE (cotizacion_status = '3' OR cotizacion_status = 'Processed') AND cotizacion_id_remitente = '$acc_id' AND cotizacion_create_at >= '$before_2_month'";

    $result_1 = $conexion->query($query1)->fetch_array()[0];
    $result_2 = $conexion->query($query2)->fetch_array()[0];

    $response['total_income'] = $result_2 - $result_1;

    // INCOME GROW AND INCOME HISTORIC

    $m = date('m');
    $m2 = prevMonth($m, 1);
    $m3 = prevMonth($m, 2);
    $m4 = prevMonth($m, 3);
    $m5 = prevMonth($m, 4);
    $m6 = prevMonth($m, 5);

    $before_6_month = date("Y-$m6-00 00:00:00");
    $before_5_month = date("Y-$m5-00 00:00:00");
    $before_4_month = date("Y-$m4-00 00:00:00");
    $before_3_month = date("Y-$m3-00 00:00:00");
    $before_2_month = date("Y-$m2-00 00:00:00");
    $before_1_month = date("Y-$m-00 00:00:00");

    $query6 = "SELECT SUM(wp_cotizacion.cotizacion_total)
    FROM wp_cotizacion
    WHERE (cotizacion_status = '3' OR cotizacion_status = 'Processed') AND cotizacion_id_remitente = '$acc_id' AND cotizacion_create_at >= '$before_6_month'";
    $query5 = "SELECT SUM(wp_cotizacion.cotizacion_total)
    FROM wp_cotizacion
    WHERE (cotizacion_status = '3' OR cotizacion_status = 'Processed') AND cotizacion_id_remitente = '$acc_id' AND cotizacion_create_at >= '$before_5_month'";
    $query4 = "SELECT SUM(wp_cotizacion.cotizacion_total)
    FROM wp_cotizacion
    WHERE (cotizacion_status = '3' OR cotizacion_status = 'Processed') AND cotizacion_id_remitente = '$acc_id' AND cotizacion_create_at >= '$before_4_month'";
    $query3 = "SELECT SUM(wp_cotizacion.cotizacion_total)
    FROM wp_cotizacion
    WHERE (cotizacion_status = '3' OR cotizacion_status = 'Processed') AND cotizacion_id_remitente = '$acc_id' AND cotizacion_create_at >= '$before_3_month'";
    $query2 = "SELECT SUM(wp_cotizacion.cotizacion_total)
    FROM wp_cotizacion
    WHERE (cotizacion_status = '3' OR cotizacion_status = 'Processed') AND cotizacion_id_remitente = '$acc_id' AND cotizacion_create_at >= '$before_2_month'";
    $query1 = "SELECT SUM(wp_cotizacion.cotizacion_total)
    FROM wp_cotizacion
    WHERE (cotizacion_status = '3' OR cotizacion_status = 'Processed') AND cotizacion_id_remitente = '$acc_id' AND cotizacion_create_at >= '$before_1_month'";

    $result_6 = $conexion->query($query6)->fetch_array()[0];
    $result_5 = $conexion->query($query5)->fetch_array()[0];
    $result_4 = $conexion->query($query4)->fetch_array()[0];
    $result_3 = $conexion->query($query3)->fetch_array()[0];
    $result_2 = $conexion->query($query2)->fetch_array()[0];
    $result_1 = $conexion->query($query1)->fetch_array()[0];

    $response['graph_1'] = [
        $result_6 - $result_5,
        $result_5 - $result_4,
        $result_4 - $result_3,
        $result_3 - $result_2,
        $result_2 - $result_1,
        $result_1
    ];

    // COUNT WILL RESTART

    $response['will_restart'] = days_until_monthend();

    // MOST SELLED PRODUCTS

    $query_sold_6 = "SELECT cotizacion_detalle_name, SUM(cotizacion_detalle_cant) AS total_sold
    FROM wp_cotizacion_detalle
    INNER JOIN wp_cotizacion ON wp_cotizacion_detalle.cotizacion_detalle_id = wp_cotizacion.cotizacion_id
    WHERE (wp_cotizacion.cotizacion_status = '3' OR wp_cotizacion.cotizacion_status = 'Processed') AND wp_cotizacion.cotizacion_id_remitente = '$acc_id' AND wp_cotizacion.cotizacion_create_at >= '$before_6_month'
    GROUP BY cotizacion_detalle_name";

    $result_sold_6 = $conexion->query($query_sold_6);

    $data_sold_6_names = array();
    $data_sold_6_quantity = array();

    while ($row = $result_sold_6->fetch_assoc()) {
        array_push($data_sold_6_names, $row['cotizacion_detalle_name']);
        array_push($data_sold_6_quantity, $row['total_sold']);
    }

    $response['graph_3_names'] = $data_sold_6_names;
    $response['graph_3_quan'] = $data_sold_6_quantity;

    // SOLD PRODUCTS

    $query_sold_1 = "SELECT SUM(cd.cotizacion_detalle_cant)
    FROM wp_cotizacion_detalle cd
    INNER JOIN wp_cotizacion c ON cd.cotizacion_detalle_id = c.cotizacion_id
    WHERE (c.cotizacion_status = '3' OR c.cotizacion_status = 'Processed') AND c.cotizacion_id_remitente = '$acc_id' AND c.cotizacion_create_at >= '$before_1_month'";

    $query_sold_2 = "SELECT SUM(cd.cotizacion_detalle_cant)
    FROM wp_cotizacion_detalle cd
    INNER JOIN wp_cotizacion c ON cd.cotizacion_detalle_id = c.cotizacion_id
    WHERE (c.cotizacion_status = '3' OR c.cotizacion_status = 'Processed') AND c.cotizacion_id_remitente = '$acc_id' AND c.cotizacion_create_at >= '$before_2_month'";

    $result_sold_1 = $conexion->query($query_sold_1);
    $result_sold_2 = $conexion->query($query_sold_2);

    $response['sold_products'] = $result_sold_2->fetch_array()[0] - $result_sold_1->fetch_array()[0];

    // total costumers

    $query = "SELECT COUNT(*) from wp_cotizacion c WHERE (c.cotizacion_status = '3' OR c.cotizacion_status = 'Processed') AND c.cotizacion_id_remitente = '$acc_id'";
    $result = $conexion->query($query);

    $response['total_costumers'] = $result->fetch_array()[0];

    echo json_encode($response);

?>