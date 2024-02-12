<?php
    require __DIR__ . '/../conexion.php';

    $consulta2 = "SELECT * FROM wp_account WHERE account_rol_aid = '0' ORDER BY account_aid DESC";   
    $resultado2 = $conexion->query($consulta2);

    $html = "
        <table class='table custom-table'>
            <thead class='headTableForQuote'>
                <tr>
                    <td scope='col'>Correo</td>
                </tr>
            </thead>
            <tbody class='bodyTableForQuote'>
    ";
    
    if ($resultado2->num_rows > 0){
        while ($value = $resultado2->fetch_assoc()) {
            $email = $value['account_correo'];

            $html.= "                                    
                <tr>
                    <td>$email</td>
                </tr>
            ";   
        }
    }else {
        $msjNoData = "
            <div class='contentNoDataQuote'>
                <i class='fa-regular fa-face-frown' style='font-size: 2em;'></i>
                <p>No se encontraron datos</p>
            </div>
        ";
    }

    $html.= "
            </tbody>
        </table>
        $msjNoData
    ";

    echo $html;
    $conexion->close();