$(document).ready(function() {
    $('form').submit(function(event) {
        event.preventDefault(); //Força a não atualizar a pagina ao clicar em submit
        //Verifica se o e-mail e senha estão prenchidos
        if ($('input[name=email]').val() == "" || $('input[name=senha]').val() == "") {
            $('#ModalEmailSenha').modal('show');
        } else {
            //Retorna os dados do form
            var data = {
                'email': $('input[name=email]').val(),
                'senha': $('input[name=senha]').val(),
            };
            //Conecta com o metodo post de autenticação
            $.ajax({

                type: "PUT",
                url: "./web_services/ws-apiFvb.php/authenticate",
                contentType: "application/json", //Define o tipo de conteudo
                data: JSON.stringify(data), //Transforma apenas os dados enviados em String
                success: function(data) {

                    //Converte retorno para um JSOM
                    var jsonLogin = JSON.parse(data);

                    let autenticacao = jsonLogin.autenticacao;
                    console.log(autenticacao);
                    if (autenticacao == 1) {
                        window.location = './menu.php';
                    } else if (autenticacao == 2) {
                        window.location = './home_motorista.php';
                    } else if (autenticacao == 3) {
                        window.location = './home_freentista.php';
                    } else if (autenticacao == 0) {
                        $('#ModalInvalido').modal('show');
                    } else {
                        alert('Ocorreu um erro! Tente novamente em alguns instantes');
                    }

                }

            });
        }
    });
});