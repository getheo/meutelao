

$(document).ready(function() {


    // Get the input field
    var input = document.getElementById("senha");

    // Execute a function when the user releases a key on the keyboard
    input.addEventListener("keyup", function(event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
            // Cancel the default action, if needed
            event.preventDefault();
            // Trigger the button element with a click
            document.getElementById("tentalogin").click();
        }
    });

    /// Quando usuário clicar em salvar será feito todos os passos abaixo
    $('#tentalogin').click(function() {

        var dados = $('#formlogin').serialize();

        $("#loaderajax").css("display","block");

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'model/autenticalogin.php',
            async: true,
            data: dados,
            success: function(response) {
                if (response.success===true) {
                    $("#loaderajax").css("display","none");
                    window.location.href="index.php";
                } else { alert('Erro: '+response.erro); }
            }

        });
        //      window.location.href="index.php";
        return false;
    });



    /// Quando usuário clicar em salvar será feito todos os passos abaixo
    $('#reseta').click(function() {

        var dados = $('#formreset').serialize();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'envia_email.php',
            async: true,
            data: dados,
            success: function(response) {
                alert('Email enviado');
                $('#fechamodal').click();
                //window.location.href="index.php";
            }

        });
        //      window.location.href="index.php";
        return false;
    });

});
