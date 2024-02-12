<?php
    /* require __DIR__ . '/../../../php/conexion.php';
    
    $p_id = isset($_GET['p']) ? $_GET['p'] : '';
    if($p_id == ''){
        $p_id = isset($_GET['id']) ? $_GET['id'] : '';
    }

    $p_id = $p_get_id ? $p_get_id : $p_id;

    $manu_preview = isset($in_manu_or_distri)? true : false;
    
    $consulta = "SELECT * FROM wp_k_products WHERE product_aid = '$p_id'";
    $resultado = $conexion->query($consulta);

    $row = mysqli_fetch_array($resultado);
    $count = mysqli_num_rows($resultado);

    if ($count > 0){
        $name = $row["product_name_es"];
        $model = $row["product_model"];
        $brand = $row["product_brand"];
        $description = $row["product_description_es"];
        $category = $row["product_category"];
        $subcategory = $row["product_subcategory"];
        $image = $row["product_image"];
        $type =  $row['product_type'];
        $condition =  $row['product_condition'];
        $price = $row["product_priceUSD"];
        
        $multi = $price * 0.18;
        $disc = round($price - $multi, 2);
        
        $table = $row["product_technical_description_es"];
        
        $used = $type == 'used'? "<p><strong>Condición</strong>: <em>$condition</em></p>" : '';

        $consulta2 = "SELECT * FROM wp_k_products WHERE (product_model LIKE '%$model%' OR product_parent = '$p_id') AND product_group = '1'";
        $resultado2 = $conexion->query($consulta2);

    }
?>
<style>
    #product-container {
        font-family: "Roboto", Arial, sans-serif;
    }

    .p-prev-table {
        width: 100%;
    }
    .p-prev-table > table {
        width: 100%;
    }

    .p-prev-table th {
        background-color: #fff;
        color: #000;
        border: 1px solid #aaa;
        padding: 12px;
    }
    
    .p-prev-table td {
        background-color: #fff;
        color: #000;
        border: 1px solid #0000001f;
        padding: 12px;
    }

    .p-prev-table tr td:first-child {
        font-weight: bold;
    }

    #btn-quote-back {
        border-radius: 50%;
        background-color: #aaa;
        box-shadow: 13px 11px 35px -11px rgba(0,0,0,0.75);
        display: flex;
        cursor: pointer;
        position: fixed;
        width: 40px;
        height: 40px;
        justify-items: center;
        align-items: center;
        margin-top: -40px;
        top: 60mm;
        left: 5mm;
    }

    #btn-quote-back i {
        margin: auto;
    }

    #product-container ul br, #product-container .section br {
        display: none;
    }

    #product-container ul > li {
        margin-bottom: 5px;
        margin-left: 15px !important;
    }

    #product-container ul > li::marker {
        content: "  •   ";
        display: inline-block;
    }

    #product-container h2, #product-container h3, #product-container h4 {
        font-weight: 400;
    }

    #product-container h6 {
        margin-top: 12px;
    }

    #product-container h2, #product-container h3{
        font-size: 2em;
        word-wrap: break-word;
    }

    .accordion-button {
        text-align: left;
        background-color: #fff;
        color: #000;
        border: 1px solid #aaa;
        padding: 12px;
    }

    .accordion-button:hover {
        background-color: #eee;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion-collapse {
        padding: 10px;
        border: 1px solid #aaa;
        margin-top: 10px;
        background-color: #fff;
    }

  
    .form-check-label {
        white-space: nowrap; 
        overflow: hidden; 
        text-overflow: ellipsis;
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        margin-bottom: 5px; 
    }

    .form-check-input {
        width: 1.2em; 
    }

    .form-check-input:checked + .form-check-label::before {
        border: 1px solid #000; 
        background-color: #000; 
        color: #fff; 
    }

</style>

<?php echo !isset($_GET['id']) ? '<div id="btn-quote-back"><i class="fa-solid fa-chevron-left"></i></div>' : ''?>
<div id="product-container" class="container-fluid">

    <h2><?php echo $name.($type == 'used'? '(Used)': '') ?> <!--span id='btnShare' class='d-inline ms-2' style='cursor: pointer' value='<?php echo $model?>'><i class="fa-solid fa-share-nodes" style="color: #213280; font-size: 25px"></i></span--></h2>

    <!-- PRODUCT HEADING-->

    <div class="row">
        <div class="col-sm-6 order-sm-last">
            <img
                src="<?php echo $image?>"
                title="<?php echo $name?>"
            />
        </div>

        <div class="col-12 col-sm-6">
            <input type="hidden" id="woo-meta-model" data-model="<?php echo $model?>">
            <div>
                <p class='mb-0'><strong>Fabricante</strong>: <em><?php echo $brand?></em></p>
                <p class='mb-0'><strong>Modelo</strong>: <em><?php echo $model?></em></p>
                <?php echo $used?>
                <p>
                    <img class="alignnone size-full wp-image-29188"
                        src="https://kalstein.net/en/wp-content/uploads/2022/01/CE.jpg" alt="" width="54" height="53" />
                </p>
                <div class='d-flex flex-row'>
                    <div>
                        <p class='card-text'><small class='text-muted'><?php echo number_format($disc, 2)?> -18% de descuento con pre-orden</small></p>
                        <h6 class='my-0 mb-1'>USD$ <?php echo number_format($price, 2)?></h6>
                        <?php
                            if (!$manu_preview){
                                $html = "
                                    <div><span class='quantity d-inline'>Cantidad:</span> <input type='number' class='i-cant d-inline' id='i-cant-woo-$model' product='$model' value='1' style='width: 20mm; margin-left: 2mm; margin-top: -2mm;'></div>
                                ";

                                $html.="  
                                        <button value='$model' class='btnQuo'>Cotizar</button>
                                        <button class='activeModal' data-bs-toggle='modal' data-bs-target='#cotModal' style='display: none;'></button>
                                ";

                            }

                            if ($resultado2->num_rows > 0) {
                                $html .= "
                                    <div class='accordion accordion-flush mt-3' id='accordionFlushExample'>
                                        <div class='accordion-item'>
                                            <input type='hidden' id='ih-accesories-add' value='0'>
                                            <h6 class='accordion-header'>
                                                <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapseOne' aria-expanded='false' aria-controls='flush-collapseOne'>
                                                    Accesorios adicionales
                                                </button>
                                            </h6>
                                            <div id='flush-collapseOne' class='accordion-collapse collapse' data-bs-parent='#accordionFlushExample'>
                                                <div class='accordion-body'>
                                                    <div class='row'>
                                ";

                                while ($value = $resultado2->fetch_assoc()) {
                                    $modelAccesorie = $value['product_model'];
                                    $nameAccesorie = $value['product_name_es'];
                                    $priceAccesorie = $value['product_priceUSD'];
                            
                                    $html .= "
                                                        <div class='col-sm-12 mb-3'>
                                                            <div class='form-check'>
                                                                <input id='form-check-input' class='form-check-input' type='checkbox' value='$modelAccesorie' id='chk-$modelAccesorie'>
                                                                <label class='form-check-label' for='chk-$modelAccesorie' style='margin-left: 0.5em; font-size: 0.8em; white-space: nowrap;'>
                                                                    $nameAccesorie USD$ $priceAccesorie
                                                                </label>      
                                                            </div>
                                                            <i class='fa-solid fa-circle-exclamation btn-view-accessory' style='color: #aaa' data-id='$idAccesorie'></i>
                                                        </div>
                                    ";
                                }

                                $html.="                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";

                                echo $html;
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- DESCRIPTION -->
    <div>
        <h4>Descripción del producto</h4>

        <p>
            <?php echo $description?>
        </p>

        <!-- RENDER TABLE -->

        <?php
            if (strpos($table, '</table>')){
                echo "
                <h4>Detalles</h4>
                <div class='p-prev-table' style='overflow-x: scroll'>
                    $table
                </div>
                ";
            }
            else {
                if ($table != ''){
                    echo "
                    <h4>Detalles</h4>
                    <div style='overflow-x: scroll'>
                        <table class='p-prev-table'>
                            $table
                        </table>
                    </div>
                    ";
                }
            }
        ?>

        <?php
            if(!$manu_preview) include __DIR__.'/quotes/widget-related-products.php';
        ?>
    </div>
</div> */

require __DIR__ . '/../../../php/conexion.php';
    
$p_id = isset($_GET['p']) ? $_GET['p'] : '';
if($p_id == ''){
    $p_id = isset($_GET['id']) ? $_GET['id'] : '';
}

$p_id = $p_get_id ? $p_get_id : $p_id;

$manu_preview = isset($in_manu_or_distri)? true : false;

$consulta = "SELECT * FROM wp_k_products WHERE product_aid = '$p_id'";
$resultado = $conexion->query($consulta);

$row = mysqli_fetch_array($resultado);
$count = mysqli_num_rows($resultado);

if ($count > 0){
    $name = $row["product_name_es"];
    $maker = $row["product_maker"];
    $model = $row["product_model"];
    $brand = $row["product_brand"];
    $description = $row["product_description_es"];
    $category = $row["product_category"];
    $subcategory = $row["product_subcategory"];
    $image = $row["product_image"];
    $type =  $row['product_type'];
    $condition =  $row['product_condition'];
    $price = $row["product_priceUSD"];
    
    $multi = $price * 0.18;
    $disc = round($price - $multi, 2);
    
    $table = $row["product_technical_description_es"];
    
    $used = $type == 'used'? "<p><strong>Condición</strong>: <em>$condition</em></p>" : '';

    $consulta2 = "SELECT * FROM wp_k_products WHERE (product_model LIKE '%$model%' OR product_parent = '$p_id') AND product_group = '1'";
    $resultado2 = $conexion->query($consulta2);

    if ($maker == 'KALSTEIN-INTERNAL'){
        $company = 'Kalstein France S.A.S';
        $country = 'Francia';
    }else{        
        $consulta3 = "SELECT * FROM wp_company WHERE company_account_correo = '$maker'";
        $resultado3 = $conexion->query($consulta3);
        $row3 = mysqli_fetch_array($resultado3);
        $company = $row3['company_nombre'];
        $isoCountry = $row3['company_pais'];

        $consulta4 = "SELECT * FROM wp_paises WHERE iso = '$isoCountry'";
        $resultado4 = $conexion->query($consulta4);
        $row4 = mysqli_fetch_array($resultado4);
        $country = $row4['es'];
    }

}
?>
<style>
 #product-container {
        font-family: "Roboto", Arial, sans-serif;
    }

    .p-prev-table {
        width: 100%;
    }

    .p-prev-table > table {
        width: 100%;
    }

    .p-prev-table th {
        background-color: #fff;
        color: #000;
        border: 1px solid #aaa;
        padding: 12px;
    }

    .p-prev-table td {
        background-color: #fff;
        color: #000;
        border: 1px solid #0000001f;
        padding: 12px;
    }

    .p-prev-table tr td:first-child {
        font-weight: bold;
    }

    #btn-quote-back {
        border-radius: 50%;
        background-color: #aaa;
        box-shadow: 13px 11px 35px -11px rgba(0,0,0,0.75);
        display: flex;
        cursor: pointer;
        position: fixed;
        width: 40px;
        height: 40px;
        justify-items: center;
        align-items: center;
        margin-top: -40px;
        top: 60mm;
        left: 5mm;
    }

    #btn-quote-back i {
        margin: auto;
    }

    #product-container ul br, #product-container .section br {
        display: none;
    }

    #product-container ul > li {
        margin-bottom: 5px;
        margin left: 15px !important;
    }

    #product-container ul > li::marker {
        content: "  •   ";
        display: inline-block;
    }

    #product-container h2, #product-container h3, #product-container h4 {
        font-weight: 400;
    }

    #product-container h6 {
        margin-top: 12px;
    }

    #product-container h2, #product-container h3 {
        font-size: 2em;
        word-wrap: break-word;
    }

    .accordion-button {
        text-align: left;
        background-color: #fff;
        color: #000;
        border: 1px solid #aaa;
        padding: 12px;
    }

    .accordion-button:hover {
        background-color: #eee;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .form-check {
        display: flex;
        align-items: center;
    }

    .form-check-label {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex-grow: 1;
        margin-bottom: 5px;
    }

    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-right: 10px;
        border: 2px solid #000;
        background-color: #fff;
        border-radius: 4px;
        transition: background-color 0.2s, border-color 0.9s;

      
    }

    .form-check-input:checked {
        background-color: #213280; 
        border-color: #213280; 
    }

    .form-check-input:hover {
        background-color: #eee; 
        border-color: #eee; 
    }

    .form-check-input:focus {
        box-shadow: 0 0 5px #000; 
        outline: none; 
    }
</style>

<?php echo !isset($_GET['id']) ? '<div id="btn-quote-back"><i class="fa-solid fa-chevron-left"></i></div>' : ''?>
<div id="product-container" class="container-fluid">

<h2><?php echo $name.($type == 'used'? '(Used)': '') ?> <!--span id='btnShare' class='d-inline ms-2' style='cursor: pointer' value='<?php echo $model?>'><i class="fa-solid fa-share-nodes" style="color: #213280; font-size: 25px"></i></span--></h2>

<!-- PRODUCT HEADING-->

<div class="row">
    <div class="col-sm-6 order-sm-last">
        <img
            src="<?php echo $image?>"
            title="<?php echo $name?>"
        />
        <p class='mb-0'><strong>Empresa</strong>: <em id='btnCompanyPreview'><?php echo $company?></em></p>
        <p class='mb-0'><strong>País</strong>: <em><?php echo $country?></em></p>
    </div>

    <div class="col-12 col-sm-6">
        <input type="hidden" id="woo-meta-model" data-model="<?php echo $model?>">
        <div>
            <p class='mb-0'><strong>Fabricante</strong>: <em><?php echo $brand?></em></p>
            <p class='mb-0'><strong>Modelo</strong>: <em><?php echo $model?></em></p>
            <?php echo $used?>
            <p>
                <img class="alignnone size-full wp-image-29188"
                    src="https://kalstein.net/en/wp-content/uploads/2022/01/CE.jpg" alt="" width="54" height="53" />
            </p>
            <div class='d-flex flex-row'>
                <div>
                    <p class='card-text'><small class='text-muted'><?php echo number_format($disc, 2)?> -18% de descuento con pre-orden</small></p>
                    <h6 class='my-0 mb-1'>USD$ <?php echo number_format($price, 2)?></h6>
                    <?php
                        if (!$manu_preview){
                            $html = "
                                <div><span class='quantity d-inline'>Cantidad:</span> <input type='number' class='i-cant d-inline' id='i-cant-woo-$model' product='$model' value='1' style='width: 20mm; margin-left: 2mm; margin-top: -2mm;'></div>
                            ";

                            $html.="  
                                    <button value='$model' class='btnQuo'>Cotizar</button>
                                    <button class='activeModal' data-bs-toggle='modal' data-bs-target='#cotModal' style='display: none;'></button>
                            ";

                            if ($resultado2->num_rows > 0) {
                                $html .= "
                                    <div class='accordion accordion-flush mt-3' id='accordionFlushExample'>
                                        <div class='accordion-item'>
                                            <input type='hidden' id='ih-accesories-add' value='0'>
                                            <h6 class='accordion-header'>
                                                <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapseOne' aria-expanded='false' aria-controls='flush-collapseOne'>
                                                    Accesorios adicionales
                                                </button>
                                            </h6>
                                            <div id='flush-collapseOne' class='accordion-collapse collapse' data-bs-parent='#accordionFlushExample'>
                                                <div class='accordion-body'>
                                                    <div class='row'>
                                ";

                                while ($value = $resultado2->fetch_assoc()) {
                                    $idAccesorie = $value['product_aid'];
                                    $modelAccesorie = $value['product_model'];
                                    $nameAccesorie = $value['product_name_es'];
                                    $priceAccesorie = $value['product_priceUSD'];
                                
                                    $truncatedName = (strlen($nameAccesorie) > 30) ? substr($nameAccesorie, 0, 30) . '...' : $nameAccesorie;
                                
                                    $html .= "
                                    <div class='col-sm-12 mb-3'>
                                        <div class='form-check'>
                                            <input id='form-check-input' class='form-check-input' type='checkbox' value='$modelAccesorie' id='chk-$modelAccesorie'>
                                            <label class='form-check-label' for='chk-$modelAccesorie'>
                                                <div style='display: flex; align-items: center;'>
                                                    <span style='flex: 2;'>$truncatedName</span>
                                                    <span style='flex: 1; margin: 0 10px;'>USD$ $priceAccesorie</span>
                                                <div style='display: flex; flex-direction: column; align-items: center; text-align: center;'>
                                                    <i class='fa-solid fa-eye btn-view-accessory' style='color: #aaa; flex: 1;' data-id='$idAccesorie'></i>
                                                    <span>Ver</span>
                                                </div>
                                                    
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    ";
                                }

                                $html.="                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                            }

                            echo $html;
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- DESCRIPTION -->
<div>
    <h4>Descripción de producto</h4>

    <p>
        <?php echo $description?>
    </p>

    <!-- RENDER TABLE -->

    <?php
        if (strpos($table, '</table>')){
            echo "
            <h4>Detalles</h4>
            <div class='p-prev-table' style='overflow-x: scroll'>
                $table
            </div>
            ";
        }
        else {
            if ($table != ''){
                echo "
                <h4>Detalles</h4>
                <div style='overflow-x: scroll'>
                    <table class='p-prev-table'>
                        $table
                    </table>
                </div>
                ";
            }
        }
    ?>

    <?php
        if(!$manu_preview) include __DIR__.'/quotes/widget-related-products.php';
    ?>
</div>
</div>