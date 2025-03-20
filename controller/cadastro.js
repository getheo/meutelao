$(document).ready(function () {
    /// Quando usuário clicar em salvar será feito todos os passos abaixo
    $('#formcadastro').submit(function (e) {
        //e.preventDefault()

        var dados = $('#formcadastro').serialize();
        //console.log(dados);
        $("#loaderajax").css("display","block");

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: './model/cadastro.php',
            async: true,
            data: dados,

            success: function (response) {
                $("#loaderajax").css("display","none");
                Swal.fire('Pronto!', 'Usuario cadastrado com sucesso!', 'success')
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