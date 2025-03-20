$(document).ready(function () {
    /// Quando usuário clicar em salvar será feito todos os passos abaixo
    $('#formlogin').submit(function (e) {
        e.preventDefault()

        var dados = $('#formlogin').serialize();
        //console.log(dados);

        $("#loaderajax").css("display","block");

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: './model/login.php',
            async: true,
            data: dados,

            success: function (response) {
                $("#loaderajax").css("display","none");
                Swal.fire('Pronto!', response[0], 'success')
                    .then(res => {
                        if (res.isConfirmed) {
                            window.location.href = 'index.php?pg=dashboard';
                        }
                    })
            },
            error (warnings) {
				$("#loaderajax").css("display","none");
                let errors = ''
                warnings.responseJSON.map((row) => {
                    errors += `${row}<br>`
                })
                Swal.fire('Ops!', errors, 'error')
            }
        });
        return false;
    });
});