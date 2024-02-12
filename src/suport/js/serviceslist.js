jQuery(document).ready(function($){
 
    //Funcion para mostrar la tabla de reportes
    let category= $('#category').val()
    let status = $('#estatus').val()
    let inputSearch = $('#searchreport').val()
   
    tablaconsulta(inputSearch,status,category)

    function tablaconsulta(inputSearch, status, category){
        $.ajax({
            url: "https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/php/suport/listservice.php",
            type: "POST",
            data: {inputSearch, status, category},
        })
        .done(function(respuesta){
            $('#report-fails').html(respuesta)
            tblListServicePagination();
        })
        .fail(function(){
            console.log("error");

        })
    }

    function tblListServicePagination() {
        function tableContent(nextPage) {
            $.ajax({
                url: 'https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/php/suport/listservice.php',
                type: "GET",
                data: { e: nextPage },
                success: function (data) {
                    var tableContent = $(data).find('#tblListService').html();
    
                    if (tableContent.trim() === "") {
                        return;
                    } 

                    var currentPage = nextPage;
                    $("#currentPageIndicatorService").text("Page: " + currentPage);
    
                    $('#tblListService').html(tableContent);
    
                    $(".pagination #form-next-service input[name=e]").val(parseInt(currentPage) + 1);
                    let prev = parseInt(currentPage) > 1 ? parseInt(currentPage) - 1 : 1;
                    $(".pagination #form-previous-service input[name=e]").val(prev);
    
                },
                error: function () {
                    alert("Error charging quote data.");
                }
            });
        }
    
        $(".pagination #form-next-service").submit(function (e) {
            e.preventDefault();
            var nextPage = $(this).find("input[name=e]").val();
            console.log(nextPage);
            tableContent(nextPage);
        });
    
        $(".pagination #form-previous-service").submit(function (e) {
            e.preventDefault();
            var prevPage = $(this).find("input[name=e]").val();
            tableContent(prevPage);
        });
    }
    

    $(document).on('keyup', '#searchreport', function(){
        let inputSearch = $(this).val();
        let category =$('#category').val();
        let status = $('#estatus').val();
        tablaconsulta(inputSearch, status, category)
    })

    $(document).on('change', '#estatus', function(){
        let status = $(this).val();
        let category =$('#category').val();
        let inputSearch = $('#searchreport').val();
        tablaconsulta(inputSearch, status, category)
    })

    $(document).on('change', '#category', function(){
        let category = $(this).val();
        let status = $('#estatus').val();
        let inputSearch = $('#searchreport').val();
        tablaconsulta(inputSearch, status, category)
    })
});

jQuery(document).ready(function($) {
    $(document).on('click', '#Register_service', function(e) {
        /* const rcoma = (str) => { return str.replace(/'/g, /\'/).replace(/\//g, "")} */

        let SE_servicio =    rcoma($('#SEnombre').val());
        let SE_company =     rcoma($('#SEcompany').val());
        let SE_agente =      rcoma($('#SEagente').val());
        let SE_telefono =    rcoma($('#SEtelefono').val());
        let SE_correo =      rcoma($('#SEcorreo').val());

        let SE_pais =        rcoma($('#SEpais').val());
        let SE_direccion =   rcoma($('#SEdireccion').val());
        let SE_estadolugar = rcoma($('#SEestadoLugar').val());
        let SE_ciudad =      rcoma($('#SEciudad').val());
        let SE_provincia =   rcoma($('#SEprovincia').val());

        let SE_category =    rcoma($('#SEcategory').val());
        let SE_estado =      rcoma($('#SEestado').val());
        let SE_tiempo =      rcoma($('#SEtiempoEstimado').val());
        let SE_descripcion = rcoma($('#SEdescription').val());

        console.log(SE_servicio)

        let err_msg = '';

        if (SE_servicio === '0') {
            err_msg == 'name empty';
        }
        else{
            if (SE_category === '0') {
                err_msg == 'category empty';
            }
            else{
                if(SE_company === '0') {
                    err_msg == 'company name empty';
                }
                else{
                    if(SE_pais === '0') {
                        err_msg == 'country name empty';
                    }
                    else{
                        if(SE_direccion === '0') {
                            err_msg == 'address empty';
                        }
                        else{                
                            if (SE_agente === '0') {
                                err_msg == 'service agent name empty';
                            }
                            else {
                                if (SE_correo === '0') {
                                    err_msg == 'email empty';
                                }
                                else{
                                    if (SE_descripcion === '0') {
                                        err_msg == 'description empty';
                                    }
                                    else {
                                        if (SE_estado === '0') {
                                            err_msg == 'status empty';
                                        }
                                        else {
                                            if (SE_tiempo === '0') {
                                                err_msg == 'expected time empty';
                                            }
                                            else {
                                                if (SE_tiempo < 0) {
                                                    err_msg == 'expected time can not be less than 0';
                                                }
                                                else {
                                                    if (SE_telefono === '0') {
                                                        err_msg == 'phone number empty';
                                                    }
                                                    else {
                                                        if (SE_telefono < 0) {
                                                            err_msg == 'invalid phone number';
                                                        }
                                                        else {
                                                            uploadFormData(SE_servicio, SE_company, SE_agente, SE_telefono, SE_correo, SE_pais, SE_direccion, SE_estadolugar, SE_ciudad, SE_provincia, SE_category, SE_descripcion, SE_tiempo, SE_estado);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if (err_msg != ''){
            iziToast.error({
                title: 'Error',
                message: err_msg,
                position: 'center'
            });
        }
    });
  
    function uploadFormData(SE_servicio, SE_company, SE_agente, SE_telefono, SE_correo, SE_pais, SE_direccion, SE_estadolugar, SE_ciudad, SE_provincia, SE_category, SE_descripcion, SE_tiempo, SE_estado) {
        
        var formData = new FormData();
        formData.append('service',SE_servicio);
        formData.append('service_company',SE_company);
        formData.append('service_agente',SE_agente); 
        formData.append('service_telefono',SE_telefono);
        formData.append('service_correo',SE_correo);

        formData.append('service_pais',SE_pais);
        formData.append('service_direccion',SE_direccion);
        formData.append('service_estadolugar',SE_estadolugar);
        formData.append('service_ciudad',SE_ciudad);
        formData.append('service_provincia',SE_provincia);

        formData.append('service_category',SE_category);
        formData.append('service_estado',SE_estado);
        formData.append('service_tiempo',SE_tiempo);
        formData.append('service_description',SE_descripcion);
                
        $.ajax({
            contentType: "multipart/form-data",
            url: 'https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/php/suport/service_insert.php',
            type: 'POST', 
            data: formData, 
            dataType: 'text', 
            processData: false, 
            contentType: false, 
            cache: false, 
            success: function(response) {
                console.log(response);
                iziToast.success({
                    title: 'Success',
                    message: 'Data updated successfully.',
                    position: 'center'
                });
                window.location.href = 'https://plataforma.kalstein.net/index.php/support/services';
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            } 
        });
    }
});

jQuery(document).ready(function($) {

    mostrarDatos($('#dataEdit').val());

    /*function dataCMB(consulta) {
        $.ajax({
            url: 'https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/php/selectservice.php',
            type: 'POST',
            data: { consulta },
        })
        .done(function(respuesta) {
            console.log(respuesta);
            $('#dataEdit').html(respuesta);
        })
        .fail(function() {
            console.log("error");
        });
        
    }*/

    function mostrarDatos(consulta){
        $.ajax({
            // Cambia mificherophp.php por el nombre de tu fichero
            url: "https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/php/suport/servicedata.php",
            type: "POST",
            data: {consulta},
        })
        .done(function(respuesta){
            let data = JSON.parse(respuesta)
            // Coloca el nombre del input el cual mostrara los datos dependiendo de si es un id o una clase vas a hacer lo mismo con todos
            
            $('#SEAnombre').val(data.name);
            $('#SEAcategory').val(data.category);
            $('#SEAagente').val(data.usuario);
            $('#SEAcorreo').val(data.correo);
            $('#SEAdescription').val(data.description);
            $('#SEAprecio').val(data.precio);
            $('#SEAestado').val(data.estado);
            $('#SEAcompany').val(data.company);
            $('#SEApais').val(data.pais);
            $('#SEAciudad').val(data.ciudad);
            $('#SEAdireccion').val(data.direccion);
            $('#SEAtelefono').val(data.telefono);
            $('#SEAestadoLugar').val(data.estadolugar);
            /* $('#SEAestadoLugar').val(data.estadolugar); */
            $('#SEAprovincia').val(data.provincia);
            $('#actualizar_id').val(data.id);

        })
        .fail(function(){
            console.log(data.id);
        })
    }


    // Evento on change
    
    $(document).on('change', '#dataEdit', function(){
        let valor = $(this).val()
        mostrarDatos(valor)
    })

    //Haciendo todo esto de manera correcta debe de cargarte los datos
    
    $(document).on('click', '#actualizar', function(e) {

        /* const rcoma = (str) => { return str.replace(/'/g, /\'/).replace(/\//g, "")} */

        let actualizar_id = $('#actualizar_id').val();

        let SE_servicio =    rcoma($('#SEAnombre').val());
        let SE_company =     rcoma($('#SEAcompany').val());
        let SE_agente =      rcoma($('#SEAagente').val());
        let SE_telefono =    rcoma($('#SEAtelefono').val());
        let SE_correo =      rcoma($('#SEAcorreo').val());

        let SE_pais =        rcoma($('#SEApais').val());
        let SE_direccion =   rcoma($('#SEAdireccion').val());
        let SE_estadolugar = rcoma($('#SEAestadoLugar').val());
        let SE_ciudad =      rcoma($('#SEAciudad').val());
        let SE_provincia =   rcoma($('#SEAprovincia').val());

        let SE_category =    rcoma($('#SEAcategory').val());
        let SE_estado =      rcoma($('#SEAestado').val());
        let SE_tiempo =      rcoma($('#SEAtiempoEstimado').val());
        let SE_descripcion = rcoma($('#SEAdescription').val());
        
        let err_msg = '';

        if (SE_servicio === '0') {
            err_msg == 'name empty';
        }
        else{
            if (SE_category === '0') {
                err_msg == 'category empty';
            }
            else{
                if(SE_company === '0') {
                    err_msg == 'company name empty';
                }
                else{
                    if(SE_pais === '0') {
                        err_msg == 'country name empty';
                    }
                    else{
                        if(SE_direccion === '0') {
                            err_msg == 'address empty';
                        }
                        else{                
                            if (SE_agente === '0') {
                                err_msg == 'service agent name empty';
                            }
                            else {
                                if (SE_correo === '0') {
                                    err_msg == 'email empty';
                                }
                                else{
                                    if (SE_descripcion === '0') {
                                        err_msg == 'description empty';
                                    }
                                    else {
                                        if (SE_estado === '0') {
                                            err_msg == 'status empty';
                                        }
                                        else {
                                            if (SE_tiempo === '0') {
                                                err_msg == 'expected time empty';
                                            }
                                            else {
                                                if (SE_tiempo < 0) {
                                                    err_msg == 'expected time can not be less than 0';
                                                }
                                                else {
                                                    if (SE_telefono === '0') {
                                                        err_msg == 'phone number empty';
                                                    }
                                                    else {
                                                        if (SE_telefono < 0) {
                                                            err_msg == 'invalid phone number';
                                                        }
                                                        else {
                                                            updateFormData(actualizar_id, SE_servicio, SE_company, SE_agente, SE_telefono, SE_correo, SE_pais, SE_direccion, SE_estadolugar, SE_ciudad, SE_provincia, SE_category, SE_descripcion, SE_tiempo, SE_estado);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if (err_msg != ''){
            iziToast.error({
                title: 'Error',
                message: err_msg,
                position: 'center'
            });
        }
    });

    function updateFormData(actualizar_id, SE_servicio, SE_company, SE_agente, SE_telefono, SE_correo, SE_pais, SE_direccion, SE_estadolugar, SE_ciudad, SE_provincia, SE_category, SE_descripcion, SE_tiempo, SE_estado) {
        
        var formData = new FormData();
        formData.append('actualizar_id', actualizar_id);
        formData.append('service',SE_servicio);
        formData.append('service_company',SE_company);
        formData.append('service_agente',SE_agente);
        formData.append('service_telefono',SE_telefono);
        formData.append('service_correo',SE_correo);

        formData.append('service_pais',SE_pais);
        formData.append('service_direccion',SE_direccion);
        formData.append('service_estadolugar',SE_estadolugar);
        formData.append('service_ciudad',SE_ciudad);
        formData.append('service_provincia',SE_provincia);

        formData.append('service_category',SE_category);
        formData.append('service_estado',SE_estado);
        formData.append('service_tiempo',SE_tiempo);
        formData.append('service_description',SE_descripcion);
        
        $.ajax({ contentType: "multipart/form-data", url: 'https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/php/suport/service-update.php',
            type: 'POST',
            data: formData,
            dataType: 'text',  
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
                console.log(response);  
                iziToast.success({
                    title: 'Success',
                    message: 'Data updated successfully.',
                    position: 'center'
                });
                //window.location.href = 'https://plataforma.kalstein.net/index.php/support/services';
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
            }
        });
    }
});

jQuery(document).ready(function($) {
    $(document).on('click', '#btn-service-details', function() {

        var service_id = $(this).val();

        $.ajax({
            url:'https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/php/suport/serviceinfo.php',
            method: 'POST', 
            data: {service_id}
        })
        .done(function (response){
            console.log(response)
            let res = JSON.parse(response);

            res.forEach(elem => {
                SE_descripcion = elem.SE_descripcion;
                var details =  SE_descripcion + '<br>';

                iziToast.show({
                    title: 'Service description: ',
                    message: details,
                    position: 'center',
                    timeout: false,
                    closeOnClick: true,
                    progressBar: false
                });
            });
        })
    });
});
       
jQuery(document).ready(function($) {   
    category();  
    function category(consulta) {
        $.ajax({
            url: 'https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/php/suport/category_product.php',
            type: 'POST',
            data: { consulta },
        })
        .done(function(respuesta) {
            $('#SEcategory').html(respuesta);
            $('#SEAcategory').html(respuesta);
        })
        .fail(function() {
            console.log("error");
        });
    }
});

jQuery(document).ready(function($){
    $(document).on('click', '#btnEditService', function (){
        let edit_id = $(this).val();
        console.log('detectó');

        let form = $("<form action='https://plataforma.kalstein.net/index.php/support/services/edit/' method='get' hidden>" +
            "<input type='hidden' name='edit' value='" + edit_id + "' /></form>");

        $('body').append(form);
        form.submit();
    });
});

jQuery(document).ready(function($){
    searchCountry();

    function searchCountry(consulta){

        $.ajax({
            url: 'https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/php/suport/pais.php',
            type: 'POST',
            data: {consulta},
        })
        .done(function(respuesta){
            $('#SEpais').html(respuesta)
            $('#SEApais').html(respuesta)
        })
        .fail(function(){
            console.log("error");
        });
    }
});

jQuery(document).ready(function($) {
    // Sección: Eliminar producto desde el botón de la página

    $(document).on('click', '#btnDeleteService', function() {
        let delete_aid = $(this).val();

        // Mostrar una alerta de confirmación usando IziToast
        iziToast.question({
            title: 'Confirmation',
            message: 'Are you sure you want to delete this service?',
            close: false,
            overlay: true,
            timeout: false,
            position: 'center',
            buttons: [
                ['<button><b>Yes</b></button>', function(instance, toast) {
                    // Realizar una solicitud AJAX para eliminar el servicio
                    $.ajax({
                        url: 'https://plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/php/suport/delete-service.php',
                        type: 'POST',
                        data: { delete_aid },
                    })
                    .done(function(response) {
                        console.log(response); 

                        if (response === 'done') {
                            iziToast.success({
                                title: 'Success',
                                message: 'Service deleted.',
                                position: 'center',
                                onClosing: function() {
                                    setTimeout(function() {
                                        window.location.href = 'https://plataforma.kalstein.net/index.php/support/services';
                                    }, 1000);
                                }
                            });
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: 'Service not deleted',
                                position: 'center',
                            });
                        }
                    })
                    .fail(function() {
                        iziToast.error({
                            title: 'Error',
                            message: "Can't connect with database",
                            position: 'center',
                        });
                    });

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                },
                true],
                ['<button>No</button>', function(instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.error({
                        title: 'Error',
                        message: 'Service delete canceled.',
                        position: 'center',
                    });
                }]
            ]
        });
    });
});

