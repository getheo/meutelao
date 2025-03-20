$(document).ready(function () {
    /// Quando usuário clicar em atulizar será feito todos os passos abaixo
    $('#formAtualizarPerfil').submit(function (e) {
        e.preventDefault();

        var dados = $('#formAtualizarPerfil').serialize();
        //console.log(dados);

        $("#loaderajax").css("display","block");

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../model/perfil.php',
            async: true,
            data: dados,

            success: function (response) {
                $("#loaderajax").css("display","none");
                Swal.fire('Pronto!', 'Dados de usuário atualizado com sucesso!', 'success')
                    .then(res => {
                        if (res.isConfirmed) {
                            window.location.href = 'index.php';
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

/*
window.onload = function(){

    var form = document.getElementById("formatualizarperfil");
    var onsubmit = function(event){
        event.preventDefault();

        if(!validar()){
            //chame as funções para valores não válidos
        }else{
            form.submit();
        }
    }

    form.addEventListener("submit", onsubmit);
}

function validar() {
    var campo1 = document.getElementById('senha').value;
    var campo2 = document.getElementById('senha_confirme').value;

    if (campo1 != campo2) {
        alert('Senhas diferentes');
        return false;
    }
    return true;
}
*/
