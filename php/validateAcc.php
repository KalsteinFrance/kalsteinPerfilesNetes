<?php

    require __DIR__.'/conexion.php';

    session_start();

    $validate_aid = $_POST['acc_id'];
    $email = $_POST['email'];
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $acc_id = $_SESSION['privateEmailAccount'];

    $queryAction = "SELECT type, action_mod FROM wp_mod_moves WHERE type = 'account' AND action_mod = '$acc_id' AND action_id = '$validate_aid'";
    $resultAction = $conexion->query($queryAction);

    if ($resultAction->num_rows > 0){

        $query = "UPDATE wp_account SET account_status = 'validated' WHERE account_aid = '$validate_aid'";
        $result = $conexion->query($query);
    
        $response = array();
        
        if($result){
            $response = array('status' => 'correcto');
            $queryDeleteMove = "DELETE FROM wp_mod_moves WHERE action_id = '$validate_aid'";

            $mod = $_SESSION['privateEmailAccount'];
            $receptor = $conexion->query("SELECT account_correo FROM wp_account WHERE account_aid = '$validate_aid'")->fetch_array()[0];

            if ( ($buis = $conexion->query("SELECT company_nombre FROM wp_company WHERE company_account_correo = '$receptor'"))->num_rows > 0 ){
                $texto_buis = '<br>'.$buis->fetch_array()[0];
            }
            else {
                $texto_buis = '';
            }

            $conexion->query("INSERT INTO wp_mod_log (moder, receptor, type, meta) VALUES ('$mod', '$receptor$texto_buis', 'a_aproved', '$validate_aid')");

            //$queryDeleteResult = $conexion->query($queryDeleteMove);
        }
        else {
            $response = array('status' => 'incorrecto');
        }
    
        echo json_encode($response);
         
        
        try {
            require __DIR__.'/../PHPMailer/src/Exception.php';
            require __DIR__.'/../PHPMailer/src/PHPMailer.php';
            require __DIR__.'/../PHPMailer/src/SMTP.php';
            
            $mail = new PHPMailer(true);

            //$mail->SMTPDebug = 2;  // Sacar esta línea para no mostrar salida debug
            $mail->isSMTP();
            $mail->Host = 'plataforma.kalstein.net';  // Host de conexión SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply2@plataforma.kalstein.net';                 // Usuario SMTP
            $mail->Password = 'XsI2C;6d{++-';                           // Password SMTP
            $mail->SMTPSecure = 'tls';                            // Activar seguridad TLS
            $mail->Port = 587;                                    // Puerto SMTP
        
            #$mail->SMTPOptions = ['ssl'=> ['allow_self_signed' => true]];  // Descomentar si el servidor SMTP tiene un certificado autofirmado
            #$mail->SMTPSecure = false;				// Descomentar si se requiere desactivar cifrado (se suele usar en conjunto con la siguiente línea)
            #$mail->SMTPAutoTLS = false;			// Descomentar si se requiere desactivar completamente TLS (sin cifrado)
         
            $mail->setFrom('no-reply2@plataforma.kalstein.net');		// Mail del remitente
            $mail->addAddress($email);     // Mail del destinatario
    
            $position = strpos($email, '@');
            $nameEmail = substr($email, 0, $position);
         
            $mail->isHTML(true);
            $mail->Subject = 'Enhorabuena, su cuenta ha sido validada.';  // Asunto del mensaje
            $mail->Body    = '
                <div style="width: 100%; background-color: #fff;">
                    <div style="width: 50%; margin-left: 25%;">
                        <div style="width: 100%; color: #000;">
                            <img src="https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/src/images/logo_kalstein.png" style="width: 200px;  margin-left: 25%; background-color: #fff; margin-top: 4rem; margin-bottom: 2rem;">
                            <h1 style="text-align: center; color: #000;">Hola, '.$nameEmail.'</h1>
                            <p style="text-align: justify; color: #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nuestro equipo de moderadores ha validado tu cuenta. Ya puede iniciar sus actividades en nuestra plataforma</p>
                            <p style="text-align: center; color: #000; font-size: 1.2em; font-weight: bold;">Comenzar ahora</p>
                            <p style="text-align: center; color: #000; font-weight: bold; font-size: 2em;">https://plataforma.kalstein.net/acceder</p>
                            <hr>
                            <p style="text-align: justify; color: #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kalstein France nunca enviará un correo electrónico o solicitará que revele o verifique su contraseña, tarjeta de crédito o número de cuenta bancaria.</p>
                            <p style="color: #000;">2023 © Todos los derechos reservados</p>
                        </div>
                    </div>
                </div>
            ';    // Contenido del mensaje (acepta HTML)
            $mail->AltBody = 'Este es el contenido del mensaje en texto plano';    // Contenido del mensaje alternativo (texto plano)
            // Activo condificacción utf-8
            $mail->CharSet = 'UTF-8';
         
            $mail->send();
        }
        catch (Exception $e) {
            echo 'El mensaje no se ha podido enviar, error: ', $mail->ErrorInfo;
        }
    }
    else {
        echo json_encode(array('status' => 'busy'));
    }

?>