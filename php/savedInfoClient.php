<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    if(isset($_SESSION["emailAccount"])){
        $email = $_SESSION["emailAccount"];
        
    }
    $session_id = session_id();

    require __DIR__ . '/conexion.php';
	require __DIR__ . '/../vendor/autoload.php';

    function slug_sanitize($title) {
        $title = strtolower($title); 
        $title = preg_replace('/[^a-z0-9\s-]/', '', $title); 
        $title = preg_replace('/[\s-]+/', '-', $title); 
        $title = trim($title, '-'); 
        return $title;
    }
    

    $imageDocument = $_FILES['imageDocument']['name'] ?? NULL;
    $imageTaxDocument = $_FILES['imageTaxDocument']['name'] ?? NULL;
    $path = __DIR__ . '/../src/images/images-verify/';

    if (is_null($imageDocument)){
        $newName = '';
    }else{
        $extension = pathinfo($imageDocument, PATHINFO_EXTENSION);
        $newName = uniqid().".".$extension;    
        $uploadFile = $path . basename($newName);
        move_uploaded_file($_FILES['imageDocument']['tmp_name'], $uploadFile);
    }

    if (is_null($imageTaxDocument)){
        $newNameTax = '';
    }else{
        $extensionTax = pathinfo($imageTaxDocument, PATHINFO_EXTENSION);
        $newNameTax = uniqid().".".$extension;        
        $uploadFile2 = $path . basename($newNameTax);
        move_uploaded_file($_FILES['imageTaxDocument']['tmp_name'], $uploadFile2);
    }

    $nameB = $_POST['nameB'] ?? NULL;
    $countryB = $_POST['countryB'] ?? NULL;
    $stateB = $_POST['stateB'] ?? NULL;
    $addressB = $_POST['addressB'] ?? NULL;
    $zipcodeB = $_POST['zipcodeB'] ?? NULL;
    $phoneB = $_POST['phoneB'] ?? NULL;
    $websiteB = $_POST['websiteB'] ?? NULL;
    $nameUser = $_POST['nameUser'] ?? NULL;
    $lastnameUser = $_POST['lastnameUser'] ?? NULL;
    $countryUser = $_POST['countryUser'] ?? NULL;
    $stateUser = $_POST['stateUser'] ?? NULL;
    $addressUser = $_POST['addressUser'] ?? NULL;
    $zipcodeUser = $_POST['zipcodeUser'] ?? NULL;
    $phoneUser = $_POST['phoneUser'] ?? NULL;
    $jobRole = $_POST['jobRole'] ?? NULL;
    $profileRole = $_POST['profileRole'] ?? NULL;
    $idDocument = $_POST['idDocument'] ?? NULL;
    $taxDocument = $_POST['taxDocument'] ?? NULL;

    $sqlPais = "SELECT * FROM wp_paises WHERE iso = '$countryUser'";
    $resultPais = $conexion->query($sqlPais);
    $rowPais = mysqli_fetch_array($resultPais);
    $pais = $rowPais['es'];

    if ($profileRole == 2 || $profileRole == 3 || $profileRole == 4){
        $accStatus = 'filled';
    }else{
        $accStatus = 'validated';
    }

    $datos = [];

    $consulta = "SELECT * FROM wp_account WHERE account_correo = '$email'";
    $resultConsulta = $conexion->query($consulta);
	$row = mysqli_fetch_array($resultConsulta);
    $idAcc = $row[0];
    $date = $row['account_created_at'];
    $paswword = $row['account_contraseña'];

    $data = array(
        $email, 
        $nameUser, 
        $lastnameUser, 
        $pais, 
        $phoneUser, 
        'Client', 
        'R2', 
        $date, 
        'es', 
        'kalstein.net/es/'
    );				
    array_push($datos, $data);

    function insertDataIntoCsv($sheetId, $sheetName, $dataRows) {
		$client = new Google_Client();
		$client->setApplicationName('Google Sheets API PHP Integration');
		$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
		
		$client->setAuthConfig(__DIR__ . '/../credentials.json');
	
		$service = new Google_Service_Sheets($client);
	
		$range = $sheetName;
		$body = new Google_Service_Sheets_ValueRange([
			'values' => $dataRows 
		]);
		$params = [
			'valueInputOption' => 'RAW'
		];
	
		$result = $service->spreadsheets_values->append($sheetId, $range, $body, $params);
	
		return $result;
	}
	
	$sheetId = '1jRMFwWkqJ5X908HBNO-n-KHqjQRaNWM_vd8Kj6Dy0Ks'; 
	$sheetName = 'contactos-crm'; 
	$dataRows = []; 

    foreach ($datos as $dato) {
		$dataRows[] = [$dato[0], $dato[1], $dato[2], $dato[3], $dato[4], $dato[5], $dato[6], $dato[7], $dato[8], $dato[9]];
	}

    try {
		$result = insertDataIntoCsv($sheetId, $sheetName, $dataRows);
	} catch (Exception $e) {
		echo ' Error al insertar datos: ',  $e->getMessage(), "\n";
	}

    if ($jobRole == 0){
        $update = "UPDATE wp_account SET account_nombre = '$nameUser', account_apellido = '$lastnameUser', account_rol_aid = '$profileRole', account_direccion = '$addressUser', account_pais = '$countryUser', account_ciudad = '$stateUser', account_zipcode = '$zipcodeUser', account_telefono = '$phoneUser', account_document = '$idDocument', account_image_document = '$newName', account_status = '$accStatus' WHERE account_correo = '$email'";
        if ($conexion->query($update) === TRUE){
            $update = "correcto";
            $insertCRM = "INSERT INTO wp_clients_crm(aid_clients_crm, name_clients_crm, lastname_clients_crm, email_clients_crm, phone_clients_crm, country_clients_crm, profile_clients_crm, status_clients_crm, date_clients_crm) VALUES ('','$nameUser','$lastnameUser','$email','$phoneUser','$countryUser','Client','R2', '$date')";
            $conexion->query($insertCRM);
        }else{
            $update = "incorrecto" .$conexion->error;
        }
    }else{
        $update = "UPDATE wp_account SET account_nombre = '$nameUser', account_apellido = '$lastnameUser', account_rol_aid = '$profileRole', account_direccion = '$addressUser', account_pais = '$countryUser', account_ciudad = '$stateUser', account_zipcode = '$zipcodeUser', account_telefono = '$phoneUser', account_document = '$idDocument', account_image_document = '$newName', account_status = '$accStatus' WHERE account_correo = '$email'";
        if ($conexion->query($update) === TRUE){
            if ($profileRole == 2){

                $insertCRM = "INSERT INTO wp_clients_crm(aid_clients_crm, name_clients_crm, lastname_clients_crm, email_clients_crm, phone_clients_crm, country_clients_crm, profile_clients_crm, status_clients_crm, date_clients_crm) VALUES ('','$nameUser','$lastnameUser','$email','$phoneUser','$countryUser','Distributor','R2', '$date')";
                $conexion->query($insertCRM);

                $slug1 = slug_sanitize($nameB);
                $insertSlug = "INSERT INTO tienda_virtual(ID_tienda, ID_user, titulo_t, subtitulo_t, descripcion, mision, vision, logo_t, quienes_somos_t, facebook_t, twitter_t, instagram_t, color_p, color_s, banner_t, img_quienes_s, img_mision, img_vision, ID_idioma, ID_slug) VALUES ('', '$email', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'https://plataforma.kalstein.net/$slug1/')";
                $conexion->query($insertSlug);
                if (!$conexion->query($insertSlug)) {
                    echo "Error en la consulta: " . $conexion->error;
                }

                $slug = slug_sanitize($nameB);
                $empty_template = 'empty.php';
                
                $post_date = date('Y-m-d H:i:s');
                $post_title = $conexion3->real_escape_string($slug);
                $post_content = $conexion3->real_escape_string('<script>console.log("Blank template");</script>');
                $post_name = $conexion3->real_escape_string($slug);
                $post_status = 'draft';
                $post_author = 1;
                $post_type = 'page';

                $sql = "INSERT INTO wp_posts (post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_name, post_type) 
                        VALUES ('$post_author', '$post_date', '$post_date', '$post_content', '$post_title', '$post_status', '$post_name', '$post_type')";

                if ($conexion3->query($sql) === TRUE) {
                    $post_id = $conexion3->insert_id;

                    $empty_template = $conexion3->real_escape_string($empty_template);
                    $sql_template = "INSERT INTO wp_postmeta (post_id, meta_key, meta_value) 
                                     VALUES ('$post_id', '_wp_page_template', '$empty_template')";
                    $conexion3->query($sql_template);

                    $meta_values = [
                        '_edit_lock' => time(), 
                        '_edit_last' => $post_author, 
                    ];

                    foreach ($meta_values as $meta_key => $meta_value) {
                        $meta_value = $conexion->real_escape_string($meta_value);
                        $sql_meta = "INSERT INTO wp_postmeta (post_id, meta_key, meta_value) 
                                    VALUES ('$post_id', '$meta_key', '$meta_value')";
                        $conexion3->query($sql_meta);
                    }
                }
            
            }

            if ($profileRole == 3){
                $insertCRM = "INSERT INTO wp_clients_crm(aid_clients_crm, name_clients_crm, lastname_clients_crm, email_clients_crm, phone_clients_crm, country_clients_crm, profile_clients_crm, status_clients_crm, date_clients_crm) VALUES ('','$nameUser','$lastnameUser','$email','$phoneUser','$countryUser','Manufacturer','R2', '$date')";
                $conexion->query($insertCRM);

                $slug = slug_sanitize($nameB);
                $empty_template = 'empty.php';
                
                $insertSlug = "INSERT INTO tienda_virtual(`ID_tienda`, `ID_user`, `titulo_t`, `titulo_t`, `subtitulo_t`, `descripcion`, `mision`, `vision`, `logo_t`, `quienes_somos_t`, `facebook_t`, `twitter_t`, `instagram_t`, `color_p`, `color_s`, `banner_t`, `img_quienes_s`, `img_mision`, `img_vision`, `ID_idioma`, `ID_slug`) VALUES ('', '$email', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'https://plataforma.kalstein.net/$slug/')";
                $conexion->query($insertSlug);

                $post_date = date('Y-m-d H:i:s');
                $post_title = $conexion3->real_escape_string($slug);
                $post_content = $conexion3->real_escape_string('<script>console.log("Blank template");</script>');
                $post_name = $conexion3->real_escape_string($slug);
                $post_status = 'draft';
                $post_author = 1;
                $post_type = 'page';

                
                $insertSlug = "INSERT INTO tienda_virtual(ID_tienda, ID_user, titulo_t, subtitulo_t) VALUES ()";
                $conexion->query($insertSlug);

                $sql = "INSERT INTO wp_posts (post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_name, post_type) 
                        VALUES ('$post_author', '$post_date', '$post_date', '$post_content', '$post_title', '$post_status', '$post_name', '$post_type')";

                if ($conexion3->query($sql) === TRUE) {
                    $post_id = $conexion->insert_id;

                    $empty_template = $conexion3->real_escape_string($empty_template);
                    $sql_template = "INSERT INTO wp_postmeta (post_id, meta_key, meta_value) 
                                     VALUES ('$post_id', '_wp_page_template', '$empty_template')";
                    $conexion3->query($sql_template);

                    $meta_values = [
                        '_edit_lock' => time(), 
                        '_edit_last' => $post_author, 
                    ];

                    foreach ($meta_values as $meta_key => $meta_value) {
                        $meta_value = $conexion->real_escape_string($meta_value);
                        $sql_meta = "INSERT INTO wp_postmeta (post_id, meta_key, meta_value) 
                                    VALUES ('$post_id', '$meta_key', '$meta_value')";
                        $conexion3->query($sql_meta);
                    }
                }

            }
            
            if ($profileRole == 6){


                $updateDataScientist = "UPDATE wp_account_scientist SET account_nombre = '$nameUser', account_apellido = '$lastnameUser', account_rol_aid = '$profileRole', account_direccion = '$addressUser', account_pais = '$countryUser', account_ciudad = '$stateUser', account_zipcode = '$zipcodeUser', account_telefono = '$phoneUser', account_document = '$idDocument', account_image_document = '$newName', account_status = '$accStatus', account_session = '$session_id' WHERE account_correo = '$email'";
                $conexion2->query($updateDataScientist);

                $updateDataScientistWordpress = "UPDATE wp_users SET display_name = '$nameUser $lastnameUser', user_nicename = '$nameuser', account_session = '$session_id' WHERE ID = $idAccountBiblioteca";

                $conexion2->query($updateDataScientistWordpress);

                $consultBiblioteca = "SELECT * FROM wp_users WHERE user_login = '$email'";
                $respuestaBiblioteca = $conexion2->query($consultBiblioteca);
                $fetch = mysqli_fetch_array($respuestaBiblioteca);
                $idAccountBiblioteca = $fetch["ID"]; 

                $insertBiblioteca2 = "INSERT INTO wp_usermeta (user_id, meta_key, meta_value) 
                VALUES 
                ('$idAccountBiblioteca','nickname','$nameUser'), 
                ('$idAccountBiblioteca','first_name','$nameUser'), 
                ('$idAccountBiblioteca','description',''), 
                ('$idAccountBiblioteca','rich_editing','true'), 
                ('$idAccountBiblioteca','syntax_highlighting','true'), 
                ('$idAccountBiblioteca','comment_shortcuts','false'), 
                ('$idAccountBiblioteca','admin_color','fresh'), 
                ('$idAccountBiblioteca','use_ssl','0'), 
                ('$idAccountBiblioteca','show_admin_bar_front','true'), 
                ('$idAccountBiblioteca','locale',''), 
                ('$idAccountBiblioteca','wp_capabilities','a:1:{s:10:\"subscriber\";b:1;}'), 
                ('$idAccountBiblioteca','wp_user_level','0')";
                $conexion2->query($insertBiblioteca2);

                $updateDataScientistWordpress = "UPDATE wp_users SET display_name = '$nameUser $lastnameUser', user_nicename = '$nameuser' WHERE ID = $idAccountBiblioteca";

                $conexion2->query($updateDataScientistWordpress);

                $insertCRM = "INSERT INTO wp_clients_crm(aid_clients_crm, name_clients_crm, lastname_clients_crm, email_clients_crm, phone_clients_crm, country_clients_crm, profile_clients_crm, status_clients_crm, date_clients_crm) VALUES ('','$nameUser','$lastnameUser','$email','$phoneUser','$countryUser','Scientist','R2', '$date')";
                $conexion->query($insertCRM);

            }

            $register = "INSERT INTO wp_company(company_aid, company_account_correo, company_role, company_nombre, company_direccion, company_pais, company_ciudad, company_telefono, company_zipcode, company_website, company_rif, company_image_rif) VALUES ('', '$email', '$jobRole', '$nameB', '$addressB', '$countryB', '$stateB', '$phoneB', '$zipcodeB', '$websiteB', '$taxDocument', '$newNameTax')";
            if ($conexion->query($register) === TRUE){
                $update = "correcto";
            }else{
                $update = "incorrecto";
            }
        }else{
            $update = "incorrecto" .$conexion->error;
        }
    }

    
    

    $datos = array(
        'update'      => $update,
        'nombre'      => $nameUser,
        'apellido'    => $lastnameUser,
        'profileRole' => $profileRole,
        'addressUser' => $addressUser,
        'countryUser' => $countryUser,
        'stateUser'   => $stateUser,
        'zipcodeUser' => $zipcodeUser,
        'phoneUser'   => $phoneUser,
        'idDocument'  => $idDocument,
        'newName'     => $newName,
        'accStatus'   => $accStatus,
        'email'       => $email,
        'contrasena'  => $row['account_contraseña'],
        'user_tag'    => $row['user_tag'],
        
    );

    echo json_encode($datos, JSON_FORCE_OBJECT);

 
    $conexion->close();