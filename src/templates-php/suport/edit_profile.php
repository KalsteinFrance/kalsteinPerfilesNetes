<div class="container">
    <header class="header" data-header>
        <?php
            include 'navdar.php';
        ?>
    </header>
    
    
    <article class="container article">

        <?php
            $banner_img = 'Header-servicio-tecnico-IMG.jpg';
            $banner_text = "Welcome, $acc_name $acc_lname";
            include __DIR__.'/../manufacturer/banner.php';
        ?>

        <?php
            $outerClient = true;
            include __DIR__.'/../client/settings.php';
        ?>
    </article>

    <?php
        $footer_img = 'Footer-servicio-tecnico-IMG.jpg';
        include 'footer.php';
    ?>
</div>
