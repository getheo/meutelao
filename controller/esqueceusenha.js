$(document).ready(function () {
    /// Quando usuário clicar em salvar será feito todos os passos abaixo
    $('#formesqueci').submit(function (e) {
        e.preventDefault();

        var dados = $('#formesqueci').serialize();
        //console.log(dados);
        $("#loaderajax").css("display","block");
		
		//alert("Chegou");

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: './model/esqueceusenha.php',
            async: true,
            data: dados,

            success: function (response) {
                $("#loaderajax").css("display","none");
                Swal.fire('Pronto!', response[0], 'success')
                    .then(res => {
                        if (res.isConfirmed) {
                            window.location.href = 'index.php?pg=login';
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
	
	
	/// Atualizar senha de Usuário
    $('#formAlterarSenha').submit(function (e) {
        e.preventDefault();

        var dados = $('#formAlterarSenha').serialize();
        //console.log(dados);
        $("#loaderajax").css("display","block");

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: './model/alterarsenha.php',
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