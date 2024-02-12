<div class="container">
    <header class="header" data-header>
        <?php
            
            include 'navbar.php';

        ?>
        <script>
            let page = "list-order";

            document.querySelector('#link-' + page).classList.add("active");
            document.querySelector('#link-' + page).removeAttribute("style");
        </script>
    </header>

    <article class="container article">
        <?php
            $banner_img = 'Header-fabricante-IMG.png';
            $banner_text = "Sus pedidos";
            include 'banner.php';
        ?>
        
        <nav class="nav nav-borders">
            <a class="nav-link active" href="https://plataforma.kalstein.net/index.php/manufacturer/list-order">Todos los pedidos</a>
            <a class="nav-link" href="https://plataforma.kalstein.net/index.php/manufacturer/list-order/processed">Pedidos procesados</a>
            <a class="nav-link" href="https://plataforma.kalstein.net/index.php/manufacturer/list-order/cancelled">Pedidos cancelados</a>
            <a class="nav-link" href="https://plataforma.kalstein.net/editor-de-plantillas/">Editar plantilla</a>
        </nav>
        
        <br>
        
        <div id="listOrderTable" class="table-responsive">
        <?php
                session_start();
                require __DIR__.'/../../../php/conexion.php';
        
                $acc_id = $_SESSION['emailAccount'];
        
                $perPage = 5;
                $page = isset($_GET['i']) ? $_GET['i'] : 1;
        
               

                $queryTotal = "SELECT COUNT(*) FROM wp_cotizacion WHERE (cotizacion_status = 'Process' OR cotizacion_status = '1') AND cotizacion_id_remitente = '$acc_id'";
                $All = $conexion->query($queryTotal)->fetch_array()[0];

                if ($All <= ($page - 1) * $perPage){
                    $page = intdiv($All, $perPage) + ($All % $perPage > 0 ? 1 : 0);
                }

                $page = max(intval($page), 1);
        
                $offset = ($page - 1) * $perPage;
                $limit = $perPage;

                $consulta = "SELECT * FROM wp_cotizacion WHERE (cotizacion_status = 'Process' OR cotizacion_status = '1') AND cotizacion_id_remitente = '$acc_id' ORDER BY cotizacion_create_at DESC LIMIT $offset, $limit";
                $resultado = $conexion->query($consulta);
        
                $html = "
                <table class='table custom-table'>
                    <thead class='headTableForQuote'>
                        <tr>
                            <th class='fw-bold' style='background-color: #213280; color: white; width: 50px;'>ID</th>
                            <th class='fw-bold' style='background-color: #213280; color: white; width: 150px;'>Cliente</th>
                            <th class='fw-bold' style='background-color: #213280; color: white; width: 150px;'>Método en envío</th>
                            <th class='fw-bold' style='background-color: #213280; color: white; width: 150px;'>Total en (USD)</th>
                            <th class='fw-bold' style='background-color: #213280; color: white; width: 120px;'>Fecha</th>
                            <th class='fw-bold' style='background-color: #213280; color: white; width: 120px;'>Estatus</th>
                            <th class='fw-bold' style='background-color: #213280; color: white; width: 120px;'>Detalles</th>
                            <th class='fw-bold' style='background-color: #213280; color: white; width: 120px;'>Ver</th>
                            <th class='fw-bold' style='background-color: #213280; color: white; width: 120px;'>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class='bodyTableForQuote'>
                ";
        
                if ($resultado->num_rows > 0) {
        
                    while ($row = $resultado->fetch_assoc()) {
                        $quoteId = $row['cotizacion_id'];
                        $quoteClient = $row['cotizacion_atencion'];
                        $quoteEnvio = $row['cotizacion_metodo_envio'];
                        $quoteEnvio = str_replace('Aerial', 'Aereo', $quoteEnvio);
                        $quoteEnvio = str_replace('Maritime', 'Maritimo', $quoteEnvio);
                        $quoteTotal = $row['cotizacion_total'];
                        $quoteDate = $row['cotizacion_create_at'];
                        $quoteStatus = $row['cotizacion_status'];
                        $quoteStatus = str_replace('1', 'Para procesar', $quoteStatus);
                        $quoteClientEmail = $row['cotizacion_id_user'];
        
                        $html .= "
                            <tr>
                                <td>$quoteId</td>
                                <td class='customer-name'>$quoteClient <br> $quoteClientEmail</td>
                                <td>$quoteEnvio</td>
                                <td>$quoteTotal</td>
                                <td>$quoteDate</td>
                                <td>$quoteStatus</td>
                                <td>
                                    <center>
                                        <button type='button' class='fa-solid fa-eye btn-details' style='color: #444 !important; font-size: 16px;' value='$quoteId'></button>
                                    </center>
                                </td>
                                <td>
                                    <a href='https://plataforma.kalstein.net/wp-content/plugins/kalsteinCotizacion/classes/createPDF.php?idCotizacion=$quoteId' id='btnViewQuote' style='margin: 0 auto; color: green;'><i class='fa-solid fa-up-right-from-square'></i></a>
                                </td>
                                <td>
                                    <select name='cotizacion_status' style='color: #000 !important; border: 1px solid #aaa !important; border-radius: 4px' class='status-select''>
                                        <option value=''></option>
                                        <option value='3'>Procesado</option>
                                        <option value='4'>Cancelado</option>
                                    </select>
                                    <button type='button' id='btnUpdate' class='btn btn-info btn-block p-2 mt-2 mx-auto' value='$quoteId'>Cambiar estatus</button>
                                </td>
                            </tr>
                        ";
                    }
        
                    $msjNoData = "";
                } else {
                    $msjNoData = "
                        <tr>
                            <td colspan='9'>
                                <div class='contentNoDataQuote'>
                                    <center><span class='material-symbols-rounded icon'>sentiment_dissatisfied</span></center>
                                    <center><p style='color: #000;'>No hay datos encontrados</p></center>
                                </div>
                            </td>
                        </tr>
                    ";
                }
        
                $html .= "
                    </tbody>
                </table>
                $msjNoData
                ";
        
                $prevPage = $page > 1? $page - 1 : 1;
                $nextPage = $page + 1;

                $hiddenPrev = $page == 1 ? 'hidden' : '';
                $hiddenNext = $page * $perPage >= $All ? 'hidden' : '';

                $html .= "
                    <span> Página $page </span>
                    <div class='pagination'>
                        <form action='' method='get' style='margin-right: 8px' $hiddenPrev>
                            <input type='hidden' name='i' value=".($prevPage).">
                            <input type='submit' style='color: black !important; border: 1px solid #555 !important' value='&laquo; Previo'>
                        </form>
                        <form action='' method='get' $hiddenNext>
                            <input type='hidden' name='i' value=".($nextPage).">
                            <input type='submit' style='color: black !important; border: 1px solid #555 !important' value='Próximo &raquo;'>
                        </form>
                    </div>
                    <input id='hiddenPage' type='hidden' value='$page'>
                ";
                    
                echo $html;
            ?>
        </div>
    </article>

    <?php
        $footer_img = 'Footer-fabricante-IMG.png';
        include 'footer.php';
    ?>
</div>