<?php

    session_start();
    require __DIR__.'/../../../php/conexion.php';
                
    $acc_id = $_SESSION['emailAccount'];

    $row = $conexion->query("SELECT account_nombre, account_apellido, account_url_image_perfil FROM wp_account WHERE account_correo = '$acc_id'")->fetch_assoc();
    
    $acc_name = $row['account_nombre'];
    $acc_lname = $row['account_apellido'];
    $acc_img = $row['account_url_image_perfil'];

    $firstLyricsName = strtoupper($acc_name[0]);
    $firstLyricsLastname = strtoupper($acc_lname[0]);

    if ($acc_img == ''){
        $urlImagePerfil = 'https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/src/images/Iconos/'.$firstLyricsName.'/'.$firstLyricsName.''.$firstLyricsLastname.'.png';
    }
    else{
        $urlImagePerfil == 'https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/src/images/upload/'.$imgPerfil;
    }

?>
<header class="header" data-header>
    <div class="container">
        
        <h1>
            <img src="https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/src/images/LOGO-KALSTEIIN-PLUS-2.png" alt="Kalstein" width="200" height="40">
        </h1>
        
        <button class='menu-toggle-btn icon-box' data-menu-toggle-btn aria-label='Toggle Menu'>
            <span class='material-symbols-rounded  icon' style='color: #213280'>menu</span>
        </button> 
        
        <nav class="navbar">
            <div class="container">
                <ul class="navbar-list">

                    <div class="d-flex flex-row">
                        <li>
                            <a href='https://plataforma.kalstein.net/index.php/support/inbox/' class='navbar-link icon-box'>
                                <span class='material-symbols-rounded icon position-relative'>
                                    mail
                                    <span id='messagesBaloon' class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style='font-family: sans-serif; font-size: 10px' hidden>
                                        <div id='messagesCant' class="unread-messages"></div>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="https://plataforma.kalstein.net/index.php/support/edit-profile/" class="navbar-link icon-box">
                                <span class='material-symbols-rounded  icon'>settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="btn-logout" class="navbar-link icon-box">
                                <span class="material-symbols-rounded  icon">logout</span>
                            </a>
                        </li>
                    </div>

                    <li>
                        <a href="" class="header-profile">
                
                            <figure class="profile-avatar" style="margin-top: 0.5rem;">
                                <img src="<?php echo $urlImagePerfil?>" alt="Profile 1" style="width: 50px; height: 50px">
                            </figure>
                
                            <div>
                                <p class="profile-title"><?php echo $acc_name; ?></p>
                                <p class="profile-subtitle">Soporte</p>
                            </div>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-list">
                    <li>
                        <a id="home" href="https://plataforma.kalstein.net/index.php/support/dashboard" class="navbar-link icon-box">
                            <span>Escritorio</span>
                        </a>
                    </li>
                    <li>
                        <a id="reports" href="https://plataforma.kalstein.net/index.php/support/reports/" class="navbar-link icon-box">
                            <span>Reportes</span>
                        </a>
                    </li>
                    <li>
                        <a id="services" href="https://plataforma.kalstein.net/index.php/support/services/" class="navbar-link icon-box">
                            <span>Mis Servicios</span>
                        </a>
                    </li>
                    <li>
                        <a id="quotes" href="https://plataforma.kalstein.net/index.php/support/quotes/" class="navbar-link icon-box">
                            <span>Ordenes</span>
                        </a>
                    </li>
                    <li>
                        <a id="catalog" href="https://plataforma.kalstein.net/index.php/support/manuals/" class="navbar-link icon-box">
                            <span>Manuales</span>
                        </a>
                    </li>
                    <li>
                        <a id="shop" href="https://plataforma.kalstein.net/index.php/support/shop" class="navbar-link icon-box">
                            <span>Tienda</span>
                        </a>
                    </li>
                    <li class='generate-quote'> <!-- only style class-->
                        <a id='btnGenQuote' href="https://plataforma.kalstein.net/index.php/support/services/add" class='navbar-link icon-box text-white'>
                            <span>AÑADIR SERIVICIO</span>
                        </a>
                    </li>
                </ul>

            </div>
            <script src="https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/src/manufacturer/js/inbox-notification.js"></script>
            <script src="https://plataforma.kalstein.net/wp-content/plugins/kalsteinCotizacion/assets/js/script.cot2.lite.sup.js"></script>
        </nav>
    </div>
    <div class="container flex-column">
        <div class="hr mb-2"></div>
        <style>
            .btn-blue {
                background-color: #213280;
                color: #fff;
                transition: background-color .3s;
            }
            .hover {
                background-color: #fff;
                color: #444;
            }
        </style>
        <?php
            echo navbar();
        ?>
    </div>
</header>