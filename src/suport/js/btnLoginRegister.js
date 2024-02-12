jQuery(document).ready(function($){
    $('.topBarInLogoArea').prepend("<div class='c-btnLoginSignup'></div>")
    showUserLoguer()

    function showUserLoguer(consulta){
        $.ajax({
			url: "https://kalstein.us/wp-content/plugins/kalsteinPerfiles/php/infoAccountLoguer.php",
			type: "POST",
			data: {consulta},
        })
        .done(function(respuesta){
            $('.c-btnLoginSignup').html(respuesta)
        })
        .fail(function(){
            console.log("error");
        })
    }

    $(document).on('click', '#btnLogout', function(e){
        e.preventDefault()
        logout()
    })

    function logout(consulta){
        $.ajax({
            url: 'https://kalstein.us/wp-content/plugins/kalsteinPerfiles/php/logout.php',
            type: 'POST',
            data: {consulta},
        })
        .done(function(respuesta){
            $(location).attr('href','https://kalstein.us/login/')
        })
        .fail(function(){
            console.log("error")
        })
    }
})