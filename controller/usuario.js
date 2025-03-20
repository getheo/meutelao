$(document).ready(function () {
    /// Quando usuário clicar em atulizar será feito todos os passos abaixo
    $('#formatualizar').submit(function (e) {
        e.preventDefault()

        var dados = $('#formatualizar').serialize();
        //console.log(dados);

        $("#loaderajax").css("display","block");

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: './model/usuario.php',
            async: true,
            data: dados,

            success: function (response) {
                $("#loaderajax").css("display","none");
                Swal.fire('Pronto!', 'Dados de usuário atualizado com sucesso!', 'success')
                    .then(res => {
                        if (res.isConfirmed) {
                            window.location.href = 'index.php?pg=usuario';
                        }
                    })
            },
            error (warnings) {
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