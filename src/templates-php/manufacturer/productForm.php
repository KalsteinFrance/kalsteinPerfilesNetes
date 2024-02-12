<?php
    // El Barto was here
    if ($add){
        $stock_inputs = "
        <div class='form-group mb-3 col-12'>
            <label>Unidades en existencias</label>
            <input id='stockProduct' type='number' placeholder='0' class='form-control validate' min='0'/>
        </div>
        <div class='form-group mb-3 col-xs-12 col-sm-6' hidden>
            <label>Status</label>
            <select  id='statusProduct' style='width: 200px'>
                <option class='text-dark' value='in stock'> En existencias </option>
                <option class='text-dark' value='out of stock'> Agotado </option>
            </select>
        </div>
        ";
    }
    else{
        $stock_inputs = "
        <div class='form-group mb-3 col-12 col-sm-6'>
            <label>Unidades en existencias</label>
            <input id='stockProduct' type='number' placeholder='0' class='form-control validate' min='0'/>
        </div>
        <div class='form-group mb-3 col-12 col-sm-6'>
            <label>Status</label>
            <select  id='statusProduct' style='width: 200px'>
                <option class='text-dark' value='in stock'> En existencias </option>
                <option class='text-dark' value='out of stock'> Agotado </option>
            </select>
        </div>
        ";
    }
?>
<style>
    .tm-edit-product-form input, .tm-edit-product-form select {
        border-color: #999;
        border-radius: 0.35rem;
    }
    .tm-edit-product-form textarea{
        border-color: #999;
        border-radius: 0;
    }
    .tm-edit-product-form input::placeholder, .tm-edit-product-form textarea::placeholder{
        color: #bbb;
    }
    .stock-title {
        background-color: #213280;
        color: white;
        padding: 5px;
        border-radius: 0.25rem;
        font-size: 18px;
        text-align: center;
        margin-bottom: 15px;
    }
    .stock-special-input {
        border-radius: 0 !important;
        margin: 5px 0;
        padding: 5px !important;
        height: auto !important;
    }
    label {
        font-weight: bold;
    }
    .table-editor-selector{
        border: 1px solid #333;
        display: flex;
        flex-direction: row;
        width: 380px;
    }
    .table-editor-selector > div{
        box-sizing: border-box;
        margin: 0;
        padding: 8px;
        width: 100%;
        text-align: center;
        font-weight: bold;
        cursor: pointer;
    }
    .table-editor-selector:first-child, .table-editor-selector:nth-child(2){
        border-right: 1px solid #333;
    }
    .table-editor-selector > div.selected{
        background-color: #333;
        color: #fff;
    }

    .p-prev-table {
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
        border: 1px solid #aaa;
        padding: 12px;
    }
    .p-prev-table tr td:first-child {
        font-weight: bold;
    }

    .btn-clipboard{
        background-color: #213280;
        color: white;
        padding: 5px;
        border-radius: 0.25rem;
        width: 200px;
        cursor: pointer;
    }

    #stock-table-keys {
        padding: 0;
    }
    #stock-table-values {
        padding: 0;
    }
    #stock-table-keys > div{
        background-color: #fff;
        color: #000;
        border: 1px solid #aaa;
        font-weight: bold;
    }
    #stock-table-values > div{
        background-color: #fff;
        color: #000;
        border: 1px solid #aaa;
    }
    #stock-table-keys > div > input, #stock-table-values > div > input{
        padding: 12px;
        width: 100%;
        height: 100%;
        margin: 0;
        padding: auto;
        border: none
    }

    .stock-table-buttons {
        display: row;
        font-weight: 12px;
        display: flex;
        width: 100px;
        margin-top: 10px;
    }
    #stock-table-button-plus {
        padding: 5px;
        font-size: 15px;
        font-weight: bold;
        background-color: #333;
        color: #fff;
        width: 100%;
        text-align: center;
    }
    #stock-table-button-minus {
        padding: 5px;
        font-size: 15px;
        font-weight: bold;
        background-color: #ddd;
        border: 1px solid #333;
        color: #333;
        width: 100%;
        text-align: center;
    }
    select {
        outline: 1px solid #1110;
        transition: outline .3s, border-color 0.3s;
    }
    select:focus {
        outline: 1px solid yellow;
        border-color: #000;
    }

    .triplette {
        display: flex;
        flex-direction: row;
        border: 1px solid #999;
        border-radius: 0.35rem;
    }

    .triplette input {
        border: none;
        margin: 0;
        border-right: 1px solid #999;
        border-radius: 0;
    }
    .triplette input:last-child {
        border-right: none;
    }
    .accordion-button:focus {
        z-index: 0;
    }

    .accessoryTarget {
        transition: background-color .2s;
    }
    .accessoryTarget:hover {
        background-color: #eee;
        cursor: pointer;
    }
</style>
<form method="post" class="tm-edit-product-form">
    <div class="row">

        <?php echo $add ? '<div class="col-12"><div class="stock-title">Añadir un nuevo producto</div></div>' : '<div class="col-12"><div class="stock-title">Edit product</div></div>'?>
        <!-- BASIC DATA -->
        <div class="col-12 col-md-6">

            <label>Nombre</label>
            <input id="nameProduct" type="text" class="form-control validate mb-3" placeholder="Nombre"/>

            <!-- true brand input -->
            <input type="hidden" id="productBrand" value="<?php
                $b = $conexion->query("SELECT company_nombre FROM wp_company WHERE company_account_correo = '$acc_id'");
                $brand = $b->fetch_assoc()['company_nombre'];
                echo $brand;
            ?>">
            
            <!-- fake brand input -->
            <label>Marca</label>

            <input type="text" class="form-control validate mb-3" value="<?php echo $brand?>" disabled/>
            
            <label>Modelo</label>
            <input id="modelProduct" type="text" class="form-control validate mb-3" placeholder="Modelo"/>
            
        </div>

        <img id='imgLoad' hidden/><!-- trash??? -->

        <!-- PRODUCT IMAGE -->
        <div class="col-12 col-md-6 mb-4">
            <label>Imagen del producto</label>
            <div class="custom-file mt-3 mb-3">
                <label for="file-input" class="drop-container" id="dropcontainerImage">
                    <span class="drop-title">Seleccionar o arrastrar y soltar una imagen</span>
                    <img class="drop-image" src="https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/src/images/IMAGE-document.png" alt="pdf">
                    <img id="thumbnail"/>
                </label>
                <input type="file" id="file-input">
            </div>
        </div>

        <div class="col-12 mb-4">
            <label>Descripción</label>
            <textarea style="height: 200px" id="descriptionProduct" class="form-control validate tm-small" placeholder="Describa su producto en menos de 5000 caracteres
            "></textarea>
        </div>
    </div>

    <!-- TABLA TECNICA -->

    <div class="row">
        <label>Ficha técnica</label>
        <div class="col-12">
            <div class='table-editor-selector mb-3'>
                <div id='stock-ignore-table' class="selected">
                    Ninguno
                </div>
                <div id='stock-basic-editor'>
                    Tabla básica
                </div>
                <div id='stock-excel-editor'>
                    Tabla Excel
                </div>
            </div>
            <input type="hidden" id="table-mode" value="ignore">
            
            <!-- BASIC -->
            <div id="stock-basic-table" class="mb-4" hidden>
                
                <div>

                    <div class='stock-table-buttons mb-3'>
                        <button id="stock-table-button-plus">+</button>
                        <button id="stock-table-button-minus">-</button>
                    </div>
                    <small>Toca las celdas para editarlas</small>
                    <div class="row">
                        <div id="stock-table-keys" class="col-6">
                            <div><input id="table-keys-1" type="text" value="Example"></div>
                            <div><input id="table-keys-2" type="text" value="Example"></div>
                        </div>
                        <div id="stock-table-values" class="col-6">
                            <div><input id="table-values-1" type="text" value="example"></div>
                            <div><input id="table-values-2" type="text" value="example"></div>
                        </div>
                    </div>

                </div>
                
            </div>

            <!-- EXCEL -->
            <div id="stock-excel-table" class="mb-4" hidden>

                Incluya una tabla de Microsoft Excel o csv
                
                <div id="paste-excel-clipboard" class="btn-clipboard mb-3">
                    Pegar desde el portapapeles <i class="fa-regular fa-clipboard"></i>
                </div>

                <textarea id="csv" hidden>example</textarea>

                <span>Tiene cabecera <input type="checkbox" id="has_headers" style="border-radius: 0" class="d-inline"></span>

                <label>Vista previa</label>
                <table id="resultTable" class='table p-prev-table'>
                    <thead>
                        <th>Ejemplo</th>
                        <th>ejemplo</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ejemplo</td>
                            <td>ejemplo</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    <div>
        
    <!-- PRODUCT DATA -->

    <div class="col-12">
        <div class="stock-title">Datos del producto</div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 form-group mb-3">
            <label>Categoría</label>
            <select id="dataCategory" class="custom-select tm-select-accounts">
                <option value=''>-- Elija una opción --</option>
                <?php
                    require __DIR__.'/../../../php/conexion.php';
                
                    $consulta = "SELECT categorie_description_es FROM wp_categories ORDER BY categorie_description ASC";
                        
                    $resultado = $conexion->query($consulta);

                    $already_printed = [];
                        
                    if ($resultado->num_rows > 0) {
                        while ($value = $resultado->fetch_assoc()) {
                            if (!in_array($value['categorie_description_es'], $already_printed)){
                                array_push($already_printed, $value['categorie_description_es']);
                                echo "<option value='".$value['categorie_description_es']."'>".$value['categorie_description_es']."</option>";
                            }
                        }
                    }
                ?>
            </select>
        </div>
        <div class="col-12 col-sm-6">
            <div class="row">
                <?php echo $stock_inputs?>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <!-- GROSS -->
        <div class="col-sm-6 col-xsm-12">
            <h6 class="tm-block-title mb-0">Producto <i class="fas fa-microscope"></i></h6>
            <label>Peso neto (kg)</label>
            <input
                id="weProduct"
                type="number"
                step="0.01"
                placeholder="0.00"
                class="form-control validate mb-2"
                data-large-mode="true"
                min="0"
            />
            
            <label>Anchura / altura / longitud netas (cm)</label>
            <div class='triplette mb-2'>
                <input
                    id="wiProduct"
                    type="number"
                    placeholder="0.00"
                    min="0"
                />
                <input
                    id="heProduct"
                    type="number"
                    placeholder="0.00"
                    min="0"
                />
                <input
                    id="leProduct"
                    type="number"
                    placeholder="0.00"
                    min="0"
                />
            </div>
        </div>
        <!-- PACKAGED -->
        <div class=" col-sm-6 col-xsm-12">
            <h6 class="tm-block-title mb-0">Empaquetado <i class="fas fa-box"></i></h6>
            <label>Peso bruto (kg)</label>
            <input
                id="weProductPa"
                type="number"
                step="0.01"
                placeholder="0.00"
                class="form-control validate mb-2"
                data-large-mode="true"
                min="0"
            />

            <label>Anchura / altura / longitud brutas (cm)</label>
            <div class="triplette mb-2">
                <input
                    id="wiProductPa"
                    type="number"
                    placeholder="0.00"
                    min="0"
                />
                <input
                    id="heProductPa"
                    type="number"
                    placeholder="0.00"
                    min="0"
                />
                <input
                    id="leProductPa"
                    type="number"
                    placeholder="0.00"
                    min="0"
                />
            </div>

            <label>Tipo de paquete</label>
            <select id="packageType">
                <option class="text-dark" value="">-- Seleccionar --</option>
                <option class="text-dark" value="carton">Caja de cartón</option>
                <option class="text-dark" value="wooden">Caja de madera</option>
            </select>
        </div>
    </div>

    <!-- PRICING -->

    <div class="col-12">
        <div class="stock-title">Precios</div>
    </div>

    <div class="row">
        <div class="form-group mb-3 col-sm-6 col-xsm-12">
            <label>Precio unitario</label>
            <input
                id="priceProduct"
                type="number"
                step="0.01"
                placeholder="0.00"
                class="form-control mb-1 validate"
                min="0"
            />
        </div>
        <div class="form-group mb-3 col-sm-6 col-xsm-12">
            <label>Moneda <i class="far fa-money-bill-1 h5"></i></i></label>
            <select id="currency">
                <option class="text-dark" value="">-- Seleccionar --</option>
                <option class="text-dark" value="USD">USD</option>
                <option class="text-dark" value="EUR">EUR</option>
            </select>
        </div>

        <h6 class="tm-block-title mb-0">Descuento al por mayor 1 (opcional)</h6>
        <div class='form-group col-12 mb-3 ms-3'>
            Aplicar <input style="width: 45px;"
                id="discount1"
                type="number"
                placeholder="0"
                class="form-control validate mb-2 d-inline-block stock-special-input"
                min="0"
                max="100"
            /> % descuento de 
            <input style="width: 55px;"
                id="discount1Amount"
                type="number"
                placeholder="24"
                class="form-control validate d-inline-block stock-special-input"
                min="0"
            /> unidades
        </div>
        
        <h6 class="tm-block-title mb-0">Descuento al por mayor 2 (opcional)</h6>
        <div class='form-group col-12 mb-3 ms-3'>
            Aplicar <input style="width: 45px;"
                id="discount2"
                type="number"
                placeholder="0"
                class="form-control validate mb-2 d-inline-block stock-special-input"
                min="0"
                max="100"
            /> % descuento de 
            <input style="width: 55px;"
                id="discount2Amount"
                type="number"
                placeholder="50"
                class="form-control validate d-inline-block stock-special-input"
                min="0"
            /> unidades
        </div>
    </div>
    
    <!-- PRICING -->

    <div class="col-12">
        <div class="stock-title">Accesorios</div>
    </div>

    <div class="row mb-3 d-flex justify-content-center">
        <div class="accordion col-12 col-md-8" id="accordionExample">

            <!-- ACORDEON ACCESSORY -->

            <div class="accordion-item">
                <h2 class="accordion-header pb-0" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <b>Añadir nuevo accesorio</b>
                    </button>
                </h2>


                <div id="collapseOne" class="accordion-collapse show mx-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?php

                            include 'productFormAccessory.php';
                        
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div id='uploadAccesoryList' class='mt-4 col-12 col-md-4'>
        </div>
    </div>

    <!-- FILES -->

    <div class="col-12">
        <div class="stock-title">Suministros</div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 mb-3 p-4">
            <label>Información del catálogo (opcional)</label>
            <label for="catalogPDF" class="drop-container" id="dropcontainerCatalog">
                <span class="drop-title">Seleccione o arrastre y suelte su archivo</span>
                <img class="drop-image" src="https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/src/images/PDF-document-upload.png" alt="pdf">
            </label>
            <input type="file" id="catalogPDF" accept="application/pdf" required>
            <p id='currentlyUploadedCatalog'></p>
        </div>
        <div class="col-12 col-md-6 mb-3 p-4">
            <label>Manual técnico (opcional)</label>
            <label for="manualPDF" class="drop-container" id="dropcontainerManual">
                <span class="drop-title">Seleccione o arrastre y suelte su archivo</span>
                <img class="drop-image" src="https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/src/images/PDF-document-upload.png" alt="pdf">
            </label>
            <input type="file" id="manualPDF" accept="application/pdf" required>
            <p id='currentlyUploadedManual'></p>
        </div>
    </div>
</form>