$(document).ready(function () {
    /// Registrar um novo evento para o usuário logado
    $('#formEvento').submit(function (e) {
        e.preventDefault();

        var dados = $('#formEvento').serialize();
        //console.log(dados);

        $("#loaderajax").css("display","block");

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: './model/evento.php',
            async: true,
            data: dados,

            success: function (response) {
                $("#loaderajax").css("display","none");
                Swal.fire('Pronto!', 'Evento registrado com sucesso! Agora cadastre as fotos e/ou videos.', 'success')
                    .then(res => {
                        if (res.isConfirmed) {
                            window.location.href = 'index.php?pg=form_evento&cod=' + response[1];
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
	
	/// Registrar um novo evento para o usuário logado
    $('#formAplicacao').submit(function (e) {
        e.preventDefault();

        var dados = $('#formAplicacao').serialize();
        //console.log(dados);		

        $("#loaderajax").css("display","block");

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: './model/evento_aplicar.php',
            async: true,
            data: dados,

            success: function (response) {
                $("#loaderajax").css("display","none");
                Swal.fire('Pronto!', response[0], 'success')
                    .then(res => {
                        if (res.isConfirmed) {
                            window.location.href = 'index.php?pg=form_evento&cod=' + response[1];
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

    /// Cadastrar Fotos e/ou Videos para um determindado evento
    $('#formEventoArquivosss').submit(function (e) {
        e.preventDefault();

        //var dados = $('#formEventoArquivos').serialize();

        const meuImput = document.getElementById('arquivo');
        const reader = new FileReader();
        reader.readAsDataURL(meuImput.files[0]);
        reader.onload = function () {
            // Aqui temos a sua imagem convertida em string em base64.
            //console.log(reader.result);
            dados.arquivo = reader.result;
        };

        var dados = new FormData();
        dados.append('idusuario', document.getElementById('idusuario').value)
        dados.append('idevento', document.getElementById('idevento').value)
        dados.append('cod', document.getElementById('cod').value)
        dados.append('codArquivo', document.getElementById('codArquivo').value)
        dados.append('arquivo', document.getElementById('arquivo').files[0]);
        var dados = $('#formEventoArquivos').serialize();
        console.log(dados);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../model/arquivo.php',
            async: true,
            data: dados,

            success: function (response) {
                Swal.fire('Pronto!', 'Fotos e/ou videos cadastrados com sucesso!', 'success')
                    .then(res => {
                        if (res.isConfirmed) {
                            window.location.href = 'index.php?pg=evento';
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


    /// Quando usuário clicar em salvar será feito todos os passos abaixo
    $('.arquivoApagar').click(function() {
        //alert('aki');
        //let arquivoId = this.attr("data-idarquivo").val();
        //let arquivoIdEvento = this.attr("data-idevento").val();

        var arquivoId = this.getAttribute("data-id");
        var arquivoIdEvento = this.getAttribute("data-idevento");
        var arquivoUsuario = this.getAttribute("data-idusuario");

        //alert(arquivoId + " >>> " + arquivoIdEvento);

        //var dados = $('#formEventoArquivos').serialize();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: './model/arquivo_excluir.php',
            async: true,
            data: {idarquivo: arquivoId, idevento: arquivoIdEvento, idusuario: arquivoUsuario},

            success (response) {
                Swal.fire('Pronto!', response[0], 'success')
                .then((res) => {
                    if(res.isConfirmed){
                        window.location.reload(true)
                    }
                })
            },
            error (response) {
                console.log(response)
                let errors = JSON.parse(response.responseText)
                let text = ''
                errors.map((error) => text += `${error}<br>`)
                Swal.fire('Ops!', text, 'error')
                    .then((res) => {
                        if(res.isConfirmed){
                            window.location.reload(true)
                        }
                    })
            }
        });

        return false;
    });
	
	/// Destacar arquivo 
    $('.arquivoDestaque').click(function() {
        //alert('aki');
        //let arquivoId = this.attr("data-idarquivo").val();
        //let arquivoIdEvento = this.attr("data-idevento").val();

        var arquivoId = this.getAttribute("data-id");
        var arquivoIdEvento = this.getAttribute("data-idevento");
        var arquivoUsuario = this.getAttribute("data-idusuario");
		var arquivoDestaque = this.getAttribute("data-destaque");

        //alert(arquivoId + " >>> " + arquivoIdEvento);

        //var dados = $('#formEventoArquivos').serialize();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: './model/arquivo_destaque.php',
            async: true,
            data: {idarquivo: arquivoId, idevento: arquivoIdEvento, idusuario: arquivoUsuario, destaque: arquivoDestaque},

            success (response) {
                Swal.fire('Pronto!', response[0], 'success')
                .then((res) => {
                    if(res.isConfirmed){
                        window.location.reload(true)
                    }
                })
            },
            error (response) {
                console.log(response)
                let errors = JSON.parse(response.responseText)
                let text = ''
                errors.map((error) => text += `${error}<br>`)
                Swal.fire('Ops!', text, 'error')
                    .then((res) => {
                        if(res.isConfirmed){
                            window.location.reload(true)
                        }
                    })
            }
        });

        return false;
    });
	
});
