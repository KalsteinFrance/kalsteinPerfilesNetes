<?php

    //TABLE
    session_start();
    require __DIR__.'/../conexion.php';


    // POSTS

    $response = array();

    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $page = intval($page);
    $perPage = $_POST['per_page'];
    $type = $_POST['type'];
    $search_term = $_POST['search_term'];

    // TOTAL COUNT

    $queryAll = "SELECT COUNT(*) count FROM wp_mod_log WHERE 1 ";

    if ($type != 'all' && $type != ''){
        $queryAll .= "AND type = '$type'";
    }
    if ($search_term != ''){
        $queryAll .= "AND (moder LIKE '%$search_term%' OR meta LIKE '%$search_term%' OR extra LIKE '%$search_term%')";
    }

    $resultAll = $conexion->query($queryAll);
    
    if(($All = $resultAll->fetch_assoc()['count']) != null){
        if ($All <= ($page - 1) * $perPage){
            $page = intdiv($All, $perPage) + ($All % $perPage > 0 ? 1 : 0);
        }
        $page = max(intval($page), 1);
    }

    // PAGINATION LIMITS 

    $offset = ($page - 1) * $perPage;
    $limit = $perPage;

    // FILTERS

    $query = "SELECT * FROM wp_mod_log WHERE 1 ";

    if ($type != 'all' && $type != ''){
        $query .= "AND type = '$type'";
    }
    if ($search_term != ''){
        $query .= "AND (moder LIKE '%$search_term%' OR receptor LIKE '%$search_term%' OR meta LIKE '%$search_term%' OR extra LIKE '%$search_term%')";
    }
    
    $query .= "ORDER BY date DESC LIMIT $offset, $limit";

    // $response['query'] = $query;
    $result = $conexion->query($query);

    // TABLE PRINT

    $html = "
        <table class='table custom-table'>
            <thead class='headTableForQuote'>
                <tr>
                    <td>item</td>
                    <td>Log ID</td>
                    <td>Moderator</td>
                    <td>Account</td>
                    <td>Type</td>
                    <td>Info</td>
                    <td>Extra. info</td>
                    <td>Date</td>
                </tr>
            </thead>
            <tbody id='tblQuoteClientBody' class='bodyTableForQuote'>
    ";

    if ($result->num_rows > 0){

        $i = ($page - 1) * $perPage;
        
        while ($value = $result->fetch_assoc()) {
            $i = $i + 1;
            $id = $value["ID"];
            $mod = $value["moder"];
            $rec = $value["receptor"];
            $type = $value["type"];
            $meta = $value["meta"];
            $extra = $value["extra"];
            $date = $value["date"];

            $date = new DateTime($date);
            $d = date_format($date, 'M/d/Y');
            $h = date_format($date, 'H:i a');

            $html.= "                                    
                <tr>
                    <td>$i</td>
                    <td>$id</td>
                    <td>$mod</td>
                    <td>$rec</td>
                    <td>$type</td>
                    <td>$meta</td>
                    <td>$extra</td>
                    <td>$d<br>$h</td>
                </tr>
            ";
        }

        $msjNoData = "";
    } else {
        $msjNoData = "
            <div class='contentNoDataQuote'>
                <i class='fa-regular fa-face-frown' style='font-size: 2em;'></i>
                <p>No data found</p>
            </div>
        ";
    }

    $html.= "
            </tbody>
        </table>
        $msjNoData
    ";

    $response['rows'] = $resultsArray;
    $response['html'] = $html;
    $response['page'] = $page;
    $response['hide_prev'] = $page == 1;
    $response['hide_next'] = $page * $perPage >= $All;

    echo json_encode($response);
    $conexion->close();
?>