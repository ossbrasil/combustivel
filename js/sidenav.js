function acessPage(pagina) {
    window.location = './' + pagina;
}

var idDoUsuario = 0;

function abrirModalSenha() {
    $('#modalSenhaUser').modal('show');
}


//Botão que registra os usuários
function alterarSenha() {

    //Regex de salvar usuário
    let minRegex = new RegExp("^(?=.{8,})");
    let specialRegex = new RegExp("^(?=.*[!@#\$%\^&\*])");
    let numbRegex = new RegExp("^(?=.*[0-9])");
    let letterRegex = new RegExp("^(?=.*[a-z])");

    var novaSenha = $('#novaSenha').val()
    var novaRepetir = $('#novaRepetir').val()

    var data = {
        "senha": novaSenha,
    }

    if (novaSenha == 0) {
        $('#passHelpUser').html("Digite uma senha");

    } else if (!novaSenha.match(minRegex)) {
        $('#passHelpUser').html("É necessário no mínimo 8 caracteres")

    } else if (!novaSenha.match(letterRegex)) {
        $('#passHelpUser').html('É necessário no mínimo 1 letra')

    } else if (!novaSenha.match(numbRegex)) {
        $('#passHelpUser').html('É necessário no mínimo 1 número')

    } else if (!novaSenha.match(specialRegex)) {
        $('#passHelpUser').html('É necessário no mínimo 1 caractere especial')

    } else if (novaSenha != novaRepetir) {
        $('#passHelpUser').html("Senhas não coincidem")

    } else {
        $.ajax({
            type: "PUT",
            url: "./web_services/ws-navBar.php/novaSenhaUser",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function(data) {
                $('#modalSenhaUser').modal('hide')

                $('#modificadoComSucesso').modal('show')

                $('#modalSenhaUser').on('hidden.bs.modal', function(e) {
                    $(this)
                        .find("input,textarea,small")
                        .val('')
                        .end()
                })
            }
        });
    }
}

$(document).ready(function() {
    $('#nav-icon4').click(function() {
        $(this).toggleClass('open');
    });
});