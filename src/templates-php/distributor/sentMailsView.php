<header class="header" data-header>
    <?php include 'navbar.php'; ?>
    <script>
        let page = "inbox";
        document.querySelector('#link-' + page).classList.add("active");
        document.querySelector('#link-' + page).removeAttribute("style");
    </script>
</header>
<br>
<br>
<br>
<br>
<br>
<div class="container">
    <div class="email-app mb-4">
        <nav>
            <a href="https://testing.kalstein.digital/index.php/distributor/inbox/compose" style="color: #fff !important" class="btn btn-danger btn-block">New Message</a>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="https://testing.kalstein.digital/index.php/distributor/inbox/"><i class="fa fa-inbox"></i> Inbox</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://testing.kalstein.digital/index.php/distributor/inbox/sent"><i class="fa fa-rocket"></i> Sent</a>
                </li>
            </ul>
        </nav>
        <main class="message">
            <div class="details">
                <?php
                require __DIR__.'/../../../php/conexion.php';

                function getProfileImage($conexion, $email)
                {
                    $consulta = "SELECT account_url_image_perfil
                                 FROM wp_account
                                 WHERE account_correo = '$email'";
                    $resultado = $conexion->query($consulta);
                    $row = $resultado->fetch_assoc();
                    return $row['account_url_image_perfil'];
                }

                function getMessageDetails($conexion, $message_id)
                {
                    $consulta = "SELECT * FROM wp_mensajes WHERE id = '$message_id'";
                    $resultado = $conexion->query($consulta);
                    $message = $resultado->fetch_assoc();
                    return $message;
                }

                if (isset($_GET['message_id'])) {
                    $message_id = $_GET['message_id'];
                    $message = getMessageDetails($conexion, $message_id);

                    if ($message) {
                        echo '<div class="title">' . $message['asunto'] . '</div>';

                        // INFORMACION DEL REMITENTE 
                        echo '<div class="header-mail">';
                        $sender_avatar_url = getProfileImage($conexion, $message['remitente_id']);
                        $default_avatar_url = 'https://bootdey.com/img/Content/avatar/avatar1.png';
                        $sender_avatar_url = $sender_avatar_url ? 'https://testing.kalstein.digital/wp-content/plugins/kalsteinPerfiles/src/images/upload/'.$sender_avatar_url : $default_avatar_url;
                        echo '<img class="avatar" src="' . $sender_avatar_url . '">';
                        echo '<div class="from">';
                        echo '<span style="color: #000">From: ' . $message['remitente_id'] . '</span>';
                        echo '</div>';
                        echo '</div>';

                        // INFORMACION DEL DESTINATARIO
                        echo '<div class="header-mail" style="display: flex; align-items: center; justify-content: space-between;">';
                        $recipient_avatar_url = getProfileImage($conexion, $message['destinatario_id']);
                        $recipient_default_avatar_url = 'https://bootdey.com/img/Content/avatar/avatar1.png';
                        $recipient_avatar_url = $recipient_avatar_url ? 'https://testing.kalstein.digital/wp-content/plugins/kalsteinPerfiles/src/images/upload/'.$recipient_avatar_url : $recipient_default_avatar_url;
                        echo '<img class="avatar" src="' . $recipient_avatar_url . '">';
                        echo '<div class="to">';
                        echo '<span style="color: #000">To: ' . $message['destinatario_id'] . '</span>';
                        echo '</div>';
                        echo '<div class="date" style="text-align: right;">';
                        $formatted_date = date('F j, Y, g:i a', strtotime($message['fecha_envio']));
                        echo $formatted_date;
                        echo '</div>';
                        echo '</div>';

                        echo '<br>';

                        echo '<div class="content">';
                        echo '<p>' . $message['contenido'] . '</p>';
                        echo '</div>';
                    } else {
                        echo '<div class="title">Message not found</div>';
                    }

                    $conexion->close();
                } else {
                    echo '<div class="title">Invalid message ID</div>';
                }
                ?>
            </div>
        </main>
    </div>
</div>
