<div class='asideCategory w-100'>
    <span class='tltAsideCategory'>
        <h6>Categorías de productos</h6>
    </span>
    <ul class='cCategory'>
        <?php
            $html = '';

            // get lines

            $queryLines = "SELECT categorie_line_es FROM wp_categories ORDER BY categorie_line_es ASC";	
            $resultLines = $conexion->query($queryLines);

            $already_printed = [];
                
            if ($resultLines->num_rows > 0) {
                while ($value = $resultLines->fetch_assoc()) {
                    if (!in_array($value['categorie_line_es'], $already_printed)){
                        array_push($already_printed, $value['categorie_line_es']);
                    }
                }
            }

            // print lines

            foreach ($already_printed as $i => $line) {
                
                // line start
                $raw_line = str_replace(' ', '-', $line);
                $raw_line = str_replace('&', 'and', $raw_line);

                $html .= "
                <li class='border-top border-end border-start ps-2'>
                    <div class='d-flex flex-row justify-content-between'>
                        <span class='acordeon-line-button' value='$raw_line' style='cursor: pointer'>$line</span>
                        <buttton class='acordeon-line-button rounded-circle text-center' style='background-color: #ccc; width: 25px; height: 25px; margin: 4px; cursor: pointer' value='$raw_line'>
                            <i class='acordeon-chevron-$raw_line fa-solid fa-chevron-down' style='float: none'></i>
                        </buttton>
                    </div>
                    <ul class='acordeon-category-ul-$raw_line' hidden>
                ";

                $consulta = "SELECT categorie_description_es FROM wp_categories WHERE categorie_line_es = '$line' ORDER BY categorie_description_es ASC";	
                $resultado = $conexion->query($consulta);

                $already_printed = [];
                    
                if ($resultado->num_rows > 0) {
                    while ($value = $resultado->fetch_assoc()) {
                        if (!in_array($value['categorie_description_es'], $already_printed)){
                            array_push($already_printed, $value['categorie_description_es']);
                        }
                    }
                }

                foreach ($already_printed as $i => $category) {
                    $raw_category = str_replace(' ', '-', $category);
        
                    
                    $sql2 = "SELECT * FROM wp_categories WHERE categorie_description_es = '$category'";
                    $rs2 = $conexion->query($sql2);
                    
                    // elemento de categoria
                    $html .= "
                        <li class='border-bottom ps-3 mb-0'>
                            <div class='d-flex flex-row justify-content-between'>
                                <span class='typeCategoryWidget p-1'>$category</span>
                                
                    ";
        
                    if ($rs2->num_rows > 1) {
                        // boton de desplegar
                        $html .= "
                                <button class='acordeon-subcategory-button rounded-circle text-center' style='background-color: #ccc; width: 25px; height: 25px; margin: 4px; cursor: pointer' value='$raw_category'>
                                    <i class='acordeon-chevron-$raw_category fa-solid fa-chevron-down' style='float: none'></i>
                                </button>
                            </div>
                            <ul class='acordeon-subcategory-ul-$raw_category ms-3' hidden>
                        ";
        
                        while ($value = $rs2->fetch_assoc()) {
                            $subcategory = $value['categorie_sub_es'];
                            $html .= "<li class='list-subcategory-widget border-bottom'>$subcategory</li>";
                        }
        
                        $html.="</ul>";
                    }
                    else {
                        $html .= "
                            </div>
                        ";
                    }
        
                    $html .= "
                        </li>
                    ";
                }

                $html .= "
                    </ul>
                </li>
                ";
            }

            echo $html;
        ?>
    </ul>
    <hr class='mt-0'>
</div>