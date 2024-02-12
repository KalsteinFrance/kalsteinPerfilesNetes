<div class="container">
    <header class="header" data-header>
        <?php
            
            include __DIR__.'/../navbar.php';

        ?>
        <script>
            let page = "stock";

            document.querySelector('#link-' + page).classList.add("active");
            document.querySelector('#link-' + page).removeAttribute("style");
        </script>
    </header>

    <article class="container article">

        <?php
            $banner_img = 'Header-fabricante-IMG.png';
            $banner_text = "Add a New Accesory";
            include __DIR__.'/../banner.php';
        ?>

        <nav class="nav nav-borders">
            <a class="nav-link" href="https://platform.kalstein.us/index.php/manufacturer/stock">Products stock</a>
            <a class="nav-link" href="https://platform.kalstein.us/index.php/manufacturer/stock/add"> Add product</a>
            <a class="nav-link active" href="https://platform.kalstein.us/index.php/manufacturer/stock/add/accessories"> Add accessory</a>
            <a class="nav-link" href="https://platform.kalstein.us/index.php/manufacturer/stock/shipping">Shipping Costs</a>
        </nav>
    
        <hr class="mt-0 mb-4">
    
        <div class="container tm-mt-big tm-mb-big">
            <div class="row">
                <div class="col-12 mx-auto">
                    <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                        <div class="row tm-edit-product-row">
                            <?php
                                $add = true;
                                include __DIR__.'/productForm.php';
                            ?>
                            <div class="col-12">
                                <center><button type="button" id="btnSendData" name="send" class="btn btn-primary btn-block text-uppercase" style='color: white; background-color: #de3a46 !important; border: none'>Add New Accessory</button></center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>

    <?php
        $footer_img = 'Footer-fabricante-IMG.png';
        include __DIR__.'/../footer.php';
    ?>
</div>
