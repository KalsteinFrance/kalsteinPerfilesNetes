<div class="container">
    <?php 
        session_start(); 
        if (isset($_SESSION['emailAccount'])){
            $acc_id = $_SESSION['account_id'];
        }
    ?>
    <header class="header" data-header>
        <?php
            
            include 'navbar.php';

        ?>
        <script>
            let page = "stock";

            document.querySelector('#link-' + page).classList.add("active");
            document.querySelector('#link-' + page).removeAttribute("style");
        </script>
    </header>

    <article class="container article">
        
        <?php
            $banner_img = 'Header-distribuidor-IMG.jpg';
            $banner_text = "Editar un producto";
            include __DIR__.'/../manufacturer/banner.php';
        ?>

        <nav class="nav nav-borders">
            <a class="nav-link" href="https://plataforma.kalstein.net/distribuidor/productos"><i class="fa-solid fa-share"></i> Volver</a>
            <a class="nav-link" href="https://plataforma.kalstein.net/distribuidor/productos/agregar">Agregar un producto</a>
            <a class="nav-link" href="https://plataforma.kalstein.net/distribuidor/productos/calculadora">Calculadora de envíos</a>
        </nav>
    
        <hr class="mt-0 mb-4">
    
        <div class="container tm-mt-big tm-mb-big">
            <div class="row">
                <div class="col-12 mx-auto">
                    <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                        <div class="row mb-4">
                            <div class="col-12">
                            </div>
                            <select class="custom-select tm-select-accounts" style="color: #000 !important;" id="dataEdit" name="consulta">
                                <option selected value='0'>Por favor, elige una opción</option>
                                <?php
                                    
                                    require __DIR__.'/../../../php/conexion.php';
            
                                    $consulta = "SELECT * FROM wp_k_products WHERE product_maker = '$acc_id'";
            
                                    $resultado = $conexion->query($consulta);
    
                                    echo $consulta;
                                    if ($resultado->num_rows > 0) {
                                        while ($value = $resultado->fetch_assoc()) {
                                            $p_id = $value["product_aid"];
                                            $p_name = $value["product_name_es"];
                                            
                                            if (isset($_GET["edit"])) {
    
                                                $edit = $_GET["edit"];
                                                
                                                if ($edit == $p_id){
                                                    echo "<option selected style='color: #000 !important;' value='$p_id'>(ID: $p_id) $p_name</option>";
                                                }
                                            }
                                            else {
                                                echo "<option style='color: #000 !important;' value='$p_id'>(ID: $p_id) $p_name</option>";
                                            }   
                                        }
                                    }
            
                                ?>
                            </select>
                        </div>
                        <!-- OCULTO POR DEFECTO -->
                        <div id="formElements" class="row tm-edit-product-row" hidden>
                            <?php
                                $edit=true;
                                include __DIR__.'/productFormEdit.php';
                            ?>
                        </div>
                        <div id="formElementsbutton" class="col-12" hidden>
                            <center><button type="button" id="btnUpdateData" class="btn btn-primary btn-block text-uppercase" id="btnUpdateData" style='color: white; background-color: #de3a46 !important; border: none'>Editar producto ahora</button></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>

    <?php
        $footer_img = 'Footer-distribuidor-IMG.png';
        include 'footer.php';
    ?> 
</div>
