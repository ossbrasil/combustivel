var idglobal = 0;

$(document).on('hidden.bs.modal', '.modal', function() {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});

$('.myCollapsible').on('shown.bs.collapse', function() {
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
});

// Data Tables Funcionarios

function executaTabelaFuncionarios() {
    $('#ListarFuncionariostable').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#ListarFuncionariostable').DataTable({
        "scrollY": "600px",
        "scrollX": true,
        "scrollCollapse": true,
        "lengthMenu": [5, 10, 25],
        "language": {
            "info": "Exibindo pagina _PAGE_ de _PAGES_",
            "emptyTable": "Não foram encontrados registros",
            "infoEmpty": "Não foram encontrados registros",
            "sZeroRecords": "Não foram encontrados registros",
            "infoFiltered": " - filtrado _TOTAL_ de _MAX_ entradas",
            "info": "Exibindo página _PAGE_ de _PAGES_",
            "sLengthMenu": "Exibindo _MENU_ Registros",
            "search": "Buscar",
            "info": "Exibindo página _PAGE_ de _PAGES_",
            "sLengthMenu": "Exibindo _MENU_ Registros",
            "paginate": {
                "next": "Próximo",
                "previous": "Anterior"
            },
            "autoComplete": "off"
        }

    });
}

executaTabelaFuncionarios();

//listar funcionarios

function listarFuncionarios() {
    //Conecta com o metodo get de listar usuários
    $.ajax({
        type: "GET",
        url: "./web_services/ws-cadastro_funcionarios.php/retornafuncionario",
        success: function(data) {
            console.log(data);
            $('#ListarFuncionariostable').DataTable().destroy();
            $table = '';

            var mydata = JSON.parse(data);

            for (var i = 0; i < mydata.length; i++) {

                var it = mydata[i];

                $table += "<tr>";

                $table += "<td class='th-sm text-center align-middle'>" + it.nome + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.matricula + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.email + "</td>";

                $table += "<td class='th-sm text-center align-middle'><button id=" + it.id + " onclick='modalEditar(this.id)' type='button' class='btn btn-primary p-2'><i class='fas fa-pen fa-lg'></i></button>";

                $table += "<button id=" + it.id + " onclick='abrirmodalDeletar(this.id)' type='button' class='btn btn-danger p-2 deleteButton'><i class='fas fa-trash'></i></button></td>";

                $table += "</tr>";
                idfuncionario = it.id
            }
            $('#cadastrofuncionariotable').html($table);
            executaTabelaFuncionarios();

        }
    });
}

listarFuncionarios();

//criar funcionario

function abrirmodalFuncionario() {
    $('#registrarFuncionario').modal('show');
}

function criarFuncionario() {

    //Regex de salvar usuário
    let minRegex = new RegExp("^(?=.{8,})");
    let specialRegex = new RegExp("^(?=.*[!@#\$%\^&\*])");
    let numbRegex = new RegExp("^(?=.*[0-9])");
    let letterRegex = new RegExp("^(?=.*[a-z])");
    let emailRegex = new RegExp("[a-zA-Z0-9_\\.\\+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-\\.]+");

    var nome = $('#nomecad').val();
    var matricula = $('#matriculacad').val();
    var email = $('#emailcad').val();
    var senha = $('#senhacad').val();
    var confsenha = $('#confsenhacad').val();
    var nivel_acesso = $('#nivel_acessocad').val();

    var data = {
        "nome": nome,
        "matricula": matricula,
        "email": email,
        "senha": senha,
        "nivel_acesso": nivel_acesso
    }
    console.log(data);
    if (nome.length == 0) {
        $('#nameHelpCad').html("Digite o nome válido.")
    } else if (email.length == 0) {
        $('#emailHelpCad').html("Digite um email válido.");
    } else if (!email.match(emailRegex)) {
        $('#emailHelpCad').html("Digite um email válido.");
    } else if (matricula.length == 0) {
        $('#matriHelpCad').html("Digite um matricula válida.");
    } else if (senha == 0) {
        $('#passHelpCad').html("Digite uma senha.");
    } else if (!senha.match(minRegex)) {
        $('#passHelpCad').html("É necessário no mínimo 8 caracteres.");
    } else if (!senha.match(letterRegex)) {
        $('#passHelpCad').html('É necessário no mínimo 1 letra.');
    } else if (!senha.match(numbRegex)) {
        $('#passHelpCad').html('É necessário no mínimo 1 número.');
    } else if (!senha.match(specialRegex)) {
        $('#passHelpCad').html('É necessário no mínimo 1 caractere especial.');
    } else if (senha != confsenha) {
        $('#passHelpCad').html("Senhas não coincidem.");
    } else if (nivel_acesso == null) {
        alert('Favor selecionar o Nível de acesso!');
    } else {
        $.ajax({
            method: 'POST',
            url: "./web_services/ws-cadastro_funcionarios.php/criarfuncionario/",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function(data) {
                console.log(data);
                $('#registrarFuncionario').modal('hide');
                $('#criadoComSucesso').modal('show');
                listarFuncionarios();
                idglobal = 0;
            }
        });
    }
}

// Modal de Registrar Funcionarios

//puxa as informações para o modal de editar
function modalEditar(id) {

    idglobal = id;

    $.ajax({
        type: "get",
        url: "./web_services/ws-cadastro_funcionarios.php/listaEditarFuncionario/" + id,
        success: function(data) {

            var mydata = JSON.parse(data);
            var it = mydata[0];

            try {

                $('#nomeEdit').val(it.nome);
                $('#emailEdit').val(it.email);
                $('#matriEdit').val(it.matricula);
                $('#nivelEdit').val(it.nivel_acesso);

                $('#editarFuncionario').modal('show');
            } catch (e) {
                Alert(e);
            }
        }
    });
}

function abreTrocarSenha() {
    $('#trocarSenha').modal('show');
}

function alterarSenha() {

    let minRegex = new RegExp("^(?=.{8,})");
    let specialRegex = new RegExp("^(?=.*[!@#\$%\^&\*])");
    let numbRegex = new RegExp("^(?=.*[0-9])");
    let letterRegex = new RegExp("^(?=.*[a-z])");

    var id = idglobal;
    var senha = $('#senhaEdit').val();
    var confsenha = $('#confsenhaEdit').val();

    var data = {
        "id": id,
        "senha": senha
    }

    if (senha == 0) {
        $('#senhaEditHelpCad').html("Digite uma senha.");
    } else if (!senha.match(minRegex)) {
        $('#senhaEditHelpCad').html("É necessário no mínimo 8 caracteres.");
    } else if (!senha.match(letterRegex)) {
        $('#senhaEditHelpCad').html('É necessário no mínimo 1 letra.');
    } else if (!senha.match(numbRegex)) {
        $('#senhaEditHelpCad').html('É necessário no mínimo 1 número.');
    } else if (!senha.match(specialRegex)) {
        $('#senhaEditHelpCad').html('É necessário no mínimo 1 caractere especial.');
    } else if (senha != confsenha) {
        $('#senhaEditHelpCad').html("Senhas não coincidem.");
    } else {
        $.ajax({
            method: 'POST',
            url: './web_services/ws-cadastro_funcionarios.php/alterarSenha/',
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function(data) {
                $('#trocarSenha').modal('hide');
                $('#senhaTrocada').modal('show');
                //notificação de confirmação de troca de senha
                listarFuncionarios();
                idglobal = 0;
            }
        });
    }
}


function alterarFuncionario() {

    var id = idglobal;

    let emailRegex = new RegExp("[a-zA-Z0-9_\\.\\+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-\\.]+");


    var nome = $('#nomeEdit').val();
    var matricula = $('#matriEdit').val();
    var email = $('#emailEdit').val();
    var nivel_acesso = $('#nivelEdit').val();

    var data = {
        "id": id,
        "nome": nome,
        "matricula": matricula,
        "email": email,
        "nivel_acesso": nivel_acesso
    }

    console.log(data)

    if (nome.length == 0) {
        $('#nomeEditHelpCad').html("Digite o nome válido.")
    } else if (email.length == 0) {
        $('#emailEditHelpCad').html("Digite um email válido.");
    } else if (!email.match(emailRegex)) {
        $('#emailEditHelpCad').html("Digite um email válido.");
    } else if (matricula.length == 0) {
        $('#planoEditHelpCad').html("Digite uma matrícula válida.");
    } else if (nivel_acesso == null) {
        alert('Favor selecionar o Nível de acesso!');
    } else {
        $.ajax({
            method: 'POST',
            url: './web_services/ws-cadastro_funcionarios.php/alterarFuncionario/',
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function(data) {
                $('#editarFuncionario').modal('hide');
                $('#editadoComSucesso').modal('show');
                listarFuncionarios();
                idglobal = 0;
            }
        });
    }

}

//DELETE 
//Exclui a Entrega selecionada

function abrirmodalDeletar(id) {
    idglobal = 0;
    idglobal = id;
    $('#deletarFuncionario').modal('show');
}

$("#btnDeletarFuncionario").click(function() {
    $.ajax({
        type: "DELETE",
        url: "./web_services/ws-cadastro_funcionarios.php/deletarFuncionario/" + idglobal,
        success: function(data) {
            console.log(data)
            $('#deletarFuncionario').modal('hide');
            $('#deletadoComSucesso').modal('show');
            listarFuncionarios();
            idglobal = 0;
        }
    });
});
//DELETE 

// Limpa os modais
$(document).ready(function() {
    $('.modal').on('hidden.bs.modal', function() {
        $(this).find('input[type=text],input[type=time],input[type=date],input[type=password], textarea').val('');
        $(this).find('select.selectValues').val('0');
        $(this).find(':checkbox').prop('checked', false);

    });
});

// VISUALIZAÇÃO DE SENHA
$(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});
// VISUALIZAÇÃO DE SENHA

//Reseta os <small> em baixo de cada input
function resetHelper(id) {
    var id_do_small = id
    $('#' + id_do_small).text('')
}
//Reseta os <small> em baixo de cada input

listarFuncionarios();